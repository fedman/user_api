<?php 
$I = new ApiTester($scenario);
$I->wantTo('get friendship list via API');
$I->sendGET('');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesXpath('//uid1');
$I->seeResponseJsonMatchesXpath('//uid2');