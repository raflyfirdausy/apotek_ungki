<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wa_Controller extends CI_Controller
{
    public $userData;
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance(); //MENGGANTI $this
        $this->global_data = [
            "app_name"          => "WA BOT",
            "app_complete_name" => "Whatsapp BOT",
            "CI"                => $CI,
            "_session"          => $CI->session->userdata("WHATSAPP"),
            "title"             => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "module_name"       => $this->router->fetch_class(),
        ];

        $classNoAuth = ["auth"];
        if (!in_array($this->router->fetch_class(), $classNoAuth)) {
            if (!$this->session->has_userdata("WHATSAPP")) {
                redirect(base_url("whatsapp/auth/login"));
            }

            $db2 = $this->load->database('pegasus', TRUE);
            $db2->select('*');
            $db2->from('master.view_pegawai');
            $db2->where(array('nip' => $this->session->userdata("WHATSAPP")["simas"]->nip));
            $data      = $db2->get()->row();
            $this->userData = $data;
        }

        // $this->load->model("Log_http_model", "logHttp");

        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     $this->logHttp->insert([
        //         "SERVER_NAME"       => $_SERVER['SERVER_NAME'],
        //         "REQUEST_URI"       => $_SERVER["REQUEST_URI"],
        //         "REQUEST_METHOD"    => $_SERVER['REQUEST_METHOD'],
        //         "QUERY_STRING"      => $_SERVER['QUERY_STRING'],
        //         "HTTP_USER_AGENT"   => $_SERVER['HTTP_USER_AGENT'],
        //         "HTTP_COOKIE"       => $_SERVER['HTTP_COOKIE'],
        //         "HTTP_CONTENT_TYPE" => $_SERVER['HTTP_CONTENT_TYPE'],
        //         "REQUEST_TIME"      => $_SERVER['REQUEST_TIME'],
        //         "DATA_SESSION"      => json_encode($_SESSION),
        //         "DATA_POST"         => json_encode($_POST),
        //         "NIP_ADMIN"         => $this->userData->nip,
        //         "SERVER_PORT"       => $_SERVER['SERVER_PORT'],
        //     ]);
        // }
    }

    protected function loadViewWa($view = NULL, $local_data = array(), $asData = FALSE)
    {
        // if (!file_exists(APPPATH . "views/whatsapp/$view" . ".php")) {
        //     show_404();                       
        // }

        $this->loadViewBase("whatsapp/template/header", $local_data, $asData);
        $this->loadViewBase("whatsapp/template/sidebar", $local_data, $asData);
        $this->loadViewBase("whatsapp/$view", $local_data, $asData);
        $this->loadViewBase("whatsapp/template/footer", $local_data, $asData);
    }

    public function loadViewBase($view = NULL, $local_data = array(), $asData = FALSE)
    {
        $data = array_merge($this->global_data, $local_data);
        return $this->load->view($view, $data, $asData);
    }
}
