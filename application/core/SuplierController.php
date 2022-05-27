<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SuplierController extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        if ($this->userData->level != "SUPLIER") {
            redirect(base_url());
        }
    }
}
