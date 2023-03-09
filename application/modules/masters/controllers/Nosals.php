<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Nosals extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Nosals';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Nosals List';
		$this->data['nosals']	= $this->Nosals_m->nosals_list();
		$this->data['loadPage']	= "masters/nosals/nosals_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']	= 'New Nosal';
		$this->data['products']		= $this->Products_m->get_all();
		$this->data['entry_form']	= "masters/forms/new_nosal_form";
		$this->data['loadPage']		= "masters/products/entry_form";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_nosals(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('product_id', 'Products', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'New Nosal';
			$this->data['products']		= $this->Products_m->get_all();
			$this->data['entry_form']	= "masters/forms/new_nosal_form";
			$this->data['loadPage']		= "masters/products/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Vendors_m->array_from_post(array(
				'name',
				'product_id'
			));
			$this->Nosals_m->insert($data);
			add_notification('fa-save', "Nosal saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/nosals');
		}
	}

	public function update_nosal($id){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('product_id', 'Products', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'New Nosal';
			$this->data['products']		= $this->Products_m->get_all();
			$this->data['entry_form']	= "masters/forms/new_nosal_form";
			$this->data['loadPage']		= "masters/products/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Vendors_m->array_from_post(array(
				'name',
				'product_id'
			));
			$this->Nosals_m->update($id, $data);
			add_notification('fa-save', "Nosal saved");
			$this->session->set_flashdata("success", "Data successfully updated");
			redirect('masters/nosals');
		}
		
	}

	public function edit_nosal($id){
		$this->data['pageTitle']	= 'Edit Nosal';
		$this->data['nosal']		= $this->Nosals_m->get($id);
		$this->data['products']		= $this->Products_m->get_all();
		$this->data['entry_form']	= "masters/forms/edit_nosal_form";
		$this->data['loadPage']		= "masters/products/entry_form";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_nosal(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Nosals_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Vendors deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
