<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Identitas extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Identitas_model", "identitas");
    }

    public function index()
    {
        $identitas = $this->identitas->order_by("id", "DESC")->as_object()->get();
        $data = [
            "identitas" => $identitas
        ];
        $this->loadViewBack("master/apotek/identitas/data_identitas", $data);
    }

    public function proses()
    {
        $nama_aplikasi  = $this->input->post('nama_aplikasi');
        $nama_apotek    = $this->input->post('nama_apotek');
        $sia_no         = $this->input->post('sia_no');
        $pemilik        = $this->input->post('pemilik');
        $apa            = $this->input->post('apa');
        $sipa_no        = $this->input->post('sipa_no');
        $provinsi       = $this->input->post('provinsi');
        $kabupaten      = $this->input->post('kabupaten');
        $kecamatan      = $this->input->post('kecamatan');
        $kelurahan      = $this->input->post('kelurahan');
        $alamat         = $this->input->post('alamat');
        $telp           = $this->input->post('telp');
        $email          = $this->input->post('email');
        $website        = $this->input->post('website');

        $data = [
            "nama_aplikasi"     => $nama_aplikasi,
            "nama_apotek"       => $nama_apotek,
            "sia_no"            => $sia_no,
            "pemilik"           => $pemilik,
            "apa"               => $apa,
            "sipa_no"           => $sipa_no,
            "prov"              => $provinsi,
            "kab"               => $kabupaten,
            "kec"               => $kecamatan,
            "kel"               => $kelurahan,
            "alamat"            => $alamat,
            "telp"              => $telp,
            "email"             => $email,
            "website"           => $website
        ];
        if (!empty($_FILES["logo"]["name"])) {
            $config['upload_path']          = './assets/apotek/img/';
            $config['allowed_types']        = 'jpg|png|jpeg';
            $config['max_size']             = 2048;
            $config['file_name']            = 'logo_' . date('YmdHis');
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('logo')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                echo json_encode([
                    "code"      => 400,
                    "message"   => "Terjadi kesalahan saat upload logo apotek. Keterangan : " . $this->upload->display_errors()
                ]);
                die;
            } else {
                $upload_data = $this->upload->data();
                $logo = $upload_data['file_name'];
                $data["logo"]   = $logo;
            }
        }

        $insert = $this->identitas->insert($data);
        if (!$insert) {
            echo json_encode([
                "code"      => 400,
                "message"   => "Terjadi kesalahan saat menyimpan data identitas apotek"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Berhasil menyimpan data identitas apotek"
        ]);
    }
}
