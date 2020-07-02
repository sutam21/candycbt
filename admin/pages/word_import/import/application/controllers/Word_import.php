<?php
class Word_import extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->lang->load('basic', $this->config->item('language'));
	$this->load->helper('url');
    $this->load->helper('word_import_helper');
	$this->load->model('word_import_model','',TRUE);
 }

 function index($limit='0',$cid='0')
 {
				$logged_in=$this->session->userdata('beeuser');		
                $config['upload_path']          = './upload/';
                $config['allowed_types']        = 'docx';
                $config['max_size']             = 10000;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('word_file'))
                {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$error['error']." </div>");
					redirect('qbank');				
					exit;
                }
                else
                {
					$data = array('upload_data' => $this->upload->data());
					$targets = 'upload/';
					$targets = $targets . basename($data['upload_data']['file_name']);
					$Filepath = $targets;               
                
                }
$this->load->helper('word_import_helper');
$questions=word_file_import($Filepath);
$this->word_import_model->import_ques($questions);
$this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_imported_successfully')." </div>");
$id_soal=$_POST['id_bank_soal'];
$id_lokal=$_POST['id_lokal'];
$sip = $_SERVER['SERVER_NAME'];
header('location:../../../../index.php?pg=banksoal&tambah=yes&ac=lihat&id='.$id_soal);  

 }



}
