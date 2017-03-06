<?php

// include the class
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/AltoRouter.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/handlers/Response.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/helpers/ResponseHelper.php";

// init router
$app = new AltoRouter();
$app->setBasePath('');

/// route handler
$app->map('GET', '/', $_SERVER['DOCUMENT_ROOT'] . '/controllers/index.php');
$app->map('POST', '/user/signup', $_SERVER['DOCUMENT_ROOT'] . '/controllers/user.php');

/**
 * @var match: boolean
 * @function match: boolean => checks if request route 
 * is defined
 **/
$match = $app->match();

if ($match) {
    require $match['target'];
} else {
    $response  = new Response();
    $res = $response->createResponse(ResponseHelper::HTTP_404);
    if ($res) {
        $response->sendResponse();
    } else {
        echo json_encode(array("error" => "true", "message" => "Unable to create response"));
    }
}


