<!-- Select2 -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>">

<form method="POST" action="<?= site_url('masters/Laundries/save_laundry'); ?>" enctype="multipart/form-data" id="vendorsForm">
    <div class="card-body row">
    <div class="form-group col-4">
            <label for="branch_id">Branch <sup class="text-danger">*</sup></label>
            <select name="branch_id" id="branch_id" class="form-control select2">
                <option value="">Select</option>
                <?php if(!empty($branches)): ?>
                    <?php foreach($branches as $value):?>
                        <option value="<?= $value->id; ?>"><?= $value->branch_name; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group col-sm-8">
            <label for="name">Laundry Name <sup class="text-danger">*</sup></label>
            <input type="text" name="laundry_name" class="form-control form-control-sm" id="laundry_name" placeholder="Name">
        </div>
        <div class="form-group col-sm-4">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control form-control-sm" id="address" placeholder="Address">
        </div>
        <div class="form-group col-sm-4">
            <label for="pin_code">PIN Code</label>
            <input type="text" name="pin_code" class="form-control form-control-sm" id="pin_code" placeholder="PIN Code">
        </div>
        <div class="form-group col-4">
            <label for="post_office">Post Office</label>
            <select name="post_office" id="post_office" class="form-control form-control-sm">
                <option value="">Select</option>
            </select>
        </div>
        <div class="form-group col-sm-4">
            <label for="district">District</label>
            <input type="text" name="district" class="form-control form-control-sm" id="district" placeholder="District" readonly>
        </div>
        <div class="form-group col-sm-4">
            <label for="state">State</label>
            <input type="text" name="state" class="form-control form-control-sm" id="state" placeholder="State" readonly>
        </div>
        <div class="form-group col-sm-4">
            <label for="country">Country</label>
            <input type="text" name="country" class="form-control form-control-sm" id="country" placeholder="Country" readonly>
        </div>
        <div class="form-group col-sm-4">
            <label for="mobile">Mobile <sup class="text-danger">*</sup></label>
            <input type="text" name="mobile" class="form-control form-control-sm" id="mobile" placeholder="Mobile">
        </div>
        <div class="form-group col-sm-4">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control form-control-sm" id="email" placeholder="Email">
        </div>
        <div class="form-group col-sm-4">
            <label for="gst_number">GST No</label>
            <input type="text" name="gst_number" class="form-control form-control-sm" id="gst_number" placeholder="GST No">
        </div>
        <div class="form-group col-sm-4">
            <label for="contact_person">Contact Person</label>
            <input type="text" name="contact_person" class="form-control form-control-sm" id="contact_person" placeholder="Contact Person">
        </div>
        <div class="form-group col-sm-4">
            <label for="owner_name">Owner</label>
            <input type="text" name="owner_name" class="form-control form-control-sm" id="owner_name" placeholder="Owner">
        </div>
        <div class="form-group col-sm-4">
            <label for="opening_balance">Opening Balance</label>
            <input type="text" name="opening_balance" class="form-control form-control-sm" id="opening_balance" placeholder="Opening Balance">
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
        $('#vendorsForm').validate({
            rules: {
                branch_id :{
                    required: true
                },
                laundry_name: {
                    required: true
                },
                mobile: {
                    required: true
                },
            },
            messages: {
                branch_id :{
                    required: "Please select Branch"
                },
                laundry_name: {
                    required: "Please enter Laundry",
                },
                mobile: {
                    required: "Please enter mobile",
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

        $('#pin_code').change(function() {
            var pin_code = this.value;
            $.ajax({
                type: "POST",
                url: base_url + "settings/get_post_office",
                data: "pin_code=" + pin_code,
                cache: false,
                async: false,
                success: function(result) {
                    $('#post_office').empty();
                    var html = '<option value=""> Select </option>'
                    var data = JSON.parse(result);
                    var rslt = data[0].PostOffice
                    for (var i = 0; i < rslt.length; i++) {
                        html += '<option value="' + rslt[i].Name + '"> ' + rslt[i].Name + ' </option>';
                    }
                    $('#post_office').append(html);
                    $('#district').val(rslt[0].District);
                    $('#state').val(rslt[0].State);
                    $('#country').val(rslt[0].Country);
                }
            });
        });
    });
</script>