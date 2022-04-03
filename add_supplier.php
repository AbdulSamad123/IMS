<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']!=="Admin"){
        header('location:index.php');
    }
    include_once'inc/header_all.php';

    if(isset($_POST['add_supplier'])){

        $name = $_POST['name'];
        $address = $_POST['address'];
        $balance = $_POST['balance'];
        
        //insert query here
        
        $insert = $pdo->prepare("INSERT INTO tbl_supplier(name,address,balance) VALUES(:name,:address,:balance)");

        //binding the values parameter with input from user
        $insert->bindParam(':name',$name);
        $insert->bindParam(':address',$address);
        $insert->bindParam(':balance',$balance);

        //if execution $insert
        if($insert->execute()){
            echo'<script type="text/javascript">
                jQuery(function validation(){
                swal("Success", "New Supplier Added", "success", {
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
        Supplier
      </h1>
      <hr>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Enter New Supplier</h3>
            </div>
            <form action="" method="POST" name="form_product"
                enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Name</label><br>
                            <input type="text" class="form-control"
                            name="name">
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" class="form-control"
                            name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="">Contact Number</label>
                            <input type="text" class="form-control"
                            name="balance" required>
                        </div>                        
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"
                    name="add_supplier">Add Supplier</button>
                    <a href="supplier.php" class="btn btn-warning">Back</a>
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