<?php
    include_once'db/connect_db.php';
    session_start();
    if($_SESSION['role']!=="Admin"){
        header('location:index.php');
    }
    include_once'inc/header_all.php';

    error_reporting(0);

    $id = $_GET['id'];

    $delete = $pdo->prepare("DELETE FROM tbl_user WHERE user_id=".$id);

    if($delete->execute()){
        echo'<script type="text/javascript">
            jQuery(function validation(){
            swal("Info", "User Has Been Deleted", "info", {
            button: "Continue",
                });
            });
            </script>';
    }

    if(isset($_POST['submit'])){

        $date = $_POST['date'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $cnic = $_POST['cnic'];
        $mobile = $_POST['mobile'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $role = $_POST['select_option'];
        $status = $_POST['status'];

        //check if the email already exist
        if(isset($_POST['username'])){
            $select = $pdo->prepare("SELECT username FROM tbl_user WHERE username='$username'");
            $select->execute();

            if($select->rowCount() > 0 ){
                echo'<script type="text/javascript">
                    jQuery(function validation(){
                    swal("Warning", "Username already exists", "warning", {
                    button: "Continue",
                        });
                    });
                    </script>';
            } else {
                //insert query here
                $insert = $pdo->prepare("INSERT INTO tbl_user(date,username,email,cnic,mobile,address,password,role,is_active) VALUES(:date,:username,:email,:cnic,:mobile,:address,:password,:role,1)");

                //binding the values parameter with input from user
                $insert->bindParam(':date',$date);
                $insert->bindParam(':username',$username);
                $insert->bindParam(':email',$email);
                $insert->bindParam(':cnic',$cnic);
                $insert->bindParam(':mobile',$mobile);
                $insert->bindParam(':address',$address);
                $insert->bindParam(':password',$password);
                $insert->bindParam(':role',$role);

                //if execution $insert
                if($insert->execute()){
                    echo'<script type="text/javascript">
                        jQuery(function validation(){
                        swal("Success", "New User Added", "success", {
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
    <!-- Main content -->
    <section class="content container-fluid">
        <form action="" method="POST">
            <!-- Registration Form -->
            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Register a New Staff</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                        <div class="box-body">
                                <div class="form-group">
                                    <label for="username">Date</label>
                                    <input type="date" class="form-control" id="username" name="date" placeholder="Enter Date" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                                </div>
                                <div class="form-group">
                                    <label for="fname">E-mail</label>
                                    <input type="email" class="form-control" id="fname" name="email" placeholder="Enter Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">CNIC</label>
                                    <input type="text" class="form-control" id="username" name="cnic" placeholder="Enter Cnic" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Mobile Number</label>
                                    <input type="text" class="form-control" id="username" name="mobile" placeholder="Enter Mobile" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Address</label>
                                    <input type="text" class="form-control" id="username" name="address" placeholder="Enter Address" required>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="password" name="status" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <label>Role </label>
                                    <select class="form-control" name="select_option" required>
                                        <option>Admin</option>
                                        <option>Operator</option>
                                    </select>
                                </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Registered Table -->
            <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                <h3 class="box-title">Staff detail</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div style="overflow-x:auto;">
                        <table class="table table-striped" id="myRegister">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Username</th>                                    
                                    <th>E-mail</th>
                                    <th>Cnic</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $select = $pdo->prepare("SELECT * FROM tbl_user");
                                $select->execute();
                                while($row=$select->fetch(PDO::FETCH_OBJ)){
                                ?>
                                    <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row->date; ?></td>
                                    <td><?php echo $row->username; ?></td>
                                    <td><?php echo $row->email; ?></td>
                                    <td><?php echo $row->cnic; ?></td>
                                    <td><?php echo $row->mobile; ?></td>
                                    <td><?php echo $row->address; ?></td>
                                    <td><?php echo $row->role; ?></td>
                                    <td>
                                        <a href="register.php?id=<?php echo $row->user_id; ?>"
                                        onclick="return confirm('Delete User?')"
                                        class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        <!-- <a href="deactivate.php?id=" class="btn btn-info btn-sm"
                                        onclick="return confirm('Are You Sure, You Want To Deactivate The Account?')" name="deactivate">
                                        <i class="fa fa-power-off"></i></a> -->
                                    </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            </div>
        </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
  $(document).ready( function () {
      $('#myRegister').DataTable();
  } );
  </script>

 <?php
    include_once'inc/footer_all.php';
 ?>