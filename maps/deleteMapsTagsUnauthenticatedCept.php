<?php
$I = new MapsGuy($scenario);
$I->wantTo('test DELETE request against the /maps/tags(/:tag) and /maps/:map_id/tags(/:tag) end-points without authentication');
$I->haveHttpHeader('Content-Type', 'text/html');
$I->haveHttpHeader('User-Agent', 'Api Test/0.1');

// Test Delete of map tags
$I->sendDelete('/maps/tags/pancakes');
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 401));
$I->seeResponseContainsJson(array('success' => false));
$I->seeResponseContainsJson(array('error' => 'This action requires an API token or a valid session.'));

//tests for /maps/tags(/:tag) not 
$I->sendGet('/maps/tags/');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
$resp = $I->grabResponse();
$I->checkTagsObjs($resp, array('dear leader','instagram','kim jong un','korea','north korea','social media','beans','cafe','coffee','global','travel','crepes','pancake','pancakes','burger','burgers','austin','barbecue','food','texas'));

$I->sendGet('/maps/tags/pancakes');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
$resp = $I->grabResponse();
$I->checkTagsObjs($resp, array('pancakes'));

//test delete on tags that don't exist
$I->sendDelete('/maps/tags/notatag');
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 401));
$I->seeResponseContainsJson(array('success' => false));
$I->seeResponseContainsJson(array('error' => 'This action requires an API token or a valid session.'));

$I->sendGet('/maps/1/tags/');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
$resp = $I->grabResponse();
$I->checkTagsObjs($resp, array('dear leader','instagram','kim jong un','korea','north korea','social media'));

// Test delete on spaced map tag
$I->sendDelete('/maps/1/tags/dear+leader');
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 401));
$I->seeResponseContainsJson(array('success' => false));
$I->seeResponseContainsJson(array('error' => 'This action requires an API token or a valid session.'));

// Test map tag was not removed
$I->sendGet('/maps/1/tags/dear+leader');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
$resp = $I->grabResponse();
$I->checkTagsObjs($resp, array('dear leader'));

$I->sendGet('/maps/1/tags/', array('count'=>true);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
$I->seeResponseContainsJson(array('count' => "6"));

//test of a tag that appears on multiple maps to make sure this only returns the count for the current map.
$I->sendGet('/maps/1/tags/korea');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
$I->seeResponseContainsJson(array('count' => "1"));

//tests for map that doesn't exist

$I->sendGet('/maps/notamap/tags/');
$I->seeResponseCodeIs(404);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 404));
$I->seeResponseContainsJson(array('success' => false));
$I->seeResponseContainsJson(array('error' => "Map not found."));

$I->sendGet('/maps/notamap/tags/notatag');
$I->seeResponseCodeIs(404);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 404));
$I->seeResponseContainsJson(array('success' => false));
$I->seeResponseContainsJson(array('error' => "Map not found."));

// Test delete tag on non-existent map
$I->sendDelete('/maps/1010101010/tags/notatag');
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 401));
$I->seeResponseContainsJson(array('success' => false));
$I->seeResponseContainsJson(array('error' => 'This action requires an API token or a valid session.'));

// Tests delete for tag that doesn't exist on /maps/:subdomain
$I->sendDelete('/maps/northkoreasocial/tags/notatag');
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 401));
$I->seeResponseContainsJson(array('success' => false));
$I->seeResponseContainsJson(array('error' => 'This action requires an API token or a valid session.'));

// Tests for tag that doesn't exist on /maps/:subdomain
$I->sendGet('/maps/northkoreasocial/tags/notatag');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
$I->seeResponseContains('"maps_tags":[]');

$I->sendDelete('/maps/1/tags/notatag');
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 401));
$I->seeResponseContainsJson(array('success' => false));
$I->seeResponseContainsJson(array('error' => 'This action requires an API token or a valid session.'));

// Tests for tag that doesn't exist on maps/:map_id
$I->sendDelete('/maps/1/tags/notatag');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
$I->seeResponseContains('"maps_tags":[]');

$I->sendGet('/maps/1/tags/notatag', array('count'=>true));
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(array('status' => 200));
$I->seeResponseContainsJson(array('success' => true));
$I->seeResponseContainsJson(array('count' => "0"));