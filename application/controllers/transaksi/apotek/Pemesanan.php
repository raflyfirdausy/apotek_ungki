<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemesanan extends RFLController
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
    }

    public function get_data()
    {
        $limit              = $this->input->post("length")  ?: 10;
        $offset             = $this->input->post("start")   ?: 0;

        $data               = $this->filterDataTable($this->vPemesanan)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->vPemesanan)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->vPemesanan->count_rows() ?: 0;

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
        $suplier        = isset($inputKolom) ? $inputKolom[4]["search"]["value"] : "";
        $total          = isset($inputKolom) ? $inputKolom[5]["search"]["value"] : "";
        $status         = isset($inputKolom) ? $inputKolom[6]["search"]["value"] : "";
        $nama_admin     = isset($inputKolom) ? $inputKolom[7]["search"]["value"] : "";
        $created_at     = isset($inputKolom) ? $inputKolom[8]["search"]["value"] : "";

        if (!empty($no_faktur)) {
            $model = $model->where("LOWER(no_faktur)", "LIKE", strtolower($no_faktur));
        }

        if (!empty($tanggal)) {
            $model = $model->where("LOWER(tgl_faktur)", "LIKE", strtolower($tanggal));
        }

        if (!empty($suplier)) {
            $model = $model->where("LOWER(nama_suplier)", "LIKE", strtolower($suplier));
        }

        if (!empty($total)) {
            $model = $model->where("LOWER(total_obat)", "LIKE", strtolower($total));
        }

        if (!empty($status)) {
            $model = $model->where("LOWER(status_suplier)", "LIKE", strtolower($status));
        }
        if (!empty($nama_admin)) {
            $model = $model->where("LOWER(nama_admin)", "LIKE", strtolower($nama_admin));
        }

        if (!empty($created_at)) {
            $model = $model->where("LOWER(created_at)", "LIKE", strtolower($created_at));
        }

        return $model;
    }

    public function index()
    {
        $data = [
            "title"     => "Pemesanan Obat",
        ];
        $this->loadViewBack("transaksi/apotek/pemesanan/data_pemesanan", $data);
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

    public function delete()
    {
        $no_faktur = $this->input->post('no_faktur');
        $cek = $this->trPemesanan->where(["no_faktur" => $no_faktur])->get();
        if (!$cek) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data tidak ditemukan"
            ]);
            die;
        }

        $this->trPemesanan->where(["id" => $cek["id"]])->delete();
        $this->trPemesananDetail->where(["id_pemesanan" => $cek["id"]])->delete();

        echo json_encode([
            "code"      => 200,
            "message"   => "Pesanan berhasil di hapus"
        ]);
        die;
    }

    public function tambah()
    {
        $suplier    = $this->suplier->get_all();
        $obat       = $this->vObat->get_all();
        $data = [
            "title"     => "Tambah pemesanan obat",
            "suplier"   => $suplier,
            "obat"      => $obat
        ];
        $this->loadViewBack("transaksi/apotek/pemesanan/tambah_pemesanan", $data);
    }

    public function ubah($no_faktur = NULL)
    {
        $pemesanan_obat     = $this->vPemesanan->where(["no_faktur" => $no_faktur])->get() ?: [];
        $suplier            = $this->suplier->get_all();
        $obat               = $this->vObat->get_all();

        $data   = [
            "title"             => "Ubah data pemesanan obat",
            "pemesanan_obat"    => $pemesanan_obat,
            "suplier"           => $suplier,
            "obat"              => $obat
        ];
        $this->loadViewBack("transaksi/apotek/pemesanan/edit_pemesanan", $data);
    }

    public function tambah_proses()
    {
        $noFaktur   = "FKTR" . date("ymd") . "0001";
        $getKode    = $this->trPemesanan->where("no_faktur", "LIKE", date("ymd"))->order_by("no_faktur", "DESC")->get();
        if ($getKode) {
            $lastKode = (int) substr($getKode["no_faktur"], -4);
            $noFaktur = "FKTR" . date("ymd") . str_pad((string)($lastKode + 1), 4, "0", STR_PAD_LEFT);
        }

        $dataPemesanan = [
            "id_admin"              => $this->userData->id,
            "id_suplier"            => $this->input->post("suplier"),
            "no_faktur"             => $noFaktur,
            "tgl_faktur"            => date("Y-m-d"),
            "status_suplier"        => "MENUNGGU",
            "status_apotek"         => "MENUNGGU",
            "keterangan_pemesanan"  => $this->input->post("catatan")
        ];

        //TODO : INSERT INTO PEMESANAN        
        $insertPemesanan = $this->trPemesanan->insert($dataPemesanan);
        if (!$insertPemesanan) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Terjadi kesalahan saat melakukan pemesanan obat. silahkan hubungi programmer"
            ]);
            die;
        }

        //TODO : INSERT DETAIL
        $id_obat            = $this->input->post("id_obat");
        $quantity_obat      = $this->input->post("quantity_obat");
        $catatan_detail     = $this->input->post("catatan_detail");

        foreach($quantity_obat as $qty){
            if($qty < 1){
                echo json_encode([
                    "code"      => 404,
                    "message"   => "Terjadi kesalahan saat melakukan pemesanan obat. Keterangan : Quantity tidak boleh kurang dari 1"
                ]);
                die;
            }
        }

        $index                  = 0;
        $dataPemesananDetail    = [];
        foreach ($id_obat as $io) {

            array_push($dataPemesananDetail, [
                "id_pemesanan"  => $insertPemesanan,
                "id_obat"       => $id_obat[$index],
                "qty"           => $quantity_obat[$index],
                "catatan"       => $catatan_detail[$index]
            ]);

            $index++;
        }

        $insertDetail = $this->trPemesananDetail->insert($dataPemesananDetail);
        if (!$insertDetail) {
            echo json_encode([
                "code"      => 403,
                "message"   => "Terjadi kesalahan saat menambahkan pemesanan obat. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Pemesanan Obat berhasil"
        ]);
    }

    public function ubah_proses()
    {
        $noFaktur = $this->input->post("no_faktur");
        $cek = $this->trPemesanan->where(["no_faktur" => $noFaktur])->get();
        if (!$cek) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data tidak ditemukan"
            ]);
            die;
        }

        $dataPemesanan = [
            "id_admin"              => $this->userData->id,
            "id_suplier"            => $this->input->post("suplier"),
            "status_suplier"        => "MENUNGGU",
            "status_apotek"         => "MENUNGGU",
            "keterangan_pemesanan"  => $this->input->post("catatan")
        ];

        //TODO : UPDATE INTO PEMESANAN        
        $updatePemesanan = $this->trPemesanan->where(["no_faktur" => $noFaktur])->update($dataPemesanan);
        if (!$updatePemesanan) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Terjadi kesalahan saat melakukan pemesanan obat. silahkan hubungi programmer"
            ]);
            die;
        }

        //TODO : DELETE DETAIL
        $this->trPemesananDetail->where(["id_pemesanan" => $cek["id"]])->delete();

        //TODO : INSERT DETAIL
        $id_obat            = $this->input->post("id_obat");
        $quantity_obat      = $this->input->post("quantity_obat");
        $catatan_detail     = $this->input->post("catatan_detail");

        $index                  = 0;
        $dataPemesananDetail    = [];
        foreach ($id_obat as $io) {

            array_push($dataPemesananDetail, [
                "id_pemesanan"  => $cek["id"],
                "id_obat"       => $id_obat[$index],
                "qty"           => $quantity_obat[$index],
                "catatan"       => $catatan_detail[$index]
            ]);

            $index++;
        }

        $insertDetail = $this->trPemesananDetail->insert($dataPemesananDetail);
        if (!$insertDetail) {
            echo json_encode([
                "code"      => 403,
                "message"   => "Terjadi kesalahan saat mengubah pemesanan obat. Silahkan hubungi programmer"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Pemesanan Obat berhasil diubah"
        ]);
    }
}
