<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Income_expense_type extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Income & Expense Heads';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Heads List';
		$this->data['heads']	= $this->db->order_by('id', 'desc')->get('lms_income_expense_heads')->result();
		$this->data['loadPage']	= "masters/inc_exp_heads/inc_exp_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']	= 'New Head';
		$this->data['behaviors'] 	=	enum_select('lms_income_expense_heads', 'behavior');
		$this->data['txn_type'] 	=	enum_select('lms_income_expense_heads', 'txn_type');
		$this->data['entry_form']	= "masters/forms/new_inc_exp_form";
		$this->data['loadPage']		= "masters/inc_exp_heads/entry_form";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_inc_exp_head(){
		$this->form_validation->set_rules('heads', 'Head Name', 'trim|required');
		$this->form_validation->set_rules('behavior', 'Behavior', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	=	'New Head';
			$this->data['behaviors'] 	=	enum_select('lms_income_expense_heads', 'behavior');
			$this->data['txn_type'] 	=	enum_select('lms_income_expense_heads', 'txn_type');
			$this->data['entry_form']	=	'masters/forms/new_inc_exp_form';
			$this->data['loadPage']		=	'masters/inc_exp_heads/entry_form';
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Income_expense_heads_m->array_from_post(array(
				'heads',
				'behavior',
				'txn_type'
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Income_expense_heads_m->insert($data);
			add_notification('fa-save', "Income Expense head saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/income-expense-type');
		}
	}

	public function update_head($id){
		$this->form_validation->set_rules('heads', 'Head Name', 'trim|required');
		$this->form_validation->set_rules('behavior', 'Behavior', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['head'] 	= $this->Income_expense_heads_m->get($id);
			$this->data['pageTitle']	= 'Edit Head';
			$this->data['behaviors'] 	=	enum_select('lms_income_expense_heads', 'behavior');
			$this->data['txn_type'] 	=	enum_select('lms_income_expense_heads', 'txn_type');
			$this->data['entry_form']	= "masters/forms/edit_inc_exp_form";
			$this->data['loadPage']		= "masters/inc_exp_heads/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Income_expense_heads_m->array_from_post(array(
				'heads',
				'behavior',
				'txn_type'
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Income_expense_heads_m->update($id, $data);
			add_notification('fa-save', "Income Expense head updated");
			$this->session->set_flashdata("success", "Data successfully updated");
			redirect('masters/income-expense-type');
		}
	}

	public function edit_head($id){
		$this->data['head'] 	= $this->Income_expense_heads_m->get($id);
		$this->data['pageTitle']	= 'Edit Head';
		$this->data['behaviors'] 	=	enum_select('lms_income_expense_heads', 'behavior');
		$this->data['txn_type'] 	=	enum_select('lms_income_expense_heads', 'txn_type');
		$this->data['entry_form']	= "masters/forms/edit_inc_exp_form";
		$this->data['loadPage']		= "masters/inc_exp_heads/entry_form";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_heads(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Income_expense_heads_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Incom Expense Head deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
