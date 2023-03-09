<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shifts extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Shifts';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Shifts List';
		$this->data['shifts']	= $this->db->order_by('shift_id', 'desc')->get('pms_shifts')->result();
		$this->data['loadPage']	= "masters/shifts/shifts_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']	= 'New Shift';
		$this->data['entry_form']	= "masters/forms/new_shift_form";
		$this->data['loadPage']		= "masters/shifts/entry_form";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_shift(){
		$this->form_validation->set_rules('title', 'Shift Title', 'trim|required');
		if($this->form_validation->run()==FALSE){
            $this->data['pageTitle']	= 'New Shift';
            $this->data['entry_form']	= "masters/forms/new_shift_form";
            $this->data['loadPage']		= "masters/shifts/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Shifts_m->array_from_post(array(
				'title',
                'start_time',
                'end_time'
			));
			$this->Shifts_m->insert($data);
			add_notification('fa-save', "Shifts saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/shifts');
		}
	}

	public function update_shift($id){
		$this->form_validation->set_rules('title', 'Shift Title', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['shift']        = $this->Shifts_m->get($id);
            $this->data['pageTitle']	= 'Edit Shift';
            $this->data['entry_form']	= "masters/forms/edit_shift_form";
            $this->data['loadPage']		= "masters/shifts/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Shifts_m->array_from_post(array(
				'title',
                'start_time',
                'end_time'
			));
			$this->Shifts_m->update($id, $data);
			add_notification('fa-save', "Shifts saved");
			$this->session->set_flashdata("success", "Data successfully shifts");
			redirect('masters/shifts');
		}
	}

	public function edit_shift($id){
		$this->data['shift']        = $this->Shifts_m->get($id);
		$this->data['pageTitle']	= 'Edit Shift';
		$this->data['entry_form']	= "masters/forms/edit_shift_form";
		$this->data['loadPage']		= "masters/shifts/entry_form";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_shifts(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Shifts_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Shift deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
