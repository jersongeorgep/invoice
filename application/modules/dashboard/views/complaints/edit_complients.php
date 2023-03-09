<link rel="stylesheet" href="<?= site_url('assets/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" href="<?= site_url('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); ?>">
<!-- Bootstrap 4 -->
<script src="<?= site_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/moment/moment.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); ?>"></script>

<form method="POST" action="<?= site_url('dashboard/complaints/update_complaints/'.$complaints->id); ?>" enctype="multipart/form-data" id="categoriesForm">
    <div class="card-body">
        <div class="row">
            <div class="form-group col-6">
                <label for="complaint_date_time">Date Time <sup class="text-danger">*</sup></label>
                <div class="input-group date" id=complaint_date_time" data-target-input="nearest" readonly>
                    <input type="text" class="form-control form-control-sm datetimepicker-input" id="complaint_date_time" name="complaint_datetime" placeholder="Complaint Date" data-target="#complaint_date_time" value="<?= date('d-m-Y h:i a', strtotime($complaints ->complaint_datetime)); ?>" />
                    <div class="input-group-append" data-target="#complaint_date_time" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            <div class="form-group col-6">
                <label for="branch_id">Branch <sup class="text-danger">*</sup></label>
                <select class="form-control form-control-sm select2" name="branch_id" id="branch_id">
                    <option value="">Select</option>
                    <?php if (!empty($branches)) :  foreach ($branches as $branch) : ?>
                            <option value="<?= $branch->id; ?>" <?= (($branch->id == $complaints->branch_id)?"selected" : "") ?>><?= $branch->branch_name; ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="form-group col-12">
                <label for="complaints">Complaints <sup class="text-danger">*</sup></label>
                <textarea name="complaints" class="form-control form-control-sm" id="complaints" placeholder="Complaints"><?= $complaints->complaints; ?></textarea>
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
<script src="<?= site_url('assets/plugins/select2/js/select2.full.min.js'); ?>"></script>
<script src="<?= site_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<script>
    $(function() {
        $('input').attr('autocomplete', 'off');
        $('.select2').select2();

        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy'
        });

        //Date and time picker
        $('#complaint_date_time').datetimepicker({
            icons: {
                time: 'far fa-clock'
            },
            format: "DD-MM-YYYY hh:mm A"
        });


        $('#categoriesForm').validate({
            rules: {
                complaint_datetime: {
                    required: true
                },
                branch_id: {
                    required: true
                },
                complaints: {
                    required: true
                },
            },
            messages: {
                complaint_datetime: {
                    required: "Please choose date",
                },
                branch_id: {
                    required: "Please choose branch",
                },
                complaints: {
                    required: "Please enter Complint",
                },
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