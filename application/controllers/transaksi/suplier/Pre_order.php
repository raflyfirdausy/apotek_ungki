<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pre_order extends SuplierController
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
        $this->load->model("Trpemesanan_model", "trPemesanan");
        $this->load->model("Trpemesanan_detail_model", "trPemesananDetail");
        $this->load->model("VPemesanan_model", "vPemesanan");
        $this->load->model("Suplier_model", "suplier");
        $this->load->model("StokObat_model", "stokObat");
        $this->load->model("VDetail_pemesanan_model", "vPemesananDetail");
    }

    public function index()
    {
        redirect("transaksi/suplier/pre-order/belum");
    }

    public function belum()
    {
        $data = [
            "title"     => "Pemesanan Obat Belum di proses",
            "status"    => "MENUNGGU"
        ];
        $this->loadViewBack("transaksi/suplier/pre_order/data_preorder", $data);
    }

    public function sudah()
    {
        $data = [
            "title"     => "Pemesanan Obat Belum di proses",
            "status"    => "DI_TERIMA"
        ];
        $this->loadViewBack("transaksi/suplier/pre_order/data_preorder", $data);
    }

    public function tolak()
    {
        $data = [
            "title"     => "Pemesanan Obat Belum di proses",
            "status"    => "DI_TOLAK"
        ];
        $this->loadViewBack("transaksi/suplier/pre_order/data_preorder", $data);
    }

    public function get_data($status = NULL)
    {
        $id_suplier         = $this->userData->id_suplier;
        $limit              = $this->input->post("length")  ?: 10;
        $offset             = $this->input->post("start")   ?: 0;

        $data               = $this->filterDataTable($this->vPemesanan)->where(["id_suplier" => $id_suplier])->where(["status_suplier" => $status])->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->vPemesanan)->where(["id_suplier" => $id_suplier])->where(["status_suplier" => $status])->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->vPemesanan->where(["id_suplier" => $id_suplier])->where(["status_suplier" => $status])->count_rows() ?: 0;

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
            $model = $model->where("LOWER(status_suplier)", "LIKE", strtolower($status));
        }

        if (!empty($created_at)) {
            $model = $model->where("LOWER(created_at)", "LIKE", strtolower($created_at));
        }

        return $model;
    }

    public function proses($no_faktur = NULL)
    {
        $pemesanan_obat     = $this->vPemesanan->where(["no_faktur" => $no_faktur])->get() ?: [];
        $suplier            = $this->suplier->get_all();
        $obat               = $this->vObat->get_all();

        $data   = [
            "title"             => "Proses data pemesanan obat (" . $pemesanan_obat["no_faktur"] . ")",
            "pemesanan_obat"    => $pemesanan_obat,
            "suplier"           => $suplier,
            "obat"              => $obat
        ];
        $this->loadViewBack("transaksi/suplier/pre_order/proses_preorder", $data);
    }

    public function acc()
    {
        // d($_POST);
        $no_faktur      = $this->input->post("no_faktur");
        $id_detail      = $this->input->post("id_detail");
        $qty_acc        = $this->input->post("qty_acc");
        $tgl_expired    = $this->input->post("tgl_expired");
        $id_obat        = $this->input->post("id_obat");

        $update = $this->trPemesanan->where(["no_faktur" => $no_faktur])->update(["status_suplier" => "DI_TERIMA"]);
        if (!$update) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Terjadi kesalahan saat melakukan pemesanan obat. silahkan hubungi programmer"
            ]);
            die;
        }

        $index = 0;
        foreach ($id_detail as $detail) {
            $this->trPemesananDetail
                ->where(["id" => $id_detail[$index]])
                ->update([
                    "qty_acc"       => $qty_acc[$index],
                    "tgl_expired"   => $tgl_expired[$index]
                ]);

            $cek = $this->stokObat->where([
                "id_obat"       => $id_obat[$index],
                "tgl_expired"   => $tgl_expired[$index]
            ])->get();

            $currentStok = $qty_acc[$index];
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
                    "id_obat"       => $id_obat[$index],
                    "id_stok"       => $cek["id"],
                    "tanggal"       => date("Y-m-d"),
                    "stok_awal"     => $cek["stok"],
                    "stok_akhir"    => $currentStok,
                    "jenis"         => "TAMBAH BY PO",
                    "keterangan"    => "Penambahan stok obat oleh suplier"
                ]);
            } else {
                $insert = $this->stokObat->insert([
                    "id_obat"       => $id_obat[$index],
                    "stok"          => $currentStok,
                    "tgl_expired"   => $tgl_expired[$index]
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
                    "id_obat"       => $id_obat[$index],
                    "id_stok"       => $cek["id"],
                    "tanggal"       => date("Y-m-d"),
                    "stok_awal"     => $cek["stok"],
                    "stok_akhir"    => $currentStok,
                    "jenis"         => "TAMBAH BY PO",
                    "keterangan"    => "Penambahan stok obat oleh suplier"
                ]);
            }

            $index++;
        }

        $this->session->set_flashdata("sukses", "Pemesanan berhasil terima");
        redirect("transaksi/suplier/pre-order/belum");
    }

    public function deny()
    {
        $no_faktur = $this->input->post("no_faktur");
        $cek = $this->trPemesanan->where(["no_faktur" => $no_faktur])->get();
        if (!$cek) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Terjadi kesalahan saat melakukan penolakan pemesanan. Keterangan : Data tidak ditemukan"
            ]);
            die;
        }

        $update = $this->trPemesanan->where(["no_faktur" => $no_faktur])->update(["status_suplier" => "DI_TOLAK"]);
        if (!$update) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Terjadi kesalahan saat melakukan pemesanan obat. silahkan hubungi programmer"
            ]);
            die;
        }

        $this->trPemesananDetail
            ->where(["id_pemesanan" => $cek["id"]])
            ->update([
                "qty_acc"       => 0,
                "tgl_expired"   => date("Y-m-d")
            ]);

        echo json_encode([
            "code"      => 200,
            "message"   => "Berhasil melakukan penolakan pemesanan obat"
        ]);
        die;
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
}
