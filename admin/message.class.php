<?php
class message
{
    public $errorMsg = array();
    public $errorIds = array();
    public $warningMsg = array();
    public $successMsg = array();
    public $isSuccess = true;
    public $data = null;

    public function add($kind, $msg) {
        switch ($kind) {
            case 'errorMsg' :
                array_push($this->errorMsg, $msg);
                $this->isSuccess = false;
                break;

            case 'errorIds' :
                array_push($this->errorIds, $msg);
                $this->isSuccess = false;
                break;

            case 'warningMsg' :
                array_push($this->warningMsg, $msg);
                break;

            case 'successMsg' :
                array_push($this->successMsg, $msg);
                break;

            case 'data' :
                $this->data = $msg;
                break;
        }
    }

    public function error($errorIds,$errorMsg) {
        $this->add("errorIds",$errorIds);
        $this->add("errorMsg",$errorMsg);
        return $this;
    }

    public function printJson() {
        echo json_encode($this);
    }
}