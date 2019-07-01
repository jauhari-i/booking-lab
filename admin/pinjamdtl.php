<?php 
session_start();

include '../conn.php';

$id = $_GET['uid'];
$id_pinjam = $_GET['id'];
$user = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM users WHERE id_user = '$id' "));

$pinjam = mysqli_query($myDB,"SELECT * FROM pinjam INNER JOIN users ON pinjam.id=users.id_user INNER JOIN lab ON pinjam.id_lab=lab.id_lab INNER JOIN kelas ON users.id_kelas=kelas.id_kelas WHERE id_pinjam = '$id_pinjam' ORDER BY id_pinjam");
$data = mysqli_fetch_assoc($pinjam);
$id_admin = $data['admin'];
$admin = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM users WHERE id_user = '$id_admin' "));
// $id_user = mysqli_fetch_assoc(mysqli_query());


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
      Detail Peminjaman
      <small>#LPJ<?= $id_pinjam ?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <?php 
                if(isset($_SESSION['success'])){
                    ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-check"></i> Success!</h4>
                            <?= $_SESSION['success'] ?>
                        </div>
                    <?php
                    unset($_SESSION['success']);
                }
            ?>
  <!-- Main content -->
  <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Lab Moklet, Sch.id
            <small class="pull-right"><?php $now2 = date("F j, Y"); echo $now2;?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          Admin
          <address>
            <strong>Labku.id</strong><br>
            <?= $admin['nama'] ?><br>
            Email: <?= $admin['email'] ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          User
          <address>
            <strong><?= $data['nama'] ?></strong><br>
            <?= $data['kelas'] ?><br>
            <?= $data['nama_lab'] ?><br>           
            Date: <?= $newDate = date("d-m-Y", strtotime($data['tgl_pinjam'])) ?> - <?= $$newDate = date("d-m-Y", strtotime($data['tgl_kembali'])) ?><br>
            Email: <?= $data['email'] ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice #LPJ<?= $data['id_pinjam'] ?></b><br>
          <br>
          <b>ID Peminjaman:</b> #LPJ<?= $data['id_pinjam'] ?><br>
          <b>Tanggal Peminjaman:</b> <?= $data['created_at'] ?> <br>
          <b>Akun ID :</b> <?= $data['id'] ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>ID Peminjaman</th>
              <th>Peminjam</th>
              <th>Lab</th>
              <th>Tanggal</th>
              <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>LPJ<?= $data['id_pinjam'] ?></td>
              <td><?= $data['nama'] ?>(<?= $data['kelas'] ?>)</td>
              <td><?= $data['nama_lab'] ?></td>
              <td><?= $newDate = date("d-m-Y", strtotime($data['tgl_pinjam'])) ?> - <?= $$newDate = date("d-m-Y", strtotime($data['tgl_kembali'])) ?></td>
              <td><?php
                     if($data['status'] == 'sukses'){
                    ?>
                        <span class="label label-success">Sukses</span>
                    <?php
                    }elseif ($data['status'] == 'gagal' ) {
                     ?>
                        <span class="label label-danger">Gagal</span>
                    <?php
                        if($user['admin'] == 1){
                            ?><a href="../admin/pinjamstats?id=<?= $data['id_pinjam'] ?>&uid=<?= $admin['id_user'] ?>"><br><i class="fa fa-pencil" aria-hidden="true"></i> Ganti</a><?php
                        }
                    }else{
                    ?>
                        <span class="label label-primary">-</span>
                        
                    <?php
                        if($user['admin'] == 1){
                            ?><a href="../admin/pinjamstats?id=<?= $data['id_pinjam'] ?>&uid=<?= $admin['id_user'] ?>"><br><i class="fa fa-pencil" aria-hidden="true"></i> Ganti</a><?php
                        }
                    }
                   ?>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <?php 
      
        $enc_id_user = base64_encode($id);
        $enc_id_pinjam = base64_encode($id_pinjam);
        $enc_enc_id_user = base64_encode($enc_id_user);
      ?>
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="../admin/pinjamdtl_print?uid=<?= $enc_enc_id_user ?>&id=<?= $enc_id_pinjam ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
 
        </div>
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