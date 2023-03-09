<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Departments extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Departments';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Departments List';
		$this->data['departments']	= $this->db->order_by('id', 'desc')->get('lms_departments')->result();
		$this->data['loadPage']	= "masters/department/departments_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']	= 'New Department';
		$this->data['entry_form']	= "masters/forms/new_department_form";
		$this->data['loadPage']		= "masters/department/form_view";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_department(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'New Department';
			$this->data['entry_form']	= "masters/forms/new_department_form";
			$this->data['loadPage']		= "masters/department/form_view";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Departments_m->array_from_post(array(
				'name'
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Departments_m->insert($data);
			add_notification('fa-save', "Department saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/departments');
		}
	}

	public function update_department($id){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'Edit Department';
			$this->data['dept'] 		= $this->Departments_m->get($id);
			$this->data['entry_form']	= "masters/forms/edit_department_form";
			$this->data['loadPage']		= "masters/department/form_view";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Roles_m->array_from_post(array(
				'name'
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Departments_m->update($id, $data);
			add_notification('fa-pencil-alt', "Department updated");
			$this->session->set_flashdata("success", "Data successfully updated");
			redirect('masters/departments');
		}
	}

	public function edit_department($id){
		$this->data['pageTitle']	= 'Edit Department';
		$this->data['dept'] 		= $this->Departments_m->get($id);
		$this->data['entry_form']	= "masters/forms/edit_department_form";
		$this->data['loadPage']		= "masters/department/form_view";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_dept(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Departments_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Department deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
