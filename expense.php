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

    $id = $_GET['id'];

    $delete = $pdo->prepare("DELETE FROM tbl_expense WHERE expense_id=".$id);

    if($delete->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "Expense Has Been Deleted", "info", {
            button: "Continue",
                });
            });
            </script>';
    }

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
                <h3 class="box-title">Expense List</h3>
                <a href="add_expense.php" class="btn btn-success btn-sm pull-right">Add Expense</a>
            </div>
            <div class="box-body">
                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myProduct">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Type</th>
                                <th>Discription</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $select = $pdo->prepare("SELECT * FROM tbl_expense");
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                            ?>
                                <tr>
                                <td><?php echo $no++ ;?></td>
                                <td><?php echo $row->Type; ?></td>
                                <td><?php echo $row->discription; ?></td>
                                <td><?php echo $row->date; ?></td>
                                <td>Rp <?php echo number_format($row->Amount,2);?></td>
                                                               <td>
                                    <?php if($_SESSION['role']=="Admin"){ ?>
                                    <a href="expense.php?id=<?php echo $row->expense_id; ?>"
                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    <a href="edit_expense.php?id=<?php echo $row->expense_id; ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                                    <?php
                                    }
                                    ?>
                                    <a href="view_expense.php?id=<?php echo $row->expense_id; ?>" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
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