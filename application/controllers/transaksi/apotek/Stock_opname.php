<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_opname extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Golongan_obat_model", "golongan");
        $this->load->model("Kategori_obat_model", "kategori");
        $this->load->model("Satuan_obat_model", "satuan");
        $this->load->model("Obat_model", "obat");
        $this->load->model("VObat_model", "vObat");
        $this->load->model("Transaksi_obat_model", "trObat");
        $this->load->model("VStok_obat_model", "vStok");
        $this->load->model("StokObat_model", "stok");
    }

    public function index()
    {
        $data = [
            "title"     => "Stock Opname Data Obat",
        ];
        $this->loadViewBack("transaksi/apotek/stock_opname/data_stock_opname", $data);
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

    public function get($id)
    {
        $data = $this->vObat->where(["id" => $id])->get();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data Obat tidak ditemukan, silahkan cobalah beberapa saat lagi"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data Obat ditemukan",
            "data"      => $data
        ]);
    }

    public function prosesX()
    {
        $id_data        = $this->input->post("id_data");
        $stock_nyata    = $this->input->post("stock_nyata");
        $keterangan     = $this->input->post("keterangan");

        $data = $this->vObat->where(["id" => $id_data])->get();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data Obat tidak ditemukan, silahkan hubungi Programmer"
            ]);
            die;
        }

        //TODO : UPDATE STOCK
        $this->obat->where(["id" => $id_data])->update([
            "stok" => $stock_nyata
        ]);

        //TODO : INSERT INTO TR_TRANSAKSI_OBAT
        $this->trObat->insert([
            "id_admin"      => $this->userData->id,
            "id_obat"       => $id_data,
            "tanggal"       => date("Y-m-d"),
            "stok_awal"     => $data["stok"],
            "stok_akhir"    => $stock_nyata,
            "jenis"         => "STOCK OPNAME",
            "keterangan"    => $keterangan
        ]);

        echo json_encode([
            "code"      => 200,
            "message"   => "Stock Opname pada obat " . $data["nama"] . " berhasil dilakukan"
        ]);
    }

    public function proses($kode_obat = NULL)
    {
        $cek = $this->vObat->where(["kode_obat" => $kode_obat])->get();
        if (!$cek) {
            $this->session->set_flashdata("gagal", "Data obat tidak diketahui");
            redirect("transaksi/apotek/stock-opname");
        }

        $stok = $this->vStok->where(["id_obat" => $cek["id"]])->order_by("tgl_expired", "ASC")->get_all() ?: [];

        $data = [
            "title"     => "Proses Stock Opname obat",
            "obat"      => $cek,
            "stok"      => $stok
        ];
        $this->loadViewBack("transaksi/apotek/stock_opname/proses_stok_opname", $data);
    }

    public function execute()
    {        
        $id_obat            = $this->input->post("id_obat");
        $id_stok            = $this->input->post("id_stok");
        $stok_sebenarnya    = $this->input->post("stok_sebenarnya");
        $stok_gudang        = $this->input->post("stok_gudang");

        $index = 0;
        foreach ($id_stok as $id) {
            $this->stok->where(["id" => $id])->update([
                "stok" => $stok_sebenarnya[$index],
            ]);

            //TODO : INSERT INTO TR_TRANSAKSI_OBAT
            $this->trObat->insert([
                "id_admin"      => $this->userData->id,
                "id_obat"       => $id_obat,
                "tanggal"       => date("Y-m-d"),
                "stok_awal"     => $stok_gudang[$index],
                "stok_akhir"    => $stok_sebenarnya[$index],
                "jenis"         => "STOCK OPNAME",
                "keterangan"    => "Perubahan stok dari $stok_gudang[$index] menjadi $stok_sebenarnya[$index]"
            ]);

            $index++;
        }

        $this->session->set_flashdata("sukses", "Stock Opname berhasil dilakukan");
        redirect("transaksi/apotek/stock-opname");
    }
}
