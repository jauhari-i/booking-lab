<?php
//login.php
session_start();
include("../conn.php");
$message = '';
$pass_errors = '';

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    if(empty($email && $password)){
        $message = '<span><div class="alert alert-danger">Please input data</div></span>';
    }else{
        
        $login_query = mysqli_query($myDB,"SELECT * FROM users WHERE email='$email' ");
        if(mysqli_num_rows($login_query) == 0 )
        {
            $message = '<span><div class="alert alert-danger">User Not found Please Register To Continue</div></span>';
        }else
        {
            $data = mysqli_fetch_assoc($login_query);
            if($data['password'] != $password)
            {
                $pass_errors = '<label class="control-label" style="color:red;" for="password"><i class="fa fa-times-circle-o"></i> Password Is Incorrect</label>';
            }else
            {
                if($data['admin'] == '1')
                {
                    $_SESSION['id'] = $data['id_user'];
                    // $_SESSION['loged'] = '1';
                    $_SESSION['admin'] = '1';
                    $_SESSION['user'] = '1'; 

                    header('location: ../admin/index'); 
                }else{

                    $_SESSION['id'] = $data['id_user'];
                    $_SESSION['admin'] = '0';
                    $_SESSION['user'] = '1'; 

                    header('location: ../user/index'); 
                }
            }
        }

    }
}

// print_r($_REQUEST);
?>
<?php ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in</title>
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
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <?php 
        if(isset($_SESSION['error'])){
    ?>
        <script>
                alert('<?= $_SESSION['error'] ?>');
        </script>
    <?php
        unset($_SESSION['error']);
        }
    ?>
    <div class="login-box">
        <div class="login-logo">
            <a href="../"><b>Labku</b>.id</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Masuk Bos</p>

            <form action="login" method="POST">
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" value='<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>' placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?= $pass_errors ?>
                    <input type="password" class="form-control" name="password" value='<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>' placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <?= $message ?>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-4"></div>
                    <div class="col-xs-4">
                        <!-- <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button> -->
                        <input type="submit" value="Log in" name="login" class="btn btn-primary btn-block btn-flat">
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <p class="msg">Tidak Punya Akun ?</p>
            <a href="register" class="text-center">Daftar</a>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="../assets/lte/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="../assets/lte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="../assets/lte/plugins/iCheck/icheck.min.js"></script>
</body>

</html>