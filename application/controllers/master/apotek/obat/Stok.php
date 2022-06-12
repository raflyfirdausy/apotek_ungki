<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Golongan_obat_model", "golongan");
        $this->load->model("Kategori_obat_model", "kategori");
        $this->load->model("Satuan_obat_model", "satuan");
        $this->load->model("Obat_model", "obat");
        $this->load->model("VObat_model", "vObat");
        $this->load->model("StokObat_model", "stokObat");
        $this->load->model("Transaksi_obat_model", "trObat");
        $this->load->model("VStok_obat_model", "vStok");
    }

    public function index()
    {
        $data = [
            "title"     => "Master Data Stok Obat",
        ];
        $this->loadViewBack("master/apotek/obat/data_stok", $data);
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
        $min_stok       = isset($inputKolom) ? $inputKolom[7]["search"]["value"] : "";
        $stok           = isset($inputKolom) ? $inputKolom[8]["search"]["value"] : "";

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

        if (!empty($min_stok)) {
            $model = $model->where("LOWER(min_stok)", "LIKE", strtolower($min_stok));
        }

        if (!empty($stok)) {
            $model = $model->where("LOWER(stok)", "LIKE", strtolower($stok));
        }

        return $model;
    }

    public function detail($kode_obat = NULL)
    {
        $cek = $this->obat->where(["kode_obat" => $kode_obat])->get();
        if (!$cek) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Obat tidak ditemukan. Silahkan hubungi Programmer!"
            ]);
            die;
        }

        $data = [
            "title" => "Stok obat " . $cek["nama"] . " (" . $cek["kode_obat"] . ")",
            "obat"  => $cek
        ];

        $this->loadViewBack("master/apotek/obat/stok_obat_detail", $data);
    }

    public function get_data_detail($id_obat = NULL)
    {
        $limit              = $this->input->post("length")  ?: 10;
        $offset             = $this->input->post("start")   ?: 0;

        $data               = $this->filterDataTableDetail($this->vStok)->where(["id_obat" => $id_obat])->where("stok", ">", 0)->order_by("tgl_expired", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTableDetail($this->vStok)->where(["id_obat" => $id_obat])->where("stok", ">", 0)->order_by("tgl_expired", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->vStok->where(["id_obat" => $id_obat])->where("stok", ">", 0)->count_rows() ?: 0;

        echo json_encode([
            "draw"              => $this->input->post("draw", TRUE),
            "data"              => $data,
            "recordsFiltered"   => $dataFilter,
            "recordsTotal"      => $dataCountAll,
        ]);
    }

    public function filterDataTableDetail($model)
    {
        $inputKolom     = $this->input->post("columns");
        $nama           = isset($inputKolom) ? $inputKolom[1]["search"]["value"] : "";
        $stok           = isset($inputKolom) ? $inputKolom[2]["search"]["value"] : "";
        $satuan         = isset($inputKolom) ? $inputKolom[3]["search"]["value"] : "";
        $exp             = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";

        if (!empty($nama)) {
            $model = $model->where("LOWER(nama_obat)", "LIKE", strtolower($nama));
        }

        if (!empty($stok)) {
            $model = $model->where("LOWER(stok)", "LIKE", strtolower($stok));
        }

        if (!empty($satuan)) {
            $model = $model->where("LOWER(nama_satuan)", "LIKE", strtolower($satuan));
        }

        if (!empty($exp)) {
            $model = $model->where("LOWER(tgl_expired)", "LIKE", strtolower($exp));
        }        

        return $model;
    }

    public function add()
    {
        $id_obat        = $this->input->post("id_obat");
        $stok           = $this->input->post("stok");
        $tgl_expired    = $this->input->post("tgl_expired");

        if($stok < 1){
            echo json_encode([
                "code"      => 503,
                "message"   => "Stok obat tidak boleh kurang dari 1. Silahkan periksa kembali !"
            ]);
            die;
        }

        $cek = $this->stokObat->where([
            "id_obat"    => $id_obat,
            "tgl_expired" => $tgl_expired
        ])->get();

        if ($cek) {
            $stok += $cek["stok"];

            //TODO : UPDATE STOK OBAT
            $update = $this->stokObat->where(["id" => $cek["id"]])->update(["stok" => $stok]);
            if (!$update) {
                echo json_encode([
                    "code"      => 503,
                    "message"   => "Stok obat gagal diperbaharui. Silahkan hubungi Programmer!"
                ]);
                die;
            }

            //TODO : INSERT INTO TR_TRANSAKSI_OBAT
            $this->trObat->insert([
                "id_admin"      => $this->userData->id,
                "id_obat"       => $id_obat,
                "id_stok"       => $cek["id"],
                "tanggal"       => date("Y-m-d"),
                "stok_awal"     => $cek["stok"],
                "stok_akhir"    => $stok,
                "jenis"         => "TAMBAH STOK",
                "keterangan"    => "Penambahan stok obat secara manual"
            ]);

            echo json_encode([
                "code"      => 200,
                "message"   => "Berhasil menambahkan stok obat secara manual"
            ]);
            die;
        } else {
            $insert = $this->stokObat->insert([
                "id_obat"       => $id_obat,
                "stok"          => $stok,
                "tgl_expired"   => $tgl_expired
            ]);
            if (!$insert) {
                echo json_encode([
                    "code"      => 503,
                    "message"   => "Stok obat gagal diperbaharui. Silahkan hubungi Programmer!"
                ]);
                die;
            }

            //TODO : INSERT INTO TR_TRANSAKSI_OBAT
            $this->trObat->insert([
                "id_admin"      => $this->userData->id,
                "id_obat"       => $id_obat,
                "id_stok"       => $insert,
                "tanggal"       => date("Y-m-d"),
                "stok_awal"     => 0,
                "stok_akhir"    => $stok,
                "jenis"         => "TAMBAH STOK",
                "keterangan"    => "Penambahan stok obat secara manual"
            ]);

            echo json_encode([
                "code"      => 200,
                "message"   => "Berhasil menambahkan stok obat secara manual"
            ]);
            die;
        }
    }
}
