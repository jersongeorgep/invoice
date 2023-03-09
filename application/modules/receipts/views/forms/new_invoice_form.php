<!-- Select2 -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>">

<form method="POST" action="<?= site_url('receipts/tax-invoice/save'); ?>" enctype="multipart/form-data"
    id="invoiceForm">
    <div class="card-body row">
        <div class="form-group col-sm-4">
            <label for="ref_no">Ref. No.</label>
            <input type="text" name="ref_no" class="form-control form-control-sm" id="ref_no" placeholder="Ref. NO" value="<?= auto_num("INV_",'invoices', 'ref_no', 1000); ?>" readonly>
        </div>
        <div class="form-group col-sm-4">
            <label for="invoice_date">Date<sup class="text-danger">*</sup></label>
            <input type="text" name="invoice_date" id="invoice_date" class="form-control form-control-sm datepicker"  placeholder="Date">
        </div>
        <div class="form-group col-sm-4">
            <label for="mobile">Mobile No.<sup class="text-danger">*</sup></label>
            <input type="text" name="mobile" class="form-control form-control-sm" id="mobile" placeholder="Mobile No.">
        </div>
        <div class="form-group col-sm-6">
            <label for="customer_name">Customer <sup class="text-danger">*</sup></label>
            <input type="text" name="customer_name" class="form-control form-control-sm" id="customer_name" placeholder="Customer Name" >
        </div>
        <div class="form-group col-sm-6">
            <label for="total_amount">Total Amount</label>
            <input type="text" name="total_amount" class="form-control form-control-sm" id="total_amount" placeholder="Total Amount" readonly>
        </div>
        <div class="form-group col-sm-12 table-responsive">
            <table class="table table-bordered table-hover table-striped table-sm">
                <thead>
                    <tr>
                        <th class=" text-center" width="6%">Sl.No</th>
                        <th class=" text-center">Particulars</th>
                        <th class=" text-center" width="8%">Unit</th>
                        <th class=" text-center" width="10%">Qty</th>
                        <th class=" text-center" width="10%">Rate (<span><i class="fa fa-dollar-sign text-xs"></i></span>)</th>
                        <th class=" text-center" width="10%">Total (<span><i class="fa fa-dollar-sign text-xs"></i></span>)</th>
                        <th class=" text-center" width="10%">Tax (<span><i class="fa fa-percentage text-xs"></i></span>)</th>
                        <th class=" text-center" width="11%">Sub Total (<span><i class="fa fa-dollar-sign text-xs"></i></span>)</th>
                        <th class=" text-center" width="5%">Action</th>
                    </tr>
                </thead>
                <tbody id="line_items_list">
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class=" text-right"> TOTAL </th>
                        <th class=" text-right"><input type="text" class="form-control form-control-sm text-right" name="total_value" id="total_value" readonly /></th>
                        <th class=" text-right"><input type="text" class="form-control form-control-sm text-right" name="tax_total_value" id="tax_total_value" readonly /></th>
                        <th class=" text-right"><input type="text" class="form-control form-control-sm text-right" name="grand_total" id="grand_total" readonly /></th>
                        <th><button id="add_line_item" name="add_line_item" type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button></th>
                    </tr>
                    <tr>
                        <th colspan="5" class=" text-right text-lg"> Dis. Amt. </th>
                        <th colspan="3"><input type="text" class="form-control text-lg text-right" name="dis_amount" id="dis_amount" onchange="discountAmount()"  /></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="5" class=" text-right text-lg"> GRAND TOTAL </th>
                        <th colspan="3"><input type="text" class="form-control text-lg text-right" name="grandTotal" id="grandTotal" readonly /></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
<script src="<?= site_url('assets/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/jquery-validation/additional-methods.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/select2/js/select2.full.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<script>
$(function() {
    $('input').attr('autocomplete','off');
    $('.select2').select2();
    $('.datepicker').datepicker({
        format : 'dd-mm-yyyy'
    });
    $('#invoiceForm').validate({
        rules: {
            ref_no: {
                required: true
            },
            invoice_date: {
                required: true
            },
            mobile: {
                required: true
            },
            customer_name: {
                required: true
            }
            
        },
        messages: {
            ref_no: {
                required: "Please enter Bill Number",
            },
            invoice_date: {
                required: "Please enter invoice date",
            },
            mobile: {
                required: "Please enter customer mobile",
            },
            customer_name: {
                required: "Please enter customer name",
            }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

   
    var i = $('#line_items_list tr').length;
    $('#add_line_item').click(function() {
        i++;
        var line_item_html = `
            <tr>
            <td class="text-center">` + i +
            `</td>
            <td><input type="text" name="products[]" id="products_` + i +`" class="form-control form-control-sm" required />`+
            `</td>
            <td><input type="text" class="form-control form-control-sm text-center" name="units[]" id="unit_` + i +`" placeholder="0" /></td>
            <td><input type="text" class="form-control form-control-sm text-center" onChange="getLineSum(` + i +`)" name="qty[]" id="qty_` + i +`" placeholder="0" /></td>
            <td><input type="text" class="form-control form-control-sm text-right" onChange="getLineSum(` + i +`)" name="rate[]" id="rate_` + i +`" placeholder="0.00"  /></td>
            <td><input type="text" class="form-control form-control-sm text-right" onChange="getLineSum(` + i +`)" name="total[]" id="total_` + i +`" placeholder="0.00" readonly/></td>
            <td><input type="text" class="form-control form-control-sm text-right" onChange="getLineSum(` + i +`)" name="tax_amt[]" id="tax_amount_` + i +`" placeholder="0%"  /></td>
            <td><input type="text" class="form-control form-control-sm text-right" onChange ="getLineSum(` + i +`)" name="amount[]" id="amount_` + i +`" placeholder="0.00" readonly/></td>
            <td><button type="button" id="remove_line_` + i + `" onClick="remove_line(` + i + `)" class="btn btn-sm btn-danger"><i class=" fa fa-minus-circle"></i></button></td>
            </tr>`;
        $('#line_items_list').append(line_item_html);
    });
});

/* Remove Line Item */
function remove_line(line_id) {
    $('#remove_line_' + line_id).closest('tr').remove();
    getLineSum(line_id);
}
/* get unit */
function get_unit(productId, lineId){
    $.ajax({
        type    : "POST",
        url     : base_url + "purchase/get_unit",
        data    : "product_id="+productId,
        success : function(result){
            var data = JSON.parse(result);
            $('#unit_'+lineId).val(data.short_name);
        }
    });
}

function getLineSum(line_id){
    var line_qty        = $('#qty_'+line_id).val();
    var line_rate       = $('#rate_'+line_id).val();
    var line_taxAmout   = $('#tax_amount_'+line_id).val();

    var qty = (line_qty)? parseInt(line_qty): 0 ;
    var rate = (line_rate)? parseFloat(line_rate) : 0;
    var tax_amount = ((line_taxAmout)? parseFloat(line_taxAmout):0)

    var totalAmt = qty * rate ;
    var line_tax_value = (totalAmt * tax_amount) / 100;
    var lineTotal = totalAmt + line_tax_value ;
    $('#total_'+line_id).val(totalAmt.toFixed(2));
    $('#amount_'+line_id).val(lineTotal.toFixed(2));

    var totalAmt = findSum('total');
    var totalTax = findSum('tax_amt');
    var totalAmount = findSum('amount');

    var discount = $('#dis_amount').val();

    var discountTotal = totalAmount - discount;

    $('#total_value').val(totalAmt.toFixed(2));
    $('#tax_total_value').val(totalTax);
    $('#grand_total').val(totalAmount.toFixed(2));
    $('#grandTotal').val(discountTotal.toFixed(2));
    $('#total_amount').val(discountTotal.toFixed(2));
}

function discountAmount(){
    var discount = $('#dis_amount').val();

    var totalAmt = findSum('total');
    var totalTax = findSum('tax_amt');
    var totalAmount = findSum('amount');

    var discountTotal = totalAmount - discount;

    $('#total_value').val(totalAmt.toFixed(2));
    $('#tax_total_value').val(totalTax);
    $('#grand_total').val(totalAmount.toFixed(2));
    $('#grandTotal').val(discountTotal.toFixed(2));
    $('#total_amount').val(discountTotal.toFixed(2));
}

function findSum(feildID) {
    var sum = 0;
    $('input[name="' + feildID + '[]"]').each(function() {
        sum += Number($(this).val());
    });
    return sum;
}
</script>