<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Roles_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'lms_user_roles';
	public $primary_key = 'id' ;
		 
}
?>