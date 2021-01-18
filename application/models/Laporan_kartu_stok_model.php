<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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