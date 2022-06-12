<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RFLController extends MY_Controller
{
    public $userData;
    public $kadaluarsa;
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->has_userdata(SESSION)) {
            redirect(base_url("auth/login"));
        }
        $this->load->model("Admin_model", "admin");
        $this->userData = $this->admin->where(["id" => $this->session->userdata(SESSION)["id"]])->as_object()->get();


        $this->load->model("VKadaluarsa_model", "vKadaluarsa");
        $dataKadaluarsa["total"]    = $this->vKadaluarsa->as_array()->count_rows() ?: 0;
        $dataKadaluarsa["sample"]   = $this->vKadaluarsa->with_obat()->as_array()->order_by("tgl_expired", "ASC")->limit(10)->get_all();
        $dataKadaluarsa["awal"]     = $this->vKadaluarsa->as_array()->order_by("tgl_expired", "ASC")->limit(1)->get();
        $dataKadaluarsa["akhir"]    = $this->vKadaluarsa->as_array()->order_by("tgl_expired", "DESC")->limit(1)->get();
        $this->kadaluarsa = $dataKadaluarsa;        
    }

    protected function loadViewBack($view = NULL, $local_data = array(), $asData = FALSE)
    {
        if (!file_exists(APPPATH . "views/$view" . ".php")) {
            show_404();
        }

        $this->loadView("template/header", $local_data, $asData);
        $this->loadView("template/sidebar", $local_data, $asData);
        $this->loadView($view, $local_data, $asData);
        $this->loadView("template/footer", $local_data, $asData);
    }
}
