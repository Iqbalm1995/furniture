<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download_apk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Mo_apk_upload', 'apk_upload');
		if($this->session->userdata('status') != "logindcaadministrator"){
			redirect(base_url());
		}
    }
    
	public function index()
	{
        $data['data_apk'] = $this->apk_upload->tampil_data()->result();

		$this->load->view('header_view');
		$this->load->view('download_apk', $data);
		$this->load->view('footer_view');
    }

    function hapus($id){
		$where = array('id' => $id);
		$read_file = $this->apk_upload->get_by_id($id);
		if(file_exists('upload_file/apk/'.$read_file->nama_file) && $read_file->nama_file)
			unlink('upload_file/apk/'.$read_file->nama_file);

		$this->apk_upload->hapus_data($where,'t_apk_upload');
		$this->session->set_flashdata('message1', '
			<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Berhasil <i class="glyphicon glyphicon-ok"></i></strong> Data telah di hapus
            </div>
			');
        redirect (base_url().'download_apk');
	}

	public function download_file($upload_file){	
		# load download helper
	    $this->load->helper('download');

	    $this->db->select('nama_file');
	    $this->db->where('nama_file', $upload_file);
	    $q = $this->db->get('t_apk_upload');

	    # if exists continue
	    if($q->num_rows() > 0)
	    {
	        $row  = $q->row();
	        $file = FCPATH . 'upload_file/apk/'. $row->upload_file;
	        if(file_exists($file))
	            force_download($file, NULL);
	    }

	    else
	        show_404();
	}

    public function proses_upload()
    {
        $deskripsi 		= $this->input->post('deskripsi');
        $versi 	        = $this->input->post('versi');
        $tgl_upload 	= date('Y-m-d');

        $dataAPK = array(
			'deskripsi' 	=> $deskripsi,
			'versi' 	    => $versi,
			'tgl_upload' 	=> $tgl_upload,
			'id_admin'		=> $this->session->userdata('id')
		);
        
        if(!empty($_FILES['upload_file']['name']))
		{
			//delete file
			if(file_exists('upload_file/apk/'.$_FILES['upload_file']['name']) && $_FILES['upload_file']['name'])
            unlink('upload_file/apk/'.$_FILES['upload_file']['name']);
            
            $upload = $this->_do_upload();
            
            $dataAPK['nama_file'] = $upload;
            echo 'upload_file/apk/'.$_FILES['upload_file']['name'];
        }

        $this->apk_upload->input_data($dataAPK,'t_apk_upload');
        
        $this->session->set_flashdata('message1', '
			<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Berhasil <i class="glyphicon glyphicon-ok"></i></strong> Data telah di upload
            </div>
			');
		redirect (base_url().'download_apk');
    }
    
    private function _do_upload()
	{
		// $file_name = "file_".time();

		$config['upload_path']          =  'upload_file/apk';
        // $config['allowed_types']        = 'apk';
        $config['allowed_types'] 		=  '*';
        $config['max_size']             =  1000000; //set max size allowed in Kilobyte
        // $config['max_width']            = 1000; // set max width image allowed
        // $config['max_height']           = 1000; // set max height allowed
        //$config['file_name']            =  'APK_furniture'; //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('upload_file')) //upload and validate
        {
            $this->session->set_flashdata('message1', '
				<div class="alert alert-danger alert-dismissible" role="alert">
	              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	              <strong>Gagal </strong> Data gagal di upload
	            </div>
				');
            redirect (base_url().'download_apk');
			exit();
		}
		return $this->upload->data('file_name');
	}
}
