<?php
  include_once'db/connect_db.php';
  session_start();
  if($_SESSION['role']!=="Admin"){
    header('location:index.php');
  }
  include_once'inc/header_all.php';


if(isset($_POST['edit_customer'])){
      $ty = $_POST['name'];
      $dis = $_POST['address'];
      $mb = $_POST['mobile'];
      $am = $_POST['balance'];
      $update = $pdo->prepare("UPDATE tbl_customer SET name='$ty', address='$dis',mobile='$mb', balance='$am' WHERE customer_id='".$_GET['id']."' ");
      $update->bindParam(':name', $ty);
      $update->bindParam(':address', $dis);
      $update->bindParam(':mobile', $mb);
      $update->bindParam(':balance', $am);
      
      if($update->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "Customer Has Been Updated", "info", {
            button: "Continue",
                });
            });
            </script>';
    }
}


if($id=$_GET['id']){
    $select = $pdo->prepare("SELECT * FROM tbl_customer WHERE customer_id = '".$_GET['id']."' ");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    $cus_id = $row->customer_id;
    $cus_nm = $row->name;
    $cus_ad = $row->address;
    $cus_mb = $row->mobile;
    $cus_bl = $row->balance;

}else{
    header('location:customer.php');
}


  include_once'inc/header_all.php';

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>

      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Customer</h3>
            </div>
            <form action="" method="POST" name="form_product"
                enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Customer id</label>
                            <input type="text" class="form-control"
                            name="expense_id" value="<?php echo $cus_id; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control"
                            name="name" value="<?php echo $cus_nm; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text" 
                            class="form-control"
                            name="address" value="<?php echo $cus_ad; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Contact Number</label>
                            <input type="text"
                            class="form-control"
                            name="mobile" value="<?php echo $cus_mb; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Balance</label>
                            <input type="text"
                            class="form-control"
                            name="balance" value="<?php echo $cus_bl; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"
                    name="edit_customer">Update Customer</button>
                    <a href="customer.php" class="btn btn-warning">Back</a>
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