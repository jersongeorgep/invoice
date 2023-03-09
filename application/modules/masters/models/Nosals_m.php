<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Nosals_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	public $_table = 'pms_nosals';
	public $primary_key = 'nosal_id' ;

    function nosals_list() {       
        $qry = "select n.*,p.products from pms_nosals as n left join pms_products as p on (n.product_id=p.id)";
        $res = $this->db->query($qry)->result();
        return $res;
    }
		 
}
?>