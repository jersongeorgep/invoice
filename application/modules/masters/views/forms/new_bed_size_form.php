<form method="POST" action="<?= site_url('masters/bed_size/save_size'); ?>" enctype="multipart/form-data" id="roleForm">
    <div class="card-body">
        <div class="form-group">
            <label for="name">Size <sup class="text-danger">*</sup></label>
            <input type="text" name="size" class="form-control" id="size" placeholder="Size">
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
        $('input').attr('autocomplete', 'off');
        $('#roleForm').validate({
            rules: {
                size: {
                    required: true
                }
            },
            messages: {
                size: {
                    required: "Please enter size",
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