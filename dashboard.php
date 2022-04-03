<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']=="Admin"){
      include_once'inc/header_all.php';
    }else{
        include_once'inc/header_all_operator.php';
    }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid">
      <div class="row">
        <!-- get alert stock -->
        <?php
        $select = $pdo->prepare("SELECT count(product_code) as total FROM tbl_product WHERE stock <= min_stock");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $total1 = $row->total;
        ?>
        <!-- get alert notification -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-archive"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Stock Ending</span>
              <?php if($total1==true){ ?>
              <span class="info-box-number"><small><?php echo $row->total;?></small></span>
              <?php }else{?>
              <span class="info-box-text"><strong>Nill</strong></span>
              <?php }?>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


        <!-- get total products-->
        <?php
        $select = $pdo->prepare("SELECT count(product_code) as t FROM tbl_product");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $total = $row->t;
        ?>

        <!-- get total products notification -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-cubes"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Products</span>
              <span class="info-box-number"><small><?php echo $row->t ?></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <!-- get today transactions -->
        <?php
        $select = $pdo->prepare("SELECT sum(Amount) as i FROM tbl_expense WHERE date = CURDATE()");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $invoice = $row->i ;
        ?>
         <!-- get today transactions notification -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Today's Expense</span>
              <span class="info-box-number"><small>Rp. <?php echo $row->i  ?></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

      </div>

      <div class="row">

              <!-- get today income -->
              <?php
        $select = $pdo->prepare("SELECT sum(total) as total FROM tbl_invoice WHERE order_date = CURDATE()");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $total = $row->total ;
        ?>
         <!-- get today income -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-dollar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Today's Income</span>
              <span class="info-box-number"><small>Rp. <?php echo number_format($row->total,2); ?></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <!-- get today transactions -->
        <?php
        $select = $pdo->prepare("SELECT sum(due) as total FROM tbl_invoice WHERE credit=1 and duedate >= CURDATE()");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $invoice = $row->total ;
        ?>
         <!-- get today transactions notification -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-bank"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Amount Receivale</span>
              <span class="info-box-number"><small>Rp. <?php echo number_format($invoice,2); ?></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <!-- get today income -->
        <?php
        $select = $pdo->prepare("SELECT sum(due) as total FROM tbl_purchase WHERE credit=1 and duedate >= CURDATE()");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
        $total = $row->total ;
        ?>
         <!-- get today income -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-credit-card"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Amount Payable</span>
              <span class="info-box-number"><small>Rp. <?php echo number_format($total,2) ?></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

      </div>

      <div class="col-md-offset-1 col-md-10">
        <div class="box box-success">
          <div class="box-header with-border">
              <h3 class="box-title">Profit loss</h3>
          </div>
          <div class="box-body">
            <div class="col-md-offset-1 col-md-10">
              <div style="overflow-x:auto;">
                  <table class="table table-striped" id="pl">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Sale</th>
                              <th>Purchase</th>
                              <th>Receivable</th>
                              <th>Payable</th>
                          </tr>

                      </thead>
                      <tbody>
                          <?php
                          $no = 0;

                          $select = $pdo->prepare("SELECT SUM(tbl_invoice.total) as a,SUM(tbl_invoice.due) as b,SUM(tbl_purchase.total) as c, SUM(tbl_purchase.due) as d from tbl_invoice, tbl_purchase ");
                          $select->execute();
                          while($row=$select->fetch(PDO::FETCH_OBJ)){
                          ?>
                              <tr>
                              <td><?php echo $no++ ;?></td>
                              <td>Rp <?php echo number_format($row->a,2);?></td>
                              <td>Rp <?php echo number_format($row->c,2);?></td>
                              <td>Rp <?php echo number_format($row->b,2); ?></td>
                              <td>Rp <?php echo number_format($row->d,2); ?></td>
                              </tr>

                        <?php
                          }
                        ?>
                      </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-offset-1 col-md-10">
        <div class="box box-success">
          <div class="box-header with-border">
              <h3 class="box-title">List of Stock Ending items</h3>
          </div>
          <div class="box-body">
            <div class="col-md-offset-1 col-md-10">
              <div style="overflow-x:auto;">
                  <table class="table table-striped" id="tbstock">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Product Name</th>
                              <th>Product Category</th>
                              <th>Product Unit</th>
                              <th>Discription</th>
                          </tr>

                      </thead>
                      <tbody>
                          <?php
                          $no = 0;

                          $select = $pdo->prepare("SELECT * FROM tbl_product where stock <= 5");
                          $select->execute();
                          while($row=$select->fetch(PDO::FETCH_OBJ)){
                          ?>
                              <tr>
                              <td><?php echo $no++ ;?></td>
                              <td><?php echo $row->product_name; ?></td>
                              <td><?php echo $row->product_category; ?></td>
                              <td><?php echo $row->product_satuan; ?></td>
                              <td><?php echo $row->description; ?></td>
                              </tr>

                        <?php
                          }
                        ?>
                      </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-offset-1 col-md-10">
        <div class="box box-success">
          <div class="box-header with-border">
              <h3 class="box-title">List of Sold Products</h3>
          </div>
          <div class="box-body">
            <div class="col-md-offset-1 col-md-10">
              <div style="overflow-x:auto;">
                  <table class="table table-striped" id="myBestPurchase">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Product</th>
                              <th>code</th>
                              <th>Sold</th>
                              <th>Price</th>
                              <th>Income</th>
                          </tr>

                      </thead>
                      <tbody>
                          <?php
                          $no = 0;

                          $select = $pdo->prepare("SELECT product_code,product_name,price,sum(qty) as q, sum(qty*price) as total FROM
                          tbl_invoice_detail GROUP BY product_id ORDER BY sum(qty) DESC LIMIT 30");
                          $select->execute();
                          while($row=$select->fetch(PDO::FETCH_OBJ)){
                          ?>
                              <tr>
                              <td><?php echo $no++ ;?></td>
                              <td><?php echo $row->product_name; ?></td>
                              <td><?php echo $row->product_code; ?></td>
                              <td><?php echo $row->q; ?>
                              </td>
                              <td>Rp <?php echo number_format($row->price,2);?></td>
                              <td>Rp <?php echo number_format($row->total,2); ?></td>
                              </tr>

                        <?php
                          }
                        ?>
                      </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-offset-1 col-md-10">
        <div class="box box-success">
          <div class="box-header with-border">
              <h3 class="box-title">List of Amount Receivale</h3>
          </div>
          <div class="box-body">
            <div class="col-md-offset-1 col-md-10">
              <div style="overflow-x:auto;">
                  <table class="table table-striped" id="myBest">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Customer Name</th>
                              <th>Order Date</th>
                              <th>Due Date</th>
                              <th>Total</th>
                              <th>Paid</th>
                              <th>Balance</th>
                          </tr>

                      </thead>
                      <tbody>
                          <?php
                          $no = 0;

                          $select = $pdo->prepare("SELECT tbl_customer.name, tbl_invoice.order_date, tbl_invoice.total, tbl_invoice.duedate, tbl_invoice.paid,due from tbl_invoice join tbl_customer on tbl_customer.customer_id=tbl_invoice.customer_id where credit=1");
                          $select->execute();
                          while($row=$select->fetch(PDO::FETCH_OBJ)){
                          ?>
                              <tr>
                              <td><?php echo $no++ ;?></td>
                              <td><?php echo $row->name; ?></td>
                              <td><?php echo $row->order_date; ?></td>
                              <td><?php echo $row->duedate; ?></td>
                              <td>Rp <?php echo number_format($row->total,2);?></td>
                              <td>Rp <?php echo number_format($row->paid,2);?></td>
                              <td>Rp <?php echo number_format($row->due,2); ?></td>
                              </tr>

                        <?php
                          }
                        ?>
                      </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-offset-1 col-md-10">
        <div class="box box-success">
          <div class="box-header with-border">
              <h3 class="box-title">List of Amount Payable</h3>
          </div>
          <div class="box-body">
            <div class="col-md-offset-1 col-md-10">
              <div style="overflow-x:auto;">
                  <table class="table table-striped" id="myBestpay">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Supplier Name</th>
                              <th>Order Date</th>
                              <th>Due Date</th>
                              <th>Total</th>
                              <th>Paid</th>
                              <th>Balance</th>
                          </tr>

                      </thead>
                      <tbody>
                          <?php
                          $no = 0;

                          $select = $pdo->prepare("SELECT tbl_supplier.name, tbl_purchase.order_date, tbl_purchase.total, tbl_purchase.duedate, tbl_purchase.paid, tbl_purchase.due from tbl_purchase join tbl_supplier on tbl_supplier.supplier_id=tbl_purchase.supplier_id where credit=1");
                          $select->execute();
                          while($row=$select->fetch(PDO::FETCH_OBJ)){
                          ?>
                              <tr>
                              <td><?php echo $no++ ;?></td>
                              <td><?php echo $row->name; ?></td>
                              <td><?php echo $row->order_date; ?></td>
                              <td><?php echo $row->duedate; ?></td>
                              <td>Rp <?php echo number_format($row->total,2);?></td>
                              <td>Rp <?php echo number_format($row->paid,2);?></td>
                              <td>Rp <?php echo number_format($row->due,2); ?></td>
                              </tr>

                        <?php
                          }
                        ?>
                      </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
  $(document).ready( function () {
      $('#pl').DataTable();
  } );
  </script>
  <script>
  $(document).ready( function () {
      $('#myBestProduct').DataTable();
  } );
  </script>
    <script>
  $(document).ready( function () {
      $('#myBestPurchase').DataTable();
  } );
  </script>
<script>
  $(document).ready( function () {
      $('#myBest').DataTable();
  } );
  </script>
<script>
  $(document).ready( function () {
      $('#myBestpay').DataTable();
  } );
  </script>
  <script>
  $(document).ready( function () {
      $('#tbstock').DataTable();
  } );
  </script>
  <script>
    $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'print'
        ]
    } );
} );
</script>


 <?php
    include_once'inc/footer_all.php';
 ?>