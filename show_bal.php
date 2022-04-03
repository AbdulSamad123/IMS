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

    error_reporting(0);


?>
<html>
<head>
<meta http-equiv="refresh" content="60">
</head>
</html>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Balance List</h3>
                </div>
            <div class="box-body">
                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myProduct">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Balance</th>
                                <th>Received</th>
                                <th>Current balance</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $select = $pdo->prepare("SELECT * from tbl_balance");
                            $select->execute();                            
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                            ?>
                                <tr>
                                <td><?php echo $no++ ;?></td>
                                <td><?php echo $row->Cus_name; ?></td>
                                <td><?php echo $row->date; ?></td>
                                <td><?php echo $row->balance;?></td>
                                <td><?php echo $row->received; ?></td>
                                <td><?php echo $row->net_bal; ?></td>
                                <td>
                                    <?php if($_SESSION['role']=="Admin"){ ?>
                                    <a href="edit_balance.php?id=<?php echo $row->id; ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                    <?php
                                    }
                                    ?>
                                </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
  $(document).ready( function () {
      $('#myProduct').DataTable();
  } );
  </script>

 <?php
    include_once'inc/footer_all.php';
 ?>