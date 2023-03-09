<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Room_status_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'lms_room_status';
	public $primary_key = 'id' ;
		 
}
?>