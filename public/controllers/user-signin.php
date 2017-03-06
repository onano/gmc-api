<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/handlers/User.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/handlers/Response.php";


function check_user_login($ret, $password) {
    echo $ret;
}

function main() {
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    $user = new User();
    $response = new Response();
    $ret = $user->findUserByMobile($mobile);
    if ($ret) {
        check_user_login($ret, $password);
        $res = $response->createResponse(ResponseHelper::HTTP_200, $ret);
        if ($res) {
            $response->sendResponse();
        } else {
            echo json_encode(array("error" => "true", "message" => "Unable to send response"));
        }
    } else {
        $res = $response->createResponse(ResponseHelper::HTTP_404_MSG);
        if($res) {
            $response->sendResponse();
        } else {
            echo json_encode(array("error" => "true", "message" => "Unable to send response"));
        }
    }
}

// call it
main();