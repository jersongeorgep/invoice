<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notes_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'lms_notes';
	public $primary_key = 'id' ;
		 
}
?>