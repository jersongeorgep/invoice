<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-info navbar-badge"><?= count_notification(); ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><?= count_notification(); ?> Notifications</span>
          <?php if($notifications): foreach($notifications as $msg): ?>
          <div class="dropdown-divider"></div>
          <a href="<?= site_url('settings/make_viewed/'.$msg->id.'/'. 1)?>" class="dropdown-item">
            <i class="fas <?= $msg->icon; ?> mr-2"></i> <?= $msg->title; ?>
            <span class="float-right text-muted text-sm"><?= time_elapsed_string($msg->updated_at)?></span>
          </a>
          <?php endforeach;  endif; ?>
          <div class="dropdown-divider"></div>
          <a href="<?= site_url('settings/notifications'); ?>" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->