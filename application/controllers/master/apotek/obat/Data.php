<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Golongan_obat_model", "golongan");
    }

    public function index()
    {
        $data = [
            "title"     => "Data Obat",
        ];
        $this->loadViewBack("master/apotek/obat/data_obat", $data);
    }
}
