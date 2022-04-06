<?php
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

    if(isset($_POST['add_product'])){
        $code = $_POST['product_code'];
        $entry_date=$_POST['entry_date'];
        $product = $_POST['product_name'];
        $warehouse_name = $_POST['warehouse_name'];
        $product_category = $_POST['product_category'];
        $per_piece = $_POST['per_piece'];
        $purchase = $_POST['purchase_price'];
        $sell = $_POST['sell_price'];
        $stock = $_POST['stock'];
        $min_stock = $_POST['min_stock'];
        $vehicle_number = $_POST['vehicle_number'];
        $gate_pass= $_POST['gate_pass'];
        $batch_number = $_POST['batch_number'];
        $satuan = $_POST['satuan'];
        $supplier = $_POST['supplier'];
        $desc = $_POST['description'];


        if(isset($_POST['product_code'])){
            $select = $pdo->prepare("SELECT product_code FROM tbl_product WHERE product_code='$code'");
            $select->execute();

            if($select->rowCount() > 0 ){
                echo'<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Product Code Already Registered", "warning", {
                    button: "Continue",
                        });
                    });
                    </script>';
            }elseif (strlen($code)>6 || strlen($code)<6) {
                    echo'<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Code Must Be 6 Characters", "warning", {
                    button: "Continue",
                        });
                    });
                    </script>';
            }
                        if(!isset($error)){

                            $insert = $pdo->prepare("INSERT INTO tbl_product(product_code,entry_date,product_name,warehouse_name,product_category,per_piece,purchase_price,sell_price,stock,min_stock,vehicle_number,gate_pass,batch_number,product_satuan,supplier,description)
                            values(:product_code,:entry_date,:product_name,:warehouse_name,:product_category,:per_piece,:purchase_price,:sell_price,:stock,:min_stock,:vehicle_number,:gate_pass,:batch_number,:satuan,:supplier,:desc)");

                            $insert->bindParam(':product_code', $code);
                            $insert->bindParam(':entry_date', $entry_date);
                            $insert->bindParam(':product_name', $product);
                            $insert->bindParam(':warehouse_name', $warehouse_name);
                            $insert->bindParam(':product_category', $product_category);
                            $insert->bindParam(':per_piece', $per_piece);
                            $insert->bindParam(':purchase_price', $purchase);
                            $insert->bindParam(':sell_price', $sell);
                            $insert->bindParam(':stock', $stock);
                            $insert->bindParam(':min_stock', $min_stock);
                            $insert->bindParam(':vehicle_number', $vehicle_number);
                            $insert->bindParam(':gate_pass', $gate_pass);
                            $insert->bindParam(':batch_number', $batch_number);
                            $insert->bindParam(':satuan', $satuan);
                            $insert->bindParam(':supplier', $supplier);
                            $insert->bindParam(':desc', $desc);

                            if($insert->execute()){
                                echo'<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Success", "Product Successfully Saved", "success", {
                                        button: "Continue",
                                            });
                                        });
                                        </script>';
                            }else{
                                echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "There is an error", "error", {
                                        button: "Continue",
                                            });
                                        });
                                        </script>';;
                            }

                        }else{
                            echo '<script type="text/javascript">
                                        jQuery(function validation(){
                                        swal("Error", "There is an error", "error", {
                                        button: "Continue",
                                            });
                                        });
                                        </script>';;;
                        }
                    }

                }

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product
      </h1>
      <hr>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Enter New Products</h3>
            </div>
            <form action="" method="POST" name="form_product"
                enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Product Code</label><br>
                            <span class="text-muted">Make sure the product code matches</span>
                            <input type="text" class="form-control"
                            name="product_code">
                        </div>
                        <div class="form-group">
                            <label for="">Entry Date</label><br>
                            <input type="date" class="form-control"
                            name="entry_date">
                        </div>
                        <div class="form-group">
                            <label for="">Product name</label>
                            <input type="text" class="form-control"
                            name="product_name">
                        </div>
                        <div class="form-group">
                            <label for="">warehouse_name</label>
                            <select class="form-control" name="warehouse_name">
                                <?php
                                $select = $pdo->prepare("SELECT * FROM tbl_warehouse");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                    extract($row)
                                ?>
                                    <option><?php echo $row['war_name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">product_category</label>
                            <select class="form-control" name="product_category" >
                                <?php
                                $select = $pdo->prepare("SELECT * FROM tbl_category");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                    extract($row)
                                ?>
                                    <option><?php echo $row['cat_name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <!-- //min="1000" step="1000" -->
                        <div class="form-group">
                            <label for="">Per Box/Piece Price</label>
                            <input type="text" class="form-control"
                            name="per_piece" >
                        </div>
                        <div class="form-group">
                            <label for="">Purchasing Price</label>
                            <input type="text" class="form-control"
                            name="purchase_price" >
                        </div>
                        <div class="form-group">
                            <label for="">Selling Price</label>
                            <input type="text" class="form-control"
                            name="sell_price" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Stock</label><br>
                            <span class="text-muted">Units according to the product</span>
                            <input type="number" min="1" step="1"
                            class="form-control" name="stock" >
                        </div>
                        <div class="form-group">
                            <label for="">Minimun Stock</label><br>
                            <input type="number" min="1" step="1"
                            class="form-control" name="min_stock">
                        </div>
                        <div class="form-group">
                            <label for="">Vehicle Number</label><br>
                            <input type="text" class="form-control" name="vehicle_number">
                        </div>
                        <div class="form-group">
                            <label for="">Gate Pass</label><br>
                            <input type="text" class="form-control" name="gate_pass">
                        </div>
                        <div class="form-group">
                            <label for="">Batch Number</label><br>
                            <input type="text" class="form-control" name="batch_number">
                        </div>
                        <div class="form-group">
                            <label for="">Units</label>
                            <select class="form-control" name="satuan">
                                <?php
                                $select = $pdo->prepare("SELECT * FROM tbl_satuan");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                    extract($row)
                                ?>
                                    <option><?php echo $row['nm_satuan']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Supplier</label>
                            <select class="form-control" name="supplier">
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
                        <div class="form-group">
                            <label for="">Product Brief Description</label>
                            <textarea name="description" id="description"
                            cols="30" rows="10" class="form-control" ></textarea>
                        </div>
                    </div>
                 </div>   
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"
                    name="add_product">Add Product</button>
                    <a href="product.php" class="btn btn-warning">Back</a>
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