<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemesanan_obat extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Suplier_model", "suplier");
        $this->load->model("VObat_model", "vObat");
        $this->load->model("Trpemesanan_model", "trPemesanan");
        $this->load->model("Trpemesanan_detail_model", "trPemesananDetail");
        $this->load->model("VPemesanan_model", "vPemesanan");
        $this->load->model("VDetail_pemesanan_model", "vPemesananDetail");
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
            "title"     => "Laporan Pemesanan Obat",
            "awal"      => $awal,
            "akhir"     => $akhir
        ];
        $this->loadViewBack("laporan/apotek/pemesanan_obat/data_pemesanan", $data);
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

        $data               = $this->filterDataTable($this->vPemesanan)->where("tgl_faktur", ">=", $awal)->where("tgl_faktur", "<=", $akhir)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->vPemesanan)->where("tgl_faktur", ">=", $awal)->where("tgl_faktur", "<=", $akhir)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->vPemesanan->where("tgl_faktur", ">=", $awal)->where("tgl_faktur", "<=", $akhir)->count_rows() ?: 0;

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
        $no_faktur      = isset($inputKolom) ? $inputKolom[2]["search"]["value"] : "";
        $tanggal        = isset($inputKolom) ? $inputKolom[3]["search"]["value"] : "";
        $suplier        = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";
        $total          = isset($inputKolom) ? $inputKolom[5]["search"]["value"] : "";
        $status         = isset($inputKolom) ? $inputKolom[6]["search"]["value"] : "";
        $nama_admin     = isset($inputKolom) ? $inputKolom[7]["search"]["value"] : "";
        $created_at     = isset($inputKolom) ? $inputKolom[8]["search"]["value"] : "";

        if (!empty($no_faktur)) {
            $model = $model->where("LOWER(no_faktur)", "LIKE", strtolower($no_faktur));
        }

        if (!empty($tanggal)) {
            $model = $model->where("LOWER(tgl_faktur)", "LIKE", strtolower($tanggal));
        }

        if (!empty($suplier)) {
            $model = $model->where("LOWER(nama_suplier)", "LIKE", strtolower($suplier));
        }

        if (!empty($total)) {
            $model = $model->where("LOWER(total_obat)", "LIKE", strtolower($total));
        }

        if (!empty($status)) {
            $model = $model->where("LOWER(status_suplier)", "LIKE", strtolower($status));
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
