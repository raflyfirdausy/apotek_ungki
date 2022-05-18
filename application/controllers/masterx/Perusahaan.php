<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perusahaan extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Region_model", "region");
        $this->load->model("Perusahaan_model", "perusahaan");
        $this->load->model("VPerusahaan_model", "vPerusahaan");
    }

    public function index()
    {
        $data = [
            "region"    => $this->region->get_all()
        ];
        $this->loadViewBack("master/perusahaan/index", $data);
    }

    public function get_data()
    {
        $limit              = $this->input->post("length") ?: 10;
        $offset             = $this->input->post("start") ?: 0;

        $data               = $this->filterDataTable($this->vPerusahaan)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->vPerusahaan)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->vPerusahaan->count_rows() ?: 0;

        echo json_encode([
            "draw"              => $this->input->post("draw", TRUE),
            "data"              => $data,
            "recordsFiltered"   => $dataFilter,
            "recordsTotal"      => $dataCountAll,
        ]);
    }

    public function filterDataTable($model)
    {
        $inputKolom         = $this->input->post("columns");
        $nama_region        = isset($inputKolom) ? $inputKolom[2]["search"]["value"] : "";
        $nama_perusahaan    = isset($inputKolom) ? $inputKolom[3]["search"]["value"] : "";
        $keterangan         = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";
        $created_at         = isset($inputKolom) ? $inputKolom[5]["search"]["value"] : "";

        if (!empty($nama_region)) {
            $model = $model->where("LOWER(nama_region)", "LIKE", strtolower($nama_region));
        }

        if (!empty($nama_perusahaan)) {
            $model = $model->where("LOWER(nama)", "LIKE", strtolower($nama_perusahaan));
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
        $id_region  = $this->input->post("id_region");
        $nama       = $this->input->post("nama");
        $keterangan = $this->input->post("keterangan");

        $insert = $this->perusahaan->insert([
            "id_region"     => $id_region,
            "nama"          => $nama,
            "keterangan"    => $keterangan
        ]);
        if (!$insert) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menambahkan Perusahaan. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Perusahaan berhasil di tambahkan!"
        ]);
    }

    public function get($id = NULL)
    {
        $data = $this->vPerusahaan->where(["id" => $id])->get();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data Perusahaan tidak ditemukan, silahkan cobalah beberapa saat lagi"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data Perusahaan ditemukan",
            "data"      => $data
        ]);
    }

    public function edit()
    {
        $id_data    = $this->input->post("id_data");
        $id_region  = $this->input->post("id_region");
        $nama       = $this->input->post("nama");
        $keterangan = $this->input->post("keterangan");

        $cekData    = $this->perusahaan->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data Perusahaan tidak ditemukan"
            ]);
            die;
        }

        $dataUpdate = [
            "id_region"     => $id_region,
            "nama"          => $nama,
            "keterangan"    => $keterangan
        ];

        $update = $this->perusahaan->where(["id" => $cekData["id"]])->update($dataUpdate);
        if (!$update) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengedit perusahaan. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data Perusahaan berhasil di ubah !"
        ]);
    }

    public function delete()
    {
        $id_data    = $this->input->post("id_data");
        $cekData    = $this->perusahaan->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data perusahaan tidak ditemukan"
            ]);
            die;
        }

        $delete = $this->perusahaan->where(["id" => $cekData["id"]])->delete();
        if (!$delete) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menghapus perusahaan. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data perusahaan berhasil di hapus !"
        ]);
    }
}
