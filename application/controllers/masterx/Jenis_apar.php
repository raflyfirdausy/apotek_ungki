<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_apar extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("JenisApar_model", "jenisApar");
    }

    public function index()
    {
        $data = [];
        $this->loadViewBack("master/jenis_apar/index", $data);
    }

    public function get_data()
    {
        $limit              = $this->input->post("length") ?: 10;
        $offset             = $this->input->post("start") ?: 0;

        $data               = $this->filterDataTable($this->jenisApar)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->jenisApar)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->jenisApar->count_rows() ?: 0;

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
        $nama           = isset($inputKolom) ? $inputKolom[2]["search"]["value"] : "";
        $keterangan     = isset($inputKolom) ? $inputKolom[3]["search"]["value"] : "";
        $created_at     = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";

        if (!empty($nama)) {
            $model = $model->where("LOWER(nama)", "LIKE", strtolower($nama));
        }

        if (!empty($keterangan)) {
            $model = $model->where("LOWER(keterangan)", "LIKE", strtolower($keterangan));
        }

        if (!empty($created_at)) {
            $model = $model->where("LOWER(created_at)", "LIKE", strtolower($created_at));
        }

        return $model;
    }

    public function add()
    {
        $nama       = $this->input->post("nama");
        $keterangan = $this->input->post("keterangan");

        $insert = $this->jenisApar->insert([
            "nama"          => $nama,
            "keterangan"    => $keterangan
        ]);
        if (!$insert) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menambahkan Jenis APAR. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Jenis APAR berhasil di tambahkan!"
        ]);
    }

    public function get($id = NULL)
    {
        $data = $this->jenisApar->where(["id" => $id])->get();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data Jenis APAR tidak ditemukan, silahkan cobalah beberapa saat lagi"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data Jenis APAR ditemukan",
            "data"      => $data
        ]);
    }

    public function edit()
    {
        $id_data    = $this->input->post("id_data");
        $nama       = $this->input->post("nama");
        $keterangan = $this->input->post("keterangan");

        $cekData    = $this->jenisApar->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data jenis APAR tidak ditemukan"
            ]);
            die;
        }

        $dataUpdate = [
            "nama"          => $nama,
            "keterangan"    => $keterangan
        ];

        $update = $this->jenisApar->where(["id" => $cekData["id"]])->update($dataUpdate);
        if (!$update) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengedit jenis APAR. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data jenis APAR berhasil di ubah !"
        ]);
    }

    public function delete()
    {
        $id_data    = $this->input->post("id_data");
        $cekData    = $this->jenisApar->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data jenis APAR tidak ditemukan"
            ]);
            die;
        }

        $delete = $this->jenisApar->where(["id" => $cekData["id"]])->delete();
        if (!$delete) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menghapus jenis APAR. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data jenis APAR berhasil di hapus !"
        ]);
    }
}
