<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/handlers/User.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/handlers/Response.php";

//TODO: User Input Sanitization
function main() {
    $name = $_POST['name'];
    $passwd = $_POST['password'];
    $category = $_POST['category'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    // objects
    $user = new User();
    $response = new Response();

    // checking if user already exists
    $ret  = $user->findUserByMobile($mobile);
    if ($ret) {
        $res = $response->createResponse(ResponseHelper::HTTP_409);
        if ($res) {
            $response->sendResponse();
            return;
        } else {
            echo json_encode(array("error" => "true", "message" => "Unable to send response"));
            return;
        }
    }

    // create a new user
    $user->create_new_user($name, $email, $mobile, $passwd, $category);
    if ($user->save()) {
        $res = $response->createResponse(ResponseHelper::HTTP_200);
        if ($res) {
            $response->sendResponse();
        } else {
            echo json_encode(array("error" => "true", "message" => "Unable to send response"));
        }
    } else {
        $res = $response->createResponse(ResponseHelper::HTTP_405);
        if ($res) {
            $response->sendResponse();
        } else {
            echo json_encode(array("error" => "true", "message" => "Unable to send response"));
        }
    }
}
main();