<?php

use function PHPSTORM_META\map;

defined('BASEPATH') or exit('No direct script access allowed');

class Form extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Region_model", "region");
        $this->load->model("Perusahaan_model", "perusahaan");
        $this->load->model("VPerusahaan_model", "vPerusahaan");
        $this->load->model("Unit_model", "unit");
        $this->load->model("VUnit_model", "vUnit");
        $this->load->model("TRApar_model", "trApar");
        $this->load->model("JenisApar_model", "jenisApar");
    }

    public function index()
    {
        $data = [
            "region"        => $this->region->get_all(),
            "jenis_apar"    => $this->jenisApar->get_all()
        ];
        $this->loadView('form/index', $data);
    }

    public function findPerusahaan($id_region = NULL)
    {
        $data = $this->perusahaan->where(["id_region" => $id_region])->get_all();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data perusahaan tidak ditemukan!",
                "data"      => NULL
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data perusahaan ditemukan!",
            "data"      => $data
        ]);
    }

    public function findUnit($id_perusahaan = NULL)
    {
        $data = $this->unit->where(["id_perusahaan" => $id_perusahaan])->get_all();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data unit tidak ditemukan!",
                "data"      => NULL
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data unit ditemukan!",
            "data"      => $data
        ]);
    }

    public function proses()
    {
        $dataInput = [
            "id_region"             => $this->input->post("id_region"),
            "id_perusahaan"         => $this->input->post("id_perusahaan"),
            "id_unit"               => $this->input->post("id_unit"),
            "tanggal"               => $this->input->post("tanggal"),
            "lokasi"                => $this->input->post("lokasi"),
            "kode_apar"             => $this->input->post("kode_apar"),
            "id_jenis_apar"         => $this->input->post("jenis_apar"),
            "berat_apar"            => $this->input->post("berat_apar"),
            "handle"                => $this->input->post("handle"),
            "pressure"              => $this->input->post("pressure"),
            "pin"                   => $this->input->post("pin"),
            "selang"                => $this->input->post("selang"),
            "tabung"                => $this->input->post("tabung"),
            "posisi"                => $this->input->post("posisi"),
            "segitiga"              => $this->input->post("segitiga"),
            "label"                 => $this->input->post("label"),
            "berat"                 => $this->input->post("berat"),
            "powder"                => $this->input->post("powder"),
            "pengisian_terakhir"    => $this->input->post("pengisian_terakhir"),
            "pengisian_berikutnya"  => $this->input->post("pengisian_berikutnya"),
            "keterangan"            => $this->input->post("keterangan"),
        ];

        $insert = $this->trApar->insert($dataInput);
        if (!$insert) {
            $this->session->set_flashdata("gagal", "Terjadi kesalahan saat menambahkan data Inspeksi APAR. Silahkan hubungi Programmer");
        }
        $this->session->set_flashdata("sukses", "Data berhasil di simpan. Terimakasih sudah mengisi Inspeksi APAR P.T Evans Group Indonesia");
        redirect(base_url());
    }
}
