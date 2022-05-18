<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My404 extends RFLController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->output->set_status_header('404');
        $this->loadViewBack("my_error/error_404");
    }
}
