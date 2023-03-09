<form method="POST" action="<?= site_url('masters/item/save_item'); ?>" enctype="multipart/form-data" id="unitForm">
    <div class="card-body">
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-sm table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="7%">Sl.No.</th>
                            <th class="text-center">Particulars <sup class="text-danger">*</sup></th>
                            <th class="text-center" width="20%">Price <sup class="text-danger">*</sup></th>
                            <th class="text-center" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="show_items">
                        <tr>
                            <td class="text-center">1</td>
                            <td><input type="text" name="name[]" class="form-control form-control-sm" id="name_1" placeholder="Item"></td>
                            <td><input type="text" name="amount[]" class="form-control form-control-sm" id="amount_1" placeholder="Price"></td>
                            <td class="text-center"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3"></th>
                            <th class="text-center"><button id="add_line_item" type="button"class="btn btn-xs btn-flat btn-success"> <i class="fa fa-plus"></i></button></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
<script src="<?= site_url('assets/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/jquery-validation/additional-methods.min.js'); ?>"></script>
<script>
    $(function() {
        $('input').attr('autocomplete','off');
        $('#unitForm').validate({
        rules: {
            name: {
                required: true
            },
            short_name: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter name",
            },
            short_name: {
                required: "Please enter short name",
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
    $('#add_line_item').on('click', function(){
        var slno = parseInt($('#show_items tr').length) + 1;
        var previouseLine = parseInt($('#show_items tr').length);
        if($('#name_'+previouseLine).val() != "" && $('#amount_'+previouseLine).val() != ""){
            var html = `<tr>
                        <td class="text-center">`+ slno +`</td>
                        <td><input type="text" name="name[]" class="form-control form-control-sm" id="name_`+ slno +`" placeholder="Item"></td>
                        <td><input type="text" name="amount[]" class="form-control form-control-sm" id="amount_`+ slno +`" placeholder="Price"></td>
                        <td class="text-center"><button type="button" id="delete_btn_`+ slno +`" onclick ="remove_line(`+ slno +`)" class="btn btn-xs btn-flat btn-danger"><i class="fa fa-trash"></i></button></td>
                        </tr>`;
            $('#show_items').append(html);
        }else{
            toastr.error("Please enter required fields");
        }
    });
});

function remove_line(line_id){
    $('#delete_btn_'+line_id).closest('tr').remove();
}
</script>