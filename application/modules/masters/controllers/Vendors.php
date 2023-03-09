<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vendors extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Vendors';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Vendors List';
		$this->data['vendors']	= $this->db->select('*')->from('pms_vendors')->order_by('id', 'desc')->get()->result();
		$this->data['loadPage']	= "masters/vendors/vendors_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']	= 'New Vendor';
		$this->data['entry_form']	= "masters/forms/new_vendor_form";
		$this->data['loadPage']		= "masters/products/entry_form";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_vendor(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('post_code', 'Pin Code', 'trim|required');
		$this->form_validation->set_rules('post_office', 'Post Office', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']= 'New Vendor';
			$this->data['entry_form']	= "masters/forms/new_vendor_form";
			$this->data['loadPage']	= "masters/products/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Vendors_m->array_from_post(array(
				'name',
				'address',
				'post_code',
				'post_office',
				'district',
				'state',
				'country',
				'mobile',
				'email',
				'contact_person',
				'owner',
				'gst_no',
				'opening_balance',
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Vendors_m->insert($data);
			add_notification('fa-save', "Vendor saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/vendors');
		}
	}

	public function update_vendor($id){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('post_code', 'Pin Code', 'trim|required');
		$this->form_validation->set_rules('post_office', 'Post Office', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']= 'New Vendor';
			$this->data['entry_form']	= "masters/forms/new_vendor_form";
			$this->data['loadPage']	= "masters/products/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Vendors_m->array_from_post(array(
				'name',
				'address',
				'post_code',
				'post_office',
				'district',
				'state',
				'country',
				'mobile',
				'email',
				'contact_person',
				'owner',
				'gst_no',
				'opening_balance',
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Vendors_m->update($id, $data);
			add_notification('fa-pencil-alt', "Vendor updated");
			$this->session->set_flashdata("success", "Data successfully updated");
			redirect('masters/vendors');
		}
	}

	public function edit_vendor($id){
		$this->data['vendor'] = $this->Vendors_m->get($id);
		$this->data['pageTitle']	= 'Edit Vendor';
		$this->data['entry_form']	= "masters/forms/edit_vendor_form";
		$this->data['loadPage']		= "masters/products/entry_form";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_vendor(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Vendors_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Vendors deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
