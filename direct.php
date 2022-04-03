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


    if(isset($_POST['save_purchase'])){
      $customer_name = $_POST['customer_name'];
      $cashier_name = $_POST['cashier_name'];
      $order_date = date("Y-m-d",strtotime($_POST['orderdate']));
      $order_time = date("H:i", strtotime($_POST['timeorder']));
      $total = $_POST['total'];
      $discount = $_POST['discount'];     
      $paid = $_POST['paid'];
      $due = $_POST['due'];
      $credit = $_POST['credit'];
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


        $insert = $pdo->prepare("INSERT INTO tbl_invoice(customer_name, cashier_name, order_date, time_order, total, discount, paid, due, credit, duedate)
        values(:customer_name, :name, :orderdate, :timeorder, :total, :discount, :paid, :due, :credit, :duedate)");

        $insert->bindParam(':customer_name', $customer_name);
        $insert->bindParam(':name', $cashier_name);
        $insert->bindParam(':orderdate',  $order_date);
        $insert->bindParam(':timeorder',  $order_time);
        $insert->bindParam(':total', $total);
        $insert->bindParam(':discount', $discount);
        $insert->bindParam(':paid', $paid);
        $insert->bindParam(':due', $due);
        $insert->bindParam(':credit', $credit);
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
     Direct-Sale
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
                  <label>Supplier name</label>
                  <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                            </div>
                            <select class="form-control pull-right" name="supplier_name" required>
                                <?php
                                $select = $pdo->prepare("SELECT * FROM tbl_supplier");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                    extract($row)
                                ?>
                                    <option><?php echo $row['name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            </div>
                  <!-- /.input group -->
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Vehicle No</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="cashier_name">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Date</label>
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
                          <th>Item Name</th>
                          <th colspan="2">Purchase</th>
                          <th colspan="2">Direct Sale</th>
                          <th colspan="5">Warehouse</th>
                          <th>Expense</th>
                          <th>Freight</th>
                          <th>Amount</th>
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
            <div class="col-md-3">
                <div class="form-group">
                  <label>Customer name</label>
                  <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                            </div>
                            <select class="form-control pull-right" name="customer_name" required>
                                <?php
                                $select = $pdo->prepare("SELECT * FROM tbl_customer");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                    extract($row)
                                ?>
                                    <option><?php echo $row['name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            </div>
                  <!-- /.input group -->
                </div>
              </div>

              <div class="col-md-1">
                <div class="form-group">
                  <label>Item</label>
                  <div class="input-group">
                    <input type="text" class="form-control pull-right" name="cashier_name">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group">
                  <label>Warehouse</label>
                  <div class="input-group">
                    <input type="text" class="form-control pull-right" name="itname">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group">
                  <label>Bag</label>
                  <div class="input-group">
                    <input type="text" class="form-control pull-right" name="ware">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group">
                  <label>Kgs</label>
                  <div class="input-group">
                    <input type="text" class="form-control pull-right" name="ware">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group">
                  <label>Bag Rate</label>
                  <div class="input-group">
                    <input type="text" class="form-control pull-right" name="ware">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group">
                  <label>Kg Rate</label>
                  <div class="input-group">
                    <input type="text" class="form-control pull-right" name="ware">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group">
                  <label>Expense</label>
                  <div class="input-group">
                    <input type="text" class="form-control pull-right" name="ware">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group">
                  <label>Freight</label>
                  <div class="input-group">
                    <input type="text" class="form-control pull-right" name="ware">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group">
                  <label>Amount</label>
                  <div class="input-group">
                    <input type="text" class="form-control pull-right" name="ware">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
            </div>

            <div class="box-body">
 
            </div>

            <div class="box-footer" align="center">
              <input type="submit" name="save_purchase" value="Save" class="btn btn-success">
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
        html+='<tr>';
        html+='<td><input type="hidden" class="form-control productcode" name="productcode[]" readonly></td>';
        html+='<td><input type="text" class="form-control productname" style="width:50px;" name="productname[]" placeholder="Item"></td>';
        html+='<td><input type="text" class="form-control productname" style="width:50px;" name="productname[]" placeholder="Bags"></td>';
        html+='<td><input type="text" class="form-control productname" style="width:50px;" name="productname[]" placeholder="Kgs"></td>';
        html+='<td><input type="text" class="form-control productname" style="width:50px;" name="productname[]" placeholder="Bags"></td>';
        html+='<td><input type="text" class="form-control productname" style="width:50px;" name="productname[]" placeholder="Kgs"></td>';
        html+='<td><select class="form-control productid" name="productid[]" style="width:80px;" required><option value="">--Select Product--</option><?php
        echo fill_product($pdo)?></select></td>';
        html+='<td><input type="text" class="form-control productname" style="width:50px;" name="productname[]" placeholder="Bags"></td>';
        html+='<td><input type="text" class="form-control productname" style="width:50px;" name="productname[]" placeholder="Kgs"></td>';
        html+='<td><input type="text" class="form-control productname" style="width:50px;" name="productname[]" placeholder="Bags rate"></td>';
        html+='<td><input type="text" class="form-control productname" style="width:50px;" name="productname[]" placeholder="Kgs" rate></td>';  
        html+='<td><input type="text" class="form-control productname" style="width:50px;" name="productname[]" placeholder="Expense"></td>';
        html+='<td><input type="text" class="form-control productstock" style="width:50px;" name="productstock[]" placeholder="Freight"></td>';
        html+='<td><input type="text" class="form-control productstock" style="width:50px;" name="productstock[]" placeholder="Amount"></td>';
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
              tr.find(".productprice").val(data["sell_price"]);
              tr.find(".quantity_product").val(0);
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