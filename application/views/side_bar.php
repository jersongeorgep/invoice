<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= site_url(); ?>" class="brand-link" title="<?= $app_name; ?>">
    <?= get_company_logo(); ?>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="info">
        <a href="#" class="d-block"><?= get_branch('branch_name'); //$this->session->userdata('user_name'); ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?= site_url('dashboard'); ?>" class="nav-link <?= (($pageTitle == 'Dashboard') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <?php if(user_permission_check(1)): ?>
        <li class="nav-item <?= (($menu == 'Booking') ? 'menu-open' : ''); ?>">
          <a href="#" class="nav-link <?= (($menu == 'Booking') ? 'active' : ''); ?>"><i class="nav-icon fas fa-shopping-cart"></i>
            <p>Check In/Out<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
          <?php if(user_permission_check(2)): ?>
            <li class="nav-item">
              <a href="<?= site_url('booking/checkin-new'); ?>" class="nav-link <?= (($pageTitle == 'Check-In List' || $pageTitle == 'New Check-In' || $pageTitle == 'Edit Check-In') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Check - In</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if(user_permission_check(3)): ?>
            <!-- <li class="nav-item">
              <a href="<?= site_url('booking'); ?>" class="nav-link <?= (($pageTitle == 'Booking List' || $pageTitle == 'New Booking' || $pageTitle == 'Edit Booking') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Bookings</p>
              </a>
            </li> -->
            <?php endif; ?>
            <?php if(user_permission_check(4)): ?>
            <li class="nav-item">
              <a href="<?= site_url('booking/guests'); ?>" class="nav-link <?= (($pageTitle == 'Guests List' || $pageTitle == 'New Guests' || $pageTitle == 'Edit Guests') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Guests</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if(user_permission_check(5)): ?>
             <li class="nav-item">
              <a href="<?= site_url('booking/check-rooms'); ?>" class="nav-link <?= (($pageTitle == 'Check Rooms') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Check Rooms</p>
              </a>
            </li> 
            <?php endif; ?>
            <?php if(user_permission_check(6)): ?>
            <li class="nav-item">
              <a href="<?= site_url('booking/payments'); ?>" class="nav-link <?= (($pageTitle == 'Payments List' || $pageTitle == 'New Payments' || $pageTitle == 'Edit Payments') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Payments</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if(user_permission_check(7)): ?>
            <!-- <li class="nav-item">
              <a href="<?= site_url('booking/checkout'); ?>" class="nav-link <?= (($pageTitle == 'Check-out List' || $pageTitle == 'New Check-out' || $pageTitle == 'Edit Check-out') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Check - Out</p>
              </a>
            </li> -->
            <?php endif; ?>
            <?php if(user_permission_check(8)): ?>
            <li class="nav-item">
              <a href="<?= site_url('booking/invoice'); ?>" class="nav-link <?= (($pageTitle == 'Invoice List' || $pageTitle == 'New Invoice' || $pageTitle == 'Edit Invoice') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Invoice</p>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>

        <?php if(user_permission_check(9)): ?>
        <li class="nav-item <?= (($menu == 'Stock') ? 'menu-open' : ''); ?>">
          <a href="#" class="nav-link  <?= (($menu == 'Stock') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-calendar"></i>
            <p>Calendar<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= site_url('calendar') ?>" class="nav-link <?= (($pageTitle == 'Inventory List' || $pageTitle == 'New Inventory' || $pageTitle == 'Edit Inventory') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Calendar</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
        <?php //if($this->session->userdata('branch_id') != 1): ?>
        <?php if(user_permission_check(9)): ?>
        <li class="nav-item <?= (($menu == 'Amount Transfer') ? 'menu-open' : ''); ?>">
          <a href="#" class="nav-link  <?= (($menu == 'Amount Transfer') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-coins"></i>
            <p>Amount Transfer <i class="fas fa-angle-left right"></i> <span class="badge badge-danger right"><?= pending_amount_transfer_count(); ?></span> </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= site_url('amount-transfer') ?>" class="nav-link <?= (($pageTitle == 'Amount Transfer List' || $pageTitle == 'New Amount Transfer' || $pageTitle == 'Edit Amount Transfer') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Branch to Head</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('amount-transfer/transfer-cash') ?>" class="nav-link <?= (($pageTitle == 'Transfer Cash' || $pageTitle == 'New Transfer Cash' || $pageTitle == 'Edit Amount Transfer') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Transfer Cash</p>
              </a>
            </li>

          </ul>
        </li>
        <?php endif; ?>
        <?php //endif; ?>
        <?php if($this->session->userdata('branch_id') == 1): ?>
        <?php if(user_permission_check(10)): ?>
        <li class="nav-item <?= (($menu == 'Branches') ? 'menu-open' : ''); ?>">
          <a href="#" class="nav-link <?= (($menu == 'Branches') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-shopping-bag"></i>
            <p>Branches<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= site_url('branches'); ?>" class="nav-link <?= (($pageTitle == 'Branches List' || $pageTitle == 'New Branch' || $pageTitle == 'Edit Branch') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Branches </p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
        <?php endif; ?>
        <?php if(user_permission_check(14)): ?>
        <li class="nav-item <?= (($menu == 'Visitors') ? 'menu-open' : ''); ?>">
          <a href="#" class="nav-link  <?= (($menu == 'Visitors') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-edit"></i>
            <p>Visitors<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= site_url('visitors') ?>" class="nav-link <?= (($pageTitle == 'Visitors List' || $pageTitle == 'New Visitor' || $pageTitle == 'Edit Visitor') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Visitors</p>
              </a>              
            </li>
          </ul>
        </li>
        <?php endif; ?>
        
        <?php if(user_permission_check(18)): ?>
        <li class="nav-item <?= (($menu == 'Laundry') ? 'menu-open' : ''); ?>">
          <a href="#" class="nav-link  <?= (($menu == 'Laundry') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-water"></i> 
            <p>Laundry<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <?php if(user_permission_check(19)): ?>
            <li class="nav-item">
              <a href="<?= site_url('laundry') ?>" class="nav-link <?= (($pageTitle == 'Laundry List' || $pageTitle == 'New Laundry' || $pageTitle == 'Edit Laundry') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laundry Given</p>
              </a>
            </li>
            <?php endif; ?>
            <?php if(user_permission_check(20)): ?>
            <li class="nav-item">
              <a href="<?= site_url('laundry/laundry-returned') ?>" class="nav-link <?= (($pageTitle == 'Returned Laundry List' || $pageTitle == 'New Returned Laundry' || $pageTitle == 'Edit Returned Laundry') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laundry Return</p>
              </a>
            </li>
            <?php endif; ?>

            <li class="nav-item">
              <a href="<?= site_url('laundry/laundry-payments') ?>" class="nav-link <?= (($pageTitle == 'Laundry Payments List' || $pageTitle == 'New Laundry Payment' || $pageTitle == 'Edit Laundry Payment') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laundry Payments</p>
              </a>
            </li>

          </ul>
        </li>
        <?php endif; ?>

        <?php if(user_permission_check(21)): ?>
        <li class="nav-item <?= (($menu == 'Employees') ? 'menu-open' : ''); ?>">
          <a href="#" class="nav-link  <?= (($menu == 'Employees') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Employees<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= site_url('employees') ?>" class="nav-link <?= (($pageTitle == 'Employees List' || $pageTitle == 'New Employee' || $pageTitle == 'Edit Employee') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Employees</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>

        <?php if(user_permission_check(31)): ?>
        <li class="nav-item">
          <a href="<?= site_url('attendance'); ?>" class="nav-link <?= (($pageTitle == 'Attendance Register'||$pageTitle == 'Add Attendance') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-clock"></i>
            <p>Attendance</p>
          </a>
        </li>
        <?php endif; ?>

        <?php if(user_permission_check(32)): ?>
        <li class="nav-item <?= (($menu == 'Payroll') ? 'menu-open' : ''); ?>">
          <a href="#" class="nav-link <?= (($menu == 'Payroll') ? 'active' : ''); ?>"><i class="nav-icon fas fa-cogs"></i>
            <p>Salary<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <?php if(user_permission_check(33)): ?>
            <li class="nav-item">
              <a href="<?= site_url('payroll/add_deductions'); ?>" class="nav-link <?= (($pageTitle == 'Deductions List' || $pageTitle == 'New Deduction' || $pageTitle == 'Edit Deduction') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Additions/Deductions</p>
              </a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
              <a href="<?= site_url('payroll'); ?>" class="nav-link <?= (($pageTitle == 'Payroll List'|| $pageTitle == 'New Payroll' || $pageTitle == 'Generate Payroll') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Salary</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>

        <?php if(user_permission_check(38)): ?>
        <li class="nav-item  <?= (($menu == 'Incomes Expenses') ? 'menu-open' : ''); ?>">
          <a href="#" class="nav-link <?= (($menu == 'Incomes Expenses') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-calculator"></i>
            <p> Income & Expense <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= site_url('incomes-expenses');?>" class="nav-link <?= (($pageTitle == 'Incomes List'||$pageTitle == 'New Income'||$pageTitle == 'Edit Income Expenses') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Incomes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('incomes-expenses/expenses-list');?>" class="nav-link <?= (($pageTitle == 'Expenses List'||$pageTitle == 'New Expenses'||$pageTitle == 'Edit Income Expenses') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Expenses</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
        
        <?php if(user_permission_check(26)): ?>
         <li class="nav-item <?= (($menu == 'Reports') ? 'menu-open' : ''); ?>">
          <a href="#" class="nav-link <?= (($menu == 'Reports') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Reports
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= site_url('reports/tourism_report'); ?>" class="nav-link <?= (($pageTitle == 'Tourism Report') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Tourism Report</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= site_url('reports/invoice-report'); ?>" class="nav-link <?= (($pageTitle == 'CA Report') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>CA Report</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= site_url('reports/customer_report');?>" class="nav-link <?= (($pageTitle == 'Customer Report') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Customer/Police Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('reports/customer_review');?>" class="nav-link <?= (($pageTitle == 'Customer phone') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Customer Review</p>
              </a>
            </li>
            <?php if($this->session->userdata('branch_id') == 1): ?>
            <li class="nav-item">
              <a href="<?= site_url('reports/income-expense-report');?>" class="nav-link <?= (($pageTitle == 'Income & Expense') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Income & Expense </p>
              </a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
              <a href="<?= site_url('reports/payments_report');?>" class="nav-link <?= (($pageTitle == 'Payments Report') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Payments Report</p>
              </a>
            </li>
          </ul>
        </li> 
        <?php endif; ?>
        
        <?php if(user_permission_check(27)): ?>
        <li class="nav-item <?= (($menu == 'Masters') ? 'menu-open' : ''); ?>">
          <a href="#" class="nav-link <?= (($menu == 'Masters') ? 'active' : ''); ?>"><i class="nav-icon fas fa-copy"></i>
            <p>Masters<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= site_url('masters/room'); ?>" class="nav-link <?= (($pageTitle == 'Rooms List' || $pageTitle == 'New Room' || $pageTitle == 'Edit Room') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Rooms</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('masters/room-status'); ?>" class="nav-link <?= (($pageTitle == 'Room Status List' || $pageTitle == 'New Room Status' || $pageTitle == 'Edit Room Status') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Room Status</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('masters/bed-size'); ?>" class="nav-link <?= (($pageTitle == 'Beds List' || $pageTitle == 'New Bed' || $pageTitle == 'Edit Bed') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Beds</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('masters/income-expense-type'); ?>" class="nav-link <?= (($pageTitle == 'Heads List' || $pageTitle == 'New Head' || $pageTitle == 'Edit Head') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Income Expense Heads</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('masters/roles'); ?>" class="nav-link <?= (($pageTitle == 'Roles List' || $pageTitle == 'New Role' || $pageTitle == 'Edit Role') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Roles</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('masters/departments'); ?>" class="nav-link <?= (($pageTitle == 'Departments List' || $pageTitle == 'New Department' || $pageTitle == 'Edit Department') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Departments</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('masters/item'); ?>" class="nav-link <?= (($pageTitle == 'Items List' || $pageTitle == 'New Item' || $pageTitle == 'Edit Item') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Laundry Items </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('masters/laundries'); ?>" class="nav-link <?= (($pageTitle == 'Laundries List' || $pageTitle == 'New Laundry' || $pageTitle == 'Edit Laundry') ? 'active' : ''); ?>"><i class="far fa-circle nav-icon"></i>
                <p>Laundries </p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
        
        <?php if($this->session->userdata('branch_id') == 1): ?>
        <?php if(user_permission_check(28)): ?>
        <li class="nav-item <?= (($menu == 'Settings') ? 'menu-open' : ''); ?>">
          <a href="#" class="nav-link <?= (($menu == 'Settings') ? 'active' : ''); ?>"><i class="nav-icon fas fa-cogs"></i>
            <p>Settings<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <!-- <li class="nav-item">
              <a href="<?= site_url('company'); ?>" class="nav-link <?= (($pageTitle == 'Company Settings') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Company</p>
              </a>
            </li> -->
            <li class="nav-item">
              <a href="<?= site_url('settings/users'); ?>" class="nav-link <?= (($pageTitle == 'Users List'|| $pageTitle == 'New Users' || $pageTitle == 'Edit Users') ? 'active' : ''); ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Users</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
        <?php endif; ?>
        <li class="nav-item">
          <a href="<?= site_url('login/logout'); ?>" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>