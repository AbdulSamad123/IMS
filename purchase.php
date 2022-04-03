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

    error_reporting(0);

    $id = $_GET['id'];

    $delete_query = "DELETE tbl_purchase, tbl_purchase_detail FROM tbl_purchase INNER JOIN tbl_purchase_detail ON tbl_purchase.purchase_id =
    tbl_purchase_detail.purchase_id WHERE tbl_purchase.purchase_id=$id";
    $delete = $pdo->prepare($delete_query);
    if($delete->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "Purchase has been deleted", "info", {
            button: "Continue",
                });
            });
            </script>';
    }
?>

<html>
<head>
<meta http-equiv="refresh" content="60">
</head>
</html>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Purchase List
      </h1>
      <hr>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Purchase List</h3>
                <a href="create_purchase.php" class="btn btn-success btn-sm pull-right">Create Purchase</a>
            </div>
            <div class="box-body">
                <div style="overflow-x:auto;">
                    <table class="table table-striped" id="myOrder">
                        <thead>
                            <tr>
                                <th style="width:20px;">No</th>
                                <th style="width:100px;">Supplier Name</th>
                                <th style="width:100px;">Purhcase date</th>
                                <th style="width:100px;">Bill</th>
                                <th style="width:50px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $select = $pdo->prepare("SELECT tbl_supplier.name , tbl_purchase.purchase_id, tbl_purchase.order_date, tbl_purchase.total from tbl_purchase join tbl_supplier on tbl_supplier.supplier_id=tbl_purchase.supplier_id  ORDER BY tbl_purchase.purchase_id DESC");
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                            ?>
                                <tr>
                                <td><?php echo $no++ ; ?></td>
                                <td class="text-uppercase"><?php echo $row->name; ?></td>
                                <td><?php echo $row->order_date; ?></td>
                                <td>Rp. <?php echo number_format($row->total,2); ?></td>
                                <td>
                                    <?php if($_SESSION['role']=="Admin"){ ?>
                                    <a href="purchase.php?id=<?php echo $row->purchase_id; ?>" onclick="return confirm('Remove Purchase?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    <?php } ?>
                                    <a href="misc/purchase_slip.php?id=<?php echo $row->purchase_id; ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
                                </td>
                                </tr>
                            <?php
                            }
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
      $('#myOrder').DataTable();
  } );
  </script>

 <?php
    include_once'inc/footer_all.php';
 ?>