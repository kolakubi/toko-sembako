<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

class Stok_masuk_model extends CI_Model {

	private $table = 'stok_masuk';

	public function create($data)
	{
		$dataPembelian = [
			'tanggal' => $data['tanggal'],
			'barcode' => $data['barcode'],
			'jumlah' => $data['jumlah'],
			'supplier' => $data['supplier'],
			'harga' => $data['harga'] ,
			'metode_pembayaran' => $data['metode_pembayaran'],
			'keterangan' => $data['keterangan'],
			'no_nota' => $data['no_nota'],
		];

		if($this->db->insert($this->table, $dataPembelian)){

			$lastInsertId = $this->db->insert_id();
			// insert + update metode cash
			if($data['jumlah_uang'] != 0){
				if($this->db->insert('kas', 
				[
					"jumlah_uang" => $data['jumlah_uang'],
					"metode_pembayaran" => 'cash',
					"posisi_kas" => "K",
					"keterangan_kas" => "Beli ".$data['keterangan'],
					"id_pembelian" => $lastInsertId
				]
				)){
					$data['metode_pembayaran'] = 'cash';
					$data['jumlah_uang'] = $data['jumlah_uang'];
					$this->insertOrUpdateUang($data);
				}
			}
			// insert + update metode transfer
			if($data['jumlah_uang_transfer'] != 0){
				if($this->db->insert('kas', 
				[
					"jumlah_uang" => $data['jumlah_uang_transfer'],
					"metode_pembayaran" => 'transfer',
					"posisi_kas" => "K",
					"keterangan_kas" => "Beli ".$data['keterangan'],
					"id_pembelian" => $lastInsertId
				]
				)){
					$data['metode_pembayaran'] = 'transfer';
					$data['jumlah_uang'] = $data['jumlah_uang_transfer'];
					$this->insertOrUpdateUang($data);
				}
			}
			// insert kartu stok
			return $this->db->insert('kartu_stok', [
				'id_produk' => $data['barcode'],
				'id_transaksi' => $lastInsertId,
				'posisi' => 'K',
				'qty' => $data['jumlah'],
				'keterangan' => "Jual ".$data['keterangan']
			]);
		}
	}

	public function insertOrUpdateUang($data){

		$dataUang = $this->db->get_where('uang', ['metode'=> $data['metode_pembayaran']])->row_array();
		
		if($dataUang){
			$this->db->set('jumlah_uang', ($dataUang['jumlah_uang']-$data['jumlah_uang']));
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
		$this->db->select('stok_masuk.tanggal, stok_masuk.jumlah, stok_masuk.keterangan, stok_masuk.barcode, supplier.nama as supplier, stok_masuk.harga');
		$this->db->where('tanggal >=', $dataDari);
        $this->db->where('tanggal <=', $dataSampai);
		$this->db->from($this->table);
		// $this->db->join('produk', 'produk.id = stok_masuk.barcode');
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

	public function getProduk($barcode, $qty)
	{
		$total = explode(',', $qty);
		$data = [];
		foreach ($barcode as $key => $value) {
			$this->db->select('nama_produk');
			$this->db->where('id', $value);
			$data[] = '<tr><td>'.$this->db->get('produk')->row()->nama_produk.' ('.$total[$key].')</td></tr>';
		}
		return join($data);
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

	public function removeStok($id, $stok)
	{
		$this->db->where('id', $id);
		$this->db->set('stok', $stok);
		return $this->db->update('produk');
	}

	// public function addTerjual($id, $jumlah)
	// {
	// 	$this->db->where('id', $id);
	// 	$this->db->set('terjual', $jumlah);
	// 	return $this->db->update('produk');;
	// }

}

/* End of file Stok_masuk_model.php */
/* Location: ./application/models/Stok_masuk_model.php */