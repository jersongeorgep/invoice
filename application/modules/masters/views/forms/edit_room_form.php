<!-- Select2 -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>">

<form method="POST" action="<?= site_url('masters/room/update_room/'. $room->id); ?>" enctype="multipart/form-data" id="roomForm">
    <div class="card-body row">
    <div class="form-group col-sm-4">
            <label for="branch_id">Branch <sup class="text-danger">*</sup></label>
            <select class="form-control form-control-sm select2" name="branch_id" id="branch_id">
                <option value=""> Select </option>
                <?php if(!empty($branches)): ?>
                    <?php foreach($branches as $value): ?>
                        <option value="<?= $value->id; ?>" <?= (($value->id == $room->branch_id) ? "selected": ""); ?> ><?= $value->branch_name; ?></option>

                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group col-sm-4">
            <label for="room_no">Room No <sup class="text-danger">*</sup></label>
            <input type="number" name="room_no" class="form-control form-control-sm" id="room_no" placeholder="Room number" value="<?= $room->room_no; ?>">
        </div>
        <div class="form-group col-sm-4">
            <label for="floor_no">Floor No<sup class="text-danger">*</sup></label>
            <select class="form-control form-control-sm select2" name="floor_no" id="floor_no">
                <option value=""> Select </option>
                <?php if(!empty($floors)): ?>
                    <?php foreach($floors as $value): ?>
                        <option value="<?= $value; ?>" <?= (($value == $room->floor_no)? "selected" : "") ?>><?= ucfirst($value); ?></option>

                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group col-sm-4">
            <label for="bathrooms_count">No.of Bathrooms<sup class="text-danger">*</sup></label>
            <input type="number" name="bathrooms_count" class="form-control form-control-sm" id="bathrooms_count" placeholder="No.of Bathrooms" value="<?= $room->bathrooms_count; ?>">
        </div>   
        
        <div class="form-group col-sm-4">
            
            <label for="room_status">Room Status</label>
            <select class="form-control form-control-sm select2" name="room_status" id="room_status">
                <option value=""> Select </option>
                <?php if(!empty($room_status)): ?>
                    <?php foreach($room_status as $value): ?>                        
                        <option value="<?= $value->id; ?>" <?= (($value->id == $room->room_status) ? "selected": ""); ?> ><?= $value->room_status; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        

        <div class="form-group col-sm-4">
            <label for="type">Type <sup class="text-danger">*</sup></label>
            <select class="form-control form-control-sm select2" name="type" id="type">
                <option value=""> Select </option>
                <?php if(!empty($type)): ?>
                    <?php foreach($type as $value): ?>
                        <option value="<?= $value; ?>" <?= (($value == $room->type)? "selected" : "") ?>><?= $value; ?></option>

                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        
       
        <div class="form-group col-sm-4">            
            <label for="bed_size">Bed Size</label>
            <select class="form-control form-control-sm select2" name="bed_size" id="se">
                <option value=""> Select </option>
                <?php if(!empty($sizes)): ?>
                    <?php foreach($sizes as $value): ?>
                        <option value="<?= $value->id; ?>" <?= (($value->id == $room->bed_size) ? "selected": ""); ?> ><?= $value->size; ?></option>

                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
       
        <div class="form-group col-sm-4">
            <label for="price">Price<sup class="text-danger">*</sup></label>
            <input type="text" name="price" class="form-control form-control-sm text-right" id="price" placeholder="0.00" value="<?= $room->price; ?>">
        </div>
        
        <div class="form-group col-sm-4">
            <label for="extra_bed_price">Extra Bed Price<sup class="text-danger">*</sup></label>
            <input type="text" name="extra_bed_price" class="form-control form-control-sm text-right" id="extra_bed_price" placeholder="0.00" value="<?= $room->extra_bed_price; ?>">
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
    $(document).ready(function(){
        
    });

    $(function() {
       
        $('input').attr('autocomplete','off');
        $('.select2').select2();

        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#roomForm').validate({
            rules: {
                room_no: {
                    required: true
                },
                floor_no: {
                    required: true
                },
                bathrooms_count: {
                    required: true
                },               
                room_status: {
                    required: true
                },           
                type: {
                    required: true
                },
                bed_size: {
                    required: true
                },
            },
            messages: {
                
                room_no: {
                    required: "Please enter room no",
                },
                floor_no: {
                    required: "Please enter floor no",
                },
                bathrooms_count: {
                    required: "Please enter number of bathrooms",
                },
                room_status: {
                    required: "Please enter current room status",
                },
                type: {
                    required: "Please enter room type",
                },
                bed_size: {
                    required: "Please enter bed size",
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