<form method="POST" action="<?= site_url('masters/income-expense-type/update_head/'.$head->id); ?>" enctype="multipart/form-data" id="categoriesForm">
    <div class="card-body row">
        <div class="form-group col-4">
            <label for="heads">Head Name <sup class="text-danger">*</sup></label>
            <input type="text" name="heads" class="form-control" id="heads" placeholder="Head Name" value="<?= $head->heads; ?>">
        </div>
        <div class="form-group col-4">
            <label for="behavior">Behavior <sup class="text-danger">*</sup></label>
            <select name="behavior" id="behavior" class="form-control select2-search">
                <option value="">Select Behavior</option>
                <?php foreach($behaviors as $val):?>
                    <option value="<?= $val; ?>" <?= (($head->behavior == $val)? "selected" : ""); ?>><?= ucfirst($val); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-4">
            <label for="txn_type">Txn Type <sup class="text-danger">*</sup></label>
            <select name="txn_type" id="txn_type" class="form-control select2-search">
                <option value="">Select Type</option>
                <?php foreach($txn_type as $val1):?>
                    <option value="<?= $val1; ?>" <?= (($head->txn_type == $val1)? "selected" : ""); ?>><?= ucfirst($val1); ?></option>
                <?php endforeach; ?>
            </select>
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
        $('#categoriesForm').validate({
        rules: {
            heads: {
                required: true
            },
            behavior: {
                required: true
            },
            txn_type:{
                required: true
            }
        },
        messages: {
            heads: {
                required: "Please enter Head",
            },
            behavior: {
                required: "Please choose behavior",
            },
            txn_type:{
                required: "Please choose txn type"
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
});
            </script>