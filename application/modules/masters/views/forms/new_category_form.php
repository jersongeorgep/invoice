<form method="POST" action="<?= site_url('masters/categories/save_category'); ?>" enctype="multipart/form-data" id="categoriesForm">
    <div class="card-body">
        <div class="form-group">
            <label for="category_name">Category Name <sup class="text-danger">*</sup></label>
            <input type="text" name="category_name" class="form-control" id="category_name" placeholder="Category Name">
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
                category_name: {
                    required: true
                }
            },
            messages: {
                category_name: {
                    required: "Please enter name",
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