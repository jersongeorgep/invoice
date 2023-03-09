<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shifts_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'pms_shifts';
	public $primary_key = 'shift_id' ;
		 
}
?>