<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Products';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Products List';
		$this->data['projects']	= $this->db->select('p.*, u.name as unit_name, c.category_name')->from('pms_products as p')->join('pms_categories as c', 'c.id = p.category_id', 'left')->join('pms_units as u', 'u.id=p.unit_id', 'left')->order_by('p.id', 'desc')->get()->result();
		$this->data['loadPage']	= "masters/products/products_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']= 'New Product';
		$this->data['categories']= $this->Category_m->get_all();
		$this->data['units']= $this->Units_m->get_all();
		$this->data['entry_form']	= "masters/forms/new_product_form";
		$this->data['loadPage']	= "masters/products/entry_form";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_product(){
		$this->form_validation->set_rules('products', 'Name', 'trim|required');
		$this->form_validation->set_rules('unit_id', 'Units', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']= 'New Product';
			$this->data['units']= $this->Units_m->get_all();
			$this->data['entry_form']	= "masters/forms/new_product_form";
			$this->data['loadPage']	= "masters/products/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Products_m->array_from_post(array(
				'products',
				'unit_id',
				'category_id'
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Products_m->insert($data);
			add_notification('fa-save', "Product saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/products');
		}
	}

	public function update_product($id){
		$this->form_validation->set_rules('products', 'Name', 'trim|required');
		$this->form_validation->set_rules('unit_id', 'Units', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']= 'New Product';
			$this->data['units']= $this->Units_m->get_all();
			$this->data['entry_form']	= "masters/forms/new_product_form";
			$this->data['loadPage']	= "masters/products/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Products_m->array_from_post(array(
				'products',
				'unit_id',
				'category_id'
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Products_m->update($id, $data);
			add_notification('fa-pencil-alt', "Product updated");
			$this->session->set_flashdata("success", "Data successfully updated");
			redirect('masters/products');
		}
	}

	public function edit_product($id){
		$this->data['pageTitle']	= 'Edit Product';
		$this->data['product'] 		= $this->Products_m->get($id);
		$this->data['categories']	= $this->Category_m->get_all();
		$this->data['units']		= $this->Units_m->get_all();
		$this->data['entry_form']	= "masters/forms/edit_product_form";
		$this->data['loadPage']		= "masters/products/entry_form";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_products(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Products_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Product deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
