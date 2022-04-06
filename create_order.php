  <?php
   include_once'db/connect_db.php';
   session_start();
   if($_SESSION['username']==""){
     include_once'inc/404.php';
   }else{
     if($_SESSION['role']=="Admin"){
       include_once'inc/header_all.php';
     }else{
         include_once'inc/header_all_operator.php';
     }
   }


    error_reporting(0);
    date_default_timezone_set('Asia/karachi');

    function fill_product($pdo){
      $output= '';

      $select = $pdo->prepare("SELECT * FROM tbl_product order by product_name ASC");
      $select->execute();
      $result = $select->fetchAll();

      foreach($result as $row){
        $output.='<option value="'.$row['product_id'].'">'.$row["product_name"].'</option>';
      }

      return $output;
    }

    function fill_ware($pdo){
      $output= '';

      $select = $pdo->prepare("SELECT * FROM tbl_warehouse");
      $select->execute();
      $result = $select->fetchAll();

      foreach($result as $row){
        $output.='<option value="'.$row['war_id'].'">'.$row["war_name"].'</option>';
      }

      return $output;
    }
    
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

    


    if(isset($_POST['save_purchase'])){
      $customer_id = $_POST['customer_id'];
      $war_id = $_POST['war_id'];
      $order_date = date("Y-m-d",strtotime($_POST['orderdate']));
      $order_time = date("H:i", strtotime($_POST['timeorder']));
      $total = $_POST['total'];
      $labour_exp = $_POST['labour_exp'];
      $product_exp = $_POST['product_exp'];
      $discount = $_POST['discount'];     
      $paid = $_POST['paid'];
      $due = $_POST['due'];
      $credit = $_POST['credit'];
      $bank_name = $_POST['bank_name'];
      $account_no = $_POST['account_no'];
      $cheque_no = $_POST['cheque_no'];
      $duedate = $_POST['duedate'];

      $arr_product_id =  $_POST['productid'];
      $arr_product_code = $_POST['productcode'];
      $arr_product_name = $_POST['productname'];
      $arr_product_stock = $_POST['productstock'];
      $arr_product_qty = $_POST['quantity'];
      $arr_product_satuan = $_POST['productsatuan'];
      $arr_product_price = $_POST['productprice'];
      $arr_product_total =  $_POST['producttotal'];

      if($arr_product_code == ""){
        echo '<script type="text/javascript">
              jQuery(function validation(){
              swal("Warning", "Please Fill in the Sales Form", "warning", {
              button: "Continue",
                  });
              });
              </script>';
      }else{


        $insert = $pdo->prepare("INSERT INTO tbl_invoice(customer_id, war_id, order_date, time_order, total, labour_exp, product_exp, discount, paid, due, credit, bank_name, account_no, cheque_no , duedate)
        values(:customer_id, :war_id, :orderdate, :timeorder, :total,:labour_exp,:product_exp, :discount, :paid, :due, :credit, :bank_name, :account_no, :cheque_no, :duedate)");

        $insert->bindParam(':customer_id', $customer_id);
        $insert->bindParam(':war_id', $war_id);
        $insert->bindParam(':orderdate',  $order_date);
        $insert->bindParam(':timeorder',  $order_time);
        $insert->bindParam(':total', $total);
        $insert->bindParam(':labour_exp', $labour_exp);
        $insert->bindParam(':product_exp', $product_exp);
        $insert->bindParam(':discount', $discount);
        $insert->bindParam(':paid', $paid);
        $insert->bindParam(':due', $due);
        $insert->bindParam(':credit', $credit);
        $insert->bindParam(':bank_name', $bank_name);
        $insert->bindParam(':account_no', $account_no);
        $insert->bindParam(':cheque_no', $cheque_no);
        $insert->bindParam(':duedate', $duedate);

        $insert->execute();


        $invoice_id = $pdo->lastInsertId();
        if($invoice_id!=null){
          for($i=0; $i<count($arr_product_id); $i++){

           $rem_qty = $arr_product_stock[$i] - $arr_product_qty[$i];

            if($rem_qty<0){
              echo '<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Enter Sales Amount", "warning", {
                    button: "Continue",
                        });
                    });
                    </script>';
            }else{
              $update = $pdo->prepare("UPDATE tbl_product SET stock = '$rem_qty' WHERE product_id='".$arr_product_id[$i]."'");
              $update->execute();
            }


            $insert = $pdo->prepare("INSERT INTO tbl_invoice_detail(invoice_id, product_id, product_code, product_name, qty, price, total, order_date)
            values(:invid, :productid, :productcode, :productname, :qty, :price, :total, :orderdate)");

            $insert->bindParam(':invid',  $invoice_id);
            $insert->bindParam(':productid',   $arr_product_id[$i]);
            $insert->bindParam(':productcode',   $arr_product_code[$i]);
            $insert->bindParam(':productname', $arr_product_name[$i]);
            $insert->bindParam(':qty', $arr_product_qty[$i]);
            // $insert->bindParam(':productsatuan', $arr_product_satuan[$i]);
            $insert->bindParam(':price',  $arr_product_price[$i]);
            $insert->bindParam(':total',   $arr_product_total[$i]);
            $insert->bindParam(':orderdate',  $order_date);

            $insert->execute();

          }
          echo '<script>location.href="order.php";</script>';

        }
      }

    }

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
     Sale
      </h1>
      <hr>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
          <form action="" method="POST">
            <div class="box-body"> 
            <div class="col-md-3">
                <div class="form-group">
                  <label>Customer name</label>  
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <select class="form-control pull-right" name="customer_id" required>
                    <option value="">--Select Customer--</option><?php
                      echo fill_custom($pdo)?></select>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Warehouse name</label>  
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <select class="form-control pull-right" name="war_id" required>
                    <option value="">--Select Warehouse--</option><?php
                      echo fill_ware($pdo)?></select>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Sale date</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" class="form-control pull-right" name="orderdate" 
                    data-date-format="yyyy-mm-dd">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Sale time</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="timeorder" value="<?php echo date('H:i') ?>" readonly>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
            </div>

            <div class="box-body">
              <div class="col-md-12" style="overflow-x:auto;">
                <table class="table table-border" id="myOrder">
                  <thead>
                      <tr>
                          <th></th>
                          <th>Code</th>
                          <th>Name</th>
                          <th>Quantity</th>
                          <th>Stock</th>
                          <th>Per Box</th>
                          <th>Price</th>
                          <th>Total</th>
                          <th>Unit</th>
                          <th>Weight</th>
                          <th>Gross Weight</th>
                          <th>Average</th>
                          <th>FRT</th>
                          <th>TFRT</th>
                          <th>TPT</th>
                          <th>
                            <button type="button" name="addOrder" class="btn btn-success btn-sm btn_addOrder" required><span>
                              <i class="fa fa-plus"></i>
                            </span></button>
                          </th>
                      </tr>

                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-offset-1 col-md-10">
                <div class="form-group">
                  <label>Total</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>Rp</span>
                    </div>
                    <input type="text" class="form-control pull-right" name="total" id="total" required readonly>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Labour Expense</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>Rp</span>
                    </div>
                    <input type="text" class="form-control pull-right" name="labour_exp"  required>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Product Expense</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>Rp</span>
                    </div>
                    <input type="text" class="form-control pull-right" name="product_exp"  required>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Discount</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>Rp</span>
                    </div>
                    <input type="text" class="form-control pull-right" name="discount" id="discount" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Pay Money</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>Rp</span>
                    </div>
                    <input type="text" class="form-control pull-right" name="paid" id="paid" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Balance</label>  
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>Rp <?php echo $_SESSION['invoice_id']; ?></span>
                    </div>
                    <input type="text" class="form-control pull-right" name="due" id="due" required readonly>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Credit</label>
                  <div class="form-check">
                  <input class="form-check-input" type="radio" value="0" name="credit"> Cash
                  <input class="form-check-input" type="radio" value="1" name="credit" checked>Cheque
                  </div>
                </div>
                <div class="form-group">
                  <label>Bank Name</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-bank"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="bank_name"  required>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Account Numberr</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="account_no"  required>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Cheque Number</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-money"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="cheque_no"  required>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Cheque Date</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" class="form-control pull-right" name="duedate" data-date-format="yyyy-mm-dd" required>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
            </div>

            <div class="box-footer" align="center">
              <input type="submit" name="save_purchase" value="Save Sale" class="btn btn-success">
              <a href="order.php" class="btn btn-warning">Back</a>
            </div>
          </form>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
  //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })

    $(document).ready(function(){
      $(document).on('click','.btn_addOrder', function(){

        var html='';
        html+='<tr class="dynamic_row">';
        html+='<td><input type="hidden" class="form-control productcode" name="productcode[]" readonly></td>';
        html+='<td><select class="form-control productid" name="productid[]" style="width:100px;" required><option value="">--Select Product--</option><?php
        echo fill_product($pdo)?></select></td>';
        html+='<td><input type="text" class="form-control productname" style="width:200px;" name="productname[]"></td>';
        html+='<td><input type="number" class="form-control quantity_product" style="width:100px;" name="quantity[]" required></td>';
        html+='<td><input type="text" class="form-control productstock" style="width:50px;" name="productstock[]"></td>';
        html+='<td><input type="text" class="form-control perpiece" style="width:100px;" name="perpiece[]"></td>';
        html+='<td><input type="text" class="form-control productprice" style="width:100px;" name="productprice[]"></td>';
        html+='<td><input type="text" class="form-control producttotal" style="width:150px;" name="producttotal[]"></td>';
        html+='<td><input type="text" class="form-control productsatuan" style="width:100px;" name="productsatuan[]"></td>';
        html+='<td><input type="text" class="form-control productweight" style="width:100px;" name="productweight[]"></td>';
        html+='<td><input type="text" class="form-control productgross" style="width:100px;" name="productgross[]"></td>';
        html+='<td><input type="text" class="form-control productaverage" style="width:100px;" name="productaverage[]"></td>';
        html+='<td><input type="text" class="form-control productfrt" style="width:100px;" name="productfrt[]"></td>';
        html+='<td><input type="text" class="form-control producttfrt" style="width:100px;" name="producttfrt[]"></td>';
        html+='<td><input type="text" class="form-control producttpt" style="width:100px;" name="producttpt[]"></td>';
      //  html+='<td><input type="text" class="form-control productsubtotal" style="width:150px;" name="productsubtotal[]"></td>';
        html+='<td><button type="button" name="remove" class="btn btn-danger btn-sm btn-remove"><i class="fa fa-remove"></i></button></td>'

        $('#myOrder').append(html);

        $('.productid').on('change', function(e){
          var productid = this.value;
          var tr=$(this).parent().parent();
          $.ajax({
            url:"getproduct.php",
            method:"get",
            data:{id:productid},
            success:function(data){
              //console.log(data);
              tr.find(".productcode").val(data["product_code"]);
              tr.find(".productname").val(data["product_name"]);
              tr.find(".productstock").val(data["stock"]);
              tr.find(".productsatuan").val(data["product_satuan"]);
              tr.find(".perpiece").val(data["per_piece"]);
              tr.find(".productprice").val(data["sell_price"]);
              tr.find(".quantity_product").val(0);
              tr.find(".productweight").val(0);
              tr.find(".productgross").val(0);
              tr.find(".productaverage").val(0);
              tr.find(".productfrt").val(0);
              tr.find(".producttfrt").val(0);
              tr.find(".producttpt").val(0);
              tr.find(".producttotal").val(tr.find(".quantity_product").val() * tr.find(".productprice").val());
              calculate(0,0);
            }
          })
        })

      })

      $(document).on('click','.btn-remove', function(){
        $(this).closest('tr').remove();
        calculate(0,0);
        $("#paid").val(0);
      })

      $("#myOrder").delegate(".quantity_product","keyup change", function(){
        var quantity = $(this);
        var tr=$(this).parent().parent();
        if((quantity.val()-0)>(tr.find(".productstock").val()-0)){
          swal("Warning","Insufficient Inventory","warning");
          quantity.val(1);
          tr.find(".producttotal").val(quantity.val() * tr.find(".productprice").val());
          calculate(0,0);
        }else{
          tr.find(".producttotal").val(quantity.val() * tr.find(".productprice").val());
          calculate(0,0);
        }
      })

      function calculate(paid){
        var net_total = 0;
        var discount = $('#discount').val();
        var paid = paid;

        $(".producttotal").each(function(){
          net_total = net_total + ($(this).val()*1);
        })

        due1 = net_total-discount;
        due =  due1 - paid;

        $("#total").val(net_total);
        $("#discount").val(discount);
        $("#due").val(due);
      }


      $("#paid").keyup(function(){
        var paid = $(this).val();
        calculate(paid);
      })

    });

  </script>


 <?php
    include_once'inc/footer_all.php';
 ?>