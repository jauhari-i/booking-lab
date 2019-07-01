<?php 

    session_start();
    include '../conn.php';
    $id = $_GET['uid'];
    $user = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM users WHERE id_user = '$id' "));
    // echo $user['nama'];

    if(isset($_POST['simpan'])){
        $nama_lab = $_POST['namaLab'];
        $deskripsi = $_POST['desk'];
        $kapasitas = $_POST['kapasitas'];
        $status = $_POST['status'];
        $file = $_FILES['pp']['name'];
        $file =addslashes (file_get_contents($_FILES['pp']['tmp_name']));

        $cek = mysqli_query($myDB,"SELECT * FROM lab WHERE nama_lab ='$nama_lab' ");
        if(mysqli_num_rows($cek) > 0){
            $_SESSION['error'] = "Nama Lab Telah Terpakai";
        }else{
            $addLab = mysqli_query($myDB,"INSERT INTO  `lab` (`id_lab`,`nama_lab`,`deskripsi`,`img`,`kapasitas`,`status_lab`,`lab_created_at`) VALUES (NULL,'$nama_lab','$deskripsi','$file','$kapasitas','$status',CURRENT_TIMESTAMP)");
            if($addLab){
                $last_id = mysqli_insert_id($myDB);

                $_SESSION['success'] = "Item Berhasil Ditambahkan";
                header('location: ../admin/index');
            }
        }

        // $register_query = mysqli_query($myDB,"INSERT INTO `users` (`id_user`, `nama`, `id_kelas`, `email`, `password`, `img`, `admin`, `tgl_register`) VALUES (NULL, '$name', NULL, '$email', '$password', LOAD_FILE('C:/xampp/htdocs/bookinglav/assets/default.png'), '0', CURRENT_TIMESTAMP);");

    }
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
      Tambah Lab
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <?php 
        if(isset($_SESSION['error'])){
            ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    <?= $_SESSION['error'] ?>
              </div>
            <?php
            unset($_SESSION['error']);
        }
      ?>
  <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">Input Data Lab</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="settings">
                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nama Lab</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="namaLab" id="inputName" value="<?php echo isset($_POST['namaLab']) ? $_POST['namaLab'] : ''; ?>" placeholder="Nama Lab" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Deskripsi</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="desk" id="inputEmail" value="<?php echo isset($_POST['desk']) ? $_POST['desk'] : ''; ?>" placeholder="Deskripsi" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="kelas" class="col-sm-2 control-label">kapasitas</label>

                    <div class="col-sm-10">
                      <input type="number" min="20" max="30" class="form-control" name="kapasitas" id="inputkelas" value="20" required placeholder="0">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status</label>

                    <div class="col-sm-10">
                      <select name="status" id="status" required class="form-control">
                          <option value="Tidak Digunakan" selected>Tidak Digunakan</option>
                          <option value="Digunakan">Digunakan</option>
                          <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="gambar" class="col-sm-2 control-label">Gambar Lab</label>
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="file" name="pp" id="gambar" required accept="image/*">
                        <p class="help-block">Tipe FIle: jpg, png, gif, jpeg
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <input class="btn btn-primary btn-flat" type="submit" value="Simpan" name="simpan">
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