<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Roles extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Roles';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Roles List';
		$this->data['roles']	= $this->db->order_by('id', 'desc')->get('lms_user_roles')->result();
		$this->data['loadPage']	= "masters/roles/roles_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']= 'New Role';
		$this->data['entry_form']	= "masters/forms/new_role_form";
		$this->data['loadPage']	= "masters/roles/form_view";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_role(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']= 'New Role';
            $this->data['entry_form']	= "masters/forms/new_role_form";
            $this->data['loadPage']	= "masters/roles/form_view";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Roles_m->array_from_post(array(
				'name'
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Roles_m->insert($data);
			add_notification('fa-save', "Unit saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/roles');
		}
	}

	public function update_role($id){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'Edit Role';
            $this->data['role'] 		= $this->Roles_m->get($id);
            $this->data['entry_form']	= "masters/forms/edit_role_form";
            $this->data['loadPage']		= "masters/roles/form_view";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Roles_m->array_from_post(array(
				'name'
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Roles_m->update($id, $data);
			add_notification('fa-pencil-alt', "Unit updated");
			$this->session->set_flashdata("success", "Data successfully updated");
			redirect('masters/roles');
		}
	}

	public function edit_role($id){
		$this->data['pageTitle']	= 'Edit Role';
		$this->data['role'] 		= $this->Roles_m->get($id);
		$this->data['entry_form']	= "masters/forms/edit_role_form";
		$this->data['loadPage']		= "masters/roles/form_view";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_role(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Roles_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Unit deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
