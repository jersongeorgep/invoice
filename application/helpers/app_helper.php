<?php 
if(! function_exists('get_company_logo')){
	function get_company_logo(){
		$CI =& get_instance();
		$html = "";
		$company_id = $CI->session->userdata('company_id');
		$company = $CI->Company_m->get($company_id);
		if(!empty($company->company_logo)){
			$html .= '<img src="'.site_url('assets/uploads/'.$company->company_logo).'" alt="'.$company->name.'" class="brand-image img-circle elevation-3" style="opacity: .8">';
			$html .= '<span class="brand-text font-weight-light">'.short_str($company->name).'</span>';
		}else{
			//$html .= '<img src="'.site_url('assets/uploads/'.$company->company_logo).'" alt="'.$company->name.'" class="brand-image img-circle elevation-3" style="opacity: .8">';
			$html .= '<span class="brand-text font-weight-light">'.short_str($company->name).'</span>';
		}
		return $html;
	}
}

if(! function_exists('short_str')){
	function short_str($str){
		if(preg_match_all('/\b(\w)/',strtoupper($str),$m)) {
			$v = implode('',$m[1]);
		}
		return $v;
	}
}

if(! function_exists('get_single_data')){
function get_single_data($model, $feild, $id){
	$CI =& get_instance();
	$data = $CI ->$model->get($id);
	if($data){
		$rslt = $data->$feild;
	}else{
		$rslt = "";
	}
	return($rslt);
}
}

if(! function_exists('auto_num')){
	function auto_num($prefix,$table, $numFeild, $startNum=null){
		$ci =& get_instance();
		$num = "";
		$lastRow = $ci->db->select('*')->limit(1)->order_by('id', 'DESC')->get($table)->row_array();
		if($lastRow){
			$currentNumber = $lastRow[$numFeild];
			$splitNumber = explode('_', $currentNumber);
			$getNewNum =  $splitNumber[1] + 1;
			$num = $prefix.$getNewNum;
		}else{
			$startNum = ($startNum)?$startNum : 0;
			$num = $prefix.$startNum;
		}
		return $num;
	}
}

if(! function_exists('enum_select')){
	function enum_select( $table , $field){
		$CI =& get_instance();
		$query = " SHOW COLUMNS FROM `$table` LIKE '$field' ";
		$row = $CI->db->query(" SHOW COLUMNS FROM `$table` LIKE '$field' ")->row()->Type;
		$regex = "/'(.*?)'/";
		preg_match_all( $regex , $row, $enum_array );
		$enum_fields = $enum_array[1];
		return( $enum_fields );
	}
}

if(! function_exists('get_branch')){
	function get_branch($field = null){
		$CI =& get_instance();
		$branch_id	= $CI->session->userdata('branch_id');
		$data = $CI->db->select('*')->from('lms_branches')->where('id',$branch_id)->get()->row();
		if($field){
			return $data->$field;
		}else{
			return $data;
		}
	}
}

if(! function_exists('get_user_name')){
	function get_user_name($id){
		$CI =& get_instance();
		$user = $CI->db->select('fullname')->from('pms_admin_users')->where('id',$id)->get()->row();
		return $user->fullname;
	}
}

if(! function_exists('get_company_name')){
	function get_company_name($id){
		$CI =& get_instance();
		$user = $CI->db->select('name')->from('pms_company')->where('id',$id)->get()->row();
		return $user->name;
	}
}

if(! function_exists('get_current_price')){
	function get_current_price($product_id, $day = null){
		if($day){
			$price_date =  date('Y-m-d', strtotime("-".$day." days"));
		}else{
			$price_date =  date('Y-m-d');
		}
		$CI =& get_instance();
		$price = $CI->db->select('selling_price')->from('pms_update_price')->where('product_id',$product_id)->where('price_updated_date', $price_date)->get()->row();
		$selling_price = ((isset($price->selling_price))?$price->selling_price :0);
		return $selling_price;
	}
}

if(! function_exists('check_price_updated')){
	function check_price_updated(){
		$price_date =  date('Y-m-d');
		$CI =& get_instance();
		$price = $CI->db->select('selling_price')->from('pms_update_price')->where('price_updated_date', $price_date)->get()->row();
		if($price){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
}

if(! function_exists('customer_balance')){
	function customer_balance($id){
		$CI =& get_instance();
		$sales = $CI->db->select('SUM(total_sales) as total_sales')->from('pms_sales')->where('customer_id',$id)->get()->row();
		$receipts = $CI->db->select('SUM(receipt_amount) as total_receipts')->from('pms_receipts')->where('customer_id',$id)->get()->row();
		$balance = ($sales->total_sales) -  ($receipts->total_receipts);
		return $balance;
	}
}

if(! function_exists('last_received_qty')){
	function last_received_qty($product_id, $purchaseId = null, $fromDt =null, $toDt = null){
		$CI =& get_instance();
		$CI->db->select('ROUND(SUM(qty),2) as total_qty')->from('pms_stock_inventory')->where('product_id',$product_id);
		if($purchaseId){
			$CI->db->where('purchase_id',$purchaseId);
		}
		if($fromDt){
			$CI->db->where('inventory_date >=',$fromDt);
		}
		if($toDt){
			$CI->db->where('inventory_date<=',$toDt);
		}
		$stock = $CI->db->get()->row();
		$stock_received = (($stock->total_qty) ? $stock->total_qty : 0);
		return $stock_received;
	}
}

if(! function_exists('sold_qty')){
	function sold_qty($product_id, $fromDt =null, $toDt = null){
		$CI =& get_instance();
		$CI->db->select('ROUND(SUM(item_qty),2) as total_sold')->from('pms_sales_line_item')->where('product_id',$product_id);
		if($fromDt){
			$CI->db->where('DATE(created_at)>=',$fromDt);
		}
		if($toDt){
			$CI->db->where('DATE(created_at)<=',$toDt);
		}
		$sold = $CI->db->get()->row();
		$nozzleIds = [];
		$nozzles = $CI->db->select('nosal_id')->where('product_id', $product_id)->get('pms_nosals')->result();
		foreach($nozzles as $value){
			array_push($nozzleIds, $value->nosal_id);
		}
		if(!empty($nozzleIds)){
			$newsaleQty = $CI->db->select('SUM(sale) as total_new_sale')->where_in('nosal_id', $nozzleIds)->get('pms_daily_collection')->row();
			$total_new_sale_qty = $newsaleQty ->total_new_sale;
		}else{
			$total_new_sale_qty = 0;
		}
		$sold_qty = (($sold->total_sold) ? $sold->total_sold : 0) + $total_new_sale_qty ;
		//echo print_r($nozzles);
		return $sold_qty;
	}
}



if(! function_exists('available_stock')){
	function available_stock($product_id, $fromDt =null, $toDt = null){
		$CI =& get_instance();
		$received_stock = last_received_qty($product_id, $fromDt =null, $toDt = null);
		$sold_stock = sold_qty($product_id, $fromDt =null, $toDt = null);
		$available_stock = $received_stock - $sold_stock;
		return $available_stock;
	}
}

if(! function_exists('get_current_test_value')){
	function get_current_test_value($product_id, $field,  $fromDt =null, $toDt = null){
		$CI =& get_instance();
		$currentDate = date('Y-m-d');
		$CI->db->select('SUM('.$field.') as total')->from('pms_test_sale')->where('product_id',$product_id);
		if($fromDt){
			$CI->db->where('test_date >=', $fromDt);
		}else{
			$CI->db->where('test_date >=', $currentDate);
		}
		if($toDt){
			$CI->db->where('test_date <=', $toDt);
		}else{
			$CI->db->where('test_date >=', $currentDate);
		}
		$testValue = $CI->db->get()->row();
		$current_value = ((isset($testValue->total))?$testValue->total :0);
		return $current_value;
	}
}

if(! function_exists('get_total_sales')){
	function get_total_sales($type, $customer = null, $fromDt =null, $toDt = null){
		$CI =& get_instance();
		$CI->db->select('SUM(total_sales) as totalSales')->from('pms_sales');
		if($type != 'all'){
			$CI->db->where('sales_type',$type);
		}
		if($customer){
			$CI->db->where('customer_id',$customer);
		}
		if($fromDt){
			$CI->db->where('sale_date >=', $fromDt);
		}
		if($toDt){
			$CI->db->where('sale_date <=', $toDt);
		}
		$sales = $CI->db->get()->row();
		$salesValue = ((isset($sales->totalSales)) ? $sales->totalSales :0 );
		$newSales = get_total_sales_new();
		
		$total_sale = ($salesValue + $newSales);
		return $total_sale;
	}
}

if(! function_exists('get_total_sales_new')){
	function get_total_sales_new($fromDt =null, $toDt = null){
		$CI =& get_instance();
		$CI->db->select('SUM(fuel_total) as totalNewSales')->from('pms_daily_collection');
		if($fromDt){
			$CI->db->where('entry_date >=', $fromDt);
		}
		if($toDt){
			$CI->db->where('entry_date <=', $toDt);
		}
		$newSales = $CI->db->get()->row();
		$salesNewValue = ((isset($newSales->totalNewSales)) ? $newSales->totalNewSales :0 );
		
		
		$total_new_sale = $salesNewValue;
		return $total_new_sale;
	}
}

if(! function_exists('get_total_purchase')){
	function get_total_purchase($vendor=null, $fromDt =null, $toDt = null){
		$CI =& get_instance();
		$CI->db->select('SUM(total_amount) as totalPurchase')->from('pms_purchases');
		if($vendor){
			$CI->db->where('vendo_id', $vendor);
		}
		if($fromDt){
			$CI->db->where('purchase_date >=', $fromDt);
		}
		if($toDt){
			$CI->db->where('purchase_date <=', $toDt);
		}
		$purchase = $CI->db->get()->row();
		$total_purchase = ((isset($purchase->totalPurchase)) ? $purchase->totalPurchase :0 );
		return $total_purchase;
	}
}


/* if(! function_exists('cash_in_hand_total')){
	function cash_in_hand_total($fromDt =null, $toDt = null){
		$CI =& get_instance();
		$openingBalance = $CI->db->select('cash_in_hand')->from('pms_opening_balance')->where('id', 1)->get()->row();
		$sales = $CI->db->select('SUM(total_sales) as total_cash_sales')->from('pms_sales')->where('sales_type', 'cash')->get()->row();
		$cashSale = $CI->db->select('SUM(total) as total_cash')->from('pms_denomination')->get()->row();
		$incomeCash = $CI->db->select('SUM(amount) as total_cash_income')->from('pms_daily_income_expense as ie')->join('pms_income_expense_heads as ieh', 'ieh.id = ie.head_id')->where('ieh.behavior', 'income')->where('ieh.txn_type', 'cash')->get()->row();

		$payments = $CI->db->select('SUM(paid_amount) as total_cash_payments')->from('pms_payments')->where('mode_of_txn', 'cash')->get()->row();
		$cashToBank = $CI->db->select('SUM(amount) as total_cash_to_bank')->from('pms_cash_to_bank')->get()->row();
		$expenseCash = $CI->db->select('SUM(amount) as total_cash_expense')->from('pms_daily_income_expense as ie')->join('pms_income_expense_heads as ieh', 'ieh.id = ie.head_id')->where('ieh.behavior', 'expense')->where('ieh.txn_type', 'cash')->get()->row();

		$cash = (($openingBalance->cash_in_hand + $sales->total_cash_sales + $cashSale->total_cash+$incomeCash->total_cash_income) - ($payments->total_cash_payments + $cashToBank->total_cash_to_bank + $expenseCash->total_cash_expense));
		return round($cash,2);
	}
} */

/* if(! function_exists('cash_at_bank_total')){
	function cash_at_bank_total($fromDt =null, $toDt = null){
		$CI =& get_instance();
		$openingBalance = $CI->db->select('cash_at_bank')->from('pms_opening_balance')->where('id', 1)->get()->row();
		$sales = $CI->db->select('SUM(total_sales) as total_bank_sales')->from('pms_sales')->where_not_in('sales_type', 'cash')->get()->row();
		$cashToBank = $CI->db->select('SUM(amount) as total_cash_to_bank')->from('pms_cash_to_bank')->get()->row();
		$incomeBank = $CI->db->select('SUM(amount) as total_bank_income')->from('pms_daily_income_expense as ie')->join('pms_income_expense_heads as ieh', 'ieh.id = ie.head_id')->where('ieh.behavior', 'income')->where('ieh.txn_type', 'bank')->get()->row();

		$payments = $CI->db->select('SUM(paid_amount) as total_bank_payments')->from('pms_payments')->where_not_in('mode_of_txn', 'cash')->get()->row();
		$expenseBank = $CI->db->select('SUM(amount) as total_bank_expense')->from('pms_daily_income_expense as ie')->join('pms_income_expense_heads as ieh', 'ieh.id = ie.head_id')->where('ieh.behavior', 'expense')->where('ieh.txn_type', 'bank')->get()->row();

		$bank = (($openingBalance->cash_at_bank +  $sales->total_bank_sales + $cashToBank->total_cash_to_bank + $incomeBank->total_bank_income) - ($payments->total_bank_payments + $expenseBank->total_bank_expense));
		return round($bank, 2);
	}
} */

if(! function_exists('get_total_receipts')){
	function get_total_receipts($txn_mode, $fromDt =null, $toDt = null, $customer = null){
		$CI =& get_instance();
		$CI->db->select('SUM(receipt_amount) as totalReceipts')->from('pms_receipts');
		if($txn_mode != 'all'){
			$CI->db->where('mode_of_txn', $txn_mode);
		}
		if($customer){
			$CI->db->where('customer_id', $customer);
		}
		if($fromDt){
			$CI->db->where('receipts_date >=', $fromDt);
		}
		if($toDt){
			$CI->db->where('receipts_date <=', $toDt);
		}
		$rec = $CI->db->get()->row();
		
		return $rec->totalReceipts;
	}
}

if(! function_exists('get_total_payments')){
	function get_total_payments($txn_mode, $vendor = null, $fromDt =null, $toDt = null){
		$CI =& get_instance();
		$CI->db->select('SUM(paid_amount) as totalPayments')->from('pms_payments');
		if($txn_mode != 'all'){
			$CI->db->where('mode_of_txn', $txn_mode);
		}
		if($vendor){
			$CI->db->where('vendor_id', $vendor);
		}
		if($fromDt){
			$CI->db->where('payments_date >=', $fromDt);
		}

		if($toDt){
			$CI->db->where('payments_date <=', $toDt);
		}
		$pay = $CI->db->get()->row();
		
		return $pay->totalPayments;
	}
}

if(! function_exists('month_label')){
	function month_label($num){
		$mon_labal = [];
		for($i =0; $i < $num; $i++){
			$label = date('M', strtotime('-'.$i.'months'));
			array_push($mon_labal, strtoupper($label));
		}
		return $mon_labal;
	}
}

if(! function_exists('receipts_months')){
	function receipts_months($num){
		$receiptsData = [];
		for($i =0; $i < $num; $i++){
			$fromDt = date('Y-m-01', strtotime('-'.$i.'months'));
			$toDate = date('Y-m-t', strtotime('-'.$i.'months'));
			$receipts = round(get_total_receipts('all', $fromDt,$toDate));
			array_push($receiptsData, (($receipts)?$receipts:0));
		}
		return $receiptsData;
	}
}

if(! function_exists('payments_months')){
	function payments_months($num){
		$paymentsData = [];
		for($i =0; $i < $num; $i++){
			$fromDt = date('Y-m-01', strtotime('-'.$i.'months'));
			$toDate = date('Y-m-t', strtotime('-'.$i.'months'));
			$payments = round(get_total_payments('all','', $fromDt,$toDate));
			array_push($paymentsData, (($payments)?$payments:0));
		}
		return $paymentsData;
	}
}

if(! function_exists('current_invoice_label')){
	function current_invoice_label($type){
		$CI =& get_instance();
		$monthEndDay = date('t');
		$invoiceDt = [];
		$j =1;
		for($i=0; $i < $monthEndDay; $i++){
			$dateMonths = date('Y-m-'.$j);
			$inv_label = date('d', strtotime($dateMonths));
			array_push($invoiceDt, $inv_label);
			$j++;
		}
		return $invoiceDt;
	}
}

if(! function_exists('current_invoice_amount')){
	function current_invoice_amount($type){
		$CI =& get_instance();
		$monthEndDay = date('t');
		$invoiceAmt = [];
		$j =1;
		for($i=0; $i < $monthEndDay; $i++){
			$dateMonths = date('Y-m-'.$j);
			$CI->db->select('SUM(total_sales) as totalSale')->from('pms_sales')->where('sales_type', $type)->where('sale_date', $dateMonths);
			$invAmt = $CI->db->get()->row();
			if($invAmt){
				$inv_Amt = round($invAmt->totalSale); 
			}else{
				$inv_Amt = 0;
			}
			array_push($invoiceAmt, $inv_Amt);
			$j++;
		}
		return $invoiceAmt;
	}
}

if(! function_exists('user_permission_check')){
	function user_permission_check($module_id){
		$CI =& get_instance();
		$user_id = $CI->session->userdata('user_id');
		$role_id = $CI->session->userdata('user_role');
		$permission = $CI->db->select('*')->from('lms_user_permissions')->where('user_id', $user_id)->where('role_id', $role_id)->where('module_id', $module_id)->get()->row();
		if($permission){
			return true;
		}else{
			return false;
		}
		
	}
}

if(! function_exists('add_notification')){
	function add_notification($icon, $title){
		$CI =& get_instance();
		$data['icon'] = $icon;
		$data['title'] = $title;
		$data['status'] = 1;
		$data['updated_at'] = date('Y-m-d h:i:s');
		$notice = $CI->db->insert('pms_notifications', $data);
		if($notice){
			return true;
		}else{
			return false;
		}
	}
}
if(! function_exists('count_notification')){
	function count_notification(){
		$CI =& get_instance();
		$data	= $CI->db->select('COUNT(id) as totalNotifications')->from('pms_notifications')->where('view_staus', 0)->get()->row();
		return $data->totalNotifications;
	}
}
if(! function_exists('time_elapsed_string')){
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hr',
        'i' => 'min',
        's' => 'sec',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . '' : 'just now';
}
}

if(! function_exists('fuel_products')){
	function fuel_products(){
		$CI =& get_instance();
		$items = $CI->db->select('n.name, p.products')->from('pms_nosals as n')->join('pms_products as p', 'p.id=n.product_id', 'left')->where('p.category_id', 1)->get()->result();
		$fuel_label = [];
		$j =1;
		for($i=0; $i < count((array)$items); $i++){
			$product = $items[$i]->name .' - '. $items[$i]->products;
			array_push($fuel_label, strtoupper($product));
		}
		return $fuel_label;
	}
}

if(! function_exists('fuel_products_stock')){
	function fuel_products_stock(){
		$CI =& get_instance();
		$items = $CI->db->select('id, products')->where('category_id', 1)->get('pms_products')->result();
		$fuel_stock = [];
		$j =1;
		for($i=0; $i < count((array)$items); $i++){
			array_push($fuel_stock, current_month_product_sale($items[$i]->id));
		}
		return $fuel_stock;
	}
}

if(! function_exists('current_month_product_sale')){
	function current_month_product_sale($product_id){
		$CI =& get_instance();
		$fromDt = date('Y-m-01');
		$toDt = date('Y-m-t');
		$totalSale = $CI->db->select('SUM(item_total) as totalAmt')->where('product_id', $product_id)->where('DATE(updated_at)>=', $fromDt)->where('DATE(updated_at)<=', $toDt)->get('pms_sales_line_item')->row();

		return $totalSale->totalAmt;
	}
}

if(! function_exists('timajax_ge_calc')){
	function time_calc($fromDt, $toDt, $full = false) {

		$ts1 = strtotime($fromDt);
		$ts2 = strtotime($toDt);     
		$seconds_diff = $ts2 - $ts1;                            
		$time = ($seconds_diff/3600);

		/* $now = new DateTime($toDt);
		$ago = new DateTime($fromDt);
		$diff = $now->diff($ago);
	
		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7; */
		 /* $string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hr',
			'i' => 'min',
			's' => 'sec',
		);

		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}
	
		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . '' : 'just now'; */ 
		$fullHours   = floor($seconds_diff/(60*60));
		$fullMinutes = floor(($seconds_diff-($fullHours*60*60))/60);
		$fullSeconds = floor($seconds_diff-($fullHours*60*60)-($fullMinutes*60));
		return sprintf("%02d",$fullHours) . " hrs " . sprintf("%02d",$fullMinutes) . " min ";
	}
}

if(! function_exists('ot_hrs')){
	function ot_hrs($fromDt, $toDt, $duty_hrs = NULL, $full = false) {
		$duty_hrs = (($duty_hrs)?$duty_hrs: 8);
		$ts1 = strtotime($fromDt);
		$ts2 = strtotime($toDt);     
		$seconds_diff = $ts2 - $ts1;                            
		$time = ($seconds_diff/3600);

		/* $now = new DateTime($toDt);
		$ago = new DateTime($fromDt);
		$diff = $now->diff($ago);
	
		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7; */
		 /* $string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hr',
			'i' => 'min',
			's' => 'sec',
		);

		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}
	
		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . '' : 'just now'; */ 
		$fullHours   = floor($seconds_diff/(60*60));
		$fullMinutes = floor(($seconds_diff-($fullHours*60*60))/60);
		$fullSeconds = floor($seconds_diff-($fullHours*60*60)-($fullMinutes*60));
		$workedhrs = sprintf("%02d",$fullHours);
		if($workedhrs > $duty_hrs){
			$otHrs = ($workedhrs - $duty_hrs);
			return sprintf("%02d",$otHrs) . " hrs " . sprintf("%02d",$fullMinutes) . " min ";
		}else{
			return;
		}

	}
}

	if(! function_exists('open_attendance')){
		function open_attendance($user_id, $assign_id, $shift_id, $nozzle_id){
			$CI =& get_instance();
			$currentTime = date('Y-m-d H:i:s');
			$currentDate = date('Y-m-d');

			$assign_id = $assign_id;
			$user_id = $user_id;
			$shift_id = $shift_id;
			$nozzle_id = $nozzle_id;

			$check = $CI->db->where('assign_id', $assign_id)->where('user_id', $user_id)->order_by('id','desc')->get('pms_attendance')->row();
			if($check){
				$id = $check->id;
				$data1['end_time'] = $currentTime;
				$data1['total_hrs'] = time_calc($check->start_time, $currentTime);
				$data1['updated_at'] = date('Y-m-d H:i:s');
				$CI->Attendance_m->update($id, $data1);
			}
			$data['attendance_date'] = $currentDate;
			$data['user_id']	=	$user_id;
			$data['shift_id']	=	$shift_id;
			$data['nozzle_id']	=	$nozzle_id;
			$data['assign_id']	=	$assign_id;
			$data['start_time']	=	$currentTime;
			$data['status'] 	= 1;
			$data['updated_at'] = date('Y-m-d H:i:s');
			$CI->Attendance_m->insert($data);
			return true;
		}
	}

	if(! function_exists('close_attendance')){
		function close_attendance($user_id, $assign_id, $shift_id=NULL, $nozzle_id=NULL){
			$CI =& get_instance();
			$currentTime = date('Y-m-d H:i:s');
			$currentDate = date('Y-m-d');

			$user_id = $user_id;
			$assign_id = $assign_id;
			$shift_id = $shift_id;
			$nozzle_id = $nozzle_id;

			$check = $CI->db->where('assign_id', $assign_id)->where('user_id', $user_id)->order_by('id','desc')->get('pms_attendance')->row();
			if($check){
				$id = $check->id;
				$data1['end_time'] = $currentTime;
				$data1['total_hrs'] = time_calc($check->start_time, $currentTime);
				$data1['updated_at'] = date('Y-m-d H:i:s');
				$CI->Attendance_m->update($id, $data1);
			}
			return true;
		}
	}

	if(! function_exists('total_income_expense')){
		function total_income_expense($type, $branch_id=null, $fromDt=NULL, $toDate=NULL, $txnType = NULL){
			$CI =& get_instance();
			$CI->db->select('SUM(amount) as totalAmt')
			->from('lms_incomes_expenses as ie')
			->join('lms_income_expense_heads as ieh', 'ieh.id = ie.type_id', 'left')
			->where('ie.behavior', $type);
			if($branch_id){
				$CI->db->where('ie.branch_id', $branch_id);
			}
			if($txnType){
				if($txnType == "Cash"){
					$CI->db->where('ie.mode_of_payment', 'Cash');
				}else{
					$CI->db->where('ie.mode_of_payment !=', 'Cash');
				}
			}
			if(!empty($fromDt)){
				$CI->db->where('ie.in_exp_date >=', $fromDt);
			}
			if(!empty($toDate)){
				$CI->db->where('ie.in_exp_date <=', $toDate);
			}
			$total = $CI->db->get()->row();
			$sumTotal = ($total->totalAmt);
			return round($sumTotal, 2);
		}
	}


	if(! function_exists('income_expense_months')){
		function income_expense_months($num, $type){
			$CI =& get_instance();
			$incomeExpenseAmt = [];
		
			for($i =0; $i < $num; $i++){
				$fromDt = date('Y-m-01', strtotime('-'.$i.'months'));
				$toDate = date('Y-m-t', strtotime('-'.$i.'months'));
				$totalAmt = round(total_income_expense($type, $fromDt, $toDate),2);
				array_push($incomeExpenseAmt, ((($totalAmt)?$totalAmt:0)));
			}
			return $incomeExpenseAmt;
		}
	}



	if(! function_exists('fuel_products_sales')){
		function fuel_products_sales(){
			$CI =& get_instance();
			$items = $CI->db->select('n.*, p.products')->from('pms_nosals as n')->join('pms_products as p','p.id = n.product_id')->where('p.category_id', 1)->get()->result();
			$fuel_sale = [];
			$j =1;
			for($i=0; $i < count((array)$items); $i++){
				array_push($fuel_sale, current_month_nozzle_sale($items[$i]->nosal_id));
			}
			return $fuel_sale;
		}
	}

	if(! function_exists('current_month_nozzle_sale')){
		function current_month_nozzle_sale($nozzle_id){
			$CI =& get_instance();
			$fromDt = date('Y-m-01');
			$toDt = date('Y-m-t');
			$totalSale = $CI->db->select('SUM(fuel_total) as totalAmt')->from('pms_daily_collection')
								->where('nosal_id', $nozzle_id)
								->where('entry_date >=', $fromDt)
								->where('entry_date <=', $toDt)
								->get()
								->row();
			
			return round($totalSale->totalAmt,2);
		}
	}

	if(! function_exists('current_month_income')){
		function current_month_income($type){
			$CI =& get_instance();
			$monthEndDay = date('t');
			$invoiceAmt = [];
			$j =1;
			for($i=0; $i < $monthEndDay; $i++){
				$dateMonths = date('Y-m-'.$j);
				if($type=="cash"){
					$cashSale = $CI->db->select('SUM(total) as total_cash')->from('pms_denomination')->where('entry_date', $dateMonths)->get()->row();
					$inv_Amt = (($cashSale->total_cash)?$cashSale->total_cash : 0);
				}
				if($type=="bank"){
					$inv_Amt = total_income_expense('income', $dateMonths, $dateMonths, $type);
				}
				array_push($invoiceAmt, $inv_Amt);
				$j++;
			}
			return $invoiceAmt;
		}
	}

	if(! function_exists('get_current_test_qty')){
		function get_current_test_qty($product_id, $fromDt =null, $toDt = null){
			$CI =& get_instance();
			$currentDate = date('Y-m-d');
			$CI->db->select('SUM(test_qty) as totalQty')->from('pms_test_sale')->where('product_id',$product_id);
			if($fromDt){
				$CI->db->where('test_date >=', $fromDt);
			}else{
				$CI->db->where('test_date >=', $currentDate);
			}
			if($toDt){
				$CI->db->where('test_date <=', $toDt);
			}else{
				$CI->db->where('test_date >=', $currentDate);
			}
			$testQty = $CI->db->get()->row();
			$current_qty = ((isset($testQty->totalQty))?$testQty->totalQty :0);
			return $current_qty;
		}
	}

	if(! function_exists('months_days')){
		function months_days($month, $year = null, $array=null){
			(($array)? $ignore = $array : $ignore = array(0,6));
			$yearX = ($year) ? $year : date('Y');
			$monthNum = array('January'=> 1, 'February'=> 2, 'March'=> 3, 'April'=> 4, 'May'=> 5, 'June'=> 6, 'July'=> 7, 'August'=> 8, 'September'=> 9, 'October'=> 10, 'November'=> 11, 'December'=> 12);
			//$days = cal_days_in_month(CAL_GREGORIAN, $monthNum[$month], $yearX);
			$count = 0;
			$counter = mktime(0, 0, 0, $monthNum[$month], 1, $yearX);
			while (date("n", $counter) == $monthNum[$month]) {
				if (in_array(date("w", $counter), $ignore) == false) {
					$count++;
				}
				$counter = strtotime("+1 day", $counter);
			}
			return $count;
		}
	}

if(! function_exists('getWorkdays')){
	function getWorkdays($date1, $date2, $workSat = FALSE, $patron = NULL) {
		if (!defined('SATURDAY')) define('SATURDAY', 6);
		if (!defined('SUNDAY')) define('SUNDAY', 0);
	  
		// Array of all public festivities
		$publicHolidays = array();
		// The Patron day (if any) is added to public festivities
		if ($patron) {
		  $publicHolidays[] = $patron;
		}
	  
		/*
		 * Array of all Easter Mondays in the given interval
		 */
		$yearStart = date('Y', strtotime($date1));
		$yearEnd   = date('Y', strtotime($date2));
	  
		for ($i = $yearStart; $i <= $yearEnd; $i++) {
		  $easter = date('Y-m-d', easter_date($i));
		  list($y, $m, $g) = explode("-", $easter);
		  $monday = mktime(0,0,0, date($m), date($g)+1, date($y));
		  $easterMondays[] = $monday;
		}
	  
		$start = strtotime($date1);
		$end   = strtotime($date2);
		$workdays = 0;
		for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
		  $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
		  $mmgg = date('m-d', $i);
		  if ($day != SUNDAY &&
			!in_array($mmgg, $publicHolidays) &&
			!in_array($i, $easterMondays) &&
			!($day == SATURDAY && $workSat == FALSE)) {
			  $workdays++;
		  }
		}
	  
		return intval($workdays);
	  }
	}

	if(! function_exists('total_attendance')){
		function total_attendance($emp_id, $month, $year){
			$CI =& get_instance();
			$startDate = date('Y-m-d', strtotime('01-'.$month.'-'.$year));
			$endDate = date('Y-m-t', strtotime('01-'.$month.'-'.$year));
			$data = $CI->db->select('SUM(over_all) as total_attendance')->from('lms_attendance')->where('employee_id', $emp_id)->where('date_attendance >=',$startDate)->where('date_attendance <=', $endDate)->get()->row();
			return (($data->total_attendance)?$data->total_attendance:0);
		}
	}

	if(! function_exists('total_add_deductions')){
		function total_add_deductions($emp_id, $month, $year, $type){
			// typee = deduction, addition
			$CI =& get_instance();
			$startDate = date('Y-m-d', strtotime('01-'.$month.'-'.$year));
			$endDate = date('Y-m-t', strtotime('01-'.$month.'-'.$year));
			$CI->db->select('SUM(amount) as total_add_deduct')->from('lms_deductions')->where('employee_id', $emp_id)->where('entry_date >=',$startDate)->where('entry_date <=', $endDate);
			if($type == 'deduction'){
				$CI->db->where('type', $type);
			}else{
				$CI->db->where('type', $type);
			}
			$data = $CI->db->get()->row();
			 
			return (($data->total_add_deduct)?$data->total_add_deduct:0);
		}
	}

	if(! function_exists('net_pay')){
		function net_pay($emp_id, $month, $year, $workingDays){
			$CI =& get_instance();
			
			$employee 			= $CI->Employees_m->get($emp_id);
			$basicSalary  		= $employee->basic_salary;
			$numWorkingDasy		= $workingDays;
			$totalAttendance 	= total_attendance($emp_id, $month, $year);
			$totalAdditions		= total_add_deductions($emp_id, $month, $year, 'addition');
			$totalDeductions	= total_add_deductions($emp_id, $month, $year, 'deduction');

			$grossSalary = ($basicSalary/$numWorkingDasy)*$totalAttendance;
			$netSalary = ($grossSalary + $totalAdditions) - $totalDeductions ;
 
			return (($netSalary)?round($netSalary, 2):0);
		}
	}

	if(!function_exists('count_table_row')){
		function count_table_row($table, $field, $value = null, $branch = null, $group_by = FALSE){
			$CI =& get_instance();
			$CI->db->select('COUNT('.$field.') as totalCount')->from($table);
			if($value){
				$CI->db->where($field, $value);
			}
			if($CI->session->userdata('branch_id') != 1){
				$CI->db->where('branch_id', $CI->session->userdata('branch_id'));
			}
			if($group_by){
				$CI->db->group_by($field);
			}
			$total = $CI->db->get()->row();
			return (($total->totalCount)?$total->totalCount:0);
		}
	}
	
	if(!function_exists('room_status_update')){
		function room_status_update($room_id, $status){
			$CI =& get_instance();
			$data['room_status'] = $status;
			$data['updated_on'] = date('Y-m-d H:i:s');
			$CI->Room_m->update($room_id, $data);
			return true;
		}
	}

	if(!function_exists('get_room_status_id')){
		function get_room_status_id($status){
			$CI =& get_instance();
			$status_data = $CI->Room_status_m->get_by('room_status', $status);
			return $status_data->id;
		}
	}

	if(!function_exists('get_gust_list')){
		function get_gust_list($booked_room_id, $display = FALSE){
			$CI =& get_instance();
			$gusts = $CI->db->select('gd.*')->from('lms_guest_details as gd')->where('room_booked_id', $booked_room_id)->get()->result();
			$html ="";
			if($display){
				$html .= '<table class="table table-sm text-sm m-0">';
				$html .= '<tbody>';
				foreach($gusts as $val){
					$html .= '<tr>';
					$html .= '<td width="50%">'.ucfirst($val->guest_name).'</td>';
					$html .= '<td width="20%">'.ucfirst($val->gender).'</td>';
					$html .= '<td width="10%">'.$val->age.'</td>';
					$html .= '<td width="20%">'.ucfirst($val->adult).'</td>';
					$html .= '</tr>';
				}
				$html .= '</tbody>';
				$html .= '</table>';
				return $html;
			}else{
				foreach($gusts as $val){
					$html .= '<p class="p-0 m-0">' .ucfirst($val->guest_name).' | '.ucfirst($val->gender). ', '.$val->age.', '.ucfirst($val->adult).'</p>';
				}
				return $html;
			}
			
		}
	}

	/*if(!function_exists('get_days')){
		function get_days($startDt, $endDt){
			$fromDt		= strtotime($startDt);
			$todt		= strtotime($endDt);
			$datediff	= $todt - $fromDt;
			//$totalDays	=  round($datediff / (60 * 60 * 24));
			$totalDays	= (int)($datediff / (60 * 60* 24));
			$rem = $datediff % (60 * 60* 24);
			if($rem>0) $totalDays++ ;

			return (($totalDays != 0)? round($totalDays,2) : 1);
		}
	}*/
	
	if(!function_exists('get_days')){
		function get_days($startDt, $endDt){
			$fromDt		= strtotime($startDt);
			$todt		= strtotime($endDt);
			
			date('Y/m/d H:i:s', $todt);
			date('Y/m/d H:i:s', $fromDt);
			
			$datediff	= $todt - $fromDt;
		
			$totalhrs = 25/24;
			//$hrs_value = explode('.', $totalhrs);
			
			$whole1 = floor($totalhrs);
            $hrs_value = $totalhrs - $whole1;
			
		
			//$totalDays	=  round($datediff / (60 * 60 * 24));
			$totalDays	= $datediff / (60 * 60* 24);
			//$split_hrs = explode('.', $totalDays);
			
			$whole = floor($totalDays);
            $split_hrs = $totalDays - $whole;
			
			
			
			if($split_hrs > $hrs_value){
				$total_days = $whole;
				$total_days++;
			}else{
				$total_days = $whole;
			}
			/* $rem = $datediff % (60 * 60* 24);
			if($rem>0) $totalDays++ ; */

			//return (($totalDays != 0)? round($totalDays,2) : 1);
			return $total_days;
		}
	}

	if(!function_exists('total_payments')){
		function total_payments($booking_id = null, $bookedRoomId = null){
			$CI =& get_instance();
			$CI->db->select('SUM(p.payment_amount)as receivedAmt')->from('lms_payments as p')->join('lms_booking_guests as bg', 'bg.id = p.booking_id', 'left');
			if($booking_id){
				$CI->db->where('p.booking_id', $booking_id);
			}
			if($bookedRoomId){
				$CI->db->where('p.booked_room_id', $bookedRoomId);
			}
			if($CI->session->userdata('branch_id') != 1){
				//$this->db->where('e.branch', $this->session->userdata('branch_id'));
				$CI->db->where('bg.branch_id', $CI->session->userdata('branch_id'));
			}
			$payments = $CI->db->get()->row();
			return (($payments->receivedAmt)?$payments->receivedAmt:0);
		}
	}

	if(!function_exists('total_invoice_amount')){
		function total_invoice_amount($booking_id){
			$CI =& get_instance();
			$booked_room = $CI->db->select('SUM(i.grandTotal) as total')->from('lms_invoice_details as i')->where('i.booking_id', $booking_id)->get()->row();
			return (($booked_room)?$booked_room->total : 0);
		}
	}

	if(!function_exists('update_booked_room_status')){
		function update_booked_room_status($booked_room_id){
			$CI =& get_instance();
			$booked_room = $CI->db->select('br.*')->from('lms_booked_rooms as br')->where('id', $booked_room_id)->get()->row();
			$data['room_status_id'] = get_room_status_id('Cleaning');
			$CI->db->where('id', $booked_room_id )->update('lms_booked_rooms', $data);
			room_status_update($booked_room->room_id, get_room_status_id('Cleaning'));
			return true;
		}
	}

	/* if(!function_exists('update_booked_room_status')){
		function update_booked_room_status($booking_id){
			$CI =& get_instance();
			$booked_room = $CI->db->select('br.*, r.id as roomId')->from('lms_booked_rooms as br')->join('lms_room as r', 'r.id = br.room_id', 'left')->where('booking_id', $booking_id)->get()->result();
			foreach($booked_room as $val0): 
				$id = $val0->id;
				$data['room_status_id'] = get_room_status_id('Cleaning');
				$CI->db->where('id', $id )->update('lms_booked_rooms', $data);
				room_status_update($val0->roomId, get_room_status_id('Cleaning'));
			endforeach; 

			return true;
		}
	} */

	if(! function_exists('item_quantity_balance')){
		function item_quantity_balance($id){
			$CI =& get_instance();
			$qty = $CI->db->select('SUM(item_qty) as given, SUM(received_item_qty) as received')->from('pms_laundry_line_items')->where('laundry_id',$id)->get()->row();
			$balance = ($qty->given) -  ($qty->received);
			return abs($balance);
		}
	}

	if(! function_exists('calendar_data'))
	{
		function calendar_data()
		{
			$CI =& get_instance();
			//$currentTime = date('Y-m-d H:i:s');
			$currentDate = date('Y-m-d');
			$current_month = date('m');
			$res = $CI->db->get('enquiry')->result();
			return $res;
		}
	}

	if(!function_exists('total_invoice')){
		function total_invoice(){
			$CI =& get_instance();
			$CI->db->select('SUM(grandTotal) as invoiceTotal')->from('lms_invoice_details as i');
			if($CI->session->userdata('branch_id') != 1){
				$CI->db->where('branch_id', $CI->session->userdata('branch_id'));
			}
			$invoiceAmt = $CI->db->get()->row();
			return (($invoiceAmt->invoiceTotal)?$invoiceAmt->invoiceTotal : 0);
		}
	}


	if(!function_exists('booked_rooms_concat')){
		function booked_rooms_concat($booking_id){
			$CI =& get_instance();
			$CI->db->select('GROUP_CONCAT(r.room_no) as rooms')
			->from('lms_booking_guests as bg')
			->join('lms_booked_rooms as br', 'br.booking_id = bg.id')
			->join('lms_room as r', 'r.id = br.room_id')
			->where('bg.id', $booking_id)
			->group_by('br.booking_id');
			$roomData = $CI->db->get()->row();
			return ((!empty($roomData->rooms))?$roomData->rooms : 0);
		}
	}

	if(!function_exists('get_post_offices')){
		function get_post_offices($pincode){
			$url = "https://api.postalpincode.in/pincode/".$pincode;
			$result = file_get_contents($url);
			return $result;
		}
	}

	//======================== Number to word ===================

function convertNumber($number)
{
	$number = number_format($number, 2, ".","");
    list($integer, $fraction) = explode(".", (string) $number);

    $output = "";

    if ($integer[0] == "-")
    {
        $output = "negative ";
        $integer    = ltrim($integer, "-");
    }
    else if ($integer[0] == "+")
    {
        $output = "positive ";
        $integer    = ltrim($integer, "+");
    }

    if ($integer[0] == "0")
    {
        $output .= "zero";
    }
    else
    {
        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
        $group   = rtrim(chunk_split($integer, 3, " "), " ");
        $groups  = explode(" ", $group);

        $groups2 = array();
        foreach ($groups as $g)
        {
            $groups2[] = convertThreeDigit($g[0], $g[1], $g[2]);
        }

        for ($z = 0; $z < count($groups2); $z++)
        {
            if ($groups2[$z] != "")
            {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                        $z < 11
                        && !array_search('', array_slice($groups2, $z + 1, -1))
                        && $groups2[11] != ''
                        && $groups[11][0] == '0'
                            ? " and "
                            : ", "
                    );
            }
        }

        $output = rtrim($output, ", ");
    }

    if ($fraction > 0)
    {
        $output .= " point";
        for ($i = 0; $i < strlen($fraction); $i++)
        {
            $output .= " " . convertDigit($fraction[$i]);
        }
    }

    return $output;
}

function convertGroup($index)
{
    switch ($index)
    {
        case 11:
            return " decillion";
        case 10:
            return " nonillion";
        case 9:
            return " octillion";
        case 8:
            return " septillion";
        case 7:
            return " sextillion";
        case 6:
            return " quintrillion";
        case 5:
            return " quadrillion";
        case 4:
            return " trillion";
        case 3:
            return " billion";
        case 2:
            return " million";
        case 1:
            return " thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
    {
        return "";
    }

    if ($digit1 != "0")
    {
        $buffer .= convertDigit($digit1) . " hundred";
        if ($digit2 != "0" || $digit3 != "0")
        {
            $buffer .= " and ";
        }
    }

    if ($digit2 != "0")
    {
        $buffer .= convertTwoDigit($digit2, $digit3);
    }
    else if ($digit3 != "0")
    {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0")
    {
        switch ($digit1)
        {
            case "1":
                return "ten";
            case "2":
                return "twenty";
            case "3":
                return "thirty";
            case "4":
                return "forty";
            case "5":
                return "fifty";
            case "6":
                return "sixty";
            case "7":
                return "seventy";
            case "8":
                return "eighty";
            case "9":
                return "ninety";
        }
    } else if ($digit1 == "1")
    {
        switch ($digit2)
        {
            case "1":
                return "eleven";
            case "2":
                return "twelve";
            case "3":
                return "thirteen";
            case "4":
                return "fourteen";
            case "5":
                return "fifteen";
            case "6":
                return "sixteen";
            case "7":
                return "seventeen";
            case "8":
                return "eighteen";
            case "9":
                return "nineteen";
        }
    } else
    {
        $temp = convertDigit($digit2);
        switch ($digit1)
        {
            case "2":
                return "twenty-$temp";
            case "3":
                return "thirty-$temp";
            case "4":
                return "forty-$temp";
            case "5":
                return "fifty-$temp";
            case "6":
                return "sixty-$temp";
            case "7":
                return "seventy-$temp";
            case "8":
                return "eighty-$temp";
            case "9":
                return "ninety-$temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit)
    {
        case "0":
            return "zero";
        case "1":
            return "one";
        case "2":
            return "two";
        case "3":
            return "three";
        case "4":
            return "four";
        case "5":
            return "five";
        case "6":
            return "six";
        case "7":
            return "seven";
        case "8":
            return "eight";
        case "9":
            return "nine";
    }
}
//===========================================================


if(!function_exists('update_check_out_date')){
	function update_check_out_date($booke_room_id, $chckOutDate){
		$CI =& get_instance();
		$data['check_out_date'] = $chckOutDate;
		$CI->db->where('id', $booke_room_id)->update('lms_booked_rooms', $data);
		return true;
	}
}

if(!function_exists('unlink_image')){
	function unlink_image($files){
		$CI =& get_instance();
		if(!empty($files)):
			$images = explode(",", $files);
		endif; 
		foreach($images as $vals){
			unlink($_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']).'/assets/uploads/employees_docs/'.$vals);
		}
		return true;
	}
}

if(!function_exists('status_color')){
	function status_color($current_status){
		$CI =& get_instance();
		if($current_status == 1){
			$result = 'green';
		}else if($current_status == 2){
			$result = 'danger';
		}else if($current_status == 7){
			$result = 'danger';
		}else{
			$result = 'yellow';
		}
		return $result;
	}
}

if(!function_exists('get_booking_id')){
	function get_booking_id ($room_id){
		$CI =& get_instance();
		$booked_room = $CI->db->select('*')->from('lms_booked_rooms')->where('room_id',$room_id)->where('room_status_id', 2)->order_by('id', 'desc')->get()->row();
		return $booked_room->booking_id;
	}
}

if(!function_exists('get_booked_room_id')){
	function get_booked_room_id ($room_id){
		$CI =& get_instance();
		$booked_room = $CI->db->select('*')->from('lms_booked_rooms')->where('room_id',$room_id)->where('room_status_id', 2)->order_by('id', 'desc')->get()->row();
		return $booked_room->id;
	}
}

if(!function_exists('cash_in_hand')){
	function cash_in_hand($branch_id = null){
		$txnType = "Cash";
		$CI =& get_instance();
		if(!empty($branch_id)){
			$payments 		= $CI->db->select('SUM(payment_amount) as total_payment')->from('lms_payments')->where('branch_id',$branch_id)->where('txn_mode','Cash')->get()->row();
			$total_invoice 	= $CI->db->select('SUM(balance_amt) as total_balance')->from('lms_invoice_details')->where('branch_id', $branch_id)-> where('mode_txn','Cash')->get()->row();	
			$not_paid_invoice 	= $CI->db->select('SUM(not_paid_amt) as total_not_paid_amt')->from('lms_invoice_details')->where('branch_id', $branch_id)-> where('mode_txn','Cash')->get()->row();	
			$transferAmount = $CI->db->select('SUM(transfer_amount) as transferAmt')->from('lms_fund_transfer')->where('from_branch_id', $branch_id)->where('confirm_status','approved')->get()->row();
			$laundry		= laundry_payment_cash_total($branch_id, "Cash");
			$incomes 		= total_income_expense('Income', $branch_id,"","", $txnType);
			$expenses 		= total_income_expense('Expense', $branch_id,"","", $txnType);
			$cash_transfer_add =  $CI->db->select('SUM(transfer_amount) as add_transfer_amt')->from('lms_transfer_cash')->where('branch_id',$branch_id)->where('to_txn_mode','Cash')->get()->row();
			$cash_transfer_ded =  $CI->db->select('SUM(transfer_amount) as ded_transfer_amt')->from('lms_transfer_cash')->where('branch_id',$branch_id)->where('from_txn_mode','Cash')->get()->row();
		}else{
			$payments 		= $CI->db->select('SUM(payment_amount) as total_payment')->from('lms_payments')->where('txn_mode','cash')->get()->row();
			$total_invoice 	= $CI->db->select('SUM(balance_amt) as total_balance')->from('lms_invoice_details')->where('mode_txn','cash')->get()->row();
			$not_paid_invoice 	= $CI->db->select('SUM(not_paid_amt) as total_not_paid_amt')->from('lms_invoice_details')->where('mode_txn','cash')->get()->row();
			$transferAmount = $CI->db->select('SUM(transfer_amount) as transferAmt')->from('lms_fund_transfer')->where('confirm_status','approved')->get()->row();	
			$laundry		= laundry_payment_cash_total("", "Cash");
			$incomes 		= total_income_expense('Income', "","","", $txnType);
			$expenses 		= total_income_expense('Expense', "","","", $txnType);
			$cash_transfer_add =  $CI->db->select('SUM(transfer_amount) as add_transfer_amt')->from('lms_transfer_cash')->where('to_txn_mode','Cash')->get()->row();
			$cash_transfer_ded =  $CI->db->select('SUM(transfer_amount) as ded_transfer_amt')->from('lms_transfer_cash')->where('from_txn_mode','Cash')->get()->row();
		}
		$total_invoice->total_balance = 0;
		$not_paid_invoice->total_not_paid_amt = 0;
		$cash_in_hand 	= ($payments->total_payment) + (($total_invoice->total_balance) - ($not_paid_invoice->total_not_paid_amt)) + $incomes + ($cash_transfer_add->add_transfer_amt);
		return ($cash_in_hand - ($expenses + $laundry + (int) $transferAmount->transferAmt + (int)$cash_transfer_ded->ded_transfer_amt));
		//return $transferAmount->transferAmt;
		
	}
}

if(!function_exists('cash_at_bank')){
	function cash_at_bank($branch_id = null){
		$txnType = "not cash";
		$CI =& get_instance();
		if(!empty($branch_id)){
			$payments 		= $CI->db->select('SUM(payment_amount) as total_payment')->from('lms_payments')->where('branch_id',$branch_id)->where('txn_mode !=','Cash')->get()->row();
			$total_invoice 	= $CI->db->select('SUM(balance_amt) as total_balance')->from('lms_invoice_details')->where('branch_id', $branch_id)-> where('mode_txn !=','Cash')->get()->row();	
			$not_paid_invoice 	= $CI->db->select('SUM(not_paid_amt) as total_not_paid_amt')->from('lms_invoice_details')->where('branch_id', $branch_id)-> where('mode_txn !=','Cash')->get()->row();	
			$incomes 		= total_income_expense('Income', $branch_id,"","", $txnType);
			$expenses 		= total_income_expense('Expense', $branch_id,"","", $txnType);
			$laundry		= laundry_payment_cash_total($branch_id, "Not Cash");
			$cash_transfer_add =  $CI->db->select('SUM(transfer_amount) as add_transfer_amt')->from('lms_transfer_cash')->where('branch_id',$branch_id)->where('to_txn_mode !=','Cash')->get()->row();
			$cash_transfer_ded =  $CI->db->select('SUM(transfer_amount) as ded_transfer_amt')->from('lms_transfer_cash')->where('branch_id',$branch_id)->where('from_txn_mode !=','Cash')->get()->row();
		}else{
			$payments 		= $CI->db->select('SUM(payment_amount) as total_payment')->from('lms_payments')->where('txn_mode !=','cash')->get()->row();
			$total_invoice 	= $CI->db->select('SUM(balance_amt) as total_balance')->from('lms_invoice_details')->where('mode_txn !=','cash')->get()->row();
			$not_paid_invoice 	= $CI->db->select('SUM(not_paid_amt) as total_not_paid_amt')->from('lms_invoice_details')->where('mode_txn !=','cash')->get()->row();
			$laundry		= laundry_payment_cash_total("", "Not Cash");
			$expenses 		= total_income_expense('Expense', "", "","", $txnType);
			$incomes 		= total_income_expense('Income', "","","", $txnType);
			$cash_transfer_add =  $CI->db->select('SUM(transfer_amount) as add_transfer_amt')->from('lms_transfer_cash')->where('to_txn_mode !=','Cash')->get()->row();
			$cash_transfer_ded =  $CI->db->select('SUM(transfer_amount) as ded_transfer_amt')->from('lms_transfer_cash')->where('from_txn_mode!=','Cash')->get()->row();
		}
		$total_invoice->total_balance = 0;
		$not_paid_invoice->total_not_paid_amt = 0;
			
		$cash_in_hand 	= (($payments->total_payment) + (($total_invoice->total_balance) - ($not_paid_invoice->total_not_paid_amt)) + $incomes + ($cash_transfer_add->add_transfer_amt));
		
		return (($cash_in_hand - ($expenses + $laundry + (int)$cash_transfer_ded->ded_transfer_amt)));
		
	}
}

if ( ! function_exists('laundry_payment_total')) {
	function laundry_payment_cash_total($branch_id = null, $txnType = null){
		$CI =& get_instance();
		$CI->db->select('SUM(lp.amount) as paid')
		->from('lms_laundry_payments as lp');
		if($branch_id){
			$CI->db->where('laundry_id', $branch_id);
		}
		if($txnType){
			if($txnType == 'Cash'){
				$CI->db->where('mode_txn', $txnType);
			}else{
				$CI->db->where('mode_txn !=', 'Cash');
			}
		}
		$dataPaid = $CI->db->get()->row();

		return $dataPaid->paid;
	}
}

if(!function_exists('count_rooms')){
	function count_rooms($branch_id, $status_id){
		$CI =& get_instance();
		$room = $CI->db->select('COUNT(room_no) as total_rooms')->from('lms_room')->where('room_status',$status_id)->where('branch_id', $branch_id)->get()->row();
		return (($room)? $room->total_rooms : 0) ;
	}
}

if(!function_exists('booked_room_prize')){
	function booked_room_prize($room_id){
		$CI =& get_instance();
		$room = $CI->db->select('*')->from('lms_room')->where('id', $room_id)->get()->row();
		$room_price = $CI->db->select('room_price')->from('lms_booked_rooms')->where('room_id',$room_id)->where('room_status_id', 2)->order_by('id', 'desc')->get()->row();
		return ((!empty($room_price))? $room_price->room_price : $room->price) ;
	}
}

if ( ! function_exists('display_images')) {
	function display_images($file){
		$images = "";
		if(!empty($file)){
			$image_array = explode(',', $file);
			$images = "";
			for($i = 0; $i < count((array) $image_array); $i++){
				$url = site_url('assets/uploads/guest_documents/'.$image_array[$i]);
				$images.='<a href="'.$url.'" onclick="window.open(this.href).print(); return false"  title="Click to view the file" target="_blank"><i class="fa fa-file-alt"></i></a> ';

			}
		}
		return $images;
	}
}

if ( ! function_exists('get_sum_value')) {
	function get_sum_value($table, $sum_field, $where=null){
		$CI =& get_instance();
		$data = $CI->db->select('SUM('.$sum_field.') as total')->from($table)->where($where)->get()->row();
		return (($data)? $data->total : 0);
	}
}

if ( ! function_exists('laundry_balance')) {
	function laundry_balance($laundry_id, $branch_id){
		$CI =& get_instance();
		$dataTotal = $CI->db->select('SUM(li.total_amount) as total')->from('pms_laundry_line_items as li')->join('pms_laundry as l', 'l.id = li.laundry_id')->where('l.laundry_id',$laundry_id)->where('l.branch_id',$branch_id)->get()->row();
		$dataPaid = $CI->db->select('SUM(lp.amount) as paid')->from('lms_laundry_payments as lp')->where('laundry_id', $laundry_id)->where('branch_id', $branch_id)->get()->row();
		return (($dataTotal->total) - ($dataPaid->paid));
	}
}

if ( ! function_exists('laundry_total')) {
	function laundry_total($laundry_id){
		$CI =& get_instance();
		$dataTotal = $CI->db->select('SUM(li.total_amount) as total')->from('pms_laundry_line_items as li')->join('pms_laundry as l', 'l.id = li.laundry_id')->where('l.laundry_id',$laundry_id)->get()->row();
		return $dataTotal->total;
	}
}

if ( ! function_exists('laundry_payment_total')) {
	function laundry_payment_total($laundry_id){
		$CI =& get_instance();
		$dataPaid = $CI->db->select('SUM(lp.amount) as paid')->from('lms_laundry_payments as lp')->where('laundry_id', $laundry_id)->get()->row();
		return $dataPaid->paid;
	}
}

if ( ! function_exists('pending_amount_transfer_count')) {
	function pending_amount_transfer_count(){
		$CI =& get_instance();
		$data = $CI->db->select('COUNT(ref_no) as pending')->from('lms_fund_transfer')->where('confirm_status', 'pending')->get()->row();
		return $data->pending;
	}
}



