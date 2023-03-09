<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Departments_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'lms_departments';
	public $primary_key = 'id' ;
		 
}
?>