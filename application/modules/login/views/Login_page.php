<script src="<?= site_url('assets/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= site_url(); ?>" class="h1"><b><?= $pageTitle?></b></a>
    </div>
    <div class="card-body">
      <form id="loginForm" action="<?= site_url('login/check_user'); ?>" method="post">
        <label class="clearfix text-danger"><?php echo form_error('email'); ?></label>
        <label for="email">Email <sup class="text-danger">*</sup></label>
        <div class="input-group mb-3">
          <input type="email" class="form-control has-validation" id="email" name="email" placeholder="Email" value="<?= set_value('email'); ?>">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>
        <label class="clearfix text-danger"><?php echo form_error('password'); ?></label>
        <label for="password">Password <sup class="text-danger">*</sup></label>
        <div class="input-group mb-3">
          <input type="password" class="form-control has-validation" name="password" placeholder="Password" value="<?= set_value('email'); ?>" />
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="passremember" value="1">
              <label for="remember">Remember Me</label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<script>
    $(function () {
      $('#loginForm').validate({
        rules: {
          email: {
            required: true,
            email: true,
          },
          password: {
            required: true,
            minlength: 5
          },
        },
        messages: {
          email: {
            required: "Please enter a email address"
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 5 characters long"
          }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>