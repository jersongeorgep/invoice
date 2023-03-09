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

	public function save(){
		$this->form_validation->set_rules('ref_no', 'Bill No.', 'trim|required');
		$this->form_validation->set_rules('invoice_date', 'Invoice Date', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');

		if($this->form_validation->run() == FALSE){
			$this->data['pageTitle']= 'New Invoice';
			$this->data['entry_form']= "receipts/forms/new_invoice_form";
			$this->data['loadPage']	= "receipts/invoices/form_view";
			$this->session->set_flashdata("danger", validation_errors());
			$this->layouts->admin_layouts($this->data);
		}else{
			$data = $this->Invoice_m->array_from_post(array(
				'ref_no',
				'mobile',
				'invoice_date',
				'customer_name',
				'grand_total',
				'total_value',
				'dis_amount',
				'tax_total_value'
			));
			$data['invoice_date'] = date('Y-m-d', strtotime($data['invoice_date']));
			$data['status'] = 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$invoiceId = $this->Invoice_m->insert($data);

			$products	= $this->input->post('products');
			$unit		= $this->input->post('units');
			$item_qty	= $this->input->post('qty');
			$item_rate	= $this->input->post('rate');
			$item_total	= $this->input->post('total');
			$tax_percentage	= $this->input->post('tax_amt');
			$sub_total	= $this->input->post('amount');
			
			for($i=0; $i < count((array)$products); $i++){
				$data1['invoice_id']	=	$invoiceId;
				$data1['products']		=	$products[$i];
				$data1['unit']			=	$unit[$i];
				$data1['item_qty']		=	$item_qty[$i];
				$data1['item_rate']		=	$item_rate[$i];
				$data1['item_total']	=	$item_total[$i];
				$data1['tax_percentage'] =	$tax_percentage[$i];
				$data1['sub_total']		=	$sub_total[$i];
				$data1['status']		=	1;
				$data1['updated_at'] 	= date('Y-m-d H:i:s');
				$this->Invoice_line_items_m->insert($data1);
			}
			$this->session->set_flashdata("success", "Data saved successfully");
			redirect('receipts/tax-invoice');
		}
	}

	public function print($id){
		$this->data['pageTitle']= 'Print Invoice';
		$this->data['invoice'] = $this->db->select('i.*')->from('invoices as i')->where('i.id', $id)->get()->row();
		$this->data['invoice_line'] = $this->db->select('il.*')->from('invoice_line_items as il')->where('il.invoice_id', $id)->get()->result();
		//$this->data['loadPage']	= "receipts/invoices/view_invoice";
		//$this->layouts->admin_layouts($this->data);
		$this->load->view('receipts/invoices/view_invoice', $this->data);
	}
	
}
