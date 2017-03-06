<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/handlers/Database.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/helpers/UserHelper.php";


class User {

    private $mobile = null;
    private $password = null;
    private $category = null;
    private $name = null;
    private $email = null;

    function __construct() {
    }

    private function get_uuid($category) {
        $randNum = mt_rand(9999, 1000000);
        $prefix = '';
        switch ($category) {
            case UserHelper::CAT_MED:
                $prefix = UserHelper::CAT_MED_PREFIX;
                break;
            case UserHelper::CAT_ENG:
                $prefix = UserHelper::CAT_ENG_PREFIX;
                break;
            case UserHelper::CAT_MGMT:
                $prefix = UserHelper::CAT_MGMT_PREFIX;
                break;
            case UserHelper::CAT_OTHER:
                $prefix = UserHelper::CAT_OTHER_PREFIX;
                break;
        }
        return $prefix . $randNum;
    }

    public function create_new_user($name, $email, $mob, $pass, $cat) {
        $this->mobile = $mob;
        $this->password = $pass;
        $this->category = $cat;
        $this->name = $name;
        $this->email = $email;
    }

    public function findUserByMobile($mobile) {
        $db = new Database();
        $query = "SELECT * FROM users WHERE mobile = ?";
        $sql_str = "s";
        if ($db->connect()) {
            if ($db->prepare($query)) {
                if ($db->set_params($sql_str, $mobile)){
                    $ret = $db->exec_query_array();
                    if ($ret) {
                        return $ret;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function save() {
        $db = new Database();
        $uuid = $this->get_uuid($this->category);
        $query = "INSERT INTO users(uid, name, email, mobile, password, created_at) VALUES(?, ?, ?, ?, ?, NOW())";
        $sql_str = "sssss";
        if ($db->connect()) {
            if ($db->prepare($query)) {
                if ($db->set_params($sql_str, $uuid, $this->name, $this->email, $this->mobile, $this->password)) {
                    if($db->exec_query()) {
                        return true;
                    } else {
                       return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}