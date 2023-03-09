<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Categories extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Categories';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Categories List';
		$this->data['categories']	= $this->db->order_by('id', 'desc')->get('pms_categories')->result();
		$this->data['loadPage']	= "masters/categories/categories_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']	= 'New Category';
		$this->data['entry_form']	= "masters/forms/new_category_form";
		$this->data['loadPage']		= "masters/categories/entry_form";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_category(){
		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'New Category';
			$this->data['entry_form']	= "masters/forms/new_category_form";
			$this->data['loadPage']		= "masters/categories/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Category_m->array_from_post(array(
				'category_name'
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Category_m->insert($data);
			add_notification('fa-save', "Category saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/categories');
		}
	}

	public function update_category($id){
		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['category'] 	= $this->Category_m->get($id);
			$this->data['pageTitle']	= 'Edit Category';
			$this->data['entry_form']	= "masters/forms/edit_category_form";
			$this->data['loadPage']		= "masters/categories/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Category_m->array_from_post(array(
				'category_name'
			));
			$data['status'] 	= 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Category_m->update($id, $data);
			add_notification('fa-pencil-alt', "Category updated");
			$this->session->set_flashdata("success", "Data successfully updated");
			redirect('masters/categories');
		}
	}

	public function edit_category($id){
		$this->data['category'] 	= $this->Category_m->get($id);
		$this->data['pageTitle']	= 'Edit Category';
		$this->data['entry_form']	= "masters/forms/edit_category_form";
		$this->data['loadPage']		= "masters/categories/entry_form";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_categories(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Category_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Categories deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
