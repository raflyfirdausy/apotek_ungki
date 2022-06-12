<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi_obat extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("VTransaksi_model", "vTansaksi");
    }

    public function index()
    {
        if (empty($_GET)) {
            $awal       = date("Y-m-") . "01";
            $akhir      = date("Y-m-d");
        } else {
            $awal       = $this->input->get("awal");
            $akhir      = $this->input->get("akhir");
        }

        $data = [
            "title"     => "Mutasi Obat",
            "awal"      => $awal,
            "akhir"     => $akhir
        ];
        $this->loadViewBack("laporan/apotek/mutasi_obat/data_mutasi", $data);
    }

    public function get_data()
    {
        if (empty($_GET)) {
            $awal       = date("Y-m-") . "01";
            $akhir      = date("Y-m-d");
        } else {
            $awal       = $this->input->get("awal");
            $akhir      = $this->input->get("akhir");
        }

        $limit              = $this->input->post("length")  ?: 10;
        $offset             = $this->input->post("start")   ?: 0;

        $data               = $this->filterDataTable($this->vTansaksi)->where("created_at", ">=", $awal)->where("created_at", "<=", $akhir)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->vTansaksi)->where("created_at", ">=", $awal)->where("created_at", "<=", $akhir)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->vTansaksi->where("created_at", ">=", $awal)->where("created_at", "<=", $akhir)->count_rows() ?: 0;

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
        $nama_obat      = isset($inputKolom) ? $inputKolom[1]["search"]["value"] : "";
        $stok_awal      = isset($inputKolom) ? $inputKolom[2]["search"]["value"] : "";
        $stok_akhir     = isset($inputKolom) ? $inputKolom[3]["search"]["value"] : "";
        $keterangan     = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";
        $jenis          = isset($inputKolom) ? $inputKolom[5]["search"]["value"] : "";
        $nama_admin     = isset($inputKolom) ? $inputKolom[6]["search"]["value"] : "";
        $created_at     = isset($inputKolom) ? $inputKolom[7]["search"]["value"] : "";

        if (!empty($nama_obat)) {
            $model = $model->where("LOWER(nama_obat)", "LIKE", strtolower($nama_obat));
        }

        if (!empty($stok_awal)) {
            $model = $model->where("LOWER(stok_awal)", "LIKE", strtolower($stok_awal));
        }

        if (!empty($stok_akhir)) {
            $model = $model->where("LOWER(stok_akhir)", "LIKE", strtolower($stok_akhir));
        }

        if (!empty($keterangan)) {
            $model = $model->where("LOWER(keterangan)", "LIKE", strtolower($keterangan));
        }

        if (!empty($jenis)) {
            $model = $model->where("LOWER(jenis)", "LIKE", strtolower($jenis));
        }

        if (!empty($nama_admin)) {
            $model = $model->where("LOWER(nama_admin)", "LIKE", strtolower($nama_admin));
        }

        if (!empty($created_at)) {
            $model = $model->where("LOWER(created_at)", "LIKE", strtolower($created_at));
        }


        return $model;
    }
}
