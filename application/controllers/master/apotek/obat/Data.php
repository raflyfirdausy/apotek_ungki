<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Golongan_obat_model", "golongan");
        $this->load->model("Kategori_obat_model", "kategori");
        $this->load->model("Satuan_obat_model", "satuan");
        $this->load->model("Obat_model", "obat");
        $this->load->model("VObat_model", "vObat");
    }

    public function index()
    {
        $data = [
            "title"     => "Master Data Obat",
        ];
        $this->loadViewBack("master/apotek/obat/data_obat", $data);
    }

    public function tambah()
    {
        $kodeObat = "OBT" . date("ymd") . "0001";
        $getKode = $this->obat->where("kode_obat", "LIKE", date("ymd"))->order_by("kode_obat", "DESC")->get();
        if ($getKode) {
            $lastKode = (int) substr($getKode["kode_obat"], -4);
            $kodeObat = "OBT" . date("ymd") . str_pad((string)($lastKode + 1), 4, "0", STR_PAD_LEFT);
        }
        $data = [
            "title"     => "Tambah Master Data Obat",
            "kode_obat" => $kodeObat,
            "golongan"  => $this->golongan->order_by("nama", "ASC")->get_all(),
            "kategori"  => $this->kategori->order_by("nama", "ASC")->get_all(),
            "satuan"    => $this->satuan->order_by("nama", "ASC")->get_all(),
        ];
        $this->loadViewBack("master/apotek/obat/data_obat_tambah", $data);
    }

    public function ubah($kode_obat = NULL)
    {
        $cekObat = $this->vObat->where(["kode_obat" => $kode_obat])->get();
        if (!$cekObat) {
            $this->session->set_flashdata("gagal", "Data Obat tidak ditemukan");
            redirect("master/apotek/obat/data");
        }

        $data = [
            "obat"  => $cekObat,
            "title"     => "Edit Master Data Obat",
            "golongan"  => $this->golongan->order_by("nama", "ASC")->get_all(),
            "kategori"  => $this->kategori->order_by("nama", "ASC")->get_all(),
            "satuan"    => $this->satuan->order_by("nama", "ASC")->get_all(),
        ];

        $this->loadViewBack("master/apotek/obat/data_obat_ubah", $data);
    }

    public function get_data()
    {
        $limit              = $this->input->post("length")  ?: 10;
        $offset             = $this->input->post("start")   ?: 0;

        $data               = $this->filterDataTable($this->vObat)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->vObat)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->vObat->count_rows() ?: 0;

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
        $kode           = isset($inputKolom) ? $inputKolom[2]["search"]["value"] : "";
        $nama           = isset($inputKolom) ? $inputKolom[3]["search"]["value"] : "";
        $golongan       = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";
        $kategori       = isset($inputKolom) ? $inputKolom[5]["search"]["value"] : "";
        $satuan         = isset($inputKolom) ? $inputKolom[6]["search"]["value"] : "";
        $stok           = isset($inputKolom) ? $inputKolom[7]["search"]["value"] : "";
        $min_stok       = isset($inputKolom) ? $inputKolom[8]["search"]["value"] : "";
        $created_at     = isset($inputKolom) ? $inputKolom[9]["search"]["value"] : "";

        if (!empty($kode)) {
            $model = $model->where("LOWER(kode_obat)", "LIKE", strtolower($kode));
        }

        if (!empty($nama)) {
            $model = $model->where("LOWER(nama)", "LIKE", strtolower($nama));
        }

        if (!empty($golongan)) {
            $model = $model->where("LOWER(nama_golongan)", "LIKE", strtolower($golongan));
        }

        if (!empty($kategori)) {
            $model = $model->where("LOWER(nama_kategori)", "LIKE", strtolower($kategori));
        }

        if (!empty($satuan)) {
            $model = $model->where("LOWER(nama_satuan)", "LIKE", strtolower($satuan));
        }

        if (!empty($stok)) {
            $model = $model->where("LOWER(stok)", "LIKE", strtolower($stok));
        }

        if (!empty($min_stok)) {
            $model = $model->where("LOWER(min_stok)", "LIKE", strtolower($min_stok));
        }

        if (!empty($created_at)) {
            $model = $model->where("LOWER(created_at)", "LIKE", strtolower($created_at));
        }

        return $model;
    }

    public function add()
    {
        $kode           = $this->input->post("kode");
        $nama           = $this->input->post("nama");
        $id_golongan    = $this->input->post("id_golongan");
        $id_kategori    = $this->input->post("id_kategori");
        $id_satuan      = $this->input->post("id_satuan");
        $stok           = $this->input->post("stok");
        $min_stok       = $this->input->post("min_stok");
        $deskripsi      = $this->input->post("deskripsi");
        $indikasi       = $this->input->post("indikasi");
        $kemasan        = $this->input->post("kemasan");
        $dosis          = $this->input->post("dosis");
        $kandungan      = $this->input->post("kandungan");
        $efek_samping   = $this->input->post("efek_samping");

        $cekKode = $this->obat->where(["kode_obat" => $kode])->get();
        if ($cekKode) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Kode obat sudah terdaftar. Silahkan gunakan Kode yang lain!"
            ]);
            die;
        }

        $data = [
            "id_golongan" => $id_golongan,
            "id_kategori" => $id_kategori,
            "id_satuan"   => $id_satuan,
            "kode_obat"   => $kode,
            "nama"        => $nama,
            "stok"        => $stok,
            "min_stok"    => $min_stok,
            "deskripsi"   => $deskripsi,
            "indikasi"    => $indikasi,
            "kandungan"   => $kandungan,
            "dosis"       => $dosis,
            "kemasan"     => $kemasan,
            "efek_samping" => $efek_samping,
        ];

        $insert = $this->obat->insert($data);
        if (!$insert) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menambahkan data obat. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Obat berhasil di tambahkan dengan nama $nama !"
        ]);
    }

    public function delete()
    {
        $id_data    = $this->input->post("id_data");

        $delete = $this->obat->where(["id" => $id_data])->delete();
        if (!$delete) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menghapus obat. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data obat berhasil di hapus !"
        ]);
    }

    public function edit()
    {
        $id_data        = $this->input->post("id_data");
        $nama           = $this->input->post("nama");
        $id_golongan    = $this->input->post("id_golongan");
        $id_kategori    = $this->input->post("id_kategori");
        $id_satuan      = $this->input->post("id_satuan");
        $stok           = $this->input->post("stok");
        $min_stok       = $this->input->post("min_stok");
        $deskripsi      = $this->input->post("deskripsi");
        $indikasi       = $this->input->post("indikasi");
        $kemasan        = $this->input->post("kemasan");
        $dosis          = $this->input->post("dosis");
        $kandungan      = $this->input->post("kandungan");
        $efek_samping   = $this->input->post("efek_samping");

        $dataUpdate = [
            "id_golongan" => $id_golongan,
            "id_kategori" => $id_kategori,
            "id_satuan"   => $id_satuan,
            "nama"        => $nama,
            "stok"        => $stok,
            "min_stok"    => $min_stok,
            "deskripsi"   => $deskripsi,
            "indikasi"    => $indikasi,
            "kandungan"   => $kandungan,
            "dosis"       => $dosis,
            "kemasan"     => $kemasan,
            "efek_samping" => $efek_samping,
        ];

        $cekData    = $this->obat->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data Obat Obat tidak ditemukan"
            ]);
            die;
        }

        $update = $this->obat->where(["id" => $cekData["id"]])->update($dataUpdate);
        if (!$update) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengedit Obat. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Obat berhasil di ubah !"
        ]);
    }
}
