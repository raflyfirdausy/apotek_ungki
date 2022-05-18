<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Admin_model", "admin");
    }

    public function index()
    {
        $admin = $this->admin->where(["id" => $this->userData->id])->as_object()->get();
        $data = [
            "admin" => $admin
        ];

        $this->loadViewBack("master/apotek/profile/data_profile", $data);
    }

    public function change_password()
    {
        d($_POST);
    }
}
