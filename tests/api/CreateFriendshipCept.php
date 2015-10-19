<?php 
$I = new ApiTester($scenario);
$I->wantTo('create a friendship via API');
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('', ['uid1' => 1, 'uid2' => 2]);
//$I->seeResponseCodeIs(201);
$I->seeResponseIsJson();
$I->seeResponseCodeIsValid();
//$I->seeResponseJsonMatchesXpath('//uid1');
//$I->seeResponseJsonMatchesXpath('//uid2');
//$I->seeResponseJsonMatchesXpath('//uid3');
//$I->seeResponseContains('{"result":"ok"}');