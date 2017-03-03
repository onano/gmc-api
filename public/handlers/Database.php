<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/DatabaseHelper.php';

class Database {
    /**
     * @var $conn: type Mysqli
     **/
    private $conn = null;

    /**
     * @__construct: establishes a new Connection to db
     **/
    function __construct() {
        $this->conn = new mysqli(
            DatabaseHelper::DB_HOST,
            DatabaseHelper::DB_USERNAME,
            DatabaseHelper::DB_PASSWORD,
            DatabaseHelper::DB_NAME 
        );
    }

    /**
     * @ret: $conn
     **/
    public function connect() {
        return $this->conn ? true : false;
    }

    public function exec_query($query) {
        $stmt = $this->conn->prepare($query);
        $ret = $stmt->execute();
        $stmt->close();
        return $ret ? $ret : false;
    }

    public function exec_query_array($query) {
        $stmt = $this->conn->prepare($query);
        $ret = $stmt->execute();
        if ($ret) {
            $stmt->store_result();
            $response = array();
            while($r = $this->getResultByArray($stmt)) {
                $response[] = $r;
            }
            $stmt->close();
            
            return $response;
        } else {
            return false;
        }
    }

    private function getResultByArray($stmt) {
        if($stmt->num_rows>0) {
            $result = array();
            $md = $stmt->result_metadata();
            $params = array();
            while($field = $md->fetch_field()) {
                $params[] = &$result[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $params);
            if($stmt->fetch())
                return $result;
        }
        return null;
    }
}