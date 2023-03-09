<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invoice_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'invoices';
	public $primary_key = 'id' ;
		 
}
?>