<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// uncomment jika di live server
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

class Stok_masuk_model extends CI_Model {

	private $table = 'stok_masuk';

	public function create($data)
	{
		if($this->db->insert($this->table, $data)){

			$lastInsertId = $this->db->insert_id();
			if($this->db->insert('kas',
				[
					"jumlah_uang" => $data['harga'],
					"posisi_kas" => "K",
					'metode_pembayaran' => $data['metode_pembayaran'],
					"Keterangan_kas" => "Beli ".$data['keterangan'],
					"id_pembelian" => $lastInsertId
				]
			)){
				if($this->insertOrUpdateUang($data)){

					return $this->db->insert('kartu_stok', [
						'id_produk' => $data['barcode'],
						'posisi' => 'D',
						'id_transaksi' => $lastInsertId,
						'qty' => $data['jumlah'],
						'keterangan' => "Beli ".$data['keterangan']
					]);
				}
			}
		}
	}

	public function insertOrUpdateUang($data){

		$dataUang = $this->db->get_where('uang', ['metode'=> $data['metode_pembayaran']])->row_array();
		
		if($dataUang){
			$this->db->set('jumlah_uang', ($dataUang['jumlah_uang']-$data['harga']));
			$this->db->set('tgl_update', $data['tanggal']);
			$this->db->where('metode', $data['metode_pembayaran']);
			return $this->db->update('uang');
		}
		else{
			return $this->db->insert('uang', 
				[
					'metode' => $data['metode_pembayaran'],
					'jumlah_uang' => $data['harga']*-1,
				]
			);
		}
	}

	public function read()
	{
		// $this->db->select('stok_masuk.tanggal, stok_masuk.jumlah, stok_masuk.keterangan, produk.barcode, produk.nama_produk');
		$this->db->select('stok_masuk.tanggal, stok_masuk.jumlah, stok_masuk.keterangan, produk.barcode');
		$this->db->from($this->table);
		$this->db->join('produk', 'produk.id = stok_masuk.barcode');
		return $this->db->get();
	}

	public function read_laporan_by_date($dataDari, $dataSampai){
		$this->db->select('stok_masuk.tanggal, stok_masuk.jumlah, stok_masuk.keterangan, produk.barcode, produk.nama_produk, supplier.nama as supplier, stok_masuk.harga');
		$this->db->where('tanggal >=', $dataDari);
        $this->db->where('tanggal <=', $dataSampai);
		$this->db->from($this->table);
		$this->db->join('produk', 'produk.id = stok_masuk.barcode');
		$this->db->join('supplier', 'supplier.id = stok_masuk.supplier', 'left outer');
		return $this->db->get();
	}

	public function laporan()
	{
		$this->db->select('stok_masuk.tanggal, stok_masuk.jumlah, stok_masuk.keterangan, produk.barcode, produk.nama_produk, supplier.nama as supplier, stok_masuk.harga');
		$this->db->from($this->table);
		$this->db->join('produk', 'produk.id = stok_masuk.barcode');
		$this->db->join('supplier', 'supplier.id = stok_masuk.supplier', 'left outer');
		return $this->db->get();
	}

	public function getStok($id)
	{
		$this->db->select('stok');
		$this->db->where('id', $id);
		return $this->db->get('produk')->row();
	}

	public function addStok($id,$stok)
	{
		$this->db->where('id', $id);
		$this->db->set('stok', $stok);
		return $this->db->update('produk');
	}

	public function stokHari($hari)
	{
		return $this->db->query("SELECT SUM(jumlah) AS total FROM stok_masuk WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$hari'")->row();
	}

}

/* End of file Stok_masuk_model.php */
/* Location: ./application/models/Stok_masuk_model.php */