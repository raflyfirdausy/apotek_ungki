<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suplier extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Suplier_model", "suplier");
        $this->load->model("Admin_model", "pengguna");
    }

    public function index()
    {
        $data = [];
        $this->loadViewBack("master/apotek/suplier/data_suplier", $data);
    }

    public function get_data()
    {
        $limit              = $this->input->post("length")  ?: 10;
        $offset             = $this->input->post("start")   ?: 0;

        $data               = $this->filterDataTable($this->suplier)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->suplier)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->suplier->count_rows() ?: 0;

        for ($i = 0; $i < sizeof($data); $i++) {
            unset($data[$i]["password"]);
        }

        echo json_encode([
            "draw"              => $this->input->post("draw", TRUE),
            "data"              => $data,
            "recordsFiltered"   => $dataFilter,
            "recordsTotal"      => $dataCountAll,
        ]);
    }

    public function get($id = NULL)
    {
        $data = $this->suplier->where(["id" => $id])->get();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data Suplier tidak ditemukan, silahkan cobalah beberapa saat lagi"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data Suplier ditemukan",
            "data"      => $data
        ]);
    }

    public function filterDataTable($model)
    {
        $inputKolom     = $this->input->post("columns");
        $nama           = isset($inputKolom) ? $inputKolom[2]["search"]["value"] : "";
        $alamat         = isset($inputKolom) ? $inputKolom[3]["search"]["value"] : "";
        $kota           = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";
        $no_telp        = isset($inputKolom) ? $inputKolom[5]["search"]["value"] : "";
        $no_rek         = isset($inputKolom) ? $inputKolom[6]["search"]["value"] : "";
        $nama_bank      = isset($inputKolom) ? $inputKolom[7]["search"]["value"] : "";

        if (!empty($nama)) {
            $model = $model->where("LOWER(nama)", "LIKE", strtolower($nama));
        }

        if (!empty($alamat)) {
            $model = $model->where("LOWER(alamat)", "LIKE", strtolower($alamat));
        }

        if (!empty($kota)) {
            $model = $model->where("LOWER(kota)", "LIKE", strtolower($kota));
        }

        if (!empty($no_telp)) {
            $model = $model->where("LOWER(no_telp)", "LIKE", strtolower($no_telp));
        }

        if (!empty($no_rek)) {
            $model = $model->where("LOWER(no_rek)", "LIKE", strtolower($no_rek));
        }

        if (!empty($nama_bank)) {
            $model = $model->where("LOWER(nama_bank)", "LIKE", strtolower($nama_bank));
        }


        return $model;
    }

    public function add()
    {
        $nama       = $this->input->post('nama');
        $alamat     = $this->input->post('alamat');
        $kota       = $this->input->post('kota');
        $no_telp    = $this->input->post('no_telp');
        $no_rek     = $this->input->post('no_rek');
        $nama_bank  = $this->input->post('nama_bank');

        $data = [
            "nama"      => $nama,
            "alamat"    => $alamat,
            "kota"      => $kota,
            "no_telp"   => $no_telp,
            "no_rek"    => $no_rek,
            "nama_bank" => $nama_bank
        ];

        $insert = $this->suplier->insert($data);
        if (!$insert) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menambahkan data suplier. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Suplier berhasil di tambahkan atas nama $nama !"
        ]);
    }

    public function edit()
    {
        $id_data    = $this->input->post("id_data");
        $nama       = $this->input->post('nama');
        $alamat     = $this->input->post('alamat');
        $kota       = $this->input->post('kota');
        $no_telp    = $this->input->post('no_telp');
        $no_rek     = $this->input->post('no_rek');
        $nama_bank  = $this->input->post('nama_bank');

        $dataUpdate = [
            "nama"      => $nama,
            "alamat"    => $alamat,
            "kota"      => $kota,
            "no_telp"   => $no_telp,
            "no_rek"    => $no_rek,
            "nama_bank" => $nama_bank
        ];

        $cekData    = $this->suplier->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data suplier tidak ditemukan"
            ]);
            die;
        }

        $update = $this->suplier->where(["id" => $cekData["id"]])->update($dataUpdate);
        if (!$update) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengedit Suplier. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Suplier berhasil di ubah !"
        ]);
    }

    public function delete()
    {
        $id_data    = $this->input->post("id_data");
        $cekData    = $this->pengguna->where(["id_suplier" => $id_data])->get();
        if ($cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data suplier tidak dapat dihapus di karenakan masih ada data pengguna yang pada suplier ini. Silahkan hapus data pengguna terlebih dahulu"
            ]);
            die;
        }

        $delete = $this->suplier->where(["id" => $id_data])->delete();
        if (!$delete) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menghapus suplier. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data suplier berhasil di hapus !"
        ]);
    }
}
