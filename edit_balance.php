<?php
  include_once'db/connect_db.php';
  session_start();
  if($_SESSION['role']!=="Admin"){
    header('location:index.php');
  }
  include_once'inc/header_all.php';


if(isset($_POST['edit_customer'])){
      $ty = $_POST['Cus_name'];
      $dy = $_POST['date'];
      $am = $_POST['balance'];
      $dis = $_POST['received'];
      $bal = $_POST['net_bal'];

      
      $update = $pdo->prepare("UPDATE tbl_balance SET Cus_name='$ty', date='$dy', balance='$am', received='$dis', net_bal='$bal'  WHERE id='".$_GET['id']."' ");
      $update->bindParam(':Cus_name', $ty);
      $update->bindParam(':date', $dy);
      $update->bindParam(':balance', $am);  
      $update->bindParam(':received', $dis);
      $update->bindParam(':net_bal', $bal);

      
      if($update->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "Balance Has Been Updated", "info", {
            button: "Continue",
                });
            });
            </script>';
    }
}


if($id=$_GET['id']){
    $select = $pdo->prepare("SELECT * FROM tbl_balance WHERE id = '".$_GET['id']."' ");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    $cus_id = $row->id;
    $cus_nm = $row->Cus_name;
    $cus_ad = $row->date;
    $cus_bl = $row->balance;
    $cus_rc = $row->received;
    $cus_nb = $row->net_bal;

}else{
    header('location:cus_balance.php');
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
                <h3 class="box-title">Edit Balance</h3>
            </div>
            <form action="" method="POST" name="form_product"
                enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Balance id</label>
                            <input type="text" class="form-control"
                            name="cus_id" value="<?php echo $cus_id; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control"
                            name="Cus_name" value="<?php echo $cus_nm; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="date" 
                            class="form-control"
                            name="date" value="<?php echo $cus_ad; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Balance</label>
                            <input type="text"
                            class="form-control"
                            name="balance" value="<?php echo $cus_bl; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Received</label>
                            <input type="text"
                            class="form-control"
                            name="received" value="<?php echo $cus_rc; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Net Balance</label>
                            <input type="text"
                            class="form-control"
                            name="net_bal" value="<?php echo $cus_nb; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"
                    name="edit_customer">Update Balance</button>
                    <a href="show_bal.php" class="btn btn-warning">Back</a>
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