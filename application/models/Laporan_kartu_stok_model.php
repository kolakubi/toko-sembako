<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

class Laporan_kartu_stok_model extends CI_Model {

	private $table = 'kartu_stok';

	public function read()
	{
		// $this->db->select('stok_masuk.tanggal, stok_masuk.jumlah, stok_masuk.keterangan, produk.barcode, produk.nama_produk');
		$this->db->select('kartu_stok.posisi, kartu_stok.id_produk, kartu_stok.qty, kartu_stok.keterangan, kartu_stok.tanggal, produk.nama_produk as nama');
		$this->db->from($this->table);
		$this->db->join('produk', 'produk.id = kartu_stok.id_produk');
		return $this->db->get();
	}

	public function read_by_date($tanggalDari, $tanggalSampai, $idProduk)
	{
		// $this->db->select('stok_masuk.tanggal, stok_masuk.jumlah, stok_masuk.keterangan, produk.barcode, produk.nama_produk');
		$this->db->select('kartu_stok.posisi, kartu_stok.id_produk, kartu_stok.qty, kartu_stok.keterangan, kartu_stok.tanggal, produk.nama_produk as nama');
        // $this->db->like('nama_produk', 'Kapal');
        $this->db->like('id_produk', $idProduk);
		$this->db->where('tanggal >=', $tanggalDari);
        $this->db->where('tanggal <=', $tanggalSampai);
		$this->db->from($this->table);
		$this->db->join('produk', 'produk.id = kartu_stok.id_produk');
		return $this->db->get();
	}

	public function get_1_produk($id){
		return $this->db->get_where('produk', ['id' => $id])->result_array();
	}
	
	// public function getProduk($barcode, $qty)
	// {
	// 	$total = explode(',', $qty);
	// 	foreach ($barcode as $key => $value) {
	// 		$this->db->select('nama_produk');
	// 		$this->db->where('id', $value);
	// 		$data[] = '<tr><td>'.$this->db->get('produk')->row()->nama_produk.' ('.$total[$key].')</td></tr>';
	// 	}
	// 	return join($data);
	// }

	public function getProduk($barcode, $qty, $idProduk)
	{
		$total = explode(',', $qty);
		$i=0;
		foreach ($barcode as $key => $value) {
			if($value == $idProduk){
				$this->db->select('nama_produk');
				$this->db->where('id', $value);
				// $data = '<tr><td>'.$this->db->get('produk')->row()->nama_produk.' ('.$total[$i].')</td></tr>';
				$data = $this->db->get('produk')->row();
				// $data['nama'] = $data->nama_produk;
				$data->qty = $total[$i];
			}
			$i+=1;
		}
		return $data;
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