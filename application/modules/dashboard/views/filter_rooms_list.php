<!-- Select2 -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>">

<!-- DataTables -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
<style>
    .info-box .info-box-content {
        line-height: 1.05;
    }

    .info-box {
        align-items: center;
        flex-direction: column;
    }
</style>
<?php if(!empty($branches)): 
    $i = 0;
    foreach($branches as $branches):
        $rooms = $this->db->select('r.*, rs.room_status as current_status')->from('lms_room as r')->join('lms_room_status as rs', 'rs.id = r.room_status', 'left')->where('r.room_status',$status)->where('r.branch_id',$branches->id)->get()->result();
        (($i == 10)? $i = 0: "");
        if($branches->id != 1):
?>
<div class="row">
    <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-<?= $colors[$i]; ?> card-tabs">
                            <div class="card-header">
                                <h3 class="card-title"><?= strtoupper($branches->branch_name); ?></h3>
                            </div>
                            
                            <div class="card-body">
                            <?php if ($rooms) : ?>
                                            <div class="row">
                                                <?php foreach ($rooms as $val) :
                                                if($val->room_status == 1){
                                                    $url    = site_url('booking/checkin-new/popup_booking_form/'. $val->id.'/'.$val->branch_id);
                                                    $title  = 'Room Booking';
                                                }else if($val->room_status == 2){
                                                    $url    = site_url('booking/checkin-new/popup_payments_form/'. $val->id.'/'.$val->branch_id);
                                                    $title  = 'Occupied Room Details';
                                                }else{
                                                    $url    = site_url('booking/check-rooms/change_room_status/'. $val->id.'/'.$val->branch_id);
                                                    $title  = 'Change Room status';
                                                }   
                                                ?>
                                                    <div class="col-md-3 col-sm-3 col-3" style="cursor: pointer;" onclick="show_popup('<?= $url; ?>', '<?= $title; ?>', 'modal-xl')">
                                                        <div class="d-flex justify-content-center align-content-center flex-row border rounded p-2 mb-3 shadow-sm">
                                                            <div class="col-5"><img src="<?= site_url('assets/dist/img/room_photo.jpg')?>" class="img img-thumbnail img-fluid rounded" alt=""></div>
                                                            <div class="col-7 d-flex flex-column">
                                                                <span class="text-bold  text-<?= status_color($val->room_status); ?> text-sm"><?= strtoupper($val->current_status); ?></span>
                                                                <span class="text-sm text-bold" style="margin-top:-5px"><?= ucfirst($val->floor_no); ?> Floor</span>
                                                                <span class="text-sm"><?= $val->type; ?></span>
                                                                <span class="btn btn-dark btn-flat btn-xs text-bold">BOOK NOW</span>
                                                                <span class="text-center"><i class="fa fa-rupee-sign"></i> <span class="text-md text-bold"><?= $val->price; ?>/-</span></span>
                                                            </div>
                                                            <div class="ribbon-wrapper ribbon-md mr-2">
                                                                <div class="ribbon bg-<?= status_color($val->room_status); ?> text-lg text-bold"><?= $val->room_no; ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="row">
                                                <div class="col-12 text-center">No rooms found</div>
                                            </div>
                                        <?php endif; ?>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
    </div>
</div>
<?php
    endif;
    $i++;
    endforeach; 
endif; 
?>
    <!-- DataTables  & Plugins -->
    <script src="<?= site_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/jszip/jszip.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/pdfmake/pdfmake.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/pdfmake/vfs_fonts.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>

    <script src="<?= site_url('assets/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/jquery-validation/additional-methods.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/select2/js/select2.full.min.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>

    <script>
        $(function() {

        $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });

            $('.select2').select2();

            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy'
            });

            $("#booking_table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                //"buttons": ["csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $("#select_all").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $('#delete_btn').on('click', function() {
                var post_arr = [];
                $('#show_data input[type=checkbox]').each(function() {
                    if (jQuery(this).is(":checked")) {
                        var id = this.value;
                        post_arr.push(id);
                    }
                });
                console.log(post_arr);
                if (post_arr.length > 0) {
                    if (confirm("Do you really want to delete records?")) {
                        $.ajax({
                            type: "POST",
                            url: base_url + "accounts/cash-to-bank/delete-cash-to-bank",
                            async: false,
                            cache: false,
                            data: {
                                ids: post_arr
                            },
                            success: function(response) {
                                $.each(post_arr, function(i, l) {
                                    $("#ids_" + l).closest('tr').remove();
                                });
                                toastr.error("Data Deleted");
                            }
                        });
                    }
                } else {
                    alert("Please select rows for delete");
                }
            });

        });

        function get_filter_data() {
            var form_data = $('#filter_Form').serializeArray();
            $.ajax({
                type: "POST",
                url: base_url + "accounts/daybook/get_daybook_data",
                data: form_data,
                cache: false,
                async: false,
                success: function(response) {
                    $('#show_data').html(response);

                }
            });
        }
    </script>