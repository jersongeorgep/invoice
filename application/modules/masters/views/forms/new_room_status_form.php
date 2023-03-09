<form method="POST" action="<?= site_url('masters/room-status/save-room-status'); ?>" enctype="multipart/form-data" id="roleForm">
    <div class="card-body">
        <div class="form-group">
            <label for="name">Room Status <sup class="text-danger">*</sup></label>
            <input type="text" name="room_status" class="form-control" id="room_status" placeholder="Room Status">
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
                room_status: {
                    required: true
                }
            },
            messages: {
                room_status: {
                    required: "Please enter room status",
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