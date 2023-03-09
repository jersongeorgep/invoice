<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Units extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Units';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Units List';
		$this->data['units']	= $this->db->order_by('id', 'desc')->get('pms_units')->result();
		$this->data['loadPage']	= "masters/units/units_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']= 'New Unit';
		$this->data['entry_form']	= "masters/forms/new_unit_form";
		$this->data['loadPage']	= "masters/units/new_unit";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_unit(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'New Unit';
			$this->data['entry_form']	= "masters/forms/new_unit_form";
			$this->data['loadPage']		= "masters/units/new_unit";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Units_m->array_from_post(array(
				'name',
				'short_name',
				'description'
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Units_m->insert($data);
			add_notification('fa-save', "Unit saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/units');
		}
	}

	public function update_unit($id){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('short_name', 'Short Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'New Unit';
			$this->data['entry_form']	= "masters/forms/new_unit_form";
			$this->data['loadPage']		= "masters/units/new_unit";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Units_m->array_from_post(array(
				'name',
				'short_name',
				'description'
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Units_m->update($id, $data);
			add_notification('fa-pencil-alt', "Unit updated");
			$this->session->set_flashdata("success", "Data successfully updated");
			redirect('masters/units');
		}
	}

	public function edit_unit($id){
		$this->data['pageTitle']	= 'Edit Unit';
		$this->data['unit'] 		= $this->Units_m->get($id);
		$this->data['entry_form']	= "masters/forms/edit_unit_form";
		$this->data['loadPage']		= "masters/units/new_unit";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_units(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Units_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Unit deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
