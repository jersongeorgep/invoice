<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invoice_line_items_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'invoice_line_items';
	public $primary_key = 'id' ;
		 
}
?>