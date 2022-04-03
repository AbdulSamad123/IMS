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

    error_reporting(0);


?>
<html>
<head>
<meta http-equiv="refresh" content="60">
</head>
</html>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Supplier Balance</h3>
                <a href="show_sup.php" class="btn btn-danger btn-lg pull-right"><i class="fa fa-eye"></i></a>
            </div>
            <div class="box-body">
                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myProduct">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Due</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody>
                        <?php
                                $select_customer = "SELECT * FROM tbl_supplier";
                                $result = mysqli_query($conn, $select_customer);
                                if(mysqli_num_rows($result) > 0)
                                {
                                    while($row = mysqli_fetch_array($result)){
                                        $customer_id = $row['supplier_id'];
                   
                                $select = $pdo->prepare("SELECT tbl_supplier.supplier_id, tbl_supplier.name, sum(tbl_purchase.due) as bal from tbl_purchase join tbl_supplier on tbl_supplier.supplier_id=tbl_purchase.supplier_id  where tbl_supplier.supplier_id='".$customer_id."'");
                                $select->execute();                            
                                while($row=$select->fetch(PDO::FETCH_OBJ)){
                                ?>
                                    <tr>
                                    <td><?php echo $row->supplier_id; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->bal;?></td>
                                                                   <td>
                                        <?php if($_SESSION['role']=="Admin"){ ?>
                                        <a type="submit" href="pay_balance.php?id=<?php echo $customer_id; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    </tr>
                                <?php
                                }}}
                                ?>
                        </tbody>
                    </table>

                    
                           

                 
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
  $(document).ready( function () {
      $('#myProduct').DataTable();
  } );
  </script>

 <?php
    include_once'inc/footer_all.php';
 ?>