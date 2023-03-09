<form method="POST" action="<?= site_url('masters/item/update_item/'.$item->id); ?>" enctype="multipart/form-data" id="unitForm">
    <div class="card-body">
        <div class="form-group">
            <label for="name">Name <sup class="text-danger">*</sup></label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?= $item->name; ?>">
        </div>
        <div class="form-group">
            <label for="amount">Amount <sup class="text-danger">*</sup></label>
            <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount" value="<?= $item->amount; ?>">
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
});
            </script>