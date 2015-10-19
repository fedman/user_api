<?php

namespace app\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use app\models\Friendship;

class FriendshipController extends ActiveController
{
    public $modelClass = 'app\models\Friendship';
    
    /**
     * Delete mutual friendship by IDs of users.
     */
    public function actionDeleteFriend() {
        $uid1 = Yii::$app->request->post('uid1', '');
        $uid2 = Yii::$app->request->post('uid2', '');

        Friendship::deleteAll('(uid1 = :uid1 and uid2 = :uid2) or (uid1 = :uid2 and uid2 = :uid1)', [':uid1' => $uid1, ':uid2' => $uid2]);

        Yii::$app->getResponse()->setStatusCode(204);
    }

    /**
     * Return list of friends' IDs
     * @return array List of IDs
     * @throws ServerErrorHttpException
     */
    public function actionShowFriends() {
        $id = Yii::$app->request->get('id', '');

        if ($id) {
            $model = new Friendship();
            $model->uid1 = $id;
            if (!$model->validate(['uid1'])) {
                $errors = $model->getErrors('uid1');
                throw new ServerErrorHttpException(implode(' ', $errors));
            }
            Yii::$app->getResponse()->setStatusCode(200);
            return Friendship::getFriendsList($id);
        }
    }

}
