<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Obat_kadaluarsa extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("VKadaluarsa_model", "vKadaluarsa");
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
            "title"     => "Data Obat Akan Kadaluarsa dan sudah kadaluarsa",
            "awal"      => $awal,
            "akhir"     => $akhir
        ];
        $this->loadViewBack("laporan/apotek/obat_kadaluarsa/data_kadaluarsa", $data);
    }

    public function get_data($status = NULL)
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

        $data               = $this->filterDataTable($this->vKadaluarsa)->where("tgl_expired", ">=", $awal)->where("tgl_expired", "<=", $akhir)->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->vKadaluarsa)->where("tgl_expired", ">=", $awal)->where("tgl_expired", "<=", $akhir)->count_rows() ?: 0;
        $dataCountAll       = $this->vKadaluarsa->where("tgl_expired", ">=", $awal)->where("tgl_expired", "<=", $akhir)->count_rows() ?: 0;

        for ($i = 0; $i < sizeof($data); $i++) {
            $now = time(); // or your date as well
            $your_date = strtotime($data[$i]["tgl_expired"]);
            $datediff = $now - $your_date;

            $data[$i]["interval"]  = round($datediff / (60 * 60 * 24));
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
        $nama_obat      = isset($inputKolom) ? $inputKolom[1]["search"]["value"] : "";
        $tgl_expired    = isset($inputKolom) ? $inputKolom[2]["search"]["value"] : "";
        $stok           = isset($inputKolom) ? $inputKolom[3]["search"]["value"] : "";
        $nama_satuan    = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";

        if (!empty($nama_obat)) {
            $model = $model->where("LOWER(nama_obat)", "LIKE", strtolower($nama_obat));
        }

        if (!empty($stok)) {
            $model = $model->where("LOWER(stok)", "LIKE", strtolower($stok));
        }

        if (!empty($tgl_expired)) {
            $model = $model->where("LOWER(tgl_expired)", "LIKE", strtolower($tgl_expired));
        }

        if (!empty($nama_satuan)) {
            $model = $model->where("LOWER(nama_satuan)", "LIKE", strtolower($nama_satuan));
        }

        return $model;
    }
}
