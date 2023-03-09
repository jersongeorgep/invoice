<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tax_invoice extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Tax Invoice List';
		$this->data['menu'] = 'Invoices';
	}

	public function index(){
		$this->data['pageTitle']= 'Invoice List';
		$this->data['invoices']	= $this->db->order_by('id', 'desc')->get('invoices')->result();
		$this->data['loadPage']	= "receipts/invoices/invoice_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add(){
		$this->data['pageTitle']= 'New Invoice';
		$this->data['entry_form']= "receipts/forms/new_invoice_form";
		$this->data['loadPage']	= "receipts/invoices/form_view";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_size(){
		$this->form_validation->set_rules('size', 'Size', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']= 'New Size';
            $this->data['entry_form']	= "masters/forms/new_bed_size_form";
            $this->data['loadPage']	= "masters/bed_size/form_view";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Units_m->array_from_post(array(
				'size'
			));
			//$data['status'] = 1;
			//$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Bed_size_m->insert($data);
			add_notification('fa-save', "Size saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/bed_size');
		}
	}

	public function update_size($id){
		$this->form_validation->set_rules('size', 'Size', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'Edit Bed Size';
			$this->data['bed_size'] 	= $this->Bed_size_m->get($id);
			$this->data['entry_form']	= "masters/forms/edit_bed_size_form";
			$this->data['loadPage']		= "masters/bed_size/form_view";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Units_m->array_from_post(array(
				'size'
			));
			$this->Bed_size_m->update($id, $data);
			add_notification('fa-save', "Size updated");
			$this->session->set_flashdata("success", "Data successfully updated");
			redirect('masters/bed_size');
		}
	}

	public function edit_bed_size($id){
		$this->data['pageTitle']	= 'Edit Bed Size';
		$this->data['bed_size'] 	= $this->Bed_size_m->get($id);
		$this->data['entry_form']	= "masters/forms/edit_bed_size_form";
		$this->data['loadPage']		= "masters/bed_size/form_view";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_size(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Bed_size_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Unit deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
