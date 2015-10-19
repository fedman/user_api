<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "friendship".
 *
 * @property integer $uid1
 * @property integer $uid2
 */
class Friendship extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'friendship';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid1', 'uid2'], 'required'],
            [['uid1', 'uid2'], 'integer', 'min' => 1],
//            [['uid1', 'uid2'], 'unique', 'targetAttribute' => ['uid1', 'uid2'], 'message' => 'The combination of Uid1 and Uid2 has already been taken.'],
            [['uid1'],  function ($attribute, $params) {
                if (!$this->hasErrors() && $this->uid1 == $this->uid2) {
                    $this->addError($attribute, 'User cannot become a friend with himself/herself.');
                    $this->addError('uid2', 'User cannot become a friend with himself/herself.');
                }
            }],
            [['uid1'],  function ($attribute, $params) {
                if (!$this->hasErrors()) {                    
                    $model = self::find()->where(['uid1' => $this->uid1, 'uid2' => $this->uid2])->orWhere(['uid2' => $this->uid1, 'uid1' => $this->uid2])->one();
                    if ($model) {
                        $this->addError($attribute, 'The combination of Uid1 and Uid2 has already been taken.');
                        $this->addError('uid2', 'The combination of Uid1 and Uid2 has already been taken.');
                    }                    
                }
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid1' => 'Uid1',
            'uid2' => 'Uid2',
        ];
    }
    
    /**
     * Add friend
     * @return boolean
     * @throws \Exception
     */
    public function addFriend() {
        $transaction = \yii::$app->db->beginTransaction();
        try {
            if ($this->validate()) {
                $model = new self();
                $model->uid1 = $this->uid2;
                $model->uid2 = $this->uid1;
                $this->save();
                $model->save();
                
                $transaction->commit();
            }
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {

            if ($this->uid1 > $this->uid2) {
                $uid1 = $this->uid1;
                $this->uid1 = $this->uid2;
                $this->uid2 = $uid1;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Return array of friends' uid
     * @param integer $id
     * @return array
     */
    public static function getFriendsList($id) {
        $data1 = (new \yii\db\Query())
                ->select(['uid2'])
                ->from(Friendship::tableName())
                ->where(['uid1' => $id])
                ->column();
        $data2 = (new \yii\db\Query())
                ->select(['uid1'])
                ->from(Friendship::tableName())
                ->where(['uid2' => $id])
                ->column();

        $result = array_merge($data1, $data2);
        sort($result);

        return $result;
    }

}
