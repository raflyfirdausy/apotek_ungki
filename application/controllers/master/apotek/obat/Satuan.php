<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuan extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Satuan_obat_model", "satuan");
    }

    public function index()
    {
        $data = [
            "title"     => "Satuan Obat",
        ];
        $this->loadViewBack("master/apotek/obat/data_satuan", $data);
    }

    public function get_data()
    {
        $limit              = $this->input->post("length")  ?: 10;
        $offset             = $this->input->post("start")   ?: 0;

        $data               = $this->filterDataTable($this->satuan)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->satuan)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->satuan->count_rows() ?: 0;

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
        $nama           = isset($inputKolom) ? $inputKolom[2]["search"]["value"] : "";
        $keterangan     = isset($inputKolom) ? $inputKolom[3]["search"]["value"] : "";
        $created_at     = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";

        if (!empty($nama)) {
            $model = $model->where("LOWER(nama)", "LIKE", strtolower($nama));
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
        $nama       = $this->input->post('nama');
        $keterangan = $this->input->post('keterangan');

        $data = [
            "nama"          => $nama,
            "keterangan"    => $keterangan
        ];

        $insert = $this->satuan->insert($data);
        if (!$insert) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menambahkan data satuan Obat. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Satuan Obat berhasil di tambahkan dengan nama $nama !"
        ]);
    }

    public function get($id = NULL)
    {
        $data = $this->satuan->where(["id" => $id])->get();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data satuan Obat tidak ditemukan, silahkan cobalah beberapa saat lagi"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data satuan Obat ditemukan",
            "data"      => $data
        ]);
    }

    public function edit()
    {
        $id_data    = $this->input->post("id_data");
        $nama       = $this->input->post('nama');
        $keterangan = $this->input->post('keterangan');

        $dataUpdate = [
            "nama"          => $nama,
            "keterangan"    => $keterangan
        ];

        $cekData    = $this->satuan->where(["id" => $id_data])->get();
        if (!$cekData) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data satuan Obat tidak ditemukan"
            ]);
            die;
        }

        $update = $this->satuan->where(["id" => $cekData["id"]])->update($dataUpdate);
        if (!$update) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat mengedit satuan Obat. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "satuan Obat berhasil di ubah !"
        ]);
    }

    public function delete()
    {
        $id_data    = $this->input->post("id_data");

        $delete = $this->satuan->where(["id" => $id_data])->delete();
        if (!$delete) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat menghapus satuan obat. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data satuan obat berhasil di hapus !"
        ]);
    }
}
