<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['username']==""){
      header('location:index.php');
    }else{
      if($_SESSION['role']=="Admin"){
        include_once'inc/header_all.php';
      }else{
          include_once'inc/header_all_operator.php';
      }
    }
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Expense
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-body">
              <?php
                $id = $_GET['id'];

                $select = $pdo->prepare("SELECT * FROM tbl_expense WHERE expense_id=$id");
                $select->execute();
                while($row = $select->fetch(PDO::FETCH_OBJ)){ ?>

                <div class="col-md-6">
                  <ul class="list-group">

                    <center><p class="list-group-item list-group-item-success">Expense Detail</p></center>
                    <li class="list-group-item"> <b>Expense id</b>     :<span class="label badge pull-right"><?php echo $row->expense_id; ?></span></li>
                    <li class="list-group-item"><b>Expense Type</b>    :<span class="label label-info pull-right"><?php echo $row->Type; ?></span></li>
                    <li class="list-group-item"><b>Expense Discripion</b>        :<span class="label label-primary pull-right"><?php echo $row->discription; ?></span></li>
                    <li class="list-group-item"><b>Expense Date</b>        :<span class="label label-danger pull-right"><?php echo $row->date; ?></span></li>
                    <li class="list-group-item"><b>Expense Amount</b>  :<span class="label label-warning pull-right">Rp. <?php echo number_format($row->Amount); ?></span></li>
                  </ul>
                </div>

              <?php
                }
              ?>
            </div>
            <div class="box-footer">
                <a href="expense.php" class="btn btn-warning">Back</a>
            </div>

        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php
    include_once'inc/footer_all.php';
 ?>