<?php
//----------
function isLogedUser(){
	$CI =& get_instance();
	if($CI->session->userdata('loggedin')== FALSE){
		redirect('login/login/logout');
	}
}

//========= get all data ====
function getalldata($model){
	$CI =& get_instance();
	$data = $CI ->$model->get_all();
	return($data);
}
//==================== Get order by
function getallorderby($model, $fields, $optional = NULL){
	$CI =& get_instance();
	if($optional){
		$data = $CI ->$model->order_by($fields, $optional)->get_all();
	}else{
		$data = $CI ->$model->order_by($fields,'DESC')->get_all();
	}
	return($data);
}
//============getmanyby data =========
function getmanybydata($model, $array, $id=NULL){
	$CI =& get_instance();
	if($id){
		$data = $CI->$model->order_by($id, 'DESC')->get_many_by($array);
	}else{
		$data = $CI->$model->get_many_by($array);
	}
	return $data;
}
//==== Count data =====
function countalldata($model, $array){
	$CI =& get_instance();
	$data = $CI->$model->count_by($array);
	return $data;
}

//============= Get Total =====
function gettotalamt($model,$field, $array){
	$CI =& get_instance();
	$total = 0;
	$data = $CI->$model->get_many_by($array);
	if(count($data)){
		foreach($data as $key){
			$total = $total + ($key -> $field);
		}
	}
	return $total;
}

//========== get single Data ============
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
//-------------- updating data ---------
function updatedata($model, $dataarray, $id){
	$CI =& get_instance();
	$data = $CI->$model->update($id, $dataarray);
	return $data ;
}
//=============== Auto Numbering for  =======
function autoproposalnumner($model, $id, $numfeild, $array){
	$CI =& get_instance();
	$company = getcompanydata();
	$data = getmanybydata($model, $array, $id) ;
	if(count($data)){
	$currentnum = $data[0]->$numfeild;
	$getnum = explode('/', $currentnum);
	$newnum = $getnum[1]+1;
	}else{
		$newnum = $company->auto_no_start;
	}
	$newnum = $company->com_prefix.'/'.$newnum;
	return $newnum;
}



//====================
function auto_num_revice_porposal($model, $array, $numfeild, $sort){
	$CI =& get_instance();
	$data = getcustomdata($model, $array, $sort);
	$basnum = explode('/', $data[0]->$numfeild);
	$currentnum = count($data);
	$newnum = $basnum[0].'/'.$basnum[1].'/R/'.$currentnum;
	return $newnum;
}

//=============== Auto Numbering =======
function autonumbering($model,$array=NULL, $id=NULL){
	$CI =& get_instance();
	$data = getcustomdata($model, $array, $id);
	$data1 = getcompanydata();
	//getalldata($model);
	$number = count($data);
	if(count($data)){
		$last_prefix = explode( '-', $data[0]->enqref);
		$refno = $data1->com_prefix. "-" .($last_prefix[1] + 1);
	}else{
		$refno = $data1->com_prefix.'-'.$data1->auto_no_start;
	}
	return $refno;
}
//================ Get custom data  =======
function getcustomdata($model, $array=NULL, $sort = NULL){
	$CI =& get_instance();
	if($array){
		if($sort){
			$data = $CI->$model->order_by($sort, 'DESC')->get_many_by($array);
		}else{
			$data = $CI->$model->get_many_by($array);
		}
	}else{
		$data = $CI->$model->get_all();
	}
	return $data;
}

//--------------- Get singlerowdata--------------
function getsiglerowdata($model, $id, $sort=NULL){
	$CI =& get_instance();
	$data = $CI->$model->get($id);
	return $data;
}

//============== Pagination ======================
	function getalldata1($model, $perpage, $link, $idfield, $array=NULL, $pages=NULL){
		$CI =& get_instance();
		$CI->load->library('pagination');
		$config['base_url'] = site_url($link);
		$config['total_rows'] = $CI->$model->count_by($array);
		$config['per_page'] = $perpage;
		//-------------style --------------
		$config['full_tag_open']    = '<ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul>';
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']    = '</li>';
		$config['attributes'] 		= array('class' => 'page-link');
        $config['cur_tag_open']     = "<li class='page-item active'><a class='page-link' href='#'>";
        $config['cur_tag_close']    = "</a></li>";
        $config['first_link'] 		= '<i class="fa fa-mail-reply"></i>';
		$config['first_tag_open']   = "<li>";
        $config['first_tag_close'] 	= "</li>";
		$config['last_link'] 		= '<i class="fa  fa-mail-forward"></i>';
        $config['last_tag_open']    = "<li>";
        $config['last_tag_close']  	= "</li>";
		$config['prev_link']		= '<i class="fa fa-chevron-left"></i>';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['next_link'] 		= '<i class="fa fa-chevron-right"></i>';
		$config['next_tag_open']	= '<li>';
		$config['next_tag_close']	= '</li>';
		//------------------------
		$CI->pagination->initialize($config);
		if($pages){
				$products = $CI->$model->order_by($idfield, 'DESC')->limit($perpage,$pages)->get_many_by($array);
			}else{
				$products = $CI->$model->order_by($idfield, 'DESC')->limit($perpage, 0)->get_many_by($array);
			}
		return $products ;
}

//======================== Number to word ===================

function convertNumber($number)
{
    list($integer, $fraction) = explode(".", (string) $number);

    $output = "";

    if ($integer{0} == "-")
    {
        $output = "negative ";
        $integer    = ltrim($integer, "-");
    }
    else if ($integer{0} == "+")
    {
        $output = "positive ";
        $integer    = ltrim($integer, "+");
    }

    if ($integer{0} == "0")
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
            $groups2[] = convertThreeDigit($g{0}, $g{1}, $g{2});
        }

        for ($z = 0; $z < count($groups2); $z++)
        {
            if ($groups2[$z] != "")
            {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                        $z < 11
                        && !array_search('', array_slice($groups2, $z + 1, -1))
                        && $groups2[11] != ''
                        && $groups[11]{0} == '0'
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
            $output .= " " . convertDigit($fraction{$i});
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

function getmonthlycount($model, $feils, $month){
	$CI =& get_instance();
	$year = date('Y');
	$data = $CI->$model->get_many_by(array('MONTH('.$feils.')'=>$month,'YEAR('.$feils.')'=>$year));
	$count = count($data);
	return $count;
}

//============== flags =========
function flags_marks($status){
	$flag = array(
			'<i class="clip-minus-circle text-danger"></i>',
			'<i class="fa fa-flag text-success"></i>',
			'<i class="clip-warning text-warning"></i>'
			);
	return $flag[$status];
}

//============== Pagination goprup ======================
	function getalldatagroup($model, $perpage, $link, $idfield, $groupfield, $array, $pages = NULL, $count = NULL){
		$CI =& get_instance();
		$CI->load->library('pagination');
		$config['base_url'] = site_url($link);
		$config['total_rows'] = $count ? $count : $CI->$model->group_by($groupfield)->count_by($array);
		$config['per_page'] = $perpage;
		//-------------style --------------
		$config['full_tag_open']    = '<ul class="pagination pagination-primary">';
        $config['full_tag_close']   = '</ul>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "</a></li>";
        $config['first_link'] 		= '<i class="fa fa-mail-reply"></i>';
		$config['first_tag_open']   = "<li>";
        $config['first_tag_close'] 	= "</li>";
		$config['last_link'] 		= '<i class="fa fa-mail-forward"></i>';
        $config['last_tag_open']    = "<li>";
        $config['last_tag_close']  	= "</li>";
		$config['prev_link']		= '<i class="fa fa-chevron-left"></i>';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['next_link'] 		= '<i class="fa fa-chevron-right"></i>';
		$config['next_tag_open']	= '<li>';
		$config['next_tag_close']	= '</li>';
		//------------------------
		$CI->pagination->initialize($config);
		if($pages) {

			$products = $CI->$model
				->order_by($idfield, 'DESC')
				->limit($perpage, $pages)
				->group_by($groupfield)
				->get_many_by($array);

		} else {
			$products = $CI->$model
				->order_by($idfield, 'DESC')
				->limit($perpage, 0)
				->group_by($groupfield)
				->get_many_by($array);
		}
		return $products;
	}


function get_opportunities($perpage, $link, $where, $or_where, $pages = 0, $count = NULL) {

	$model = 'Opportunity_m';
	$idfield = 'id';
	$groupfield = 'DATE(created_at)';

	$CI =& get_instance();
	$CI->load->library('pagination');

	$config['base_url'] 	= site_url($link);
	// $config['total_rows']	= $count ? $count : $CI->$model->group_by($groupfield)->count_by($where);
	$config['per_page'] 	= $perpage;

	//-------------style --------------
	$config['full_tag_open']    = '<ul class="pagination justify-content-center">';
	$config['full_tag_close']   = '</ul>';
	$config['num_tag_open']     = '<li class="page-item">';
	$config['num_tag_close']    = '</li>';
	$config['cur_tag_open']     = "<li class='page-item active'><a href='#'>";
	$config['cur_tag_close']    = "</a></li>";
	$config['first_link'] 		= '<i class="fa fa-mail-reply"></i>';
	$config['first_tag_open']   = "<li>";
	$config['first_tag_close'] 	= "</li>";
	$config['last_link'] 		= '<i class="fa fa-mail-forward"></i>';
	$config['last_tag_open']    = "<li>";
	$config['last_tag_close']  	= "</li>";
	$config['prev_link']		= '<i class="fa fa-chevron-left"></i>';
	$config['prev_tag_open'] 	= '<li>';
	$config['prev_tag_close'] 	= '</li>';
	$config['next_link'] 		= '<i class="fa fa-chevron-right"></i>';
	$config['next_tag_open']	= '<li>';
	$config['next_tag_close']	= '</li>';
	//------------------------

	$product_count = $CI->db
		->select("created_at")
		->from("cms_opportunity")
		->where($where);

	if($or_where) {
		$product_count = $product_count
			->group_start()
				->or_where($or_where)
			->group_end();
	}


	$product_count = $product_count
		->where_not_in("handler", "SELECT `auth_id` FROM `auth_users` WHERE `status` = 0", false)
		->order_by($groupfield, 'DESC')
		->group_by($groupfield)
		->get()
		->result();

	$products = $CI->db
		->select("created_at")
		->from("cms_opportunity")
		->where($where);

	if($or_where) {
		$products = $products
			->group_start()
				->or_where($or_where)
			->group_end();
	}

	$products = $products
		->where_not_in("handler", "SELECT `auth_id` FROM `auth_users` WHERE `status` = 0", false)
		->limit($perpage, $pages)
		->order_by($groupfield, 'DESC')
		->group_by($groupfield)
		->get()
		->result();

	$config['total_rows'] = count($product_count);
	$CI->data["count"] = count($product_count);
	$CI->pagination->initialize($config);

	return $products;
}

function barcodegen($len){
	$rand   = '';
    while(!(isset($rand[$len-1]))){
        $rand   .= mt_rand(0,9);
    }
    return substr( $rand , 0 , $len );
		
}


function getBookCopies($bookid){
	$CI =& get_instance();
	$data = $CI->Purchasebooksline_m->count_by(array('bookid'=>$bookid));
	$dmgbooks = $CI->Bookdamage_m->count_by(array('books_id'=>$bookid));
	$booksnum = ($data - $dmgbooks); 
	return $booksnum;
}

function CountTable($model, $array = NULL){
	$CI =& get_instance();
	$data = $CI->$model->count_by($array);
	return $data;
}

function autoReturn($id){
	$CI =& get_instance();
	$libaray = $CI->Librarydetails_m->get(1);
	$issuedata = $CI->Bookissue_m->get($id);
	if($issuedata->trans_type == 1){
		$returndate = date('d-m-Y',strtotime("+ ".$libaray->auto_return." days", strtotime($issuedata->issue_date)));
		if(strtotime($returndate)< strtotime(date('d-m-Y'))){
			$issuelineitems = $CI->Booksissueline_m->get_many_by(array('issue_id'=>$id));
			foreach($issuelineitems as $keys){
				$data['dateof_return'] = date('Y-m-d', strtotime($returndate));
				$data['return_status'] = 1;
				$CI->Booksissueline_m->update($keys->id, $data);
			}
		}
	}
	return true;
}

function logoreport($title,$txtReport){
	$CI =& get_instance();
	$data['activity_title'] = $title; 
	$data['log_report'] = $txtReport ;
	$data['status'] = 1;
	$CI->Logreport_m->insert($data);
	return true;
}

function activityReport(){
	$CI =& get_instance();
	$html = '';
	$data = $CI->Logreport_m->order_by('id', 'DESC')->limit(10)->get_all();
	if(count($data)){
		foreach ($data as $key){
			if($key->activity_title == 'Login'){
				$colour = 'purple';
				$icon = 'ft-log-in';
			}
			if($key->activity_title == 'Logout'){
				$colour = 'info';
				$icon = 'ft-log-out';
			}
			if($key->activity_title == 'Save'){
				$colour = 'success';
				$icon = 'ft-save';
			}
			if($key->activity_title == 'Edit'){
				$colour = 'warning';
				$icon = 'ft-edit';
			}
			if($key->activity_title == 'Delete'){
				$colour = 'danger';
				$icon = 'ft-x-square';
			}
			
			$html .= '<li class="timeline-item">
                        <div class="timeline-badge"><span data-toggle="tooltip" data-placement="right" title="'.$key->activity_title.'" class="bg-'.$colour.' bg-lighten-1"><i class="'.$icon.'"></i></span></div>
                        <div class="col s9 recent-activity-list-text"><a href="#" class="deep-'.$colour.'-text medium-small">'.time_elapsed_string($key->created_at).'</a>
                          <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">'.$key->log_report.'</p>
                        </div>
                      </li>';
		}
	}
	return $html;
}

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
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
 // get last record of the table
 function getLastRecord($model,$array,$id){
	 $CI =& get_instance();
	 $data = $CI->$model->order_by('id', 'DESC')->get_many_by($array);
	 return $data[0]->$id;
 }
 
 function funcdiff($date2, $date1) {
    $now        = strtotime($date2);
    $your_date  = strtotime($date1);
    $datediff   = $now - $your_date;
    return floor($datediff / (60 * 60 * 24));
}

function countCategoryBooks($id){
	$CI =& get_instance();
	$countBooks = 0;
	$books = $CI->Books_m->get_many_by(array('cateid'=>$id));
	foreach($books as $key){
		$purchasecount = $CI->Purchasebooksline_m->count_by(array('bookid'=>$key->id));
		$countBooks += $purchasecount;
	}
	return $countBooks;
}

function dailypapercheck($paperid, $fulldate){
	$CI =& get_instance();
	$currentdate = date('Y-m-d');
	if(strtotime($fulldate) > strtotime($currentdate)){
		$rsl = '<i class="ft-minus-circle primary"></i>';
	}else{
		$data = $CI->Dailyregister_m->get_many_by(array('magazineid'=>$paperid, 'reciveddate'=> date('Y-m-d', strtotime($fulldate))));
		if(count($data)){
			$rsl = '<a href="'.site_url('office/papermagazineregister/delete/'.$data[0]->id).'" onClick="return confirm(\'Do you want to delete this record?\')"><i class="ft-check success"></i></a>';	
		}else{
			$rsl = '<a href="'.site_url('office/papermagazineregister/savesingledata/'.$paperid.'/'.date('Y-m-d', strtotime($fulldate))).'"><i class="ft-x danger"></i></a>';
		}
	}
	return $rsl;
}

function dailypapercheckprint($paperid, $fulldate){
	$CI =& get_instance();
	$currentdate = date('Y-m-d');
	if(strtotime($fulldate) > strtotime($currentdate)){
		$rsl = '*';
	}else{
		$data = $CI->Dailyregister_m->get_many_by(array('magazineid'=>$paperid, 'reciveddate'=> date('Y-m-d', strtotime($fulldate))));
		if(count($data)){
			$rsl = '<span style="color:#009;font-weight:bold;">Y</span>';	
		}else{
			$rsl = '<span style="color:#900;">N</span>';
		}
	}
	return $rsl;
}

function cash_in_hand($date = NULL){
	if($date){
		$searchdt = date('Y-m-d', strtotime($date));
	}else{
		$searchdt = date('Y-m-d');
	}
	$CI =& get_instance();
	$accounts =  $CI->Accountsopen_m->get(1);
	$openingBalance = $accounts->cash_in_hand;
	$trans = $CI->Transactions_m->get_many_by(array('tran_date >='=>$accounts->opening_date, 'tran_date <='=>$searchdt));
	$incomes = 0;
	$expenses = 0;
	foreach($trans as $keys){
		if(getsingledata('Incomexpense_m','type',$keys->perticular_id) =='Income' && getsingledata('Incomexpense_m','bank_item',$keys->perticular_id) == 0){
			$incomes += $keys->tran_amount;
		}
		if(getsingledata('Incomexpense_m','type',$keys->perticular_id) =='Expense' && getsingledata('Incomexpense_m','bank_item',$keys->perticular_id) == 0){
			$expenses += $keys->tran_amount;
		}
	}
	$total = ($openingBalance + $incomes) - $expenses;
	return $total;
}

function cash_at_bank($date = NULL){
	if($date){
		$searchdt = date('Y-m-d', strtotime($date));
	}else{
		$searchdt = date('Y-m-d');
	}
	$CI =& get_instance();
	$accounts =  $CI->Accountsopen_m->get(1);
	$openingBalance = $accounts->cash_at_bank;
	$trans = $CI->Transactions_m->get_many_by(array('tran_date >='=>$accounts->opening_date, 'tran_date <='=>$searchdt));
	$incomes = 0;
	$expenses = 0;
	foreach($trans as $keys){
		if(getsingledata('Incomexpense_m','type',$keys->perticular_id) =='Income' && getsingledata('Incomexpense_m','bank_item',$keys->perticular_id) == 1){
			$incomes += $keys->tran_amount;
		}
		if(getsingledata('Incomexpense_m','type',$keys->perticular_id) =='Expense' && getsingledata('Incomexpense_m','bank_item',$keys->perticular_id) == 1){
			$expenses += $keys->tran_amount;
		}
	}
	$total = ($openingBalance + $incomes) - $expenses;
	return $total;
}

function monthlyitemtotal($startdate, $enddate, $itemid){
	$startdate = date('Y-m-d', strtotime($startdate));
	$enddate = date('Y-m-d', strtotime($enddate));
	$CI =& get_instance();
	$trans = $CI->Transactions_m->get_many_by(array('perticular_id'=>$itemid,'tran_date >='=>$startdate, 'tran_date <='=>$enddate));
	$total = 0;
	foreach($trans as $keys){
		$total += $keys->tran_amount;
	}
	return $total;
}



