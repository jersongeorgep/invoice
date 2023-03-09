<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laundries extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['pageHeading'] = 'Laundries';
		$this->data['menu'] = 'Masters';
	}

	public function index(){
		$this->data['pageTitle']= 'Laundries List';
		$this->data['laundries']	= $this->db->select('*')->from('lms_laundary_shops')->order_by('id', 'desc')->get()->result();
		$this->data['loadPage']	= "masters/laundries/laundries_lists";
		$this->layouts->admin_layouts($this->data);
	}

	public function add_new(){
		$this->data['pageTitle']	= 'New Laundry';
		if($this->session->userdata('branch_id') == 1){
			$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
		}else{
			$this->data['branches']		= $this->db->where('id',$this->session->userdata('branch_id'))->get('lms_branches')->result();
		}
		$this->data['entry_form']	= "masters/forms/new_laundry_shop_form";
		$this->data['loadPage']		= "masters/laundries/entry_form";
		$this->layouts->admin_layouts($this->data);
	}

	public function save_laundry(){
		$this->form_validation->set_rules('laundry_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['pageTitle']	= 'New Laundry';
			if($this->session->userdata('branch_id') == 1){
				$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
			}else{
				$this->data['branches']		= $this->db->where('id',$this->session->userdata('branch_id'))->get('lms_branches')->result();
			}
			$this->data['entry_form']	= "masters/forms/new_laundry_shop_form";
			$this->data['loadPage']		= "masters/laundries/entry_form";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Laundries_m->array_from_post(array(
				'branch_id',
				'laundry_name',
				'address',
				'pin_code',
				'post_office',
				'district',
				'state',
				'country',
				'mobile',
				'email',
				'contact_person',
				'owner_name',
				'gst_number',
				'opening_balance',
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Laundries_m->insert($data);
			add_notification('fa-save', "Laundry saved");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/laundries');
		}
	}

	public function update_laundry($id){
		$this->form_validation->set_rules('laundry_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->data['laundry'] 		= $this->Laundries_m->get($id);
			if($this->session->userdata('branch_id') == 1){
				$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
			}else{
				$this->data['branches']		= $this->db->where('id',$this->session->userdata('branch_id'))->get('lms_branches')->result();
			}
			$this->data['pageTitle']	= 'Edit Laundry';
			$this->data['entry_form']	= "masters/forms/edit_laundry_shop_form";
			$this->data['loadPage']		= "masters/laundries/entry_form";
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Laundries_m->array_from_post(array(
				'branch_id',
				'laundry_name',
				'address',
				'pin_code',
				'post_office',
				'district',
				'state',
				'country',
				'mobile',
				'email',
				'contact_person',
				'owner_name',
				'gst_number',
				'opening_balance',
			));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->Laundries_m->update($id, $data);
			add_notification('fa-save', "Laundry updated");
			$this->session->set_flashdata("success", "Data successfully saved");
			redirect('masters/laundries');
		}
	}

	public function edit_laundry($id){
		$this->data['laundry'] 		= $this->Laundries_m->get($id);
		if($this->session->userdata('branch_id') == 1){
			$this->data['branches']		= $this->db->where('status', 1)->get('lms_branches')->result();
		}else{
			$this->data['branches']		= $this->db->where('id',$this->session->userdata('branch_id'))->get('lms_branches')->result();
		}
		$this->data['pageTitle']	= 'Edit Laundry';
		$this->data['entry_form']	= "masters/forms/edit_laundry_shop_form";
		$this->data['loadPage']		= "masters/laundries/entry_form";
		$this->layouts->admin_layouts($this->data);
	}
	
	public function delete_laundry(){
		$ids = $this->input->post('ids');
		for($i=0; $i < count((array)$ids); $i++){
			$this->Laundries_m->delete($ids[$i]);
		}
		add_notification('fa-trash', "Laundry deleted");
		$response = array('status'=>200, 'msg'=>'Data deleted');
		echo json_encode($response);
	}
	
}
