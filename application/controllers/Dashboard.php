<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends RFLController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("Admin_model", "pengguna");
        $this->load->model("Suplier_model", "suplier");
        $this->load->model("Golongan_obat_model", "golongan");
        $this->load->model("Kategori_obat_model", "kategori");
        $this->load->model("Satuan_obat_model", "satuan");
        $this->load->model("Obat_model", "obat");
        $this->load->model("Trpemesanan_model", "trPemesanan");
    }

    public function index()
    {

        $totalKaryawan  = $this->pengguna->where(["level" => "KARYAWAN"])->count_rows() ?: 0;
        $totalSuplier   = $this->pengguna->where(["level" => "SUPLIER"])->count_rows() ?: 0;
        $suplier        = $this->suplier->count_rows() ?: 0;

        $totalGolongan  = $this->golongan->count_rows() ?: 0;
        $totalKategori  = $this->kategori->count_rows() ?: 0;
        $totalSatuan    = $this->satuan->count_rows() ?: 0;
        $totalObat      = $this->obat->count_rows() ?: 0;

        if ($this->userData->level == "SUPLIER") {
            $menunggu       = $this->trPemesanan->where(["id_suplier" => $this->userData->id_suplier])->where(["status_suplier" => "MENUNGGU"])->count_rows() ?: 0;
            $diterima       = $this->trPemesanan->where(["id_suplier" => $this->userData->id_suplier])->where(["status_suplier" => "DI_TERIMA"])->count_rows() ?: 0;
            $ditolak        = $this->trPemesanan->where(["id_suplier" => $this->userData->id_suplier])->where(["status_suplier" => "DI_TOLAK"])->count_rows() ?: 0;
        } else {
            $menunggu       = $this->trPemesanan->where(["status_suplier" => "MENUNGGU"])->count_rows() ?: 0;
            $diterima       = $this->trPemesanan->where(["status_suplier" => "DI_TERIMA"])->count_rows() ?: 0;
            $ditolak        = $this->trPemesanan->where(["status_suplier" => "DI_TOLAK"])->count_rows() ?: 0;
        }

        $total          = $menunggu + $diterima + $ditolak;

        $data = [
            "totalKaryawan"     => $totalKaryawan,
            "totalSuplier"      => $totalSuplier,
            "suplier"           => $suplier,
            "totalGolongan"     => $totalGolongan,
            "totalKategori"     => $totalKategori,
            "totalSatuan"       => $totalSatuan,
            "totalObat"         => $totalObat,
            "menunggu"          => $menunggu,
            "diterima"          => $diterima,
            "ditolak"           => $ditolak,
            "total"             => $total
        ];

        if ($this->userData->level == "SUPLIER") {
            $this->loadViewBack("dashboard/dashboard_suplier", $data);
        } else {
            $this->loadViewBack("dashboard/dashboard_admin", $data);
        }
    }
}
