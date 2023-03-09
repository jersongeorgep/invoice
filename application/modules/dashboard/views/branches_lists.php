<!-- DataTables -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">

<div class="row">
  <div class="col-12">
    <div class="card">
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped table-sm text-sm">
          <thead>
            <tr>
              <th class="text-center" width="7%">Sl. No.</th>
              <th class="text-center" width="2%"><input type="checkbox" id="select_all" name="select_all"></th>
              <th class="text-center" >Branch Name</th>
              <th width="20%" class="text-center" >Cash-in-Hand</th>
              <th width="20%" class="text-center" >Cash-in-Bank</th>
            </tr>
          </thead>
          <tbody id="show_data">
            <?php 
              $total = 0;
              $bankTotal = 0;
              if ($branches) :
              $sl_no = 1;

            ?>
              <?php foreach ($branches as $value) : 
                $total  += cash_in_hand($value->id);
                $bankTotal += cash_at_bank($value->id);
                ?>
                <tr>
                  <td class="text-center"><?= $sl_no; ?></td>
                  <td class="text-center"><input type="checkbox" name="ids[]" id="ids_<?= $value->id; ?>" value="<?= $value->id; ?>" /></td>
                  <td><?= $value->branch_name; ?></td>
                  <td class="text-right"><i class="fa fa-rupee-sign"></i> <span class="text-md text-bold"> <?= cash_in_hand($value->id);?></span></td>
                  <td class="text-right"><i class="fa fa-rupee-sign"></i> <span class="text-md text-bold"> <?= cash_at_bank($value->id);?></span></td>
                </tr>
              <?php
                $sl_no++;
              endforeach; ?>
            <?php endif; ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="text-right text-lg">Grand Total</th>
              <th class="text-lg text-right"> <i class="fa fa-rupee-sign"></i><?= $total; ?></th>
              <th class="text-lg text-right"> <i class="fa fa-rupee-sign"></i><?= $bankTotal; ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>

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

<script>
  $(function() {
    $("#example1").DataTable({
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
      if (post_arr.length > 0) {
        if (confirm("Do you really want to delete records?")) {
          $.ajax({
            type: "POST",
            url: base_url + "branches/delete_branch",
            async: false,
            cache: false,
            data: {
              ids: post_arr
            },
            success: function(response) {
              $data = JSON.parse(response);
              if($data.status != 201){
                $.each(post_arr, function(i, l) {
                  $("#ids_" + l).closest('tr').remove();
                });
                toastr.error($data.msg);
                window.location.reload();
              }else{
                toastr.error($data.msg);
              }
            }
          });
        }
      } else {
        alert("Please select rows for delete");
      }
    });

  });
</script>