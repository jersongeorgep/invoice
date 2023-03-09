<link rel="stylesheet" href="<?= site_url('assets/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">

<form action="" method="POST" id="filter_form" enctype="multipart/form-data">
  <div class="row">
    <div class="col-3">
      <label for="fromDt">From <sub class="text-danger">*</sub></label>
      <input type="text" name="fromDt" id="fromDt" class="form-control form-control-sm datepicker" value="<?= date('d-m-Y'); ?>" />
    </div>
    <div class="col-3">
      <label for="toDt">To <sub class="text-danger">*</sub></label>
      <input type="text" name="toDt" id="toDt" class="form-control form-control-sm datepicker" value="<?= date('d-m-Y'); ?>" />
    </div>
    <div class="col-3 mb-2">
      <label for="branch">Branches <sub class="text-danger">*</sub></label>
      <select class="form-control form-control-sm select2" name="branch" id="branch">
        <option value="">Select</option>
        <?php if ($this->session->userdata('branch_id') == 1) : ?>
          <option value="all">All</option>
        <?php endif; ?>
        <?php if (!empty($branches)) :  foreach ($branches as $branch) : ?>
            <option value="<?= $branch->id; ?>"><?= $branch->branch_name; ?></option>
        <?php endforeach;
        endif; ?>
      </select>
    </div>
    <div class="col-3 pt-2 mt-4">
      <button type="submit" class="btn btn-sm btn-info btn-flat"><i class="fa fa-search"></i> Search </button>
    </div>
  </div>
</form>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><span></span><a href="<?= site_url('dashboard/complaints/add_new'); ?>" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> New </a> <button type="button" id="delete_btn" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete </button></span></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped table-sm">
          <thead>
            <tr>
              <th class="text-center" width="7%">Sl. No.</th>
              <th class="text-center" width="2%"><input type="checkbox" id="select_all" name="select_all"></th>
              <th class="text-center" width="15%">Date Time</th>
              <th class="text-center" width="15%">Branch</th>
              <th class="text-center">Complaints</th>
              <th class="text-center">Status</th>
              <th class="text-center" width="15%">Action</th>
            </tr>
          </thead>
          <tbody id="show_data">

          </tbody>
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

    table = $("#example1").DataTable({
      "dom": 'Blfrtip',
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "columnDefs": [{
          "targets": [0, 1, 2, 4],
          "className": 'text-center'
        },
      ],
      "columns": [{
          "data": "sl_no"
        },
        {
          "data": "select"
        },
        {
          "data": "date"
        },
        {
          "data": "branch"
        },
        {
          "data": "complaint"
        },
        {
          "data": "status"
        },
        {
          "data": "action"
        }
      ],
      "buttons": [{
          extend: 'print',
          footer: true
        }, {
          extend: 'excel',
          footer: true
        },
        {
          extend: 'pdf',
          customize: function(doc) {
            doc.content[1].table.widths =
              Array(doc.content[1].table.body[0].length + 1).join('*').split('');
          },
          footer: true
        }
      ]
      /* "footerCallback" :function (row, data, start, end, display){
          var api = this.api();
          // Remove the formatting to get integer data for summation
          var intVal = function (i) {
            return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
          };
          // Total over all pages
          total = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                     var sum = parseFloat(a) + parseFloat(b);
                     return sum.toFixed(2);
                }, 0);
           // Update footer
           $(api.column(6).footer()).html(total);
      } */

    });

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
            url: base_url + "dashboard/Complaints/delete_complaints",
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

    $('#filter_form').validate({
      rules: {
        fromDt: {
          required: true
        },
        toDt: {
          required: true
        },
        branch: {
          required: true
        },
      },
      messages: {
        fromDt: {
          required: "Please choose from Date",
        },
        toDt: {
          required: "Please choose to Date",
        },
        branch: {
          required: "Please choose branch",
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
      },
      submitHandler: function() {
        get_filter_data();
      }
    });

  });

  function get_filter_data() {
    var form_data = $('#filter_form').serializeArray();
    $.ajax({
      type: "POST",
      url: base_url + "dashboard/complaints/get_filter_data",
      data: form_data,
      cache: false,
      async: false,
      success: function(response) {
        data = JSON.parse(response);
        table.clear();
        table.rows.add(data).draw(false);
      }
    });
  }

  function finished(id){
    $.ajax({
      type : "POST",
      url : base_url + 'dashboard/complaints/update_status',
      data : "id="+id,
      async : false,
      cache : false,
      success : function(response){
        var data = JSON.parse(response);
        toastr.success(data.msg);
        get_filter_data();
      }
    })
  }
</script>