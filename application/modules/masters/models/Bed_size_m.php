<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bed_size_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'lms_bed_size';
	public $primary_key = 'id' ;
		 
}
?>