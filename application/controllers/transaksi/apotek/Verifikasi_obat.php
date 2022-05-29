<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verifikasi_obat extends RFLController
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
        $this->load->model("StokObat_model", "stokObat");
        $this->load->model("Transaksi_obat_model", "trObat");
    }

    public function index()
    {
        $data = [
            "title"     => "Verifikasi Pemesanan Obat",
        ];
        $this->loadViewBack("transaksi/apotek/verifikasi_obat/data_verifikasi", $data);
    }

    public function get_data()
    {
        $limit              = $this->input->post("length")  ?: 10;
        $offset             = $this->input->post("start")   ?: 0;

        $kondisi = ["status_suplier" => "DI_TERIMA", "status_apotek" => "MENUNGGU"];

        $data               = $this->filterDataTable($this->vPemesanan)->where($kondisi)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->vPemesanan)->where($kondisi)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->vPemesanan->where($kondisi)->count_rows() ?: 0;

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
        $total          = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";
        $status         = isset($inputKolom) ? $inputKolom[5]["search"]["value"] : "";
        $created_at     = isset($inputKolom) ? $inputKolom[6]["search"]["value"] : "";

        if (!empty($no_faktur)) {
            $model = $model->where("LOWER(no_faktur)", "LIKE", strtolower($no_faktur));
        }

        if (!empty($tanggal)) {
            $model = $model->where("LOWER(tgl_faktur)", "LIKE", strtolower($tanggal));
        }

        if (!empty($total)) {
            $model = $model->where("LOWER(total_obat)", "LIKE", strtolower($total));
        }

        if (!empty($status)) {
            $model = $model->where("LOWER(status_apotek)", "LIKE", strtolower($status));
        }

        if (!empty($created_at)) {
            $model = $model->where("LOWER(created_at)", "LIKE", strtolower($created_at));
        }

        return $model;
    }

    public function get($noFaktur = NULL)
    {
        $data = $this->vPemesananDetail
            ->where(["no_faktur" => $noFaktur])
            ->as_array()
            ->get_all();

        if ($data) {
            echo json_encode([
                "code"      => 200,
                "message"   => "Data ditemukan",
                "data"      => $data
            ]);
        } else {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data tidak ditemukan"
            ]);
        }
    }

    public function proses()
    {
        $noFaktur = $this->input->post('no_faktur');        
        $cek = $this->trPemesanan->where(["no_faktur" => $noFaktur])->get();
        if (!$cek) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data tidak ditemukan"
            ]);
            die;
        }
        $detail = $this->trPemesananDetail->where(["id_pemesanan" => $cek["id"]])->get_all() ?: [];
        if (!$detail) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Detail obat tidak ditemukan"
            ]);
            die;
        }

        // d($detail);

        $update = $this->trPemesanan->where(["id" => $cek["id"]])->update(["status_apotek" => "DI_TERIMA"]);
        if (!$update) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Terjadi kesalahan saat melakukan pemesanan obat. silahkan hubungi programmer"
            ]);
            die;
        }

        foreach ($detail as $d) {
            $cek = $this->stokObat->where([
                "id_obat"       => $d["id_obat"],
                "tgl_expired"   => $d["tgl_expired"]
            ])->get();

            $currentStok = $d["qty_acc"];
            if ($cek) {
                $currentStok += $cek["stok"];

                //TODO : UPDATE STOK OBAT
                $update = $this->stokObat->where(["id" => $cek["id"],])->update(["stok" => $currentStok]);
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
                    "id_obat"       => $d["id_obat"],
                    "id_stok"       => $cek["id"],
                    "tanggal"       => date("Y-m-d"),
                    "stok_awal"     => $cek["stok"],
                    "stok_akhir"    => $currentStok,
                    "jenis"         => "TAMBAH BY PO",
                    "keterangan"    => "Verifikasi Obat dari supplier"
                ]);
            } else {
                $insert = $this->stokObat->insert([
                    "id_obat"       => $d["id_obat"],
                    "stok"          => $currentStok,
                    "tgl_expired"   => $d["tgl_expired"]
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
                    "id_obat"       => $d["id_obat"],
                    "id_stok"       => $insert,
                    "tanggal"       => date("Y-m-d"),
                    "stok_awal"     => "0",
                    "stok_akhir"    => $currentStok,
                    "jenis"         => "TAMBAH BY PO",
                    "keterangan"    => "Verifikasi Obat dari supplier"
                ]);
            }
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Pemesanan obat berhasil diverifikasi"
        ]);
    }
}
