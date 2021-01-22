<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// uncomment jika di live server
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

class Transaksi_model extends CI_Model {

	private $table = 'transaksi';

	public function removeStok($id, $stok)
	{
		$this->db->where('id', $id);
		$this->db->set('stok', $stok);
		return $this->db->update('produk');
	}

	public function addTerjual($id, $jumlah)
	{
		$this->db->where('id', $id);
		$this->db->set('terjual', $jumlah);
		return $this->db->update('produk');;
	}

	public function create($data)
	{
		if($this->db->insert($this->table, $data)){

			$lastInsertId = $this->db->insert_id();
			if($this->db->insert('kas', 
				[
					"jumlah_uang" => $data['total_bayar'],
					"metode_pembayaran" => $data['metode_pembayaran'],
					"posisi_kas" => "D",
					"keterangan_kas" => "Jual ".$data['keterangan'],
					"id_penjualan" => $lastInsertId
				]
			)){
				if($this->insertOrUpdateUang($data)){

					return $this->db->insert('kartu_stok', [
						'id_produk' => $data['barcode'],
						'id_transaksi' => $lastInsertId,
						'posisi' => 'K',
						'qty' => $data['qty'],
						'keterangan' => "Jual ".$data['keterangan']
					]);
				}
			}
		}
	}
	
	public function createInvoice($data){
		return $this->db->insert('invoice', $data);
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

	public function read()
	{
		$this->db->select('transaksi.id, transaksi.tanggal, transaksi.barcode, transaksi.qty, transaksi.total_bayar, transaksi.jumlah_uang, transaksi.diskon, pelanggan.nama as pelanggan');
		$this->db->from($this->table);
		$this->db->join('pelanggan', 'transaksi.pelanggan = pelanggan.id', 'left outer');
		// if($dataTanggal['dari']){
		// 	$this->db->where('transaksi.tanggal >=', $dataTanggal['dari']);
        //     $this->db->where('transaksi.tanggal <=', $dataTanggal['sampai']);
		// }
		return $this->db->get();
	}

	public function read_by_date($tanggallDari, $tanggalSampai)
	{
		$this->db->select('transaksi.id, transaksi.tanggal, transaksi.barcode, transaksi.qty, transaksi.total_bayar, transaksi.jumlah_uang, transaksi.diskon, pelanggan.nama as pelanggan');
		$this->db->where('tanggal >=', $tanggallDari);
        $this->db->where('tanggal <=', $tanggalSampai);
		$this->db->from($this->table);
		$this->db->join('pelanggan', 'transaksi.pelanggan = pelanggan.id', 'left outer');
		// if($dataTanggal['dari']){
		// 	$this->db->where('transaksi.tanggal >=', $dataTanggal['dari']);
        //     $this->db->where('transaksi.tanggal <=', $dataTanggal['sampai']);
		// }
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
		$this->db->select('transaksi.nota, transaksi.tanggal, transaksi.barcode, transaksi.qty, transaksi.total_bayar, transaksi.jumlah_uang, pengguna.nama as kasir');
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