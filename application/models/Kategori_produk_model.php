<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// uncomment jika di live server
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

class Kategori_produk_model extends CI_Model {

	private $table = 'kategori_produk';

	public function create($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function checkName($nama){
		if($this->db->get_where($this->table, ['kategori' => $nama])->num_rows()){
			return true;
		}

		return false;
	}

	public function read()
	{
		return $this->db->get($this->table);
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}

	public function getKategori($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->table);
	}

	public function search($search="")
	{
		$this->db->like('kategori', $search);
		return $this->db->get($this->table)->result();
	}

}

/* End of file Kategori_produk_model.php */
/* Location: ./application/models/Kategori_produk_model.php */