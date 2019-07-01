<?php 
    session_start();

    include '../conn.php';
    $id = $_GET['id'];

    // echo $user['nama'];
    if(isset($_POST['edit'])){
        $nama = $_POST['name'];
        $email = $_POST['email'];
        $kelas = $_POST['kelas'];
        $file = $_FILES['pp']['tmp_name'];
            if(empty($file)){
                $update = mysqli_query($myDB,"UPDATE users SET nama='$nama',email='$email',id_kelas='$kelas' WHERE id_user = '$id' ");   
                $_SESSION['success'] = "User Data Modifed Successfully";    
            }else{
                $file = addslashes(file_get_contents($_FILES['pp']['tmp_name']));
                $update = mysqli_query($myDB,"UPDATE users SET nama='$nama',email='$email',id_kelas='$kelas',img='$file' WHERE id_user = '$id' "); 
                $_SESSION['success'] = "User Data Modifed Successfully";
            }
    }
    $user = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM users WHERE id_user = '$id' "));
    $kelas = mysqli_query($myDB,"SELECT * FROM kelas ORDER BY id_kelas ASC");
    $data_kelas = mysqli_fetch_assoc($kelas);
    // print_r($_REQUEST);
?>

<!DOCTYPE html>
<html>
<head>
    <?php 
        include '../admin/head.php';
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<header class="main-header">

  <!-- Logo -->
  <a href="../admin/index" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>L</b>id</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Labku</b>id</span>
  </a>

  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
 
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="data:image/jpeg;base64,<?= base64_encode( $user['img'] )?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?= $user['nama'] ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="data:image/jpeg;base64,<?= base64_encode( $user['img'] )?>" class="img-circle" alt="User Image">

              <p>
                <?= $user['nama'] ?>
                <?php

                    $time = strtotime($user['tgl_register']);

                    // echo 'event happened '.humanTiming($time).' ago';

                    function humanTiming ($time)
                    {

                        $time = time() - $time; // to get the time since that moment
                        $time = ($time<1)? 1 : $time;
                        $tokens = array (
                            31536000 => 'tahun',
                            2592000 => 'bulan',
                            604800 => 'minggu',
                            86400 => 'hari',
                            3600 => 'jam',
                            60 => 'menit',
                            1 => 'detik'
                        );

                        foreach ($tokens as $unit => $text) {
                            if ($time < $unit) continue;
                            $numberOfUnits = floor($time / $unit);
                            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
                        }

                    }
                ?>
                <small><?php echo 'Member Since '.humanTiming($time).' Ago'; ?></small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="../admin/profile?id=<?= $id ?>" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="../auth/logout" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>

  </nav>
</header>
<aside class="main-sidebar">
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="data:image/jpeg;base64,<?= base64_encode( $user['img'] )?>" class="img-circle"
                            alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?=$user['nama']?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Admin</a>
                    </div>
                </div>
                <!-- search form -->
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="../user/index"><i class="fa fa-circle-o"></i> User</a></li>
                            <li><a href="../admin/index"><i class="fa fa-circle-o"></i> Admin</a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-edit"></i> <span>Tambah Data</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="../admin/labadd?uid=<?= $id ?>"><i class="fa fa-circle-o"></i> Tambah Lab</a>
                            </li>
                            <li><a href="../admin/pinjam?uid=<?= $id ?>"><i class="fa fa-circle-o"></i> Tambah Peminjaman</a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-table"></i> <span>Tabel</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                        <li><a href="../admin/users?id=<?= $id ?>"><i class="fa fa-circle-o"></i> Lihat User</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="../admin/profile?id=<?= $id ?>">
                            <i class="fa fa-gear"></i> <span>Edit Profile</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Profile
      <small><?= $user['nama'] ?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
      <?php 
        if(isset($_SESSION['success'])){
            ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    <?= $_SESSION['success'] ?>
              </div>
            <?php
            unset($_SESSION['success']);
        }
      ?>
  <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="data:image/jpeg;base64,<?= base64_encode( $user['img'] )?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?= $user['nama'] ?></h3>

              <p class="text-muted text-center">Admin</p>

              <a href="../admin/index" class="btn btn-primary btn-block"><b>Dashboard</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tentang Saya</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-home margin-r-5"></i> Kelas</strong>

              <p class="text-muted">
                <?php
                    $myklas = $user['id_kelas'];

                    $kelasku = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM kelas WHERE id_kelas = '$myklas' "));

                    echo $kelasku['kelas'];
                ?>
              </p>

              <hr>

              <strong><i class="fa  fa-envelope-o margin-r-5"></i> Email</strong>

              <p class="text-muted"><?= $user['email'] ?></p>

              <hr>

              <strong><i class="fa fa-calendar-check-o margin-r-5"></i> Bergabung</strong>

              <p><?= humanTiming($time) ?> yang lalu</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="settings">
                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nama</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" id="inputName" value="<?= $user['nama'] ?>" placeholder="Nama">
                      <input type="hidden" name="idUser" value="<?= $user['id_user'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="email" id="inputEmail" value="<?= $user['email'] ?>" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="kelas" class="col-sm-2 control-label">Kelas</label>

                    <div class="col-sm-10">
                      <!-- <input type="text" class="form-control" id="inputkelas" placeholder="Name"> -->
                      <select class="form-control" name="kelas" id="kelas">
                            <?php foreach($kelas as $data):  ?>
                                <?php
                                    if($user['id_kelas'] == $data['id_kelas'] )
                                    {
                                        ?>
                                        <option selected value="<?= $data['id_kelas'] ?>"><?= $data['kelas'] ?></option>
                                        <?php
                                    }else {
                                        ?>
                                        <option value="<?= $data['id_kelas'] ?>"><?= $data['kelas'] ?></option>
                                        <?php
                                    }
                                ?>
                            <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="img" class="col-sm-2 control-label">Update Foto</label>
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="file" name="pp" id="pp"  accept="image/*">
                        <p class="help-block">Tipe FIle: jpg, png, gif, jpeg
                                                    <br><small>Opsional</small> </p>
                        <a href="../admin/editpass?id=<?= $user['id_user'] ?>" class="btn btn-flat"><i class="fa fa-pencil"  style="margin-right: 5px;" aria-hidden="true"></i>Edit password</a>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <input class="btn btn-primary btn-flat" type="submit" value="Edit" name="edit">
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 2.4.0
  </div>
  <strong>Copyright &copy; 2018-2019 <a href="#">Tim Booking Lab</a>.</strong> All rights
  reserved.
</footer>

<div class="control-sidebar-bg"></div>

</div>
<?php 
    include '../admin/script.php';
?>
</body>
</html>