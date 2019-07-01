<?php 

session_start();
include '../conn.php';
$id = $_GET['uid'];
$id_pinjam = $_GET['id'];


$user = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM users WHERE id_user = '$id' "));
// echo $user['nama'];

if(isset($_POST['simpan'])){

    $status = $_POST['status'];

    if($status == 'sukses' || $status == 'gagal'){
        $update = mysqli_query($myDB,"UPDATE pinjam SET status='$status',admin='$id' WHERE id_pinjam = '$id_pinjam' ");

        $data = mysqli_fetch_assoc($pinjam = mysqli_query(
            $myDB,"SELECT * FROM pinjam INNER JOIN users ON pinjam.id=users.id_user 
            INNER JOIN lab ON pinjam.id_lab=lab.id_lab INNER JOIN kelas ON users.id_kelas=kelas.id_kelas WHERE id_pinjam = '$id_pinjam'")
        );
        $id_lab = $data['id_lab'];
        $update_lab = mysqli_query($myDB,"UPDATE lab SET status_lab='Tidak Digunakan' WHERE id_lab = '$id_lab' ");


        $_SESSION['success'] = "Success Change Booking Status!";
        header('location: ../admin/index');
    }elseif ($status == '-') {
        $update = mysqli_query($myDB,"UPDATE pinjam SET status_lab='$status',admin='$id' WHERE id_pinjam = '$id_pinjam' ");

        $data = mysqli_fetch_assoc($pinjam = mysqli_query(
            $myDB,"SELECT * FROM pinjam INNER JOIN users ON pinjam.id=users.id_user 
            INNER JOIN lab ON pinjam.id_lab=lab.id_lab INNER JOIN kelas ON users.id_kelas=kelas.id_kelas WHERE id_pinjam = '$id_pinjam'")
        );
        $id_lab = $data['id_lab'];
        $update_lab = mysqli_query($myDB,"UPDATE lab SET status_lab='Digunakan' WHERE id_lab = '$id_lab' ");


        $_SESSION['success'] = "Success Change Booking Status!";
        header('location: ../admin/index');
    }else{
        $_SESSION['error'] = "Failed To Change Booking Status!";
        header('location: ../admin/index');
    }

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
                                <img src="data:image/jpeg;base64,<?= base64_encode( $user['img'] )?>" class="user-image"
                                    alt="User Image">
                                <span class="hidden-xs"><?= $user['nama'] ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="data:image/jpeg;base64,<?= base64_encode( $user['img'] )?>"
                                        class="img-circle" alt="User Image">

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
                                        <a href="../admin/profile?id=<?= $id ?>"
                                            class="btn btn-default btn-flat">Profile</a>
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
                            <li><a href="../admin/labadd?uid=<?= $uid ?>"><i class="fa fa-circle-o"></i> Tambah Lab</a>
                            </li>
                            <li><a href="../admin/pinjam?uid=<?= $uid ?>"><i class="fa fa-circle-o"></i> Tambah
                                    Peminjaman</a>
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
                        <li><a href="../admin/users?id=<?= $uid ?>"><i class="fa fa-circle-o"></i> Lihat User</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="../admin/profile?id=<?= $uid ?>">
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
                    Set Status
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
                                            <label for="status" class="col-sm-2 control-label">Status</label>
                                            <div class="col-sm-10">
                                                <select name="status" id="status" required class="form-control">
                                                    <option value="sukses" selected>Selesai</option>
                                                    <option value="gagal">Batal</option>
                                                    <option value="-">Dalam Penggunaan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input class="btn btn-primary btn-flat" type="submit" value="Simpan"
                                                    name="simpan">
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