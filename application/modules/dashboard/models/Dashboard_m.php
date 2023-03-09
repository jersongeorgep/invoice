<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	

    function booking_list($branch_id = "",$date="") {        
         $this->db->select('br.check_in_date,br.check_out_date,br.booking_id, GROUP_CONCAT(r.room_no) as room_no,  bg.booking_date,  bg.salute, bg.first_name, bg.last_name,bg.mobile, bg.phone, bg.email ')
        ->from('lms_booked_rooms as br')
        ->join('lms_booking_guests bg', 'br.booking_id = bg.id', 'left')
        ->join('lms_room r', 'br.room_id = r.id', 'left');
        if($date != "") {
            $this->db->where('br.check_in_date=STR_TO_DATE(\''.$date.'\',\'%Y-%m-%d\')');
        }
        if($branch_id != "") {
            $this->db->where('br.branch_id', $branch_id);
        }
        $this->db->group_by('br.booking_id');
        $bookings = $this->db->get()->result(); 
       
        return $bookings;
    }   

}
?>