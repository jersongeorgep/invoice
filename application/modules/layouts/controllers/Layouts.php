<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Layouts extends My_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function loginlayouts($data){
		$this->load->view('login_template',$data);
	}

	public function admin_layouts($data){
		$this->load->view('admin_template',$data);
	}
	public function home_template($data){
		$this->load->view('home_template',$data);
	}
	
}
