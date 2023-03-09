<form method="POST" action="<?= site_url('masters/vendors/update_vendor/'.$vendor->id); ?>" enctype="multipart/form-data" id="vendorsForm">
    <div class="card-body row">
        <div class="form-group col-sm-6">
            <label for="name">Name <sup class="text-danger">*</sup></label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?= $vendor->name; ?>">
        </div>
        <div class="form-group col-sm-6">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" id="address" placeholder="Address" value="<?= $vendor->address; ?>">
        </div>
        <div class="form-group col-sm-6">
            <label for="post_code">PIN Code<sup class="text-danger">*</sup></label>
            <input type="text" name="post_code" class="form-control" id="post_code" placeholder="PIN Code" value="<?= $vendor->post_code; ?>">
        </div>
        <div class="form-group col-6">
            <label for="post_office">Post Office <sup class="text-danger">*</sup></label>
            <select name="post_office" id="post_office" class="form-control">
                <option value="<?= $vendor->post_office; ?>"><?= $vendor->post_office; ?></option>
            </select>
        </div>
        <div class="form-group col-sm-4">
            <label for="district">District</label>
            <input type="text" name="district" class="form-control" id="district" placeholder="District" readonly value="<?= $vendor->district; ?>">
        </div>
        <div class="form-group col-sm-4">
            <label for="state">State</label>
            <input type="text" name="state" class="form-control" id="state" placeholder="State" readonly value="<?= $vendor->state; ?>">
        </div>
        <div class="form-group col-sm-4">
            <label for="country">Country</label>
            <input type="text" name="country" class="form-control" id="country" placeholder="Country" readonly value="<?= $vendor->country; ?>">
        </div>
        <div class="form-group col-sm-6">
            <label for="mobile">Mobile <sup class="text-danger">*</sup></label>
            <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Mobile" value="<?= $vendor->mobile; ?>">
        </div>
        <div class="form-group col-sm-6">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="<?= $vendor->email; ?>">
        </div>
        <div class="form-group col-sm-12">
            <label for="gst_no">GST No</label>
            <input type="text" name="gst_no" class="form-control" id="gst_no" placeholder="GST No" value="<?= $vendor->gst_no; ?>">
        </div>
        <div class="form-group col-sm-4">
            <label for="contact_person">Contact Person</label>
            <input type="text" name="contact_person" class="form-control" id="contact_person" placeholder="Contact Person" value="<?= $vendor->contact_person; ?>">
        </div>
        <div class="form-group col-sm-4">
            <label for="owner">Owner</label>
            <input type="text" name="owner" class="form-control" id="owner" placeholder="Owner" value="<?= $vendor->owner; ?>">
        </div>
        <div class="form-group col-sm-4">
            <label for="opening_balance">Opening Balance</label>
            <input type="text" name="opening_balance" class="form-control" id="opening_balance" placeholder="Opening Balance" value="<?= $vendor->opening_balance; ?>">
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
        $('#vendorsForm').validate({
            rules: {
                name: {
                    required: true
                },
                post_code: {
                    required: true
                },
                post_office: {
                    required: true
                },
                mobile: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Please enter vendor",
                },
                post_code: {
                    required: "Please enter post code",
                },
                post_office: {
                    required: "Please choose post office",
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

        $('#post_code').change(function() {
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