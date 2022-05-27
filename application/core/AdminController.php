<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        if ($this->userData->level != "KEPALA_APOTEK" || $this->userData->level != "KARYAWAN") {
            redirect(base_url());
        }
    }
}
