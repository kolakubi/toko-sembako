<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

class Transaksi_model extends CI_Model {

	private $table = 'transaksi';

	public function removeStok($id, $stok)
	{
		$this->db->where('id', $id);
		$this->db->set('stok', $stok);
		return $this->db->update('produk');
	}

	public function getTerjual($id){
		$this->db->select('terjual');
		$this->db->where('id', $id);
		return $this->db->get('produk')->row_array();
	}

	public function addTerjual($id, $jumlah)
	{
		$this->db->where('id', $id);
		$this->db->set('terjual', $jumlah);
		return $this->db->update('produk');;
	}

	public function getHistoryPembelian($idProduk){
		$this->db->select('tanggal, barcode, jumlah, harga_per_item');
		$this->db->from('stok_masuk');
		$this->db->like('barcode', $idProduk);
		$this->db->order_by('tanggal', 'DESC');
		$this->db->limit(3, 0);
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function create($data)
	{
		$dataTransaksi = [
			'tanggal' => $data['tanggal'],
			'barcode' => $data['barcode'],
			'qty' => $data['qty'],
			'harga_per_item' => $data['harga_per_item'],
			'laba' => $data['laba'],
			'total_bayar' => $data['total_bayar'],
			// 'jumlah_uang' => $this->input->post('jumlah_uang'),
			'jumlah_uang' => $data['jumlah_uang'] + $data['jumlah_uang_transfer'],
			'diskon' => $data['diskon'],
			'pelanggan' => $data['pelanggan'],
			'nota' => $data['nota'],
			'kasir' => $data['kasir'],
			'keterangan' => $data['keterangan'],
			'metode_pembayaran' => $data['metode_pembayaran'],
		];

		if($this->db->insert($this->table, $dataTransaksi)){

			$lastInsertId = $this->db->insert_id();
			// insert + update metode cash
			if($data['jumlah_uang'] != 0){
				if($this->db->insert('kas', 
				[
					"jumlah_uang" => $data['jumlah_uang'],
					"metode_pembayaran" => 'cash',
					"posisi_kas" => "D",
					"keterangan_kas" => "Jual ".$data['keterangan'],
					"id_penjualan" => $lastInsertId
				]
				)){
					$data['metode_pembayaran'] = 'cash';
					$this->insertOrUpdateUang($data);
				}
			}
			// insert + update metode transfer
			if($data['jumlah_uang_transfer'] != 0){
				if($this->db->insert('kas', 
				[
					"jumlah_uang" => $data['jumlah_uang_transfer'],
					"metode_pembayaran" => 'transfer',
					"posisi_kas" => "D",
					"keterangan_kas" => "Jual ".$data['keterangan'],
					"id_penjualan" => $lastInsertId
				]
				)){
					$data['metode_pembayaran'] = 'transfer';
					$data['jumlah_uang'] =$data['jumlah_uang_transfer'];
					$this->insertOrUpdateUang($data);
				}
			}
			// insert kartu stok
			return $this->db->insert('kartu_stok', [
				'id_produk' => $data['barcode'],
				'id_transaksi' => $lastInsertId,
				'posisi' => 'K',
				'qty' => $data['qty'],
				'keterangan' => "Jual ".$data['keterangan']
			]);
			
		}
	}

	public function insertOrUpdateUang($data){

		$dataUang = $this->db->get_where('uang', ['metode'=> $data['metode_pembayaran']])->row_array();
		
		if($dataUang){
			$this->db->set('jumlah_uang', ($data['jumlah_uang']+$dataUang['jumlah_uang']));
			$this->db->set('tgl_update', $data['tanggal']);
			$this->db->where('metode', $data['metode_pembayaran']);
			return $this->db->update('uang');
		}
		else{
			return $this->db->insert('uang', 
				[
					'metode' => $data['metode_pembayaran'],
					'jumlah_uang' => $data['jumlah_uang'],
				]
			);
		}
	}
	
	public function createInvoice($data){
		return $this->db->insert('invoice', $data);
	}

	
	public function read()
	{
		$this->db->select('transaksi.id, transaksi.tanggal, transaksi.barcode, transaksi.qty, transaksi.total_bayar, transaksi.jumlah_uang, transaksi.diskon, pelanggan.nama as pelanggan');
		$this->db->from($this->table);
		$this->db->join('pelanggan', 'transaksi.pelanggan = pelanggan.id', 'left outer');
		return $this->db->get();
	}

	public function read_by_date($tanggallDari, $tanggalSampai)
	{
		$this->db->select('transaksi.id, transaksi.tanggal, transaksi.barcode, transaksi.qty, transaksi.total_bayar, transaksi.jumlah_uang, transaksi.diskon, pelanggan.nama as pelanggan');
		$this->db->where('tanggal >=', $tanggallDari);
        $this->db->where('tanggal <=', $tanggalSampai);
		$this->db->from($this->table);
		$this->db->join('pelanggan', 'transaksi.pelanggan = pelanggan.id', 'left outer');
		return $this->db->get();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}

	public function getProduk($barcode, $qty)
	{
		$total = explode(',', $qty);
		foreach ($barcode as $key => $value) {
			$this->db->select('nama_produk');
			$this->db->where('id', $value);
			$data[] = '<tr><td>'.$this->db->get('produk')->row()->nama_produk.' ('.$total[$key].')</td></tr>';
		}
		return join($data);
	}


	public function penjualanBulan($date)
	{
		$qty = $this->db->query("SELECT qty FROM transaksi WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$date'")->result();
		$d = [];
		$data = [];
		foreach ($qty as $key) {
			$d[] = explode(',', $key->qty);
		}
		foreach ($d as $key) {
			$data[] = array_sum($key);
		}
		return $data;
	}

	public function transaksiHari($hari)
	{
		return $this->db->query("SELECT COUNT(*) AS total FROM transaksi WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$hari'")->row();
	}

	public function transaksiTerakhir($hari)
	{
		return $this->db->query("SELECT transaksi.qty FROM transaksi WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$hari' LIMIT 1")->row();
	}

	public function getAll($id)
	{
		$this->db->select('transaksi.nota, transaksi.tanggal, transaksi.harga_per_item, transaksi.barcode, transaksi.qty, transaksi.total_bayar, transaksi.jumlah_uang, pengguna.nama as kasir');
		$this->db->from('transaksi');
		$this->db->join('pengguna', 'transaksi.kasir = pengguna.id');
		$this->db->where('transaksi.id', $id);
		return $this->db->get()->row();
	}

	public function getName($barcode)
	{
		foreach ($barcode as $b) {
			$this->db->select('nama_produk, harga');
			$this->db->where('id', $b);
			$data[] = $this->db->get('produk')->row();
		}
		return $data;
	}

}

/* End of file Transaksi_model.php */
/* Location: ./application/models/Transaksi_model.php */