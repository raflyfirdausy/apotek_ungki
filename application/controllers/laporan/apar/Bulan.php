<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bulan extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Region_model", "region");
        $this->load->model("Perusahaan_model", "perusahaan");
        $this->load->model("VPerusahaan_model", "vPerusahaan");
        $this->load->model("Unit_model", "unit");
        $this->load->model("VUnit_model", "vUnit");
        $this->load->model("TRApar_model", "trApar");
        $this->load->model("JenisApar_model", "jenisApar");
        $this->load->model("VTRApar_model", "vtrApar");
    }

    public function index()
    {
        $data = [
            "region"        => $this->region->get_all(),
            "jenis_apar"    => $this->jenisApar->get_all()
        ];
        $this->loadViewBack("laporan/apar/bulan/index", $data);
    }

    public function findPerusahaan($id_region = NULL)
    {
        $data = $this->perusahaan->where(["id_region" => $id_region])->get_all();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data perusahaan tidak ditemukan!",
                "data"      => NULL
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data perusahaan ditemukan!",
            "data"      => $data
        ]);
    }

    public function findUnit($id_perusahaan = NULL)
    {
        $data = $this->unit->where(["id_perusahaan" => $id_perusahaan])->get_all();
        if (!$data) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data unit tidak ditemukan!",
                "data"      => NULL
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data unit ditemukan!",
            "data"      => $data
        ]);
    }

    public function get_data($_idRegion = NULL, $_idPerusahaan = NULL, $_idUnit = NULL, $_bulan = NULL, $_tahun = NULL)
    {
        $kondisi                    = [];
        $kondisi["id_region"]       = $_idRegion;
        $kondisi["id_perusahaan"]   = $_idPerusahaan;
        $kondisi["id_unit"]         = $_idUnit;
        $kondisi["MONTH(tanggal)"]  = $_bulan;
        $kondisi["YEAR(tanggal)"]   = $_tahun;

        $limit              = $this->input->post("length") ?: 10;
        $offset             = $this->input->post("start") ?: 0;

        $data               = $this->trApar
            ->with_region("fields:nama")
            ->with_perusahaan("fields:nama")
            ->with_unit("fields:nama")
            ->with_jenis("fields:nama")
            ->order_by("id", "DESC")
            ->where($kondisi)
            ->as_array()
            ->limit($limit, $offset)
            ->get_all() ?: [];
        $dataFilter         = $this->trApar->order_by("id", "DESC")->where($kondisi)->count_rows() ?: 0;
        $dataCountAll       = $this->trApar->where($kondisi)->count_rows() ?: 0;

        echo json_encode([
            "draw"              => $this->input->post("draw", TRUE),
            "data"              => $data,
            "recordsFiltered"   => $dataFilter,
            "recordsTotal"      => $dataCountAll,
        ]);
    }

    public function download($_idRegion = NULL, $_idPerusahaan = NULL, $_idUnit = NULL, $_bulan = NULL, $_tahun = NULL)
    {

        $_region            = $this->region->where(["id" => $_idRegion])->get();
        $_perusahaan        = $this->perusahaan->where(["id" => $_idPerusahaan])->get();
        $_unit              = $this->unit->where(["id" => $_idUnit])->get();

        $kondisi                    = [];
        $kondisi["id_region"]       = $_idRegion;
        $kondisi["id_perusahaan"]   = $_idPerusahaan;
        $kondisi["id_unit"]         = $_idUnit;
        $kondisi["MONTH(tanggal)"]  = $_bulan;
        $kondisi["YEAR(tanggal)"]   = $_tahun;

        $data                       = $this->trApar
            ->with_region("fields:nama")
            ->with_perusahaan("fields:nama")
            ->with_unit("fields:nama")
            ->with_jenis("fields:nama")
            ->order_by("id", "DESC")
            ->where($kondisi)
            ->as_array()
            ->get_all() ?: [];
        // d($data);

        $inputFileType  = 'Xlsx';
        $inputFileName  = "assets/evans/template/format_apar.xlsx";
        $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet    = $reader->load($inputFileName);
        $worksheet      = $spreadsheet->getActiveSheet();
        $fileName       = "LAPORAN-INSPEKSI-APAR-BULAN-" .
            strtoupper(bulan($_bulan)) .
            "-TAHUN-" . $_tahun . "-" .
            strtoupper(slug($_region["nama"])) . "-" .
            strtoupper(slug($_perusahaan["nama"])) . "-" .
            strtoupper(slug($_unit["nama"])) . "-EXPORTED-" .
            date("Y-m-d-H-i-s");

        $worksheet->getCell('C5')->setValue(": " . $_unit["nama"]);
        $worksheet->getCell('C6')->setValue(": " . $_region["nama"]);
        $worksheet->getCell('C7')->setValue(": " . $_perusahaan["nama"]);
        $worksheet->getCell('C8')->setValue(": " . bulan($_bulan) . " " . $_tahun);

        $baris  = 14;
        $no     = 1;
        foreach ($data as $dt) {
            $worksheet->getCell('A' . $baris)->setValue($no++);
            $worksheet->getCell('B' . $baris)->setValue($dt["lokasi"]);
            $worksheet->getCell('C' . $baris)->setValue($dt["kode_apar"]);
            $worksheet->getCell('D' . $baris)->setValue($dt["jenis"]["nama"]);
            $worksheet->getCell('E' . $baris)->setValue($dt["berat_apar"] . " Kg");
            $worksheet->getCell('F' . $baris)->setValue($dt["handle"]);
            $worksheet->getCell('G' . $baris)->setValue($dt["pressure"]);
            $worksheet->getCell('H' . $baris)->setValue($dt["pin"]);
            $worksheet->getCell('I' . $baris)->setValue($dt["pin"]);
            $worksheet->getCell('I' . $baris)->setValue($dt["selang"]);
            $worksheet->getCell('J' . $baris)->setValue($dt["tabung"]);
            $worksheet->getCell('K' . $baris)->setValue($dt["posisi"]);
            $worksheet->getCell('L' . $baris)->setValue($dt["segitiga"]);
            $worksheet->getCell('M' . $baris)->setValue($dt["label"]);
            $worksheet->getCell('N' . $baris)->setValue($dt["berat"]);
            $worksheet->getCell('O' . $baris)->setValue($dt["powder"]);
            $worksheet->getCell('P' . $baris)->setValue(longdate_indo($dt["pengisian_terakhir"]));
            $worksheet->getCell('Q' . $baris)->setValue(longdate_indo($dt["pengisian_berikutnya"]));
            $worksheet->getCell('R' . $baris)->setValue($dt["keterangan"]);
            $baris++;
        }

        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText'      => TRUE
            ]
        ];

        $worksheet->getStyle('A14' . ':' .
            $worksheet->getHighestDataColumn() .
            $worksheet->getHighestRow())
            ->applyFromArray($styleBorder);

        //TODO : ADD DILAPORKAN OLEH
        $row = $worksheet->getHighestRow() + 3;
        $worksheet->getStyle("B" . $row)->applyFromArray($styleBorder);
        $worksheet->getCell("B" . $row)->setValue("Diperiksa Oleh :");

        $worksheet->mergeCells("D" . $row . ":G" . $row);
        $worksheet->getStyle("D" . $row . ":G" . $row)->applyFromArray($styleBorder);
        $worksheet->getCell("D" . $row)->setValue("Dilaporkan Oleh :");

        $row  = $row + 1;
        $worksheet->mergeCells("B" . $row . ":B" . ($row + 4));
        $worksheet->getStyle("B" . $row . ":B" . ($row + 4))->applyFromArray($styleBorder);

        $worksheet->mergeCells("D" . $row . ":G" . ($row + 4));
        $worksheet->getStyle("D" . $row . ":G" . ($row + 4))->applyFromArray($styleBorder);

        $row  = $row + 5;
        $worksheet->getCell("B" . $row)->setValue("Nama :");
        $worksheet->getCell("B" . ($row + 1))->setValue("Jabatan :");
        $worksheet->getCell("B" . ($row + 2))->setValue("Tanggal :");
        $worksheet->getStyle("B" . $row . ":B" . ($row + 2))->applyFromArray($styleBorder);

        $worksheet->getCell("D" . $row)->setValue("Nama :");
        $worksheet->mergeCells("D" . $row . ":G" . $row);
        $worksheet->getCell("D" . ($row + 1))->setValue("Jabatan :");
        $worksheet->mergeCells("D" . ($row + 1) . ":G" . ($row  + 1));
        $worksheet->getCell("D" . ($row + 2))->setValue("Tanggal :");
        $worksheet->mergeCells("D" . ($row + 2) . ":G" . ($row  + 2));        
        $worksheet->getStyle("D" . $row . ":G" . ($row + 2))->applyFromArray($styleBorder);


        //TODO : WRITE AND DOWNLOAD
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
