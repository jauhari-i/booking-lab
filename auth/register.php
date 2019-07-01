<?php

session_start();
include("../conn.php");
$message = '';
$email_msg = '';
$pass_msg = "";

if(isset($_POST['register'])) 
{
    $name = $_POST['fname'];
    $email = $_POST['email'];
    $password1 = $_POST['pass1'];
    $password2 = $_POST['pass2'];
        
    $cek_query = mysqli_query($myDB,"SELECT * FROM users WHERE email='$email' ");
    if(mysqli_num_rows($cek_query) == 0 )
    {
      if($password1 == $password2)
      {
          $password = sha1($password1);

          // $file = LOAD_FILE('C:/xampp/htdocs/bookinglav/assets/default.png');
          $register_query = mysqli_query($myDB,"INSERT INTO `users` (`id_user`, `nama`, `id_kelas`, `email`, `password`, `img`, `admin`, `tgl_register`) VALUES (NULL, '$name', NULL, '$email', '$password', LOAD_FILE('C:/xampp/htdocs/bookinglav/assets/default.png'), '0', CURRENT_TIMESTAMP);");
        //cek registered user
        if($register_query){
          $last_id = mysqli_insert_id($myDB);

          $login_query = mysqli_query($myDB,"SELECT * FROM users WHERE id_user='$last_id'");
          if(mysqli_num_rows($login_query) != 0)
          {
            $data = mysqli_fetch_assoc($login_query);

            if($data['admin'] == '1')
                {
                    $_SESSION['id'] = $data['id_user'];
                    $_SESSION['admin'] = '1';
                    $_SESSION['user'] = '1'; 

                    header('location: ../admin/index'); 
                }else{

                    $_SESSION['id'] = $data['id_user'];
                    $_SESSION['admin'] = '0';
                    $_SESSION['user'] = '0'; 

                    header('location: ../user/index'); 
                }
          }else{
            echo "Failed to get user data";
          }
        }else{
          echo mysqli_error($myDB);
        }
      }else{
        $pass_msg = '<label class="control-label" style="color:red;" for="pass2"><i class="fa fa-times-circle-o"></i>Password is not same</label>';
      }
    }else
    {
      $email_msg = '<label class="control-label" style="color:red;" for="email"><i class="fa fa-times-circle-o"></i>Email is Used</label>';
    }

    
}

// print_r($_REQUEST);

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../assets/lte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/lte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../assets/lte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/lte/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../assets/lte/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="#"><b>Labku</b>.id</a>
    </div>

    <div class="register-box-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="" method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="fname" id="fname" value='<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>' placeholder="Full name" required>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <?= $email_msg ?>
          <input type="email" class="form-control" id="email" name="email" value='<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>' placeholder="Email" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="pass1" value='<?php echo isset($_POST['pass1']) ? $_POST['pass1'] : ''; ?>' placeholder="Password" reqired>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <?= $pass_msg ?>
          <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Retype password" required>
          <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="row">
            <div class="col-sm-10" style="margin-left:30px;">
            <?= $message ?>
            </div>
          </div>
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" required name="agree"> Saya menyetujui <a href="#">peraturan</a> yang berlaku
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4"></div>
          <div class="col-xs-4">
            <!-- <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button> -->
            <input type="submit" value="Register" name="register" class="btn btn-primary btn-block btn-flat">
          </div>
          <!-- /.col -->
        </div>
      </form>
      

      <a href="login" class="text-center">Sudah Punya Akun</a>
    </div>
    <!-- /.form-box -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery 3 -->
  <script src="../assets/lte/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="../assets/lte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="../assets/lte/plugins/iCheck/icheck.min.js"></script>
  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    });
  </script>
</body>

</html>