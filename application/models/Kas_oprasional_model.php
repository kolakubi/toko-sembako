<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

class Kas_oprasional_model extends CI_Model {

    private $table = 'kas_oprasional';

	public function read()
	{
		return $this->db->get($this->table);
    }
    
    public function create($data)
	{
        if($this->db->insert($this->table, $data)){

            $lastInsertId = $this->db->insert_id();
			if($this->db->insert('kas', 
				[
					"jumlah_uang" => $data['jumlah_uang'],
					"metode_pembayaran" => $data['metode_pembayaran'],
					"posisi_kas" => $data['posisi'],
					"keterangan_kas" => $data['orang'].' '.$data['keterangan'],
					"id_kas_oprasional" => $lastInsertId
				]
			)){
				return $this->insertOrUpdateUang($data);
			}
        }
    }

    public function insertOrUpdateUang($data){
		$dataUang = $this->db->get_where('uang', ['metode'=> $data['metode_pembayaran']])->row_array();
		if($dataUang){
            if($data['posisi'] == "D"){
                $this->db->set('jumlah_uang', ($data['jumlah_uang']+$dataUang['jumlah_uang']));
            }
            if($data['posisi'] == "K"){
                $this->db->set('jumlah_uang', ($dataUang['jumlah_uang'])-$data['jumlah_uang']);
            }
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
    


}

/* End of file Kas_oprasional_model.php */
/* Location: ./application/models/Kas_oprasional_model.php */