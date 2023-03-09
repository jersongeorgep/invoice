<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customers extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Customers';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Customers List';
		$this->data['customers']	= $this->db->select('*')->from('pms_customers')->order_by('id', 'desc')->get()->result();
		$this->data['loadPage']	= "masters/customers/customer_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']	= 'New Customer';
		$this->data['entry_form']	= "masters/forms/new_customer_form";
		$this->data['loadPage']		= "masters/products/entry_form";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_customer(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('post_code', 'Pin Code', 'trim|required');
		$this->form_validation->set_rules('post_office', 'Post Office', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'New Customer';
			$this->data['entry_form']	= "masters/forms/new_customer_form";
			$this->data['loadPage']		= "masters/products/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Customer_m->array_from_post(array(
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
			$this->Customer_m->insert($data);
			add_notification('fa-save', "Customer saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/customers');
		}
	}

	public function update_customer($id){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('post_code', 'Pin Code', 'trim|required');
		$this->form_validation->set_rules('post_office', 'Post Office', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['customer'] = $this->Customer_m->get($id);
			$this->data['pageTitle']	= 'Edit Customer';
			$this->data['entry_form']	= "masters/forms/edit_customer_form";
			$this->data['loadPage']		= "masters/products/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Customer_m->array_from_post(array(
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
			$this->Customer_m->update($id, $data);
			add_notification('fa-pencil-alt', "Customer updated");
			$this->session->set_flashdata("success", "Data successfully updated");
			redirect('masters/customers');
		}
	}

	public function edit_customer($id){
		$this->data['customer'] = $this->Customer_m->get($id);
		$this->data['pageTitle']	= 'Edit Customer';
		$this->data['entry_form']	= "masters/forms/edit_customer_form";
		$this->data['loadPage']		= "masters/products/entry_form";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_customer(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Customer_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Customer deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
