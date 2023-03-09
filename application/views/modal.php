<div class="modal fade" id="show_popup" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
  function show_popup(url, title, size = null, close=null) {
    title = title || '';
    if(close == "no_close"){
      jQuery('#show_popup .modal-header .close').remove();
    }
    // SHOWING AJAX PRELOADER
    jQuery('#show_popup .modal-body').html('<div style="text-align:center;">Loading...</div>');
    jQuery('#show_popup .modal-title').html(title);
    if (size) {
      jQuery('#show_popup .modal-dialog').addClass(size);
    }
    // LOADING THE AJAX MODAL
    jQuery('#show_popup').modal({
      backdrop: 'static',
      keyboard: false
    }, 'show');
    $.ajax({
      url: url,
      success: function(response) {
        jQuery('#show_popup .modal-body').html(response);
      }
    });
  }
</script>