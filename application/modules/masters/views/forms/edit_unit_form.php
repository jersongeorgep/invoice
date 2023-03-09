<form method="POST" action="<?= site_url('masters/units/update_unit/'.$unit->id); ?>" enctype="multipart/form-data" id="unitForm">
    <div class="card-body">
        <div class="form-group">
            <label for="name">Name <sup class="text-danger">*</sup></label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?= $unit->name; ?>">
        </div>
        <div class="form-group">
            <label for="short_name">Short Name <sup class="text-danger">*</sup></label>
            <input type="text" name="short_name" class="form-control" id="short_name" placeholder="Short Name" value="<?= $unit->short_name; ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control" id="description" placeholder="Description" value="<?= $unit->description; ?>">
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