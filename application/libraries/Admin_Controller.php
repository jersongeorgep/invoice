<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_Controller extends MY_Controller{
	public $data = array();
	public function __construct(){
		parent::__construct();
		
		/* if($this->session->userdata('loggedin') != TRUE){
			$this->session->sess_destroy();
			redirect('login');
		} */

		$this->load->module('layouts');
		$this->load->model(array(
			//'masters/Room_m',
		));
	}
}
