<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class MY_Controller extends MX_Controller { 
	public $data = array();

	public function __construct() 
		{ 
			parent::__construct(); 
			$this->data['app_name'] = config_item('app_name'); 
			$this->data['copyright'] = config_item('company'); 
		} 
	 
	 
}