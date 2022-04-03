<?php
    include_once'misc/plugin.php';
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']!=="Admin"){
    header('location:index.php');
    }

    if($id=$_GET['id']){
    $select = $pdo->prepare("SELECT * FROM tbl_product WHERE product_id=$id");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    $productCode_db = $row['product_code'];
    $productName_db = $row['product_name'];
    $category_db = $row['product_category'];
    $purchase_db = $row['purchase_price'];
    $sell_db = $row['sell_price'];
    $stock_db = $row['stock'];
    $min_stock_db = $row['min_stock'];
    $satuan_db = $row['product_satuan'];
    $desc_db = $row['description'];

    }else{
    header('location:product.php');
    }

    if(isset($_POST['update_product'])){
        $code_req = $_POST['product_code'];
        $product_req = $_POST['product_name'];
        $category_req = $_POST['category'];
        $purchase_req = $_POST['purchase_price'];
        $sell_req = $_POST['sell_price'];
        $stock_req = $_POST['stock'];
        $min_stock_req = $_POST['min_stock'];
        $satuan_req = $_POST['satuan'];
        $desc_req = $_POST['description'];


        if(!isset($error)){
            $update = $pdo->prepare("UPDATE tbl_product SET product_code=:product_code,product_name=:product_name,
            product_category=:product_category, purchase_price=:purchase_price, sell_price=:sell_price,
            stock=:stock,min_stock=:min_stock,product_satuan=:product_satuan ,description=:description WHERE product_id=$id");

            $update->bindParam('product_code', $code_req);
            $update->bindParam('product_name', $product_req);
            $update->bindParam('product_category', $category_req);
            $update->bindParam('purchase_price', $purchase_req);
            $update->bindParam('sell_price', $sell_req);
            $update->bindParam('stock', $stock_req);
            $update->bindParam('min_stock', $min_stock_req);
            $update->bindParam('product_satuan', $satuan_req);
            $update->bindParam('description', $desc_req);

            if($update->execute()){
                header('location:view_product.php?id='.urlencode($id));
            }else{
                echo 'Something is Wrong';
            }

        }
              

            else{
                $update = $pdo->prepare("UPDATE tbl_product SET product_code=:product_code,product_name=:product_name,
                product_category=:product_category, purchase_price=:purchase_price, sell_price=:sell_price,
                stock=:stock,min_stock=:min_stock, product_satuan=:product_satuan ,description=:description WHERE product_id=$id");

                $update->bindParam('product_code', $code_req);
                $update->bindParam('product_name', $product_req);
                $update->bindParam('product_category', $category_req);
                $update->bindParam('purchase_price', $purchase_req);
                $update->bindParam('sell_price', $sell_req);
                $update->bindParam('stock', $stock_req);
                $update->bindParam('min_stock', $min_stock_req);
                $update->bindParam('product_satuan', $satuan_req);
                $update->bindParam('description', $desc_req);

                if($update->execute()){
                    header('location:view_product.php?id='.urlencode($id));
                }else{
                    echo '<script type="text/javascript">
                        jQuery(function validation(){
                        swal("Error", "There is an error", "error", {
                        button: "Continue",
                            });
                        });
                        </script>';
                }
            }
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
                <h3 class="box-title">Edit Product</h3>
            </div>
            <form action="" method="POST" name="form_product"
                enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Product Code</label>
                            <input type="text" class="form-control"
                            name="product_code" value="<?php echo $productCode_db; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Product name</label>
                            <input type="text" class="form-control"
                            name="product_name" value="<?php echo $productName_db; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Category</label>
                            <select class="form-control" name="category" required>
                                <?php
                                $select = $pdo->prepare("SELECT * FROM tbl_category");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                ?>
                                    <option <?php if($row['cat_name']==$category_db) {?>
                                    selected = "selected"
                                    <?php }?> >
                                    <?php echo $row['cat_name']; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Buying Price</label>
                            <input type="text" 
                            class="form-control"
                            name="purchase_price" value="<?php echo $purchase_db; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Selling price</label>
                            <input type="text"
                            class="form-control"
                            name="sell_price" value="<?php echo $sell_db; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Stock</label>
                            <input type="number" min="1" step="1"
                            class="form-control" name="stock" value="<?php echo $stock_db; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Minimun Stock</label>
                            <input type="number" min="1" step="1"
                            class="form-control" name="min_stock" value="<?php echo $min_stock_db; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Units</label>
                            <select class="form-control" name="satuan" required>
                                <?php
                                $select = $pdo->prepare("SELECT * FROM tbl_satuan");
                                $select->execute();
                                while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                ?>
                                    <option <?php if($row['nm_satuan']==$satuan_db) {?>
                                    selected = "selected"
                                    <?php }?> >
                                    <?php echo $row['nm_satuan']; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Product Description</label>
                            <textarea name="description" id="description"
                            cols="30" rows="10" class="form-control" required><?php echo $desc_db; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"
                    name="update_product">Update Product</button>
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