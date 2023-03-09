<!-- Select2 -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>">

<form method="POST" action="<?= site_url('dashboard/save_note'); ?>" enctype="multipart/form-data" id="employeeForm">
    <div class="card-body p-0">
        <div class="row">
            <div class="form-group col-sm-12">
                <label for="title">Title <sup class="text-danger">*</sup></label>
                <input type="text" name="title" class="form-control form-control-sm" id="title" placeholder="Title">
            </div>
            <div class="form-group col-sm-12">
                <label for="notes">Note <sup class="text-danger">*</sup></label>
                <textarea class="form-control form-control-sm" name="notes" id="notes" rows="5"></textarea>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <input type="hidden" name="branch_id" value="<?= $this->session->userdata('branch_id'); ?>">
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
            format: 'dd-mm-yyyy'
        });
        $('#employeeForm').validate({
            rules: {
                title: {
                    required: true
                },
                notes: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: "Please enter title",
                },
                notes: {
                    required: "Please enter note",
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