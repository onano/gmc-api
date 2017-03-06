<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/DatabaseHelper.php';

class Database {
    /**
     * @var $conn: type Mysqli
     **/

    private $conn = null;
    private $stmt = null;

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

    public function prepare($query) {
        $this->stmt = $this->conn->prepare($query);
        if ($this->stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function set_params($sql_str, ...$params) {
        // bind the sql string
        $bind_args = array();
        $bind_args[] = $sql_str;

        foreach ($params as $param_key => $param_val) {
            $bind_args[] = & $param_val[$param_key]; // pass the reference to bind_Args
        }

        if (call_user_func_array(array($this->stmt, 'bind_param'), $bind_args)) {
            return true;
        } else {
            return false;
        }
    }

    public function exec_query() {
        $ret = $this->stmt->execute();
        $this->stmt->close();
        return $ret ? $ret : false;
    }

    public function exec_query_array() {

        $ret = $this->stmt->execute();
        if ($ret) {
            $this->stmt->store_result();
            $response = array();
            while($r = $this->getResultByArray($this->stmt)) {
                $response[] = $r;
            }
            $this->stmt->close();
            
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