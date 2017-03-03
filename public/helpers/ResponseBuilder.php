<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/helpers/ResponseHelper.php";

class ResponseBuilder {

    private $resCode = null;
    private $msg = null;
    private $data = null;
    private $__response = array();

    function __construct($resCode) {
        $this->resCode = $resCode;
    }

    // @ret boolean
    public function prepare($data = false) {
        
        // setup data
        $this->data = $data ? $data : false;

        // start preping
        switch ($this->resCode) {
            case ResponseHelper::HTTP_404:
                return $this->setResponse(true, ResponseHelper::HTTP_404_MSG);
                break;
            case ResponseHelper::HTTP_401:
                return $this->setResponse(true, ResponseHelper::HTTP_401_MSG);
                break;
            case ResponseHelper::HTTP_500:
                return $this->setResponse(true, ResponseHelper::HTTP_500_MSG);
                break;
            case ResponseHelper::HTTP_200:
                return $this->setResponse(false, ResponseHelper::HTTP_200_MSG);
                break;
            case ResponseHelper::HTTP_405:
                return $this->setResponse(false, ResponseHelper::HTTP_405_MSG);
                break;
            default:
                return $this->setResponse(true, ResponseHelper::HTTP_500_MSG);
                break;
        }
    }

    private function setResponse($isError, $msg) {
        $this->__response["error"] = $isError;
        $this->__response["message"] = $msg;
        if ($this->data) {
            $this->__response["data"] = $this->data;
        }
        return ($this->__response["error"] === $isError) ? true : false;
    }

    private function getResponse() {
        return ($this->__response) ? $this->__response : false;
    }

    public function send() {
        $ret = $this->getResponse();
        if ($ret) {
            http_response_code($this->resCode);
            header("Content-Type: application/json");
            echo json_encode($ret);
        } else {
            http_response_code(ResponseHelper::HTTP_500);
            header("Content-Type: application/json");
            echo json_encode(array("error" => "true", "message" => "Unknown Error RB"));
        }
    }
}