<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RFLController extends MY_Controller
{
    public $userData;
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->has_userdata(SESSION)) {
            redirect(base_url("auth/login"));
        }
        $this->load->model("Admin_model", "admin");
        $this->userData = $this->admin->where(["id" => $this->session->userdata(SESSION)["id"]])->as_object()->get();        
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
