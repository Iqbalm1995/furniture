<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mo_produk extends CI_Model {

	public function tampil_data()
	{
        $this->db->from("t_produk");
        $this->db->order_by("id", "DESC");
        return $this->db->get();
	}

	public function tampil_detail($id)
	{
		$this->db->select('	t_produk.id AS id,
							t_kategori.nama_kategori AS nama_kategori,
							t_produk.nama_file AS nama_file,
							t_produk.upload_file AS upload_file,
							t_produk.tanggal AS tanggal,
							t_produk.u_panjang AS u_panjang,
							t_produk.u_lebar AS u_lebar,
							t_produk.u_tinggi AS u_tinggi,
							t_produk.bahan AS bahan,
							t_produk.berat AS berat,
							t_produk.merk AS merk');
        $this->db->from('t_produk');
        $this->db->join('t_kategori', 't_produk.kategori_id = t_kategori.id');
        $this->db->where('t_produk.id', $id);
        $query = $this->db->get();
        return $query->row_array();
	}

	public function tampil_stok($id)
	{
        $this->db->from("t_stok");
        $this->db->where('id_produk', $id);
        $this->db->order_by("id", "DESC");
        return $this->db->get();
	}

	function input_data($data,$table){
		$this->db->insert($table,$data);
	}

	function edit_data($where,$table){		
		return $this->db->get_where($table,$where);
	}

	function update_data($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}

	function hapus_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}	

	public function get_id_val($where,$table)
	{
		$this->db->from($table);
		$this->db->where('id',$where);
		$query = $this->db->get();

		return $query->row_array();
	}

	public function get_by_id($id)
	{
		$this->db->from('t_produk');
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

}

/* End of file Mo_libs.php */
/* Location: ./application/models/Mo_libs.php */