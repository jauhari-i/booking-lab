<?php 
session_start();

include '../conn.php';
$id = $_GET['uid'];
$user = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM users WHERE id_user = '$id' "));
$lab = mysqli_query($myDB,"SELECT * FROM lab WHERE status_lab != 'Digunakan' ORDER BY nama_lab ASC");
// echo $id;
// print_r($_REQUEST);

if(isset($_POST['simpan'])){
    $id_user = $_POST['iduser'];
    $id_lab = $_POST['lab'];
    $in = $_POST['datein'];
    $out = $_POST['dateout'];
    $status = "-";

    $cek = mysqli_query($myDB,"SELECT * FROM pinjam WHERE tgl_pinjam ='$in' AND id_lab ='$id_lab' AND status='$status' ");
    if(mysqli_num_rows($cek) > 0){

        // echo "HORA";
        $_SESSION['error'] = "Sorry Our Lab Is In Use!! ";
    }else{
        if($out < $in){
            $_SESSION['error'] = "Please Insert True Date";
            // echo "Ora";
        }else{
            // echo "HRAra";
            // $insert = mysqli_query($myDB,"INSERT INTO `pinjam`(`id_pinjam`, `id`, `id_lab`, `tgl_pinjam`, `tgl_kembali`, `status`, `admin`, `created_at`) VALUES (NULL, '$id_user', '$id_lab', '$in', '$out', '$status', NULL, CURRENT_TIMESTAMP); ");
            $insert = mysqli_query($myDB,"INSERT INTO `pinjam`(`id_pinjam`, `id`, `id_lab`, `tgl_pinjam`, `tgl_kembali`, `status`, `admin`, `created_at`) VALUES (NULL, '$id_user', '$id_lab', '$in', '$out', '$status', '$id', CURRENT_TIMESTAMP); ");
            if($insert){
                $last_id = mysqli_insert_id($myDB);
                // echo $last_id;
                $update = mysqli_query($myDB,"UPDATE lab SET status_lab = 'DIgunakan' WHERE id_lab = '$id_lab' ");
                $_SESSION['success'] = 'Please Wait for confirmation !! Your Booking Id is LPJ'.$last_id ;
            }else{
                // echo "kajsdkahsdk";
            }
        }
    }
}

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
      Tambah peminjaman
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
          <?php 
        if(isset($_SESSION['success'])){
            ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i>Hello!</h4>
                    <?= $_SESSION['success'] ?>
              </div>
            <?php
            unset($_SESSION['success']);
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
                    <label for="inputName" class="col-sm-2 control-label">Nama</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="nama" id="inputName" value="<?php echo $user['nama'] ?>" disabled placeholder="Nama User" required>
                      <input type="hidden" name="iduser" value="<?= $id ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="desk" id="inputEmail" value="<?php echo $user['email'] ?>" disabled placeholder="Email" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Pilih Lab</label>

                    <div class="col-sm-10">
                      <select name="lab" id="status" required class="form-control">
                            <?php 
                                foreach($lab as $data):
                            ?>
                                <option value="<?= $data['id_lab'] ?>"><?= $data['nama_lab'] ?></option>
                            <?php 
                                endforeach;
                            ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Tanggal Pinjam</label>

                    <div class="col-sm-10">
                      <input type="date" class="form-control" name="datein" id="inputEmail" placeholder="Tanggal Pinjam" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Tanggal kembali</label>

                    <div class="col-sm-10">
                      <input type="date" class="form-control" name="dateout" id="inputEmail" placeholder="Tanggal Pinjam" required>
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