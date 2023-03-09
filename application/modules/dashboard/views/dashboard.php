<div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-rupee-sign"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CASH IN HAND</span>
                <span class="info-box-number">
                  <small><i class="fas fa-rupee-sign"></i></small>
                  <?= cash_in_hand_total(); ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-building"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CASH IN BANK</span>
                <span class="info-box-number"><small><i class="fas fa-rupee-sign"></i></small>
                <?= cash_at_bank_total(); ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-coins"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">TOTAL SALES</span>
                <span class="info-box-number"><small><i class="fas fa-rupee-sign"></i></small>
                  <?= round(get_total_sales('cash'),2);?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-wallet"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">BANK SALES</span>
                <span class="info-box-number"><small><i class="fas fa-rupee-sign"></i></small>
                <?= total_income_expense('income','','','bank');?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>

<div class="row">
  <div class="col-6">
    <!-- DONUT CHART -->
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Current Month Fuel Sales</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
  </div>
  <!-- /.col-md-6 -->
  <div class="col-6">
  <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h3 class="card-title">Current Month Sales</h3>
        </div>
      </div>
      <div class="card-body">

        <div class="position-relative mb-4">
          <canvas id="visitors-chart" height="200"></canvas>
        </div>

        <div class="d-flex flex-row justify-content-end">
          <span class="mr-2"><i class="fas fa-square text-primary"></i> Cash</span>&nbsp;
          <span><i class="fas fa-square text-green"></i> Bank </span>&nbsp;
        </div>
      </div>
    </div>
    <!-- /.card -->
  </div>
  <div class="col-6">
    <div class="card">
      <div class="card-header border-0">
        <h3 class="card-title">Today Price</h3>
        <div class="card-tools"></div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
          <thead>
            <tr>
              <th class="text-center">Product</th>
              <th class="text-center">Unit</th>
              <th class="text-center">Available Stock</th>
              <th class="text-center">Price</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($fuel_products) :  foreach ($fuel_products as $value) : ?>
                <tr>
                  <td><?= $value->products; ?></td>
                  <td><?= $value->unit_name; ?></td>
                  <td class="text-center"><?= available_stock($value->id); ?></td>
                  <td><small class="text-success mr-1"><i class="fa fa-rupee-sign"></i></small><?= get_current_price($value->id); ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.card -->
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h3 class="card-title">Income & Expense</h3>
        </div>
      </div>
      <div class="card-body">
        <div class="position-relative mb-4">
          <canvas id="sales-chart" height="200"></canvas>
        </div>

        <div class="d-flex flex-row justify-content-end">
          <span class="mr-2">
            <i class="fas fa-square text-green"></i> Income
          </span>

          <span>
            <i class="fas fa-square text-orange"></i> Expense
          </span>
        </div>
      </div>
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col-md-6 -->
</div>


<!-- /.row -->
<script>
  $(function() {
    'use strict'

    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }

    var monthLabels = <?= json_encode(month_label(7)); ?>;
    var incomeAmounts = <?= json_encode(income_expense_months(7, 'income')); ?>;
    var expenseAmounts = <?= json_encode(income_expense_months(7, 'expense')); ?>;
    

    var mode = 'index'
    var intersect = true

    var $salesChart = $('#sales-chart')
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart($salesChart, {
      type: 'bar',
      data: {
        labels: monthLabels,
        datasets: [{
            backgroundColor: '#28a745',
            borderColor: '#28a745',
            data: incomeAmounts
          },
          {
            backgroundColor: '#fd7e14',
            borderColor: '#fd7e14',
            data: expenseAmounts
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function(value) {
                if (value >= 1000) {
                  value /= 1000
                  value += 'k'
                }

                return '₹' + value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })

    
    var $visitorsChart  = $('#visitors-chart')
    var dayLabel        = <?= json_encode(current_invoice_label('all')); ?>;
    var cashAmt         = <?= json_encode(current_month_income('cash')); ?>;
    var bankAmt          = <?= json_encode(current_month_income('bank')); ?>;
    
    var visitorsChart = new Chart($visitorsChart, {

      data: {
        labels: dayLabel,
        datasets: [{
            type: 'line',
            data: cashAmt,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            pointBorderColor: '#007bff',
            pointBackgroundColor: '#007bff',
            fill: false
          },
          {
            type: 'line',
            data: bankAmt,
            backgroundColor: 'tansparent',
            borderColor: '#28a745',
            pointBorderColor: '#28a745',
            pointBackgroundColor: '#28a745',
            fill: false
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,
              suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var labels = <?= json_encode(fuel_products());?>;
    var stock_data = <?= json_encode(fuel_products_sales()); ?>;
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: labels,
      datasets: [
        {
          data: stock_data,
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

  })

  
</script>