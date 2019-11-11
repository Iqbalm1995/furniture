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

	function tambah_stok(){

		$id_produk 		= $this->input->post('id_produk');
		$warna 			= $this->input->post('warna');
		$stok 			= $this->input->post('stok');
 
		$data = array(
			'id_produk' 	=> $id_produk,
			'warna' 		=> $warna,
			'stok' 			=> $stok
			);

		$this->produk->input_data($data,'t_stok');
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

		$kategori_id 		= $this->input->post('kategori_id');
		$nama_file 			= $this->input->post('nama_file');
		$keterangan 		= $this->input->post('keterangan');
		$tanggal 			= date('Y-m-d H:i:s');
		$u_panjang 			= $this->input->post('u_panjang');
		$u_lebar 			= $this->input->post('u_lebar');
		$u_tinggi 			= $this->input->post('u_tinggi');
		$bahan 				= $this->input->post('bahan');
		$berat 				= $this->input->post('berat');
		$merk 				= $this->input->post('merk');
 
		$data = array(
			'kategori_id' 	=> $kategori_id,
			'nama_file' 	=> $nama_file,
			'keterangan' 	=> $keterangan,
			'tanggal' 		=> $tanggal,
			'u_panjang' 	=> $u_panjang,
			'u_lebar' 		=> $u_lebar,
			'u_tinggi' 		=> $u_tinggi,
			'bahan' 		=> $bahan,
			'berat' 		=> $berat,
			'merk' 			=> $merk,
			);

		if(!empty($_FILES['upload_file']['name']))
		{
			$upload = $this->_do_upload();
			$data['upload_file'] = $upload;
		}


		$this->produk->input_data($data,'t_produk');
		$this->session->set_flashdata('message1', '
			<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Berhasil <i class="glyphicon glyphicon-ok"></i></strong> Data telah di tambahkan
            </div>
			');
		redirect (base_url().'produk');
	}

	function edit($id){

		$where = array('id' => $id);
		$data['produk'] = $this->produk->edit_data($where,'t_produk')->result();
		$data['kategori'] = $this->kategori->tampil_data()->result();

		$this->load->view('header_view');
		$this->load->view('produk_edit', $data);
		$this->load->view('footer_view');
	}

	function hapus($id){
		$where = array('id' => $id);
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
		$where = array('id' => $id);

		$this->produk->hapus_data($where,'t_stok');
		$this->session->set_flashdata('message1', '
			<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Berhasil <i class="glyphicon glyphicon-ok"></i></strong> Data telah di hapus
            </div>
			');
		redirect (base_url().'produk/detail/'.$id_produk);
	}

	function proses_ubah(){
		$id = $this->input->post('id');
		$kategori_id 		= $this->input->post('kategori_id');
		$nama_file 			= $this->input->post('nama_file');
		$keterangan 		= $this->input->post('keterangan');
		$tanggal 			= date('Y-m-d H:i:s');
		$u_panjang 			= $this->input->post('u_panjang');
		$u_lebar 			= $this->input->post('u_lebar');
		$u_tinggi 			= $this->input->post('u_tinggi');
		$bahan 				= $this->input->post('bahan');
		$berat 				= $this->input->post('berat');
		$merk 				= $this->input->post('merk');
 
		$data = array(
			'kategori_id' 	=> $kategori_id,
			'nama_file' 	=> $nama_file,
			'keterangan' 	=> $keterangan,
			'tanggal' 		=> $tanggal,
			'u_panjang' 	=> $u_panjang,
			'u_lebar' 		=> $u_lebar,
			'u_tinggi' 		=> $u_tinggi,
			'bahan' 		=> $bahan,
			'berat' 		=> $berat,
			'merk' 			=> $merk,
			);

		// if(file_exists('upload_files/'.$read_file->upload_file) && $read_file->upload_file)
		// 	unlink('upload_files/'.$read_file->upload_file);
		// 	$data['upload_file'] = '';

		if(!empty($_FILES['upload_file']['name']))
		{
			$upload = $this->_do_upload();
			
			//delete file
			$read_file = $this->produk->get_by_id($id);
			if(file_exists('upload_file/'.$read_file->upload_file) && $read_file->upload_file)
			unlink('upload_file/'.$read_file->upload_file);

			$data['upload_file'] = $upload;
		}

		$where = array('id' => $id);

		$this->produk->update_data($where,$data,'t_produk');
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
		$file_name = "file_".time();

		$config['upload_path']          = 'upload_file/';
        // $config['allowed_types']        = 'file|jpg|png|pdf';
        $config['allowed_types'] 		= '*';
        $config['max_size']             = 1000000; //set max size allowed in Kilobyte
        // $config['max_width']            = 1000; // set max width image allowed
        // $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = $file_name; //just milisecond timestamp fot unique name

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