<?php
  include_once'db/connect_db.php';
  session_start();
  if($_SESSION['role']!=="Admin"){
    header('location:index.php');
  }


if(isset($_POST['btn_edit'])){
      $war_name = $_POST['war_name'];
      $war_city = $_POST['war_city'];
      $update = $pdo->prepare("UPDATE tbl_warehouse SET war_name='$war_name', war_city='$war_city' WHERE war_id='".$_GET['id']."' ");
      $update->bindParam(':war_name', $war_name);
      $update->bindParam(':war_city', $war_city);
      if($update->rowCount() > 0){
        echo'<script type="text/javascript">
        jQuery(function validation(){
        swal("Warning", "The Warehouse Exist Already", "warning", {
        button: "Continue",
            });
        });
        </script>';
      }elseif($update->execute()){
        echo'<script type="text/javascript">
        jQuery(function validation(){
        swal("Success", "Warehouse Name Has Been Updated", "success", {
        button: "Continue",
            });
        });
        </script>';
      }
}


if($id=$_GET['id']){
    $select = $pdo->prepare("SELECT * FROM tbl_warehouse WHERE war_id = '".$_GET['id']."' ");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    $sat_name = $row->war_name;
    $sat_city = $row->war_city;
}else{
    header('location:warehouse.php');
}


  include_once'inc/header_all.php';

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
            <div class="box box-warning">
                <!-- /.box-header -->
                <!-- form start -->
                <form action="" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="category">Warehouse name</label>
                      <input type="text" class="form-control" name="war_name" placeholder="Warehouse name"
                      value="<?php echo $sat_name; ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="category">Warehouse City</label>
                      <input type="text" class="form-control" name="war_city" placeholder="Warehouse name"
                      value="<?php echo $sat_city; ?>" required>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                      <button type="submit" class="btn btn-primary" name="btn_edit">Update</button>
                      <a href="warehouse.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
            </div>
      </div>

      <div class="col-md-8">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">List of Warehouse</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Warehouse name</th>
                      <th>Warehouse city</th>
                  </tr>
              </thead>
              <tbody>
              <?php
              $no = 1;
              $select = $pdo->prepare('SELECT * FROM tbl_warehouse');
              $select->execute();
              while($row=$select->fetch(PDO::FETCH_OBJ)){ ?>
                <tr>
                    <td><?php echo $no++    ;?></td>
                    <td><?php echo $row->war_name; ?></td>
                    <td><?php echo $row->war_city; ?></td>
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
<?php
    include_once'inc/footer_all.php';
?>
