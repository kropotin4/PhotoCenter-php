<?php

class Notice{
    private $log_data;

    public function __construct() {
        $this->log_data = [];
        $this->log_data['log_time'] = 10;
    }

    public function  pushNote(){
        if (!isset($GLOBALS['notes']))
            $GLOBALS['notes'] = array();
        array_push($GLOBALS['notes'], $this->log_data);
    }

    static public function createAndPushNote($text, $type='warn', $time=10){
        $note = new Notice();
        $note->setEnable(1);
        $note->setType($type);
        $note->setText($text);
        $note->setTime($time);

        $note->pushNote();
    }

    public function setEnable($en){
        $this->log_data['log_en'] = $en;
    }
    public function setType($type){
        $this->log_data['log_type'] = '"' . $type . '"';
    }
    public function setText($text){
        $this->log_data['log_text'] = '"' . $text . '"';
    }
    public function setTime($time){
        $this->log_data['log_time'] = $time;
    }
};