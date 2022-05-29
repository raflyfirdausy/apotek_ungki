<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Obat_keluar extends RFLController
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
        $this->load->model("TrKeluar_model", "trKeluar");
        $this->load->model("TrKeluarDetail_model", "trKeluarDetail");
        $this->load->model("StokObat_model", "stokObat");
        $this->load->model("Transaksi_obat_model", "trTransaksi");
        $this->load->model("VKeluar_model", "vKeluar");
        $this->load->model("VTrDetailKeluar_model", "vKeluarDetail");
    }

    public function index()
    {
        $data = [
            "title"     => "Obat Keluar",
        ];
        $this->loadViewBack("transaksi/apotek/obat_keluar/data_obat", $data);
    }

    public function get_data($status = NULL)
    {
        $id_suplier         = $this->userData->id_suplier;
        $limit              = $this->input->post("length")  ?: 10;
        $offset             = $this->input->post("start")   ?: 0;

        $data               = $this->filterDataTable($this->vKeluar)->order_by("id", "DESC")->as_array()->limit($limit, $offset)->get_all() ?: [];
        $dataFilter         = $this->filterDataTable($this->vKeluar)->order_by("id", "DESC")->count_rows() ?: 0;
        $dataCountAll       = $this->vKeluar->count_rows() ?: 0;

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

    public function tambah()
    {
        $noFaktur = "KLR" . date("ymd") . "0001";
        $getKode = $this->trKeluar->where("no_faktur", "LIKE", date("ymd"))->order_by("no_faktur", "DESC")->get();
        $obat = $this->vObat->where("stok", ">", 0)->get_all();
        if ($getKode) {
            $lastKode = (int) substr($getKode["no_faktur"], -4);
            $noFaktur = "KLR" . date("ymd") . str_pad((string)($lastKode + 1), 4, "0", STR_PAD_LEFT);
        }

        $data = [
            "no_faktur"     => $noFaktur,
            "title"         => "Tambah Obat Keluar",
            "obat"          => $obat
        ];
        $this->loadViewBack("transaksi/apotek/obat_keluar/tambah_obat", $data);
    }

    public function tambah_proses()
    {
        // d($_POST);
        $id_admin               = $this->userData->id;
        $no_faktur              = $this->input->post("no_faktur");
        $catatan                = $this->input->post("catatan");
        $id_obat                = $this->input->post("id_obat");
        $quantity_obat          = $this->input->post("quantity_obat");
        $catatan_detail         = $this->input->post("catatan_detail");
        $keterangan_pemesanan   = $this->input->post("keterangan_pemesanan");


        //TODO : VALIDASI BARANG, MINIMAL 1
        if (empty($id_obat)) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Terjadi kesalahan pada saat penambahan obat keluar. Keterangan : data obat tidak boleh kosong"
            ]);
            die;
        }

        foreach ($quantity_obat as $qo) {
            if (empty($qo)) {
                echo json_encode([
                    "code"      => 404,
                    "message"   => "Terjadi kesalahan pada saat penambahan obat keluar. Keterangan : Terdapat quantitiy yang masih kosong. Silahkan periksa kembali"
                ]);
                die;
            }
        }


        $memenuhi_syarat        = TRUE;
        $_idObatSudahDicek      = [];
        $tidak_memenuhi_syarat  = [];
        $dataDetail             = [];

        $index = 0;
        foreach ($id_obat as $io) {
            //TODO : CALCULATE WEIGHT            
            $totalQty = 0;
            $indexQuantity = 0;
            foreach ($id_obat as $io2) {
                if ($io == $io2) {
                    $totalQty += $quantity_obat[$indexQuantity];
                }
                $indexQuantity++;
            }

            //TODO : CEK DATA OBAT TERSEDIA
            $cekData = $this->vObat
                ->where(["id" => $io])
                ->as_object()
                ->get();

            if ($cekData) {
                if ($cekData->stok >= $totalQty) {
                    //TODO : APAKAH UDAH DI CEK ID NYA UNTUK ANTISIPASI DUPLIKAT INSERT
                    if (!in_array($io, $_idObatSudahDicek)) {
                        $offset         = 0;
                        $sisaObat       = $totalQty;
                        $catatan        = $catatan_detail[$index];

                        $detail = $this->ambilObat($io, $offset, $sisaObat, $catatan, $return = []);
                        foreach ($detail as $d) {
                            array_push($dataDetail, $d);
                        }
                        array_push($_idObatSudahDicek, $io);
                    }
                } else {
                    if (!in_array($cekData->nama, $tidak_memenuhi_syarat)) {
                        array_push($tidak_memenuhi_syarat, $cekData->nama);
                    }
                }
            } else {
                $memenuhi_syarat = FALSE;
            }

            $index++;
        }

        if (!$memenuhi_syarat || sizeof($tidak_memenuhi_syarat) > 0) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Terjadi kesalahan saat melakukan penambahan obat keluar. Jumlah obat melebihi batas yang tersedia pada sistem (" . implode(",", $tidak_memenuhi_syarat) . ")"
            ]);
            die;
        } else {
            //TODO : INSERT INTO TR KELUAR
            $dataInsert = [
                "id_admin"              => $id_admin,
                "no_faktur"             => $no_faktur,
                "tgl_faktur"            => date("Y-m-d"),
                "keterangan_pemesanan"  => $keterangan_pemesanan
            ];

            $insertKeluar = $this->trKeluar->insert($dataInsert);
            if (!$insertKeluar) {
                echo json_encode([
                    "code"      => 404,
                    "message"   => "Terjadi kesalahan pada query insert keluar (Kode Error : 003)"
                ]);
                die;
            }

            foreach ($dataDetail as $dd) {
                $dd["detail"]["id_pemesanan"]   = $insertKeluar;
                //SET DETAIL ID PEMESANAN FOR INSERT KELUAR DETAIL                                
                //TODO : KURANGIN DATA STOKNYA
                $idStok         = $dd["stok_obat"]["id"];
                $sisaStok       = $dd["stok_obat"]["sisa"];
                $dataStock      = $this->stokObat->where(["id" => $idStok])->get();

                //TODO : PENGURANGAN STOK OBAT
                $this->stokObat->where(["id" => $idStok])->update(["stok" => $sisaStok]);

                //TODO : INSERT KE TR KELUAR DETAIL
                $this->trKeluarDetail->insert($dd["detail"]);

                //TODO : INSERT KE MUTASI OBAT
                $this->trTransaksi->insert([
                    "id_admin"      => $id_admin,
                    "id_obat"       => $dd["id_obat"],
                    "id_stok"       => $dataStock["id"],
                    "tanggal"       => date("Y-m-d"),
                    "stok_awal"     => $dataStock["stok"],
                    "stok_akhir"    => $sisaStok,
                    "keterangan"    => "Obat keluar sebanyak " . $dd["diambil"],
                    "jenis"         => "OBAT KELUAR"
                ]);
            }

            echo json_encode([
                "code"      => 200,
                "message"   => "Berhasil menambahkan data obat keluar"
            ]);
            die;
        }
    }

    public function ambilObat($io, $offset, $sisaObat, $catatan, $return = [])
    {
        $cekStok = $this->stokObat->where(["id_obat" => $io])->where("stok", ">", 0)->order_by("tgl_expired", "ASC")->limit(1, $offset)->get();
        $offsetPlus = $offset + 1;

        if ($sisaObat == 0) return $return;
        if ($cekStok["stok"] >= $sisaObat) {

            //TODO : KURANGI STOK BERDASARKAN PERMINTAAN OBAT AJAX
            $diambil    = $sisaObat;
            $sisaObat   -= $diambil;
            $sisaStok   = $cekStok["stok"] - $diambil;

            //TODO : DETAIL KE DETAIL KELUAR
            $dataDetail = [
                "id_pemesanan"  => NULL,
                "id_obat"       => $io,
                "qty"           => $diambil,
                "tgl_expired"   => $cekStok["tgl_expired"],
                "catatan"       => $catatan,
            ];

            array_push($return, [
                "id_obat"   => $io,
                "sisaObat"  => $sisaObat,
                "diambil"   => $diambil,
                "stok_obat" => [
                    "id"    => $cekStok["id"],
                    "sisa"  => $sisaStok,
                ],
                "detail"    => $dataDetail
            ]);

            return $return;
        } else {
            $diambil    = $cekStok["stok"];
            $sisaObat   -= $diambil;
            $sisaStok   = $cekStok["stok"] - $diambil;

            //TODO : DETAIL KE DETAIL KELUAR
            $dataDetail = [
                "id_pemesanan"  => NULL,
                "id_obat"       => $io,
                "qty"           => $diambil,
                "tgl_expired"   => $cekStok["tgl_expired"],
                "catatan"       => $catatan,
            ];

            array_push($return, [
                "id_obat"   => $io,
                "sisaObat"  => $sisaObat,
                "diambil"   => $diambil,
                "stok_obat" => [
                    "id"    => $cekStok["id"],
                    "sisa"  => $sisaStok,
                ],
                "detail"    => $dataDetail
            ]);

            return $this->ambilObat($io, $offsetPlus, $sisaObat, $catatan, $return);
        }
    }

    public function get($noFaktur = NULL)
    {
        $data = $this->vKeluarDetail
            ->where(["no_faktur" => $noFaktur])
            ->order_by("id", "ASC")
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
