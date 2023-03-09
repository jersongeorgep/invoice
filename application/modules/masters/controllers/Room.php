<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Room extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Rooms';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle'] = 'Rooms List';
		$this->db->select('r.*, bs.size as bed_size, b.branch_name,s.room_status,bg.salute, bg.first_name, bg.last_name')->from('lms_room as r');
		if($this->session->userdata('branch_id') != 1){
			//$this->db->where('e.branch', $this->session->userdata('branch_id'));
			$this->db->where('r.branch_id', $this->session->userdata('branch_id'));
		}
		$this->db->join('lms_bed_size as bs', 'bs.id = r.bed_size', 'left')
		->join('lms_branches as b', 'b.id = r.branch_id', 'left')
		->join('lms_room_status as s', 's.id = r.room_status', 'left')
		->join('lms_booking_guests as bg', 'bg.id = r.assigned_to', 'left');
		$this->data['rooms'] = $this->db->order_by('r.id', 'desc')->get()->result();
		//$this->data['rooms'] = $this->db->select('r.*, bs.size as bed_size, b.branch_name,s.room_status,bg.salute, bg.first_name, bg.last_name')->from('lms_room as r')->join('lms_bed_size as bs', 'bs.id = r.bed_size', 'left')->join('lms_branches as b', 'b.id = r.branch_id', 'left')->join('lms_room_status as s', 's.id = r.room_status', 'left')->join('lms_booking_guests as bg', 'bg.id = r.assigned_to', 'left')->order_by('r.id', 'desc')->get()->result();
		$this->data['loadPage']	 = "masters/room/room_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']	= 'New Room';
		$this->data['room_status']	= $this->Room_status_m->get_all();
		$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
		$this->data['sizes']		= $this->Bed_size_m->get_all();
		$this->data['floors']		= enum_select('lms_room', 'floor_no');
		$this->data['type']			= enum_select('lms_room', 'type');
		$this->data['entry_form']	= "masters/forms/new_room_form";
		$this->data['loadPage']		= "masters/room/entry_form";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_room(){
		$this->form_validation->set_rules('room_no', 'Name', 'trim|required');
		$this->form_validation->set_rules('floor_no', 'Floor Number', 'trim|required');
		$this->form_validation->set_rules('bathrooms_count', 'No.of Bathrooms', 'trim|required');
		$this->form_validation->set_rules('room_status', 'Room Status', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required');
		$this->form_validation->set_rules('bed_size', 'Bed Size', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'New Room';
			$this->data['room_status']	= $this->Room_status_m->get_all();
			$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
			$this->data['sizes']		= $this->Bed_size_m->get_all();
			$this->data['type']			= enum_select('lms_room', 'type');
			$this->data['entry_form']	= "masters/forms/new_room_form";
			$this->data['loadPage']		= "masters/room/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Employees_m->array_from_post(array(
				'room_no',
				'floor_no',
				'bathrooms_count',
				'room_status',
				'type',
				'bed_size',
				'branch_id',
				'price',
				'extra_bed_price'
			));
			$data['status'] = 1;
			//$data['dob'] = date('Y-m-d', strtotime($data['dob']));
			$data['updated_on'] = date('Y-m-d H:i:s');
			$check = $this->db->select('*')->from('lms_room')->where('room_no', $data['room_no'])->where('branch_id', $data['branch_id'])->get()->result();
			if(!empty($check)){
				$this->session->set_flashdata("danger", "The room number already in database");
				redirect('masters/room');
			}else{
				$this->Room_m->insert($data);
				add_notification('fa-save', "Room saved");
				$this->session->set_flashdata("success", "Data successfully saved");
				redirect('masters/room');
			}
		}
	}

	public function update_room($id){
		$this->form_validation->set_rules('room_no', 'Name', 'trim|required');
		$this->form_validation->set_rules('floor_no', 'Floor Number', 'trim|required');
		$this->form_validation->set_rules('bathrooms_count', 'No.of Bathrooms', 'trim|required');
		$this->form_validation->set_rules('room_status', 'Room Status', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required');
		$this->form_validation->set_rules('bed_size', 'Bed Size', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'Edit Room';
			$this->data['room'] 		= $this->Room_m->get($id);
			$this->data['room_status']	= $this->Room_status_m->get_all();
			$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
			$this->data['sizes']		= $this->Bed_size_m->get_all();
			$this->data['type']	= enum_select('lms_room', 'type');
			$this->data['entry_form']	= "masters/forms/edit_room_form";
			$this->data['loadPage']		= "masters/room/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Room_m->array_from_post(array(
				'room_no',
				'bathrooms_count',
				'bed_size',
				'branch_id',
				'room_status',
				'floor_no',
				'type',
				'price',
				'extra_bed_price'
			));
			$data['status'] = 1;
			$data['updated_on'] = date('Y-m-d H:i:s');
			$this->Room_m->update($id, $data);
			add_notification('fa-save', "Room updated");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/room');
		}
	}

	public function edit_room($id){
		$this->data['pageTitle']	= 'Edit Room';
		$this->data['room'] 		= $this->Room_m->get($id);
		$this->data['room_status']	= $this->Room_status_m->get_all();
		$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
		$this->data['sizes']		= $this->Bed_size_m->get_all();
		$this->data['floors']		= enum_select('lms_room', 'floor_no');
		$this->data['type']			= enum_select('lms_room', 'type');
		$this->data['entry_form']	= "masters/forms/edit_room_form";
		$this->data['loadPage']		= "masters/room/entry_form";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_room(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Room_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Room deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
		redirect('masters/room');
	}
	
}
