<?php

require $_SERVER['DOCUMENT_ROOT'] . "/helpers/ResponseBuilder.php";

class Response {

    private $rb = null;
    private $response = null;
    /**
     * @constructor: empty for now
     **/
    function __construct() {
        
    }

    /**
     * @visibility: public
     * @var $isError: boolean => checks if following response is a error
     * @var $res_code: string => gives response code
     **/
    public function createResponse($res_code, $data = false) {
        $this->rb = new ResponseBuilder($res_code);
        $ret = $this->rb->prepare($data);

        return $ret ? $ret : false;
    }

    public function sendResponse() {
        $this->rb->send();
    }
}