<?php
  include_once'db/connect_db.php';
  session_start();
  if($_SESSION['role']!=="Admin"){
    header('location:index.php');
  }
  include_once'inc/header_all.php';


if(isset($_POST['edit_expense'])){
      $ty = $_POST['Type'];
      $dis = $_POST['discription'];
      $dt = $_POST['date'];
      $am = $_POST['Amount'];
      $update = $pdo->prepare("UPDATE tbl_expense SET Type='$ty', discription='$dis',date='$dt', Amount='$am' WHERE expense_id='".$_GET['id']."' ");
      $update->bindParam(':Type', $ty);
      $update->bindParam(':discription', $dis);
      $update->bindParam(':date', $dt);
      $update->bindParam(':Amount', $am);
      
      if($update->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "Expense Has Been Updated", "info", {
            button: "Continue",
                });
            });
            </script>';
    }
}


if($id=$_GET['id']){
    $select = $pdo->prepare("SELECT * FROM tbl_expense WHERE expense_id = '".$_GET['id']."' ");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    $exp_id = $row->expense_id;
    $exp_ty = $row->Type;
    $exp_dis = $row->discription;
    $exp_dt = $row->date;
    $exp_am = $row->Amount;

}else{
    header('location:expense.php');
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
                <h3 class="box-title">Edit Expense</h3>
            </div>
            <form action="" method="POST" name="form_product"
                enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Expense id</label>
                            <input type="text" class="form-control"
                            name="expense_id" value="<?php echo $exp_id; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Expense Type</label>
                            <input type="text" class="form-control"
                            name="Type" value="<?php echo $exp_ty; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Expense Discription</label>
                            <input type="text" 
                            class="form-control"
                            name="discription" value="<?php echo $exp_dis; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Expense Date</label>
                            <input type="date"
                            class="form-control"
                            name="date" value="<?php echo $exp_dt; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Expense Amount</label>
                            <input type="number"
                            class="form-control"
                            name="Amount" value="<?php echo $exp_am; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"
                    name="edit_expense">Update Product</button>
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