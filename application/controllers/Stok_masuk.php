<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

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
		$tanggalSampai = str_replace(' ', '/', $tanggalSampai);
		$tanggalSampai = date('Y-m-d', strtotime($tanggalSampai . "+1 days"));
		$nomor = 0;

		// header('Content-type: application/json');
		if ($this->stok_masuk_model->read_laporan_by_date($tanggalDari, $tanggalSampai)->num_rows() > 0) {
			foreach ($this->stok_masuk_model->read_laporan_by_date($tanggalDari, $tanggalSampai)->result() as $stok_masuk) {
				$barcode = explode(',', $stok_masuk->barcode);
				$tanggal = new DateTime($stok_masuk->tanggal);
				$data[] = array(
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'barcode' => $barcode,
					'nama_produk' => '<table>'.$this->stok_masuk_model->getProduk($barcode, $stok_masuk->jumlah).'</table>',
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
		$produk = json_decode($this->input->post('produk'));
		$jumlahUang = $this->input->post('jumlah_uang');
		$jumlahUangTransfer = $this->input->post('jumlah_uang_transfer');
		$metodePembayaran = '';
		if($jumlahUang == 0){
			$metodePembayaran = 'transfer';
		}
		elseif($jumlahUangTransfer == 0){
			$metodePembayaran = 'cash';
		}
		else{
			$metodePembayaran = 'cash dan transfer';
		}
		$barcode = array();
		foreach ($produk as $produk) {
			$this->stok_masuk_model->removeStok($produk->id, $produk->stok);
			// $this->stok_masuk_model->addTerjual($produk->id, $produk->terjual);
			// array_push($barcode, $produk->id);
		}
		$tanggal = new DateTime($this->input->post('tanggal'));
		$data = array(
			'tanggal' => $tanggal->format('Y-m-d H:i:s'),
			'barcode' => implode(',', $this->input->post('produkId')),
			'jumlah' => implode(',', $this->input->post('qty')),
			'supplier' => $this->input->post('supplier'),
			'harga' => $jumlahUang+$jumlahUangTransfer,
			'metode_pembayaran' => $metodePembayaran,
			'keterangan' => $this->input->post('keterangan'),
			'no_nota' => $this->input->post('no_nota'),
			'jumlah_uang' => $jumlahUang,
			'jumlah_uang_transfer' => $jumlahUangTransfer,
		);
		if ($this->stok_masuk_model->create($data)) {
			echo json_encode('sukses');
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