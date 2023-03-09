<!-- DataTables -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">

<div class="row">
    <div class="col-12">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title"><span></span><a href="<?= site_url('receipts/tax-invoice/add');?>" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> New </a></span></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-sm text-sm">
                  <thead>
                  <tr>
                    <th class="text-center" width="7%">Sl. No.</th>
                    <th class="text-center" width="2%"><input type="checkbox" id="select_all" name="select_all"></th>
                    <th class="text-center" width="15%">Invoice No</th>
                    <th class="text-center" width="15%">Date</th>
                    <th class="text-center">Customer</th>
                    <th class="text-center">Mobile</th>
                    <th class="text-center" width="15%">Amount</th>
                    <th width="5%" class="text-center">Action</th>
                  </tr>
                  </thead>
                  <tbody id="show_data">
                      <?php if($invoices): 
                        $sl_no = 1;
                        ?>
                    <?php foreach($invoices as $value): ?>
                  <tr>
                    <td class="text-center"><?= $sl_no; ?></td>
                    <td class="text-center"><input type="checkbox" name="ids[]" id="ids_<?= $value->id; ?>" value="<?= $value->id; ?>" /></td>
                    <td class="text-center"><?= $value->ref_no; ?></td>
                    <td class="text-center"><?= $value->invoice_date; ?></td>
                    <td><?= $value->customer_name; ?></td>
                    <td class="text-center"d><?= $value->mobile; ?></td>
                    <td class="text-right"><?= number_format($value->total_value, 2); ?></td>
                    <td><button type="button" onclick="print_invoice(<?= $value->id; ?>)" class="btn btn-sm btn-danger"><i class="fas fa-print"></i></button></td>
                  </tr>
                  <?php 
                    $sl_no++;
                    endforeach; ?>
                  <?php endif; ?>
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

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      //"buttons": ["csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
    $("#select_all").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    /* $('#delete_btn').on('click', function(){
        var post_arr = [];
        $('#show_data input[type=checkbox]').each(function() {
            if (jQuery(this).is(":checked")) {
                var id = this.value;
                post_arr.push(id);
            }
        });
        if(post_arr.length > 0){
            if(confirm("Do you really want to delete records?")){
                $.ajax({
                    type:"POST",
                    url : base_url + "masters/bed_size/delete_size",
                    async:false,
                    cache :false,
                    data:{ids:post_arr},
                    success : function(response){
                        $.each(post_arr, function( i,l ){
                            $("#ids_"+l).closest('tr').remove();
                        });
                        toastr.error("Data Deleted");
                    }
                });
            }
        }else{
            alert("Please select rows for delete");
        }
    }); */

  });

  function print_invoice($id){
    $.ajax({
      method : "get",
      url : base_url + 'receipts/tax-invoice/print/'+ $id,
      async : false,
      cache : false,
      success : function(response){
        var divContents = response;
        var printWindow = window.open('', '', 'height=1000,width=800');
        printWindow.document.write('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>Daily Report <?= date('d-m-Y'); ?></title>');
        printWindow.document.write('<link href="<?= site_url('assets/dist/css/adminlte.min.css')?>" rel="stylesheet" type="text/css">');
        //printWindow.document.write('<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet" type="text/css">');
        printWindow.document.write('<style type="text/css">@page { size: auto;margin: 10mm 10mm 10mm 10mm;} body { margin:10px;padding:0px;} .print-hidden{display:none;} #btnprnt {display:none !important;} </style>');
        printWindow.document.write('</head><body style="font-family:Lato, sans-serif">');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
	      printWindow.document.close();
        setTimeout(function(){
          printWindow.print();
        },2000);
	      printWindow.onafterprint = function() {		
          printWindow.close();
        }
      }
    });
  }
      

  
</script>