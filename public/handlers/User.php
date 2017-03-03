<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/handlers/Database.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/helpers/UserHelper.php";


class User {

    private $mobile = null;
    private $password = null;
    private $category = null;
    private $name = null;
    private $email = null;

    function __construct($name, $email, $mob, $pass, $cat) {
        $this->mobile = $mob;
        $this->password = $pass;
        $this->category = $cat;
        $this->name = $name;
        $this->email = $email;
    }

    private function getuuid($category) {
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

    public function save() {
        $db = new Database();
        $uuid = $this->getuuid($this->category);
        $query = "INSERT INTO users(uid, name, email, mobile , password,  created_at) VALUES($uuid, $this->name, $this->email, $this->mobile, $this->password, NOW())";
        if ($db->connect()) {
            $ret = $db->exec_query($query);
            if ($ret) {
                return $ret;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}