<?php

class MY_Model extends CI_Model
{
    public $userData = null;
    public function __construct()
    {
        parent::__construct();
        $ses = $this->session->userdata(SESSION);          
    }
}
