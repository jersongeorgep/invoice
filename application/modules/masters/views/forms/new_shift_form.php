<!-- Select2 -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>">

<form method="POST" action="<?= site_url('masters/shifts/save_shift'); ?>" enctype="multipart/form-data" id="categoriesForm">
    <div class="card-body row">
        <div class="form-group col-4">
            <label for="title">Title <sup class="text-danger">*</sup></label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Title">
        </div>
        <div class="form-group col-4">
            <label for="category_name">Start Time</label>
            <input type="time" name="start_time"  class="form-control" id="start_time" placeholder="Start Time">
        </div>
        <div class="form-group col-4">
            <label for="category_name">End Time</label>
            <input type="time" name="end_time" class="form-control" id="end_time" placeholder="End Time">
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
        $('.datepicker').datepicker({
            dateFormat: '',
            timeFormat: 'HH:mm',
        });

        $('#categoriesForm').validate({
            rules: {
                title: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: "Please enter title",
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