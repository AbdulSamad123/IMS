<?php
$conn = mysqli_connect('localhost', 'root', '', 'ipos'); 
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
    
   if(isset($_POST['add_amt'])){

    $sup_name = $_POST['sup_name'];
    $date = $_POST['date'];
    $balance = $_POST['balance'];
    $received = $_POST['received'];
    $net_bal = $_POST['net_bal'];

    //insert query here
    
    $insert = $pdo->prepare("INSERT INTO tbl_pay(sup_name,date,balance,received,net_bal) VALUES(:sup_name,:date,:balance,:received,:net_bal)");

    //binding the values parameter with input from user
    $insert->bindParam(':sup_name',$sup_name);
    $insert->bindParam(':date',$date);
    $insert->bindParam(':balance',$balance);
    $insert->bindParam(':received',$received);
    $insert->bindParam(':net_bal',$net_bal);

    //if execution $insert
    if($insert->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Success", "Amount Added", "success", {
            button: "Continue",
                });
            });
            </script>';
      }
 }


   $cust_id = $_GET['id'];
   $select = "SELECT tbl_supplier.supplier_id, tbl_supplier.name, sum(tbl_purchase.due) as bal from tbl_purchase join tbl_supplier on tbl_supplier.supplier_id=tbl_purchase.supplier_id  where tbl_supplier.supplier_id='".$cust_id."'";
   $run_query = mysqli_query($conn, $select);

   if(mysqli_num_rows($run_query) > 0)
        {
        while($row = mysqli_fetch_array($run_query)){
            $customer_name = $row['name'];
            $balance = $row['bal'];

            
    ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Balance
      </h1>
      <hr>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add Balance</h3>
            </div>
            <form action="" method="POST" name="form_product"
                enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                                <label for="exampleInputEmail1">Supplier Name</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="sup_name" value="<?php echo $customer_name?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                                <label for="exampleInputEmail1">Date</label>
                                <input type="date" class="form-control" name="date">
                            </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="num1">Balance</label>
                                <input type="number" class="input form-control" name="balance" value="<?php echo $balance ?>" id="num1" readonly >
                            </div>
                        </div>
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="num2">Received</label>
                                <input type="number" class="input form-control" name="received" id="num2">
                            </div>
                            </div>
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="result">Total</label>
                                <input type="number" class="form-control" name="net_bal" id="result" readonly>
                            </div>
                            </div>


                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="add_amt">Add Amount</button>
                    <a href="sup_balance.php" class="btn btn-warning">Back</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
      $(".input").on('input',function(){
          
          var x = document.getElementById('num1').value;
          x = parseFloat(x);

          var y = document.getElementById('num2').value;
          y = parseFloat(y);

          document.getElementById('result').value = x - y;

      });
  </script>

 <?php
    include_once'inc/footer_all.php';
        }
    }
 ?>