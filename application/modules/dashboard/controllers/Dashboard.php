<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Dashboard';
		$this->data['menu'] = 'Dashboard';
	}

	public function index(){
		$this->data['pageTitle'] = 'Dashboard';
		$this->data['branch']	= $this->session->userdata('branch_id');
		$this->data['notes'] 	= $this->Notes_m->order_by('id', 'desc')->get_all();
		$this->db->select('ft.*, fb.branch_name as fromBranchName, tb.branch_name as toBranchName, e.full_name')->from('lms_fund_transfer as ft')->join('lms_branches as fb', 'fb.id = ft.from_branch_id', 'left')->join('lms_branches as tb', 'tb.id = ft.to_branch_id', 'left')->join('lms_employees as e', 'e.id = ft.transferred_by', 'left');
		$this->db->where('ft.confirm_status', 'pending');
		$this->data['transfers'] = $this->db->get()->result();
		$this->data['loadPage']	= "dashboard/dashboard_admin";
		$this->data['branches']	= $this->Branches_m->get_all();
		$this->layouts->admin_layouts($this->data);
	}

	function get_checkins() {
		$branch_id			= $this->input->post('branch_id');
		$date     			= $this->input->post('date');
		$data['booking']	= $this->Dashboard_m->booking_list($branch_id,$date);
		$this->load->view('dashboard/ajax_checkins',$data);
	}

	public function add_notes_popup(){
		$this->data['pageHeading'] = "New Note";
		$this->load->view('dashboard/add_note', $this->data);
	}
	 public function save_note(){
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('notes', 'Note', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata("danger", validation_errors());
			redirect('dashboard');
		}else{
			$data = $this->Notes_m->array_from_post(array(
				'title',
				'branch_id',
				'notes'
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Notes_m->insert($data);
			add_notification('fa-save', "Note added");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('dashboard');
		}
	 }

	 public function delete_note(){
		$val = $this->input->post(NULL, true);
		$id = $val['id'];
		$this->Notes_m->delete($id);
		add_notification('fa-trash', "Note deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	 }
	
	 public function filter_rooms_list($status){
		$this->data['pageTitle']	= 'Room List';
		if($this->session->userdata('branch_id') == 1){
			$this->data['branches']	= $this->db->where('status', 1)->get('lms_branches')->result();
		}else{
			$this->data['branches']	= $this->db->where('id',$this->session->userdata('branch_id'))->get('lms_branches')->result();
		}
		$this->data['status'] 		= $status;
		$this->data['colors']		= array('green', 'blue', 'cyan', 'maroon', 'orange', 'pink', 'primary', 'warning', 'yellow', 'teal', 'danger');
		$this->data['loadPage']		= "dashboard/filter_rooms_list";
		$this->layouts->admin_layouts($this->data);
	}

	public function cash_in_hand_branch_wise(){
		$this->data['pageTitle']	= 'Branch Wise Cash-in-hand';
		$this->data['branches'] 	= $this->Branches_m->get_all();
		$this->data['loadPage']		= "dashboard/branches_lists";
		$this->layouts->admin_layouts($this->data);
	}
		
}
