<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_m extends MY_Model {
	function __construct()
		{
			parent::__construct();
			//echo "<p>". $this->hash('123456789'). "</P>";
			
		}
		
		public $_table = 'lms_admin_users';
		public $primary_key = 'id' ;
		
	public function authorize_user(){
		$user = $this->get_many_by(array('email'=>$this->input->post('email'), 'password'=>$this->hash($this->input->post('password'))),TRUE);
		//$pass = $this->get_many_by(array('auth_pass'=>$this->hash($this->input->post('auth_email'))));
		//print_r($check_branch_active); exit();
		if(!empty($user)){
			$check_branch_active = $this->db->where('id', $user[0]->branch)->get('lms_branches')->row();
			if($check_branch_active ->status == 1){
				if($this->input->post('passremember') ==1){
					$this->load->helper('cookie');
					$cookie = array(
					'name'		=> 'auth_user',
					'value'		=> $this->input->post('email'),
					'expaire'	=> 86500,
					'domain'	=> site_url(),
					'path'		=> '/',
					'prefix'	=> 'CQUP_',
					'secure'	=> TRUE
					);
					$cookie1 = array(
					'name'		=> 'auth_pass',
					'value'		=> $this->hash($this->input->post('password')),
					'expaire'	=> 86500,
					'domain'	=> site_url(),
					'path'		=> '/',
					'prefix'	=> 'CQUP_',
					'secure'	=> TRUE
					);
					$this->input->set_cookie('$cookie');
					$this->input->set_cookie('$cookie1');
				}
				
				$this->data = array(
					'user_id'		=> $user[0]->id,
					'user_name' 	=> $user[0]->fullname,
					'user_email' 	=> $user[0]->email,
					'user_username'	=> $user[0]->username,
					'user_mobiel' 	=> $user[0]->mobile,
					'user_role'		=> $user[0]->role,
					'company_id'	=> $user[0]->company_id,
					'branch_id' 	=> $user[0]->branch,
					'loggedin' 		=> TRUE
				);
				$this->session->set_userdata($this->data);
				return TRUE;
			}else{
				$this->session->set_flashdata("danger", "You are trying to login de-activated account. Please contact administrator");
				return FALSE;
			}
		}else{
			$this->session->set_flashdata("danger", "You have entered wrong username or password. Please check and try again");
			return FALSE;
		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
	}
	
	public function loggedin(){
		return (bool) $this->session->userdata('loggedin');
	}
	
	public function hash($string){
		return hash('sha512', $string . config_item('encryption_key'));
	}
	 
}
?>