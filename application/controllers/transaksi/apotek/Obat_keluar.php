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
    }

    public function index()
    {
        $data = [
            "title"     => "Obat Keluar",
        ];
        $this->loadViewBack("transaksi/apotek/obat_keluar/data_obat", $data);
    }

    public function tambah()
    {
        $noFaktur = "KLR" . date("ymd") . "0001";
        $getKode = $this->trKeluar->where("no_faktur", "LIKE", date("ymd"))->order_by("no_faktur", "DESC")->get();
        $obat = $this->vObat->get_all();
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
        $id_admin       = $this->userData->id;
        $no_faktur      = $this->input->post("no_faktur");
        $catatan        = $this->input->post("catatan");
        $id_obat        = $this->input->post("id_obat");
        $quantity_obat  = $this->input->post("quantity_obat");
        $catatan_detail = $this->input->post("catatan_detail");


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
                "id_admin"   => $id_admin,
                "no_faktur"  => $no_faktur,
                "tgl_faktur" => date("Y-m-d"),
            ];

            $insertKeluar = $this->trKeluar->insert($dataInsert);
            if (!$insertKeluar) {
                echo json_encode([
                    "code"      => 404,
                    "message"   => "Terjadi kesalahan pada query insert keluar (Kode Error : 003)"
                ]);
                die;
            }

            $insertKeluar = "2";

            foreach ($dataDetail as $dd) {
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
        $cekStok = $this->stokObat->where(["id_obat" => $io])->order_by("tgl_expired", "ASC")->limit(1, $offset)->get();
        $offsetPlus = $offset + 1;

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
}
