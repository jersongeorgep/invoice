<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Item_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'item';
	public $primary_key = 'id' ;
		 
}
?>