<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends RFLController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [];
        $this->loadViewBack("dashboard/index", $data);
    }
}
