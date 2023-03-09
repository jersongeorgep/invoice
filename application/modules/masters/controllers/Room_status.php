<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Room_status extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Room Status';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Room Status List';
		$this->data['rooms_status']	= $this->db->order_by('id', 'desc')->get('lms_room_status')->result();
		$this->data['loadPage']	= "masters/room_status/room_status_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']= 'New Room Status';
		$this->data['entry_form']	= "masters/forms/new_room_status_form";
		$this->data['loadPage']	= "masters/room_status/form_view";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_room_status(){
		$this->form_validation->set_rules('room_status', 'Room Status', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']    = 'New Room Status';
            $this->data['entry_form']	= "masters/forms/new_room_status_form";
            $this->data['loadPage']	    = "masters/room_status/form_view";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Room_status_m->array_from_post(array(
				'room_status'
			));
			//$data['status'] = 1;
			//$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Room_status_m->insert($data);
			add_notification('fa-save', "Room status saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/room-status');
		}
	}

	public function update_room_status($id){
		$this->form_validation->set_rules('room_status', 'Room Status', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'Edit Room Status';
            $this->data['room_status'] 	= $this->Room_status_m->get($id);
            $this->data['entry_form']	= "masters/forms/edit_room_status_form";
            $this->data['loadPage']		= "masters/room_status/form_view";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Room_status_m->array_from_post(array(
				'room_status'
			));
			//$data['status'] = 1;
			//$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Room_status_m->update($id, $data);
			add_notification('fa-save', "Room status updated");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/room-status');
		}
	}

	public function edit_room_status($id){
		$this->data['pageTitle']	= 'Edit Room Status';
		$this->data['room_status'] 	= $this->Room_status_m->get($id);
		$this->data['entry_form']	= "masters/forms/edit_room_status_form";
		$this->data['loadPage']		= "masters/room_status/form_view";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_room_status(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Room_status_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Unit deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
