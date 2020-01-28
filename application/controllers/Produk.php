<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Mo_kategori', 'kategori');
		$this->load->model('Mo_produk', 'produk');
		if($this->session->userdata('status') != "logindcaadministrator"){
			redirect(base_url());
		}
	}

	public function download_file($upload_file){	
		# load download helper
	    $this->load->helper('download');

	    $this->db->select('upload_file');
	    $this->db->where('upload_file', $upload_file);
	    $q = $this->db->get('t_produk');

	    # if exists continue
	    if($q->num_rows() > 0)
	    {
	        $row  = $q->row();
	        $file = FCPATH . 'upload_file/'. $row->upload_file;
	        if(file_exists($file))
	            force_download($file, NULL);
	    }

	    else
	        show_404();
	}

	public function index()
	{
		$data['produk'] = $this->produk->tampil_data()->result();
		
		$this->load->view('header_view');
		$this->load->view('produk_view', $data);
		$this->load->view('footer_view');
	}

	public function detail($id)
	{
		$data['produk'] = $this->produk->tampil_detail($id);
		$data['stok'] 	= $this->produk->tampil_stok($id)->result();
		$data['id_produk'] = $id;

		$this->load->view('header_view');
		$this->load->view('produk_detail', $data);
		$this->load->view('footer_view');
	}

	public function produkList_json()
	{
		$produk = $this->produk->tampil_data()->result();
		$result = json_encode($produk);

		echo $result;
	}

	public function produkDetail_json($id)
	{
		$produk = $this->produk->tampil_detail($id);
		$result = json_encode($produk);

		echo $result;
	}

	public function produkStok_json($id)
	{
		$produk = $this->produk->tampil_stok($id)->result();
		$result = json_encode($produk);

		echo $result;
	}

	function tambah_stok(){

		$id_produk 		= $this->input->post('id_produk');
		$nama_warna 	= $this->input->post('nama_warna');
		$stok 			= $this->input->post('stok');
 
		$dataWarna = array(
			'id_produk' 	=> $id_produk,
			'nama_warna' 	=> $nama_warna,
			'id_admin'		=> $this->session->userdata('id')
			);

		$this->produk->input_data($dataWarna,'t_warna');

		$dataStok = array(
			'id_warna' 		=> $this->db->insert_id(),
			'stok' 			=> $stok,
			'id_admin'		=> $this->session->userdata('id')
			);

		$this->produk->input_data($dataStok,'t_stok');

		
		$this->session->set_flashdata('message1', '
			<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Berhasil <i class="glyphicon glyphicon-ok"></i></strong> Data telah di tambahkan
            </div>
			');
		redirect (base_url().'produk/detail/'.$id_produk);
	}

	public function tambah_data()
	{
		$data['kategori'] = $this->kategori->tampil_data()->result();

		$this->load->view('header_view');
		$this->load->view('produk_form', $data);
		$this->load->view('footer_view');
	}

	function proses_tambah(){

		$id_kategori 		= $this->input->post('id_kategori');
		$nama_produk 		= $this->input->post('nama_produk');
		$keterangan 		= $this->input->post('keterangan');
		$harga 				= $this->input->post('harga');
		$tanggal 			= date('Y-m-d');
		$panjang 			= $this->input->post('panjang');
		$lebar 				= $this->input->post('lebar');
		$tinggi 			= $this->input->post('tinggi');
		$bahan 				= $this->input->post('bahan');
		$merk 				= $this->input->post('merk');
 
		$dataProduk = array(
			'id_kategori' 	=> $id_kategori,
			'nama_produk' 	=> $nama_produk,
			'keterangan' 	=> $keterangan,
			'harga' 		=> $harga,
			'tanggal' 		=> $tanggal,
			'bahan' 		=> $bahan,
			'merk' 			=> $merk,
			'id_admin'		=> $this->session->userdata('id')
			);

		if(!empty($_FILES['upload_file']['name']))
		{
			$upload = $this->_do_upload();
			$dataProduk['upload_file'] = $upload;
		}


		$this->produk->input_data($dataProduk,'t_produk');

		$dataUkuran = array(
			'id_produk' 	=> $this->db->insert_id(),
			'panjang' 		=> $panjang,
			'lebar' 		=> $lebar,
			'tinggi' 		=> $tinggi,
			'id_admin'		=> $this->session->userdata('id')
			);

		$this->produk->input_ukuran($dataUkuran,'t_ukuran');

		$this->session->set_flashdata('message1', '
			<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Berhasil <i class="glyphicon glyphicon-ok"></i></strong> Data telah di tambahkan
            </div>
			');
		redirect (base_url().'produk');
	}

	function edit($id){

		$where = array('t_produk.id_produk' => $id);
		$data['produk'] = $this->produk->edit_data($where);
		$data['kategori'] = $this->kategori->tampil_data()->result();

		$this->load->view('header_view');
		$this->load->view('produk_edit', $data);
		$this->load->view('footer_view');
	}

	function hapus($id){
		$where = array('id_produk' => $id);
		$read_file = $this->produk->get_by_id($id);
		if(file_exists('upload_file/'.$read_file->upload_file) && $read_file->upload_file)
			unlink('upload_file/'.$read_file->upload_file);

		$this->produk->hapus_data($where,'t_produk');
		$this->session->set_flashdata('message1', '
			<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Berhasil <i class="glyphicon glyphicon-ok"></i></strong> Data telah di hapus
            </div>
			');
		redirect (base_url().'produk');
	}

	function hapus_stok($id_produk, $id){
		$where = array('id_warna' => $id);

		$this->produk->hapus_data($where,'t_warna');
		$this->session->set_flashdata('message1', '
			<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Berhasil <i class="glyphicon glyphicon-ok"></i></strong> Data telah di hapus
            </div>
			');
		redirect (base_url().'produk/detail/'.$id_produk);
	}

	function proses_ubah(){
		$id 				= $this->input->post('id_produk');
		$id_kategori 		= $this->input->post('id_kategori');
		$nama_produk 		= $this->input->post('nama_produk');
		$keterangan 		= $this->input->post('keterangan');
		$tanggal 			= date('Y-m-d');
		$panjang 			= $this->input->post('panjang');
		$lebar 				= $this->input->post('lebar');
		$tinggi 			= $this->input->post('tinggi');
		$bahan 				= $this->input->post('bahan');
		$harga 				= $this->input->post('harga');
		$merk 				= $this->input->post('merk');
 
		$dataProduk = array(
			'id_kategori' 	=> $id_kategori,
			'nama_produk' 	=> $nama_produk,
			'keterangan' 	=> $keterangan,
			'tanggal' 		=> $tanggal,
			'bahan' 		=> $bahan,
			'harga' 		=> $harga,
			'merk' 			=> $merk,
			'id_admin'		=> $this->session->userdata('id')
			);

		if(!empty($_FILES['upload_file']['name']))
		{
			$upload = $this->_do_upload();
			
			//delete file
			$read_file = $this->produk->get_by_id($id);
			if(file_exists('upload_file/'.$read_file->upload_file) && $read_file->upload_file)
			unlink('upload_file/'.$read_file->upload_file);

			$dataProduk['upload_file'] = $upload;
		}

		$where = array('id_produk' => $id);

		$this->produk->update_data($where,$dataProduk,'t_produk');

		$dataUkuran = array(
			'panjang' 		=> $panjang,
			'lebar' 		=> $lebar,
			'tinggi' 		=> $tinggi,
			'id_admin'		=> $this->session->userdata('id')
			);

		$this->produk->update_data($where,$dataUkuran,'t_ukuran');

		$this->session->set_flashdata('message1', '
			<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Berhasil <i class="glyphicon glyphicon-ok"></i></strong> Data telah di ubah
            </div>
			');
		redirect (base_url().'produk');
	}

	private function _do_upload()
	{
		// $file_name = "file_".time();

		$config['upload_path']          = 'upload_file/';
        // $config['allowed_types']        = 'file|jpg|png|pdf';
        $config['allowed_types'] 		= '*';
        $config['max_size']             = 1000000; //set max size allowed in Kilobyte
        // $config['max_width']            = 1000; // set max width image allowed
        // $config['max_height']           = 1000; // set max height allowed
        // $config['file_name']            = $file_name; //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('upload_file')) //upload and validate
        {
            $this->session->set_flashdata('message1', '
				<div class="alert alert-danger alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	              <strong>Gagal </strong> Data gagal di upload
	            </div>
				');
			redirect (base_url().'produk');
			exit();
		}
		return $this->upload->data('file_name');
	}

}

/* End of file produk.php */
/* Location: ./application/controllers/produk.php */