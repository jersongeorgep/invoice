<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_Controller extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->module('layouts');
		$this->load->model(array(
			'masters/Users_m'
		));
	}
}