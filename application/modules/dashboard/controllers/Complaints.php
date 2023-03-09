<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Complaints extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Complaints';
		$this->data['menu'] = 'Dashboard';
	}

	public function index(){
		$this->data['pageTitle'] = 'Complaints List';
		if($this->session->userdata('branch_id') == 1){
			$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
		}else{
			$this->data['branches']		= $this->db->where('id',$this->session->userdata('branch_id'))->get('lms_branches')->result();
		}
		$this->data['loadPage']	= "dashboard/complaints/complaints_lists";
		$this->layouts->admin_layouts($this->data);
	}

	function get_filter_data() {
		$vals = $this->input->post(NULL, true);
		$this->db->select('c.*, b.branch_name')->from('lms_complaints as c')->join('lms_branches as b', 'b.id = c.branch_id', 'left');
		if(!empty($vals['fromDt'])){
			$this->db->where('DATE(complaint_datetime)>=', date('Y-m-d', strtotime($vals['fromDt'])));
		}
		if(!empty($vals['toDt'])){
			$this->db->where('DATE(complaint_datetime)<=', date('Y-m-d', strtotime($vals['toDt'])));
		}
		if($vals['branch'] != 'all'){
			$this->db->where('branch_id', $vals['branch']);
		}
		$complaints = $this->db->order_by('id', 'desc')->get()->result();
		$data = [];
		$i = 1;
		foreach($complaints as $key => $value){
			$data[$key]['sl_no']	= $i;
			$data[$key]['select']	= '<input type="checkbox" name="ids[]" id="ids_'.$value->id.'" value="'. $value->id.'" />';
			$data[$key]['date']		= date('d-m-Y h:i a', strtotime($value->complaint_datetime));
			$data[$key]['branch']	= $value->branch_name;
			$data[$key]['complaint']	= $value->complaints;
			$data[$key]['status']	= '<span class="badge '. (($value->status == 'pending') ? " badge-warning": " badge-success").' text-md">'.$value->status.'</span>'; 
			if($value->status == 'pending'){
				$data[$key]['action']	= '<button type="button" onclick="finished('.$value->id.')" class="btn btn-sm btn-success btn-flat"> Finished </button>&nbsp; <a href="'. site_url('dashboard/complaints/edit_new/'.$value->id) .'" class="btn btn-sm btn-secondary"><i class="fas fa-pencil-alt"></i></a>';
			}else{
				$data[$key]['action']	= '<a href="'. site_url('dashboard/complaints/edit_new/'.$value->id) .'" class="btn btn-sm btn-secondary"><i class="fas fa-pencil-alt"></i></a>';
			}
			$i++;
		}
		echo json_encode($data);
	}

	public function add_new(){
		$this->data['pageTitle'] = 'New Complaints';
		if($this->session->userdata('branch_id') == 1){
			$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
		}else{
			$this->data['branches']		= $this->db->where('id',$this->session->userdata('branch_id'))->get('lms_branches')->result();
		}
		$this->data['entry_form']	= "dashboard/complaints/new_complients";
		$this->data['loadPage']	= "dashboard/complaints/entry_form";
		$this->data['branches']	= $this->Branches_m->get_all();
		$this->layouts->admin_layouts($this->data);
	}

	public function save_complaints(){
		$this->form_validation->set_rules('branch_id', 'Branch Name', 'trim|required');
		$this->form_validation->set_rules('complaint_datetime', 'complaints_datetime', 'trim|required');
		$this->form_validation->set_rules('complaints', 'Complaints', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle'] = 'New Complaints';
			if($this->session->userdata('branch_id') == 1){
				$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
			}else{
				$this->data['branches']		= $this->db->where('id',$this->session->userdata('branch_id'))->get('lms_branches')->result();
			}
			$this->data['entry_form']	= "dashboard/complaints/new_complients";
			$this->data['loadPage']	= "dashboard/complaints/entry_form";
			$this->data['branches']	= $this->Branches_m->get_all();
			$this->layouts->admin_layouts($this->data);
		}else{
			$vals = $this->input->post(NULL, true);
			$data['branch_id']		=	$vals['branch_id'];
			$data['complaint_datetime'] =	date('Y-m-d H:i:s', strtotime($vals['complaint_datetime']));
			$data['complaints'] 	=	$vals['complaints'];
			$data['created_at'] 	=	date('Y-m-d H:i:s');
			$data['updated_at'] 	=	date('Y-m-d H:i:s');
			$this->db->insert('lms_complaints', $data);
			add_notification('fa-save', "complaint saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('dashboard/complaints');
		}
	}
	
	public function delete_complaints(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->db->where('id', $ids[$i])->delete('lms_complaints');
			$response = array('status'=>201, 'msg'=>'You cannot delete Head office');
			echo json_encode($response);
			exit();
		}
		add_notification('fa-trash', "complaints deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}

	public function edit_new($id){
		$this->data['pageTitle'] = 'Edit Complaints';
		$this->data['complaints'] = $this->db->where('id', $id)->get('lms_complaints')->row();
		if($this->session->userdata('branch_id') == 1){
			$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
		}else{
			$this->data['branches']		= $this->db->where('id',$this->session->userdata('branch_id'))->get('lms_branches')->result();
		}
		$this->data['entry_form']	= "dashboard/complaints/edit_complients";
		$this->data['loadPage']	= "dashboard/complaints/entry_form";
		$this->data['branches']	= $this->Branches_m->get_all();
		$this->layouts->admin_layouts($this->data);
	}

	public function update_complaints($id){
		$this->form_validation->set_rules('branch_id', 'Branch Name', 'trim|required');
		$this->form_validation->set_rules('complaint_datetime', 'complaints_datetime', 'trim|required');
		$this->form_validation->set_rules('complaints', 'Complaints', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle'] = 'Edit Complaints';
			$this->data['complaints'] = $this->db->where('id', $id)->get('lms_complaints')->row();
			if($this->session->userdata('branch_id') == 1){
				$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
			}else{
				$this->data['branches']		= $this->db->where('id',$this->session->userdata('branch_id'))->get('lms_branches')->result();
			}
			$this->data['entry_form']	= "dashboard/complaints/edit_complients";
			$this->data['loadPage']	= "dashboard/complaints/entry_form";
			$this->data['branches']	= $this->Branches_m->get_all();
			$this->layouts->admin_layouts($this->data);
		}else{
			$vals = $this->input->post(NULL, true);
			$data['branch_id']		=	$vals['branch_id'];
			$data['complaint_datetime'] =	date('Y-m-d H:i:s', strtotime($vals['complaint_datetime']));
			$data['complaints'] 	=	$vals['complaints'];
			$data['created_at'] 	=	date('Y-m-d H:i:s');
			$data['updated_at'] 	=	date('Y-m-d H:i:s');
			$this->db->where('id', $id)->update('lms_complaints', $data);
			add_notification('fa-save', "complaint saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('dashboard/complaints');
		}
	}

	public function update_status(){
		$vals = $this->input->post(NULL, true);
		$data['status'] = "finished";
		$data['updated_at'] = date('Y-m-d H:i:s');
		$this->db->where('id', $vals['id'])->update('lms_complaints', $data);
		$result = array("status" => 200, 'type' => 'success', "msg"=>"Data updated");
		echo json_encode($result);
	}

}
