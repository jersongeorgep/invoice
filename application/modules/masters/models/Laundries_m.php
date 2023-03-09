<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laundries_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'lms_laundary_shops';
	public $primary_key = 'id' ;
		 
}
?>