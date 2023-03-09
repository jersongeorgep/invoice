<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Income_expense_heads_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'lms_income_expense_heads';
	public $primary_key = 'id' ;
		 
}
?>