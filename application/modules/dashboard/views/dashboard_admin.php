<div class="row">
  <div <?= (($branch != 1) ? 'class="col-12"' : 'class="col-12"'); ?>>
    <div class="row">
      <?php if ($this->session->userdata('branch_id') == 1) : ?>
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-gradient-blue">
            <div class="inner">
              <h3><?= count_table_row('lms_branches', 'branch_name'); ?></h3>
              <p class="text-lg"><?= strtoupper('branches'); ?></p>
            </div>
            <div class="icon">
              <i class="fas fa-building"></i>
            </div>
            <?php if ($this->session->userdata('branch_id') != 1) { ?>
            <?php } else { ?>
              <a href="<?= site_url('booking/checkin-new'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            <?php } ?>
          </div>
        </div>
      <?php endif; ?>
      <!-- ./col -->

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-gradient-cyan">
          <div class="inner">
            <h3><?= count_table_row('lms_room', 'room_status', 1); ?><sup style="font-size: 20px"></sup></h3>
            <p class="text-lg"><?= strtoupper('vacant'); ?></p>
          </div>
          <div class="icon">
            <i class="fas fa-check"></i>
          </div>
          <a href="<?= site_url('dashboard/filter_rooms_list/1'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-gradient-green">
          <div class="inner">
            <h3><?= count_table_row('lms_room', 'room_status', 2); ?></h3>

            <p class="text-lg"><?= strtoupper('occupied'); ?></p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <a href="<?= site_url('dashboard/filter_rooms_list/2'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-gradient-navy">
          <div class="inner">
            <h3><?= count_table_row('lms_room', 'room_status', 4); ?></h3>

            <p class="text-lg"><?= strtoupper('maintenance'); ?></p>
          </div>
          <div class="icon">
            <i class="fas fa-tools"></i>
          </div>
          <a href="<?= site_url('dashboard/filter_rooms_list/4'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-gradient-maroon">
          <div class="inner">
            <h3><?= count_table_row('lms_room', 'room_status',3); ?></h3>

            <p class="text-lg"><?= strtoupper('cleaning phase'); ?></p>
          </div>
          <div class="icon">
            <i class="fas fa-procedures"></i>
          </div>
          <a href="<?= site_url('dashboard/filter_rooms_list/3'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-gradient-orange">
          <div class="inner">
            <h3><?= count_table_row('lms_complaints', 'status', 'pending', (($this->session->userdata('branch_id') == 1) ? '' : $this->session->userdata('branch_id')), ''); ?></h3>

            <p class="text-lg"><?= strtoupper('Complaints'); ?></p>
          </div>
          <div class="icon">
            <i class="fas fa-cogs"></i>
          </div>
          <a href="<?= site_url('dashboard/complaints'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->


      <?php if ($branch == 1) : ?>
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-gradient-indigo">
            <div class="inner">
              <h3><sup style="font-size: 20px">₹</sup> <?= cash_in_hand(); ?></h3>
              <p class="text-lg"><?= strtoupper('Cash In Hand'); ?></p>
            </div>
            <div class="icon">
              <i class="fas fa-rupee-sign"></i>
            </div>
            <a href="<?= site_url('dashboard/cash_in_hand_branch_wise'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-gradient-teal">
            <div class="inner">
              <h3><sup style="font-size: 20px">₹</sup> <?= cash_at_bank(); ?></h3>
              <p class="text-lg"><?= strtoupper('Cash In Bank'); ?></p>
            </div>
            <div class="icon">
              <i class="fas fa-rupee-sign"></i>
            </div>
            <a href="<?= site_url('dashboard/cash_in_hand_branch_wise'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

      <?php endif; ?>

      <!-- Only for brach -->
      <?php if ($branch != 1) : ?>
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-gradient-red">
            <div class="inner">
              <h3><sup style="font-size: 20px">₹</sup> <?= cash_in_hand($branch); ?></h3>
              <p class="text-lg"><?= strtoupper('Cash in Hand'); ?></p>
            </div>
            <div class="icon">
              <i class="fas fa-rupee-sign"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-gradient-teal">
            <div class="inner">
              <h3><sup style="font-size: 20px">₹</sup> <?= cash_at_bank($branch); ?></h3>
              <p class="text-lg"><?= strtoupper('Cash In Bank'); ?></p>
            </div>
            <div class="icon">
              <i class="fas fa-rupee-sign"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

      <?php endif; ?>

    </div>
  </div>

  <!-- <div class="col-md-6 hide">
    <div class="card">
      <div class="card-header border-transparent">
        <h3 class="card-title">Check In - <span class="text-danger">Today (<?= date('d-m-Y') ?>)</span></h3>
        <?php if ($this->session->userdata('branch_id') == 1) { ?>
          <div class="card-tools">
            <select name="branch_id" class="form-control" onchange="get_checkins('<?= date('Y-m-d') ?>','today',this)">
              <option value="">Select</option>
              <?php if (!empty($branches)) {
                foreach ($branches as $row) { ?>
                  <option value="<?= $row->id ?>" <?= ($this->session->userdata('branch_id') == $row->id) ? 'selected' : '' ?>><?= $row->branch_name ?></option>
              <?php }
              } ?>
            </select>
          </div>
        <?php } ?>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Room No.</th>
                <th>Check In</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody id="today">

            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div> -->

  <!-- <div class="col-md-6 hide">
    <div class="card">
      <div class="card-header border-transparent">
        <h3 class="card-title">Check In - <span class="text-info">Tomorrow (<?= date('d-m-Y', strtotime("+ 1 day")) ?>)</span></h3>
        <?php if ($this->session->userdata('branch_id') == 1) { ?>
          <div class="card-tools">
            <select name="branch_id" class="form-control" onchange="get_checkins('<?= date('Y-m-d', strtotime('+ 1 day')) ?>','tomorrow',this)">
              <option value="">Select</option>
              <?php if (!empty($branches)) {
                foreach ($branches as $row) { ?>
                  <option value="<?= $row->id ?>" <?= ($this->session->userdata('branch_id') == $row->id) ? 'selected' : '' ?>><?= $row->branch_name ?></option>
              <?php }
              } ?>
            </select>
          </div>
        <?php } ?>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Room No.</th>
                <th>Check In</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody id="tomorrow">


            </tbody>
          </table>
        </div>

      </div>


    </div>
  </div> -->

  <div class="col-12">
    <button type="button" onclick="show_popup('<?= site_url('dashboard/add_notes_popup') ?>', 'Add note');" class="btn btn-app bg-danger float-left"><span class="badge bg-teal"><?= count((array) $notes); ?></span><i class="fas fa-sticky-note"></i> Add Notes</button>
    <div class="row">
      <?php if (!empty($notes)) : ?>
        <?php foreach ($notes as $val) : ?>
          <div class="col-md-3">
            <div class="card card-outline card-success" id="notice_<?= $val->id; ?>">
              <div class="card-header">
                <h3 class="card-title"><?= $val->title; ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" onclick="remove_note(<?= $val->id; ?>)" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <p><?= $val->notes ?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <?php if($this->session->userdata('branch_id') == 1){ ?> 
    <?php if($transfers){ ?>
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3>Pending Requests</h3>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-12 table-responsive">
              <table id="example1" class="table table-bordered table-striped table-sm">
          <thead>
            <tr>
              <th class="text-center" width="7%">Sl. No.</th>
              <th width="15%" class="text-center" >Date</th>
              <th class="text-center" >From Branch</th>
              <th class="text-center" >Head Office</th>
              <th class="text-center" >Transferred By</th>
              <th class="text-center" >Txn Mode</th>
              <th class="text-center" >Narration</th>
              <th class="text-center" >Amount</th>
              <th class="text-center" >Status</th>
              <th width="12%" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody id="show_data">
            <?php 
            $i = 1;
              foreach($transfers as $value){ ?>
              <tr>
                <td class="text-center"><?= $i; ?></td>
                <td class="text-center"><?= date('d-m-Y h:i a', strtotime($value->transfer_date));?></td>
                <td><?=  $value->fromBranchName; ?></td>
                <td><?=  $value->toBranchName; ?></td>
                <td><?=  $value->full_name; ?></td>
                <td class="text-center"><?=  $value->mode_txn; ?></td>
                <td><?=  $value->narration; ?></td>
                <td class="text-right"><?=  number_format($value->transfer_amount,2); ?></td>
                <td class="text-center"><?=  '<span class="badge '.(($value->confirm_status == 'pending') ? 'badge-warning':'badge-success').' text-md">'.ucfirst($value->confirm_status).'</span>'; ?></td>
                <td class="text-center"><button type="button" onclick="approve_amount(<?= $value->id; ?>)" class= "btn btn-xs btn-success"> <i class="fa fa-check"></i> Approval</button></td>
              </tr>
            <?php
            $i++;
           } ?>
          </tbody>
        </table>
              </div>
            </div>
        </div>
      </div>
    </div>
    <?php } ?>

   <?php } ?>
</div>

<script>
  $(function() {
    get_checkins('<?= date('Y-m-d') ?>', 'today');
    get_checkins('<?= date('Y-m-d', strtotime("+ 1 day")) ?>', 'tomorrow');

  });

  function get_checkins(date = "", div = "", ths = "") {

    if (ths != "") {
      branch_id = $(ths).val();
    } else {
      branch_id = '<?= $this->session->userdata('branch_id') ?>';
    }

    $.ajax({
      type: "POST",
      url: base_url + "dashboard/get_checkins",
      async: false,
      cache: false,
      data: {
        branch_id: branch_id,
        date: date
      },
      success: function(response) {
        $('#' + div).html(response);
      }
    });

  }

  function remove_note(id) {
    if (confirm("Do you want to delete this note ?")) {
      $.ajax({
        type: "POST",
        url: base_url + "dashboard/delete_note",
        data: "id=" + id,
        cache: false,
        async: false,
        success: function(response) {
          data = JSON.parse(response);
          toastr.error(data.msg);
          window.location.reload();
        }
      });
    }
  }

  function approve_amount(id){
    $.ajax({
      type  :"POST",
      url : base_url + 'amount_transfer/approval_fund',
      data  : "id="+id,
      async : false,
      cache : false,
      success : function(response){
        var data = JSON.parse(response);
        if(data.type != 'error'){
          toastr.success(data.msg);
          window.location.reload(1);
        }else{
          toastr.error(data.msg);
        }
      }
    });
  }

</script>