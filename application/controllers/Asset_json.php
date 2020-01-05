<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asset_json extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Mo_kategori', 'kategori');
		$this->load->model('Mo_produk', 'produk');
	}

	public function produkList()
	{
		$produk = $this->produk->tampil_data()->result();
		$result = json_encode($produk);

		echo $result;
	}

	public function produkDetail($id)
	{
		$produk = $this->produk->tampil_detail($id);
		$result = json_encode($produk);

		echo $result;
	}

	public function produkStok($id)
	{
		$produk = $this->produk->tampil_stok($id)->result();
		$result = json_encode($produk);

		echo $result;
	}

}

/* End of file Asset_json.php */
/* Location: ./application/controllers/Asset_json.php */