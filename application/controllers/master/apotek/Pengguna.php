<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Admin_model", "pengguna");
        $this->load->model("VAdmin_model", "vPengguna");
        $this->load->model("Suplier_model", "suplier");
    }

    public function index()
    {
        redirect("master/apotek/pengguna/kepala-apotek");
    }

    public function kepala_apotek()
    {
        $data = [
            "title" => "Kepala Apotek",
            "level" => "KEPALA_APOTEK"
        ];

        $this->loadViewBack("master/apotek/pengguna/data_kepala_apotek", $data);
    }

    public function karyawan()
    {
        $data = [
            "title" => "Karyawan",
            "level" => "KARYAWAN"
        ];

        $this->loadViewBack("master/apotek/pengguna/data_karyawan", $data);
    }

    public function suplier()
    {
        $data = [
            "title"     => "Suplier",
            "level"     => "SUPLIER",
            "suplier"   => $this->suplier->get_all()
        ];

        $this->loadViewBack("master/apotek/pengguna/data_suplier", $data);
    }

    public function get_data($level = null)
    {
        $limit              = $this->input->post("length")  ?: 10;
        $offset             = $this->input->post("start")   ?: 0;

        $data               = $this->filterDataTable($this->vPengguna)->where("level", "=", $level)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->vPengguna)->where("level", "=", $level)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->vPengguna->where("level", "=", $level)->count_rows() ?: 0;

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
        $username       = isset($inputKolom) ? $inputKolom[2]["search"]["value"] : "";
        $nama           = isset($inputKolom) ? $inputKolom[3]["search"]["value"] : "";
        $no_hp          = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";
        $jenis_kelamin  = isset($inputKolom) ? $inputKolom[5]["search"]["value"] : "";
        $created_at     = isset($inputKolom) ? $inputKolom[6]["search"]["value"] : "";
        $nama_suplier   = isset($inputKolom) && isset($inputKolom[7]) ? $inputKolom[7]["search"]["value"] : "";

        if (!empty($username)) {
            $model = $model->where("LOWER(username)", "LIKE", strtolower($username));
        }

        if (!empty($nama)) {
            $model = $model->where("LOWER(nama)", "LIKE", strtolower($nama));
        }

        if (!empty($no_hp)) {
            $model = $model->where("LOWER(no_hp)", "LIKE", strtolower($no_hp));
        }

        if (!empty($jenis_kelamin)) {
            $model = $model->where("LOWER(jenis_kelamin)", "LIKE", strtolower($jenis_kelamin));
        }

        if (!empty($created_at)) {
            $model = $model->where("LOWER(created_at)", "LIKE", strtolower($created_at));
        }

        if (!empty($nama_suplier)) {
            $model = $model->where("LOWER(nama_suplier)", "LIKE", strtolower($nama_suplier));
        }


        return $model;
    }

    public function get($id = NULL)
    {
        $data = $this->pengguna->where(["id" => $id])->get();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data pengguna tidak ditemukan, silahkan cobalah beberapa saat lagi"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data pengguna ditemukan",
            "data"      => $data
        ]);
    }

    public function add()
    {
        $username       = $this->input->post("username");
        $password       = md5($this->input->post("password"));
        $nama           = $this->input->post("nama");
        $no_hp          = $this->input->post("no_telp");
        $jenis_kelamin  = $this->input->post("jenis_kelamin");
        $level          = $this->input->post("level");
        $id_suplier     = $this->input->post("id_suplier");

        $cekAdmin   = $this->pengguna->where(["username" => $username])->get();
        if ($cekAdmin) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Username sudah terdaftar. Silahkan gunakan username yang lain!"
            ]);
            die;
        }

        $insert = $this->admin->insert([
            "username"      => $username,
            "password"      => $password,
            "nama"          => $nama,
            "level"         => $level,
            "no_hp"         => $no_hp,
            "jenis_kelamin"    => $jenis_kelamin,
            "id_suplier"    => $id_suplier
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
        $id_data        = $this->input->post("id_data");
        $password       = md5($this->input->post("password"));
        $nama           = $this->input->post("nama");
        $no_hp          = $this->input->post("no_telp");
        $jenis_kelamin  = $this->input->post("jenis_kelamin");
        $id_suplier     = $this->input->post("id_suplier");

        $cekData    = $this->pengguna->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data admin tidak ditemukan"
            ]);
            die;
        }

        $dataUpdate = [
            "nama"              => $nama,
            "no_hp"             => $no_hp,
            "jenis_kelamin"     => $jenis_kelamin,
            "id_suplier"    => $id_suplier
        ];

        if (!empty($password)) {
            $dataUpdate["password"] = md5($password);
        }

        $update = $this->pengguna->where(["id" => $cekData["id"]])->update($dataUpdate);
        if (!$update) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengedit Pengguna. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Pengguna berhasil di ubah !"
        ]);
    }

    public function delete()
    {
        $id_data    = $this->input->post("id_data");
        $cekData    = $this->pengguna->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data pengguna tidak ditemukan"
            ]);
            die;
        }

        $delete = $this->pengguna->where(["id" => $cekData["id"]])->delete();
        if (!$delete) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menghapus pengguna. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Pengguna berhasil di hapus !"
        ]);
    }
}
