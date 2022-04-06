<?php
include_once'db/connect_db.php';
session_start();
if($_SESSION['role']!=="Admin"){
header('location:index.php');
}
include_once'inc/header_all.php';

if(isset($_POST['submit'])){
    $war_name = $_POST['war_name'];
    $war_city = $_POST['war_city'];
    if(isset($_POST['war_name'])){

            $select = $pdo->prepare("SELECT war_name FROM tbl_warehouse WHERE war_name='$war_name'");
            $select->execute();

            if($select->rowCount() > 0 ){
                echo'<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "The warehouse Exist", "warning", {
                    button: "Continue",
                        });
                    });
                    </script>';
                }else{
                    $insert = $pdo->prepare("INSERT INTO tbl_warehouse(war_name,war_city) VALUES(:war_name,:war_city)");

                    $insert->bindParam(':war_name', $war_name);
                    $insert->bindParam(':war_city', $war_city);

                    if($insert->execute()){
                        echo '<script type="text/javascript">
                        jQuery(function validation(){
                        swal("Success", "A New Warehouse Has Been Created", "success", {
                        button: "Continue",
                            });
                        });
                        </script>';
                        }
                }
    }
}

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Warehouse
      </h1>
      <hr>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
       <!-- Category Form-->
      <div class="col-md-4">
            <div class="box box-success">
                <!-- /.box-header -->
                <!-- form start -->
                <form action="" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="category">Warehouse Name</label>
                      <input type="text" class="form-control" name="war_name" placeholder="Enter Warehouse">
                    </div>
                    <div class="form-group">
                      <label for="category">Warehouse City</label>
                      <input type="text" class="form-control" name="war_city" placeholder="Enter City">
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                  </div>
                </form>
            </div>
      </div>
        <!-- Category Table -->
      <div class="col-md-8">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">List of Warehouse</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body" style="overflow-x:auto;">
            <table class="table table-striped" id="mySatuan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Warehouse Name</th>
                        <th>Warehouse City</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody>
                <?php
                $no = 1;
                $select = $pdo->prepare('SELECT * FROM tbl_warehouse');
                $select->execute();
                while($row=$select->fetch(PDO::FETCH_OBJ)){ ?>
                  <tr>
                    <td><?php echo $no ++ ?></td>
                    <td><?php echo $row->war_name; ?></td>
                    <td><?php echo $row->war_city; ?></td>
                    <td>
                        <a href="edit_warehouse.php?id=<?php echo $row->war_id; ?>"
                        class="btn btn-info btn-sm" name="btn_edit"><i class="fa fa-pencil"></i></a>
                        <a href="delete_warehouse.php?id=<?php echo $row->war_id; ?>"
                        onclick="return confirm('Remove warehouse?')"
                        class="btn btn-danger btn-sm" name="btn_delete"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                <?php
                }
                ?>

                </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- DataTables Function -->
  <script>
  $(document).ready( function () {
      $('#mySatuan').DataTable();
  } );
  </script>

<?php
  include_once'inc/footer_all.php';
?>