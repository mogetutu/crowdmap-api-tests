<?php
$I = new UserGuy($scenario);
$I->wantTo('test get requests against the users/:user_id/posts end point with apikey');
$I->haveHttpHeader('Content-Type', 'text/html');
$I->haveHttpHeader('User-Agent', 'Api Test/0.1');

/* testing request with user_id */
$I->sendGet('/users/7977/posts');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
$resp = $I->grabResponse();
$I->checkPostObjs($resp, array(3356026,3356025,3356024));

/* testing count request with user_id */
$I->sendGet('/users/7977/posts', array('count' => TRUE));
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('count' => 3));
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));

/* testing request with crowdmapID */
$I->sendGet('/users/9b6f57db48ecc5ae4fab0c5c990143f7a241db380288011523b26c398137bf83773dca2f08b4344363d98e4ed6d31741bbd26eb2da296ad75263e9ba1090fca8/posts');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
$resp = $I->grabResponse();
$I->checkPostObjs($resp, array(3356026,3356025,3356024));

/* testing count request with crowdmapID */
$I->sendGet('/users/9b6f57db48ecc5ae4fab0c5c990143f7a241db380288011523b26c398137bf83773dca2f08b4344363d98e4ed6d31741bbd26eb2da296ad75263e9ba1090fca8/posts',
  array('count' => TRUE));
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('count' => 3));
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));

/* testing request with username */
$I->sendGet('/users/sarahmorden/posts');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
$resp = $I->grabResponse();
$I->checkPostObjs($resp, array(3356026,3356025,3356024));

/* testing count request with username */
$I->sendGet('/users/sarahmorden/posts', array('count' => TRUE);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('count' => 3));
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));

/* test bad username */
$I->sendGet('/users/returnofthejedi/posts/');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('posts' => array()));
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));

/* test count with bad username */
$I->sendGet('/users/returnofthejedi/posts/', array('count' => TRUE));
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('posts' => array()));
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));

/* test bad user_id */
$I->sendGet('/users/100000/posts/');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('posts' => array()));
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));

/* test count with bad user_id */
$I->sendGet('/users/100000/posts/', array('count' => TRUE));
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('count' => 0));
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
