<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']!=="Admin"){
        header('location:index.php');
    }
    include_once'inc/header_all.php';

    if(isset($_POST['add_expense'])){

        $type = $_POST['Type'];
        $discription = $_POST['discription'];
        $date = $_POST['date'];
        $amount = $_POST['Amount'];
        
        //insert query here
        
        $insert = $pdo->prepare("INSERT INTO tbl_expense(Type,discription,date,Amount) VALUES(:type,:discription,:date,:amount)");

        //binding the values parameter with input from user
        $insert->bindParam(':type',$type);
        $insert->bindParam(':discription',$discription);
        $insert->bindParam(':date',$date);
        $insert->bindParam(':amount',$amount);

        //if execution $insert
        if($insert->execute()){
            echo'<script type="text/javascript">
                jQuery(function validation(){
                swal("Success", "New Expense Added", "success", {
                button: "Continue",
                    });
                });
                </script>';
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
      <hr>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Enter New Expense</h3>
            </div>
            <form action="" method="POST" name="form_product"
                enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Expense Type</label><br>
                            <input type="text" class="form-control"
                            name="Type">
                        </div>
                        <div class="form-group">
                            <label for="">Expanse Description</label>
                            <textarea name="discription" id="description"
                            cols="20" rows="10" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="date" class="form-control"
                            name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="number" class="form-control"
                            name="Amount" required>
                        </div>                        
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"
                    name="add_expense">Add Expense</button>
                    <a href="expense.php" class="btn btn-warning">Back</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


 <?php
    include_once'inc/footer_all.php';
 ?>