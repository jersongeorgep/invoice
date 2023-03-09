<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_Controller extends MY_Controller{
	public $data = array();
	public function __construct(){
		parent::__construct();
		
		if($this->session->userdata('loggedin') != TRUE){
			$this->session->sess_destroy();
			redirect('login');
		}

		$this->load->module('layouts');
		$this->load->model(array(
			'masters/Room_m',
			'masters/Users_m',
			'masters/Roles_m',
			'masters/Departments_m',
			'masters/Room_status_m',
			'masters/Bed_size_m',
			'masters/Income_expense_heads_m',
			'masters/Item_m',
			'masters/Products_m',
			'masters/Laundries_m',
			'payroll/Deductions_m',
			'payroll/Additions_m',
			'payroll/Payroll_m',
			'laundry/Laundry_m',
			'laundry/Laundry_item_line_m',
			'laundry/Laundry_payment_m',
			'employees/Employees_m',
			'branches/Branches_m',
			'incomes_expenses/Income_expenses_m',
			'company/Company_m',
			'attendance/Attendance_m',
			'visitors/Visitors_m',
			'booking/Guests_m',
			'booking/Booked_room_m',
			'booking/Cancellation_m',
			'calendar/Calendar_m',
			'dashboard/Notes_m',
			'dashboard/Dashboard_m',
			'amount_transfer/Amount_transfer_m',
			'amount_transfer/Transfer_cash_m',
		));
		$this->data['notifications'] = $this->db->select('*')->from('pms_notifications')->where('view_staus', 0)->order_by('id', 'desc')->limit(5)->get()->result();
	}
}
