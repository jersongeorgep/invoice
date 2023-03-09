<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Item extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Items';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Items List';
		$this->data['item']	= $this->db->order_by('id', 'desc')->get('item')->result();
		$this->data['loadPage']	= "masters/item/item_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']= 'New Item';
		$this->data['entry_form']	= "masters/forms/new_item_form";
		$this->data['loadPage']	= "masters/item/form_view";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_item(){
		$val = $this->input->post(NULL, true);
		$name = $val['name'];
		$amount = $val['amount'];
		for($i = 0; $i < count((array)$name); $i++){
			$data['name']	=	$name[$i];
			$data['amount']	=	$amount[$i];
			$this->Item_m->insert($data);
		}
		add_notification('fa-save', "Item saved");
		$this->session->set_flashdata("success", "Data successfully saved");
		redirect('masters/item');
	}

	public function update_item($id){
		$this->form_validation->set_rules('name', 'Item Name', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'Edit Item';
            $this->data['role'] 		= $this->Item_m->get($id);
            $this->data['entry_form']	= "masters/forms/edit_item_form";
            $this->data['loadPage']		= "masters/item/form_view";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Item_m->array_from_post(array(
				'name',
				'amount'
			));
			$this->Item_m->update($id, $data);
			add_notification('fa-pencil-alt', "Item updated");
			$this->session->set_flashdata("success", "Data successfully updated");
			redirect('masters/item');
		}
	}

	public function edit_item($id){
		$this->data['pageTitle']	= 'Edit Item';
		$this->data['item'] 		= $this->Item_m->get($id);
		$this->data['entry_form']	= "masters/forms/edit_item_form";
		$this->data['loadPage']		= "masters/item/form_view";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_item(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Item_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Item deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
		redirect('masters/item');
	}
	
}
