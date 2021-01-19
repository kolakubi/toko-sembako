<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_masuk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('stok_masuk_model');
	}

	public function index()
	{
		$this->load->view('stok_masuk');
	}

	public function read()
	{
		header('Content-type: application/json');
		if ($this->stok_masuk_model->read()->num_rows() > 0) {

			// var_dump($this->stok_masuk_model->read()->result());
			// die();

			foreach ($this->stok_masuk_model->read()->result() as $stok_masuk) {
				$tanggal = new DateTime($stok_masuk->tanggal);
				$data[] = array(
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'barcode' => $stok_masuk->barcode,
					// 'nama_produk' => $stok_masuk->nama_produk,
					// 'jumlah' => $stok_masuk->jumlah,
					'jumlah' => number_format($stok_masuk->jumlah,0,',','.'),
					'keterangan' => $stok_masuk->keterangan
				);
			}
		} else {
			$data = array();
		}
		$stok_masuk = array(
			'data' => $data
		);
		echo json_encode($stok_masuk);
	}

	public function read_by_date()
	{
		$tanggalDari = $_POST['tanggal_dari'];
		$tanggalSampai = $_POST['tanggal_sampai'];
		$nomor = 0;

		// header('Content-type: application/json');
		if ($this->stok_masuk_model->read_laporan_by_date($tanggalDari, $tanggalSampai)->num_rows() > 0) {

			foreach ($this->stok_masuk_model->read_laporan_by_date($tanggalDari, $tanggalSampai)->result() as $stok_masuk) {
				$tanggal = new DateTime($stok_masuk->tanggal);
				$data[] = array(
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					// 'barcode' => $stok_masuk->barcode,
					'nama_produk' => $stok_masuk->nama_produk,
					'jumlah' => $stok_masuk->jumlah,
					'keterangan' => $stok_masuk->keterangan,
					'supplier' => $stok_masuk->supplier,
					'harga' => number_format($stok_masuk->harga, 0, ',', '.'),
					'nomor' => $nomor+=1,
				);
			}
		} else {
			$data = array();
		}
		$stok_masuk = array(
			'data' => $data
		);
		echo json_encode($stok_masuk);
	}

	public function add()
	{
		$id = $this->input->post('barcode');
		$supplier = $this->input->post('supplier');
		$jumlah = $this->input->post('jumlah');
		$stok = $this->stok_masuk_model->getStok($id)->stok;
		$rumus = max($stok + $jumlah,0);
		$addStok = $this->stok_masuk_model->addStok($id, $rumus);
		if ($addStok) {
			$tanggal = new DateTime($this->input->post('tanggal'));
			$data = array(
				'tanggal' => $tanggal->format('Y-m-d H:i:s'),
				'barcode' => $id,
				'jumlah' => $jumlah,
				'supplier' => $supplier,
				'harga' => $this->input->post('harga'),
				'metode_pembayaran' => $this->input->post('metode_pembayaran'),
				// 'keterangan' => "Beli ".$id." ".$jumlah." Dus di ".$supplier,
				'keterangan' => $this->input->post('keterangan'),
			);
			if ($this->stok_masuk_model->create($data)) {
				echo json_encode('sukses');
			}
		}
	}

	public function get_barcode()
	{
		$barcode = $this->input->post('barcode');
		$kategori = $this->stok_masuk_model->getKategori($id);
		if ($kategori->row()) {
			echo json_encode($kategori->row());
		}
	}

	public function laporan()
	{
		header('Content-type: application/json');
		if ($this->stok_masuk_model->laporan()->num_rows() > 0) {

			foreach ($this->stok_masuk_model->laporan()->result() as $stok_masuk) {
				$tanggal = new DateTime($stok_masuk->tanggal);
				$data[] = array(
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					// 'barcode' => $stok_masuk->barcode,
					'nama_produk' => $stok_masuk->nama_produk,
					'jumlah' => $stok_masuk->jumlah,
					'keterangan' => $stok_masuk->keterangan,
					'supplier' => $stok_masuk->supplier,
					'harga' => number_format($stok_masuk->harga, 0, ',', '.')
				);
			}
		} else {
			$data = array();
		}
		$stok_masuk = array(
			'data' => $data
		);
		echo json_encode($stok_masuk);
	}

	public function stok_hari()
	{
		header('Content-type: application/json');
		$now = date('d m Y');
		$total = $this->stok_masuk_model->stokHari($now);
		echo json_encode($total->total == null ? 0 : $total);
	}

}

/* End of file Stok_masuk.php */
/* Location: ./application/controllers/Stok_masuk.php */