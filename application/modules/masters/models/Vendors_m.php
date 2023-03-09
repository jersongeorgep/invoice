<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vendors_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'pms_vendors';
	public $primary_key = 'id' ;
		 
}
?>