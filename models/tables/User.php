<?php

class User {
    public $user_val;
    public $user_id;
    public $user_login;
    public $user_password;
    public $user_sessid;
    public $user_type;

    public function __construct() {
        $this->user_val = 0;
    }
}
