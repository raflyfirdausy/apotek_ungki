<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
    {
        parent::__construct();

        $this->load->model("Vsub_jenis_sampah_model", "vsub_jenis_sampah");
    }

	public function index()
	{
		// $this->load->view('welcome_message');

		// d('oke');
		d($this->session->userdata(SESSION));
	}

	public function getSubjenisByIdJenis()
	{
		$id_jenis_sampah = $this->input->post('id_jenis_sampah');

		$vsub_jenis_sampah  = $this->vsub_jenis_sampah->where(["id_jenis_sampah" => $id_jenis_sampah])->as_array()->get_all() ?: [];

		$lists = "<option value='' disabled>Pilih Sub Jenis</option>";
		if ($vsub_jenis_sampah) {
			foreach ($vsub_jenis_sampah as $data) {
				$lists .= "<option value='" . $data['id'] . "'>" . ce($data['nama']) . "</option>";
			}
		} else {
			$lists .= "<option value=''>Pilih</option>";
		}

		$callback = array('list_sub_jenis' => $lists);
		echo json_encode($callback);
	}

	public function getKabupatenByIdProvinsi()
	{
		$id = $this->input->post('id_prov');
		$api = $this->curl->simple_get('http://10.10.16.158:310/api/common/kab/' . $id);

		$kabupaten = json_decode($api, true);
		$oke = $kabupaten['data'];

		$lists = "<option value='' disabled>Pilih Kabupaten</option>";
		if ($api) {
			foreach ($oke as $data) {
				$lists .= "<option value='" . $data['id'] . "'>" . ce($data['kabupaten']) . "</option>";
			}
		} else {
			$lists .= "<option value=''>Pilih</option>";
		}

		$callback = array('list_kabupaten' => $lists);
		echo json_encode($callback);
	}

	public function getKecamatanByIdKabupaten()
	{
		$id = $this->input->post('id_kab');
		$api = $this->curl->simple_get('http://10.10.16.158:310/api/common/kec/' . $id);

		$kecamatan = json_decode($api, true);
		$oke = $kecamatan['data'];

		$lists = "<option value='' disabled>Pilih Kecamatan</option>";
		if ($api) {
			foreach ($oke as $data) {
				$lists .= "<option value='" . $data['id'] . "'>" . ce($data['kecamatan']) . "</option>";
			}
		} else {
			$lists .= "<option value=''>Pilih</option>";
		}

		$callback = array('list_kecamatan' => $lists);
		echo json_encode($callback);
	}

	public function getKelurahanByIdKecamatan()
	{
		$id = $this->input->post('kecamatan_id');
		$api = $this->curl->simple_get('http://10.10.16.158:310/api/common/kel/' . $id);

		$kelurahan = json_decode($api, true);
		$oke = $kelurahan['data'];

		// Buat variabel untuk menampung tag-tag option nya
		// Set defaultnya dengan tag option Pilih
		$lists = "<option value='' disabled>Pilih Kelurahan</option>";
		if ($api) {
			foreach ($oke as $data) {
				$lists .= "<option value='" . $data['id'] . "'>" . ce($data['kelurahan']) . "</option>"; // Tambahkan tag option ke variabel $lists
			}
		} else {
			$lists .= "<option value=''>Pilih</option>"; // Tambahkan tag option ke variabel $lists
		}

		$callback = array('list_kelurahan' => $lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
		echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}

	public function getKelurahanByIdKecamatanUbah($id)
	{
		$api = $this->curl->simple_get('http://10.10.16.158:310/api/common/kel/' . $id);

		$kelurahan = json_decode($api, true);

		$oke = $kelurahan['data'];

		if ($oke) {
			d([
				'status'    => 1,
				'data'      => $oke
			]);
		} else {
			d([
				'status'    => 0,
				'data'      => []
			]);
		}
	}

	public function provinsi()
	{
		$prov = $this->db
			->select('id, kode, INITCAP(provinsi) as provinsi')
			->order_by('provinsi', 'asc')
			->get("tm_provinsi")
			->result_array();

		if ($prov) {
			echo json_encode([
				"status"    => 1,
				"data"      => $prov
			]);
		} else {
			echo json_encode([
				"status"    => 0,
				"data"      => []
			]);
		}
	}

	public function kabupaten($id_prov = "")
	{
		$prov = $this->db
			->select('id, id_provinsi, kode, INITCAP(kabupaten) as kabupaten')
			->where(["id_provinsi" => $id_prov])
			->order_by('kabupaten', 'asc')
			->get("tm_kabupaten")
			->result_array();

		if ($prov) {
			echo json_encode([
				"status"    => 1,
				"data"      => $prov
			]);
		} else {
			echo json_encode([
				"status"    => 0,
				"data"      => []
			]);
		}
	}

	public function kecamatan($id_kab = "")
	{
		$prov = $this->db
			->select('id, id_kabupaten, kode, INITCAP(kecamatan) as kecamatan')
			->where(["id_kabupaten" => $id_kab])
			->order_by('kecamatan', 'asc')
			->get("tm_kecamatan")
			->result_array();

		if ($prov) {
			echo json_encode([
				"status"    => 1,
				"data"      => $prov
			]);
		} else {
			echo json_encode([
				"status"    => 0,
				"data"      => []
			]);
		}
	}

	public function kelurahan($id_kec = "")
	{
		$prov = $this->db
			->query("SELECT * FROM tm_kelurahan WHERE CAST(id as VARCHAR) LIKE '$id_kec%' ORDER BY kel ASC")
			->result_array();

		if ($prov) {
			echo json_encode([
				"status"    => 1,
				"data"      => $prov
			]);
		} else {
			echo json_encode([
				"status"    => 0,
				"data"      => []
			]);
		}
	}

	public function kabupatenByID($id = null)
	{
		$this->db
			->select('id, id_provinsi, kode, INITCAP(kabupaten) as kabupaten')
			->where('id', $id);
		$kab = $this->db->get('tm_kabupaten')->row_array();

		if ($kab) {
			echo json_encode([
				"status"    => 1,
				"data"      => $kab
			]);
		} else {
			echo json_encode([
				"status"    => 0,
				"data"      => []
			]);
		}
	}

	public function kecamatanByID($id = null)
	{
		$this->db
			->select('id, id_kabupaten, kode, INITCAP(kecamatan) as kecamatan')
			->where('id', $id);
		$kec = $this->db->get('tm_kecamatan')->row_array();

		if ($kec) {
			echo json_encode([
				"status"    => 1,
				"data"      => $kec
			]);
		} else {
			echo json_encode([
				"status"    => 0,
				"data"      => []
			]);
		}
	}

	public function kelurahanByID($id = null)
	{
		$this->db->where('id', $id);
		$kel = $this->db->get('tm_kelurahan')->row_array();

		if ($kel) {
			echo json_encode([
				"status"    => 1,
				"data"      => $kel
			]);
		} else {
			echo json_encode([
				"status"    => 0,
				"data"      => []
			]);
		}
	}
}
