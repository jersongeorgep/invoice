<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends User_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Login';
	}
	public function index(){
		if($this->session->userdata('loggedin') == TRUE){
			redirect('dashboard');
		}
		$this->data['pageTitle'] = 'Login';		
		$this->data['loadPage'] = "login/Login_page";
		$this->layouts->loginlayouts($this->data);
		//$this->load->view('template/login_layout', $this->data);
	}

	public function check_user(){
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password','Password', 'required');
		if($this->form_validation->run() == FALSE){
			$this->data['pageTitle'] = 'Login';		
			$this->data['loadPage'] = "login/Login_page";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->loginlayouts($this->data);
		}else{
			if($this->Users_m->authorize_user() == true){
				add_notification('fa-sign-in-alt', "User logged in"); 
				redirect('dashboard');
			}else{
				redirect('login');
			}
		}
	}

	public function logout(){
		$this->Users_m->logout();
		add_notification('fa-sign-out-alt', "User logged out"); 
		redirect('login');

	}
}
