<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Room_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'lms_room';
	public $primary_key = 'id' ;
		 
}
?>