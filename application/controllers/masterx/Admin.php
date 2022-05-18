<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Admin_model", "admin");
    }

    public function index()
    {
        $data = [];
        $this->loadViewBack("master/admin/index", $data);
    }

    public function get_data()
    {
        $limit              = $this->input->post("length") ?: 10;
        $offset             = $this->input->post("start") ?: 0;

        $data               = $this->filterDataTable($this->admin)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->admin)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->admin->count_rows() ?: 0;

        for ($i = 0; $i < sizeof($data); $i++) {
            unset($data[$i]["password"]);
        }

        echo json_encode([
            "draw"              => $this->input->post("draw", TRUE),
            "data"              => $data,
            "recordsFiltered"   => $dataFilter,
            "recordsTotal"      => $dataCountAll,
        ]);
    }

    public function filterDataTable($model)
    {
        $inputKolom     = $this->input->post("columns");
        $email          = isset($inputKolom) ? $inputKolom[2]["search"]["value"] : "";
        $nama           = isset($inputKolom) ? $inputKolom[3]["search"]["value"] : "";
        $no_hp          = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";
        $keterangan     = isset($inputKolom) ? $inputKolom[5]["search"]["value"] : "";
        $created_at     = isset($inputKolom) ? $inputKolom[6]["search"]["value"] : "";

        if (!empty($email)) {
            $model = $model->where("LOWER(email)", "LIKE", strtolower($email));
        }

        if (!empty($nama)) {
            $model = $model->where("LOWER(nama)", "LIKE", strtolower($nama));
        }

        if (!empty($no_hp)) {
            $model = $model->where("LOWER(no_hp)", "LIKE", strtolower($no_hp));
        }

        if (!empty($keterangan)) {
            $model = $model->where("LOWER(keterangan)", "LIKE", strtolower($keterangan));
        }

        if (!empty($created_at)) {
            $model = $model->where("LOWER(created_at)", "LIKE", strtolower($created_at));
        }

        return $model;
    }

    public function get($id = NULL)
    {
        $data = $this->admin->where(["id" => $id])->get();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data admin tidak ditemukan, silahkan cobalah beberapa saat lagi"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data admin ditemukan",
            "data"      => $data
        ]);
    }

    public function add()
    {
        $email      = $this->input->post("email");
        $password   = md5($this->input->post("password"));
        $nama       = $this->input->post("nama");
        $no_hp      = $this->input->post("no_telp");
        $keterangan = $this->input->post("keterangan");

        $cekAdmin   = $this->admin->where(["email" => $email])->get();
        if ($cekAdmin) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Email sudah terdaftar. Silahkan gunakan email yang lain!"
            ]);
            die;
        }

        $insert = $this->admin->insert([
            "email"         => $email,
            "password"      => $password,
            "nama"          => $nama,
            "level"         => "SUPER_ADMIN",
            "no_hp"         => $no_hp,
            "keterangan"    => $keterangan
        ]);
        if (!$insert) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menambahkan admin. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Admin berhasil di tambahkan atas nama $nama !"
        ]);
    }

    public function edit()
    {
        $id_data    = $this->input->post("id_data");
        $password   = md5($this->input->post("password"));
        $nama       = $this->input->post("nama");
        $no_hp      = $this->input->post("no_telp");
        $keterangan = $this->input->post("keterangan");

        $cekData    = $this->admin->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data admin tidak ditemukan"
            ]);
            die;
        }

        $dataUpdate = [
            "nama"          => $nama,
            "no_hp"         => $no_hp,
            "keterangan"    => $keterangan
        ];
        if (!empty($password)) {
            $dataUpdate["password"] = md5($password);
        }

        $update = $this->admin->where(["id" => $cekData->id])->update($dataUpdate);
        if (!$update) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengedit admin. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Admin berhasil di ubah !"
        ]);
    }

    public function delete()
    {
        $id_data    = $this->input->post("id_data");
        $cekData    = $this->admin->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data admin tidak ditemukan"
            ]);
            die;
        }

        $delete = $this->admin->where(["id" => $cekData->id])->delete();
        if (!$delete) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menghapus admin. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Admin berhasil di hapus !"
        ]);
    }
}
