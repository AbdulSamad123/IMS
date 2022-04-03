<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>IMS | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="img/logo1.jpg">
  <!--Sweetalert Plugin --->
  <script src="bower_components/sweetalert/sweetalert.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- bootstrap timepicker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="dist/css/skins/skin-green.min.css">

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- datepicker js -->
  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">
  <!-- iCheck 1.0.1 -->
  <script src="plugins/iCheck/icheck.min.js"></script>
  <!-- bootstrap time picker -->
  <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>

  <!-- chart Js -->
  <script src="chartjs/dist/Chart.min.js"></script>

</head>

<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>IMS</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Inventory|</b>POS</span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="img/logo1.jpg" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs text-lowercase"><?php echo $_SESSION['username']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="img/logo1.jpg" class="img-circle" alt="User Image">

                  <p class="text-lowercase">
                    <?php echo $_SESSION['username']; ?> - <?php echo $_SESSION['role']; ?>
                    <small class="text-capitalize"><?php echo $_SESSION['fullname']; ?></small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="misc/logout.php" class="btn btn-default btn-flat"
                    onclick="return confirm('YOU ARE SURE ?')"
                    class="btn btn-danger">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
          </ul>
        </div>
      </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">Menu</li>
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="treeview">
          <a href="#pagesmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down">
            <i class="fa fa-dashboard"></i> <span>Sales</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="./order.php"><i class="fa fa-shopping-cart"></i> <span>New Sale</span></a></li>
              <li><a href="./cus_balance.php"><i class="fa fa-bank"></i> <span>Customer Balance</span></a></li>
              <li><a href="./report_sales.php"><i class="fa fa-newspaper-o"></i> <span>Sale Report</span></a></li>
              <li><a href="./overall_report_sales.php"><i class="fa fa-newspaper-o"></i> <span>Overall Sale Report</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#pagesmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down">
            <i class="fa fa-truck"></i> <span>Purchase</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./purchase.php"><i class="fa fa-shopping-cart"></i> <span>New Purchase</span></a></li>
            <li><a href="./sup_balance.php"><i class="fa fa-bank"></i> <span>Suplier Balance</span></a></li>
            <li><a href="./report_purchase.php"><i class="fa fa-newspaper-o"></i> <span>Purchase Report</span></a></li>
            <li><a href="./overall_report_purchase.php"><i class="fa fa-newspaper-o"></i> <span>Overall Purchase Report</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#pagesmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down">
            <i class="fa fa-envelope-open"></i> <span>Direct Sale</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./direct.php"><i class="fa fa-envelope-open"></i> <span>Add Direct Sale</span></a></li>
            <li><a href="#"><i class="fa fa-newspaper-o"></i> <span>Report</span></a></li>
            <li><a href="./warehouse.php"><i class="fa fa-home"></i> <span>Warehousing</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#pagesmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down">
            <i class="fa fa-gift"></i> <span>Product Detail</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./product.php"><i class="fa fa-gift"></i> <span>Product</span></a></li>
            <li><a href="./category.php"><i class="fa fa-list-alt"></i> <span>Category</span></a></li>
            <li><a href="./satuan.php"><i class="fa fa-balance-scale"></i> <span>Unit of product</span></a></li>
          </ul>
        </li>
        <li><a href="./customer.php"><i class="fa fa-user"></i> <span>Customers</span></a></li>
        <li><a href="./supplier.php"><i class="fa fa-user-plus"></i> <span>Suppliers</span></a></li>          
        <li><a href="./expense.php"><i class="fa fa-money"></i> <span>Expense</span></a></li>
        <li><a href="./register.php"><i class="fa fa-users"></i> <span>List of user</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
