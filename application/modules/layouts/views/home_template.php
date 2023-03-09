<!DOCTYPE html>
<html class="html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo site_url('assets/imgs/favicon.png'); ?>" />

    <title><?php echo $pageheading; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Heebo:100%7COpen+Sans:300,400,400i,600,700,800">
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/bootsnav/css/bootsnav.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/alien-icon/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/owl.carousel2/owl.carousel.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/magnific-popup/magnific-popup.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/switchery/switchery.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/animate.css/animate.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/vendor/swiper/css/swiper.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/css/alien.min.css'); ?>">
    <!-- endinject -->

</head>
<body>

    <?php $this->load->view('Header_page'); ?>
    <?php $this->load->view($loadpage); ?>
	<?php $this->load->view('Footer_page'); ?>
    <!-- inject:js -->
    <script src="<?php echo site_url('assets/vendor/jquery/jquery-1.12.0.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/bootsnav/js/bootsnav.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/waypoints/jquery.waypoints.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/jquery.countTo/jquery.countTo.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/owl.carousel2/owl.carousel.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/jquery.appear/jquery.appear.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/parallax.js/parallax.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/isotope/isotope.pkgd.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/imagesloaded/imagesloaded.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/magnific-popup/jquery.magnific-popup.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/switchery/switchery.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/vendor/swiper/js/swiper.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/alien.js'); ?>"></script>
    <!-- endinject -->
</body>
</html>
