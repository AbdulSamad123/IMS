<?php
    include_once'db/connect_db.php';
    $conn = mysqli_connect('localhost', 'root', '', 'ipos');
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
    if(isset($_POST['generate_report'])) {
     $customer_id = $_POST['customer_id'];
      $date_1 = $_POST['date_1'];
      $date_2 = $_POST['date_2'];

     $_SESSION['name']=$customer_id;
     $_SESSION['date_1']=$date_1;
     $_SESSION['date_2']=$date_2;
     $insert=mysqli_query($conn,"SELECT tbl_customer.name, tbl_invoice.order_date, tbl_invoice_detail.price, tbl_invoice_detail.total, tbl_invoice_detail.product_name, tbl_invoice_detail.qty From tbl_customer join tbl_invoice on tbl_customer.customer_id=tbl_invoice.customer_id join tbl_invoice_detail ON tbl_invoice.invoice_id = tbl_invoice_detail.invoice_id WHERE tbl_invoice.customer_id = '$customer_id' and tbl_invoice.order_date BETWEEN '$date_1' and '$date_2'");
     $num=mysqli_num_rows($insert);
     if($insert)
     {
      echo "<script>window.location.assign('form_3.php')</script>";
     }
    
  }
    error_reporting(0);

    function fill_custom($pdo){
      $output= '';

      $select = $pdo->prepare("SELECT * FROM tbl_customer");
      $select->execute();
      $result = $select->fetchAll();

      foreach($result as $row){
        $output.='<option value="'.$row['customer_id'].'">'.$row["name"].'</option>';
      }

      return $output;
    }

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
          <form method="POST" autocomplete="off">
            <div class="box-header with-border">
                <h3 class="box-title">Stating Date : </h3>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <h3 class="box-title">Ending Date : </h3>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <h3 class="box-title">Customer Name : </h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker_1" name="date_1" data-date-format="yyyy-mm-dd" required>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker_2" name="date_2" data-date-format="yyyy-mm-dd" required>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                <div class="form-group">
                  <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                            </div>
                            <select class="form-control pull-right" name="customer_id" required>
                            <option value="">--Select Customer --</option><?php
                             echo fill_custom($pdo)?></select>
                            </div>
                  <!-- /.input group -->
                </div>
              </div>
                <div class="col-md-3">
                    <input type="submit" class="btn btn-success" name="generate_report">
                </div>
                <br>
              </div>
              </div>

          </form>
        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
  <script>
    //Date picker
    $('#datepicker_1').datepicker({
      autoclose: true
    });
    //Date picker
    $('#datepicker_2').datepicker({
      autoclose: true
    });
  </script>


 <?php
    include_once'inc/footer_all.php';
 ?>