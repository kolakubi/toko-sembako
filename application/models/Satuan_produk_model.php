<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// uncomment jika di live server
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

class Satuan_produk_model extends CI_Model {

	private $table = 'satuan_produk';

	public function create($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function checkName($nama){
		if($this->db->get_where($this->table, ['satuan' => $nama])->num_rows()){
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
		$this->db->like('satuan', $search);
		return $this->db->get($this->table)->result();
	}

}

/* End of file Satuan_produk_model.php */
/* Location: ./application/models/Satuan_produk_model.php */