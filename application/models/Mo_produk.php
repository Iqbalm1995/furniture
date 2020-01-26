<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mo_produk extends CI_Model {

	public function tampil_data()
	{
        $this->db->from("t_produk");
        $this->db->order_by("id_produk", "DESC");
        return $this->db->get();
	}

	public function tampil_detail($id)
	{
		$this->db->select('	t_produk.id_produk AS id_produk,
							t_kategori.nama_kategori AS nama_kategori,
							t_produk.nama_produk AS nama_produk,
							t_produk.upload_file AS upload_file,
							t_produk.tanggal AS tanggal,
							t_ukuran.panjang AS panjang,
							t_ukuran.lebar AS lebar,
							t_ukuran.tinggi AS tinggi,
							t_produk.bahan AS bahan,
							t_produk.harga AS harga,
							t_produk.merk AS merk, 
							admin.id_admin AS id_user, 
							admin.nama as nama');
        $this->db->from('t_produk');
        $this->db->join('t_kategori', 't_produk.id_kategori = t_kategori.id_kategori');
        $this->db->join('t_ukuran', 't_produk.id_produk = t_ukuran.id_produk');
		$this->db->join("admin", "t_produk.id_admin = admin.id_admin");
        $this->db->where('t_produk.id_produk', $id);
        $query = $this->db->get();
        return $query->row_array();
	}

	public function tampil_stok($id)
	{
		$this->db->select('	t_warna.id_warna AS id_warna,
							t_warna.nama_warna AS nama_warna,
							t_warna.kode_warna AS kode_warna,
							t_stok.stok AS stok,
							t_warna.id_produk AS id_produk, 
							admin.id_admin AS id_user, 
							admin.nama as nama');
        $this->db->from("t_warna");
        $this->db->join('t_stok', 't_warna.id_warna = t_stok.id_warna');
		$this->db->join("admin", "t_warna.id_admin = admin.id_admin");
        $this->db->where('t_warna.id_produk', $id);
        $this->db->order_by("t_warna.id_warna", "DESC");
        return $this->db->get();
	}

	function input_data($data,$table){
		$this->db->insert($table,$data);
	}

	function input_ukuran($data,$table){
		$this->db->insert($table,$data);
	}

	function edit_data($where){		
		$this->db->select('	t_produk.id_produk AS id_produk,
							t_produk.id_kategori AS id_kategori,
							t_produk.nama_produk AS nama_produk,
							t_produk.nama_produk AS nama_produk,
							t_produk.keterangan AS keterangan,
							t_produk.tanggal AS tanggal,
							t_ukuran.panjang AS panjang,
							t_ukuran.lebar AS lebar,
							t_ukuran.tinggi AS tinggi,
							t_produk.bahan AS bahan,
							t_produk.harga AS harga,
							t_produk.merk AS merk, 
							admin.id_admin AS id_user, 
							admin.nama as nama');
        $this->db->from('t_produk');
        $this->db->join('t_ukuran', 't_produk.id_produk = t_ukuran.id_produk');
		$this->db->join("admin", "t_produk.id_admin = admin.id_admin");
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
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
		$this->db->where($where);
		$query = $this->db->get();

		return $query->row_array();
	}

	public function get_by_id($id)
	{
		$this->db->from('t_produk');
		$this->db->where('id_produk',$id);
		$query = $this->db->get();

		return $query->row();
	}

}

/* End of file Mo_libs.php */
/* Location: ./application/models/Mo_libs.php */