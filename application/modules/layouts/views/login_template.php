<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $app_name; ?> || <?= $pageHeading; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= site_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= site_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= site_url('assets/dist/css/adminlte.min.css'); ?>">
  <!-- jQuery -->
  <script src="<?= site_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>

    <!-- Toastr -->
<link rel="stylesheet" href="<?= site_url('assets/plugins/toastr/toastr.min.css'); ?>">
<!-- Toastr -->
<script src="<?= site_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>

</head>
<body class="hold-transition login-page">
<?php $this->load->view($loadPage) ?>

<?php $this->load->view('messages'); ?>
<!-- Bootstrap 4 -->
<script src="<?= site_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src=".<?= site_url('assets/dist/js/adminlte.min.js'); ?>"></script>
</body>
</html>