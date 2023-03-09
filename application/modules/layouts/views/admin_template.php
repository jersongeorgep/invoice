<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $app_name; ?> | <?= $pageHeading; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= site_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= site_url('assets/dist/css/adminlte.min.css'); ?>">
  <script>
    var base_url = "<?= site_url(); ?>";
  </script>
  <!-- jQuery -->
  <script src="<?= site_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>

  <!-- Toastr -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/toastr/toastr.min.css'); ?>">
<!-- Toastr -->
<script src="<?= site_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>
<style>
  input, textarea, .select2{
    font-size: large !important;
    font-weight: bold !important;
  }
  label{
    font-size: large;
  }
  
</style>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php $this->load->view('nav_bar'); ?>
  <?php $this->load->view('side_bar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?= $pageHeading; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= site_url(); ?>">Home</a></li>
              <li class="breadcrumb-item"><?= $menu; ?></li>
              <li class="breadcrumb-item active"><?= $pageTitle; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <?php $this->load->view($loadPage);?>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; <?=date('Y');?> <a href="https://ksofttechnologies.com/" target="_blank"><?= $copyright; ?></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.1
    </div>
  </footer>
  
  <?php $this->load->view('messages'); ?>
  <?php $this->load->view('modal');?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- Bootstrap -->
<script src="<?= site_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- AdminLTE -->
<script src="<?= site_url('assets/dist/js/adminlte.js'); ?>"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?= site_url('assets/plugins/chart.js/Chart.min.js'); ?>"></script>
<!-- AdminLTE for demo purposes -->



</body>
</html>