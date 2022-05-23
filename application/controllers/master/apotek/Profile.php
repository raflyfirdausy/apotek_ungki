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

    public function change_profile()
    {
        $id             = $this->userData->id;
        $username       = $this->input->post('username');
        $nama           = $this->input->post('nama');
        $no_hp          = $this->input->post('no_hp');
        $jenis_kelamin  = $this->input->post('jenis_kelamin');

        $data = [
            "username" => $username,
            "nama" => $nama,
            "no_hp" => $no_hp,
            "jenis_kelamin" => $jenis_kelamin
        ];

        $update = $this->admin->where(["id" => $id])->update($data);
        if (!$update) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengedit data profile. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data profile berhasil di ubah !"
        ]);
    }

    public function change_password()
    {
        $id                     = $this->userData->id;
        $password_lama          = $this->input->post("password_lama");
        $password_baru          = $this->input->post("password_baru");
        $password_konfirmasi    = $this->input->post("password_konfirmasi");

        $_user = $this->admin->where(["id" => $id])->as_array()->get();
        if (!$_user) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengubah password. Profile bermasalah. Silahkan hubungi programmer"
            ]);
            die;
        }

        if ($password_baru != $password_konfirmasi) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengubah password. Keterangan : Konfirmasi password tidak sama dengan password baru"
            ]);
            die;
        }

        if ($password_baru == "") {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengubah password. Keterangan : Password baru tidak boleh kosong"
            ]);
            die;
        }

        if (md5($password_lama) != $_user["password"]) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengubah password. Keterangan : Password lama yang anda masukan salah !"
            ]);
            die;
        }

        $update = $this->admin->where(["id" => $id])->update(["password" => md5($password_baru)]);
        if (!$update) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengubah password. Silahkan hubungi programmer"
            ]);
            die;
        }

        $this->session->sess_destroy();
        echo json_encode([
            "code"      => 200,
            "message"   => "Password berhasil diubah, silahkan masuk kembali dengan password yang baru"
        ]);
    }
}
