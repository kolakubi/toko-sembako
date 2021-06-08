<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

class Bonus_model extends CI_Model {

	// private $table = 'invoice';

	public function read()
	{
		$this->db->select('invoice.id_invoice, invoice.tanggal, invoice.barcode, invoice.qty, invoice.total_bayar, invoice.jumlah_uang, invoice.diskon, invoice.keterangan, pelanggan.nama as pelanggan, invoice.status');
		$this->db->from($this->table);
		$this->db->join('pelanggan', 'invoice.pelanggan = pelanggan.id', 'left outer');
		
		return $this->db->get();
	}

    public function getProductList(){
        $this->db->select('id');
        $this->db->from('produk');
        return $this->db->get()->result();
    }

    public function read_by_date($tanggalDari, $tanggalSampai, $idProduk)
	{
		$this->db->select('kartu_stok.posisi, kartu_stok.id_produk, kartu_stok.qty, kartu_stok.tanggal, produk.nama_produk as nama');
        $this->db->like('id_produk', $idProduk);
		$this->db->where('tanggal >=', $tanggalDari);
        $this->db->where('tanggal <=', $tanggalSampai);
        $this->db->where('kartu_stok.posisi', 'k');
		$this->db->from('kartu_stok');
		$this->db->join('produk', 'produk.id = kartu_stok.id_produk');
		return $this->db->get()->result();
	}

    public function getProduk($barcode, $qty, $idProduk)
	{
		$total = explode(',', $qty);
        $data = [];
		$i=0;
		foreach ($barcode as $value) {
			if($value == $idProduk){
				$this->db->select('nama_produk');
				$this->db->where('id', $value);
				$data = $this->db->get('produk')->row();
				$data->qty = $total[$i];
			}
			$i+=1;
		}
		return $data;
	}

    public function get_product_name($produk_id){
        $this->db->select('nama_produk, bonus_penjualan');
        $this->db->where('id', $produk_id);
        return $this->db->get('produk')->row();
    }

}

/* End of file Bonus_model.php */
/* Location: ./application/models/Transaksi_model.php */