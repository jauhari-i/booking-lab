<?php 

session_start();
include '../conn.php';
$id = $_GET['id'];
$id_pinjam = $_GET['id'];


$user = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM users WHERE id_user = '$id' "));
$user_table = mysqli_query($myDB,"SELECT * FROM users INNER JOIN kelas ON users.id_kelas=kelas.id_kelas ORDER BY tgl_register ASC");
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
                            <li><a href="../admin/users?id=<?= $uid ?>"><i class="fa fa-circle-o"></i> Lihat User</a>
                            </li>
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
                    List User
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">List User</li>
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
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    <?= $_SESSION['success'] ?>
                </div>
                <?php
                        unset($_SESSION['success']);
                    }
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Users List</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Kelas</th>
                                            <th>Level</th>
                                            <th>Jumlah Peminjaman</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 1; 
                                            foreach($user_table as $data):
                                        ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $data['nama'] ?></td>
                                            <td><?= $data['email'] ?></td>
                                            <td><?= $data['kelas'] ?></td>
                                            <td>
                                                <?php 
                                                    if($data['admin'] == 1){
                                                        echo "Admin";
                                                    }else{
                                                        echo "Users";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $id_user = $data['id_user'];
                                                    $total = mysqli_fetch_array(mysqli_query($myDB,"SELECT count(1) FROM pinjam WHERE id = '$id_user' "));
                                                    if($total[0] > 0){
                                                        echo $total[0].'x';
                                                    }else{
                                                        echo "Belum Pernah Meminjam";
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php $no++; endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Kelas</th>
                                            <th>Level</th>
                                            <th>Jumlah Peminjaman</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
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
<script>
    $(function () {
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true
    })})
</script>
</body>

</html>