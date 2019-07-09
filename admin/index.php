<?php 

    include '../conn.php';
    session_start();

    if(isset($_SESSION['id'])){
        $uid = $_SESSION['id'];

        $user = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM users WHERE id_user = '$uid' "));
        if($user['admin'] != 1){
            ?>
        <script>
            alert('You dont have admin access');

            window.location.href = "../user/index";
        </script>
<?php
            
        }
    }if (!isset($_SESSION['id'])) {
        ?>
        <script>
            alert('Please Login First');

            window.location.href = "../auth/login";
        </script>
        <?php
    }
    $pinjam = mysqli_query($myDB,"SELECT * FROM pinjam INNER JOIN users ON pinjam.id=users.id_user INNER JOIN lab ON pinjam.id_lab=lab.id_lab ORDER BY id_pinjam");
    $lab = mysqli_query($myDB,"SELECT * FROM lab ORDER BY nama_lab ASC ");


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
                                                    31536000 => 'year',
                                                    2592000 => 'month',
                                                    604800 => 'week',
                                                    86400 => 'day',
                                                    3600 => 'hour',
                                                    60 => 'minute',
                                                    1 => 'second'
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
                                        <a href="../admin/profile?id=<?= $uid ?>"
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
                    <li class="treeview ">
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
                            <li><a href="../admin/pinjam?uid=<?= $uid ?>"><i class="fa fa-circle-o"></i> Tambah Peminjaman</a>
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
                    Dashboard
                    <small>Version 2.0</small>
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
                            <h4><i class="icon fa fa-check"></i> Success!</h4>
                            <?= $_SESSION['success'] ?>
                        </div>
                    <?php
                    unset($_SESSION['success']);
                }
            ?>
                <!-- Info boxes -->
                <?php 

                    $pinjam_count = mysqli_fetch_array(mysqli_query($myDB,"SELECT count(1) FROM pinjam "));
                    $pinjam_sukses_count = mysqli_fetch_array(mysqli_query($myDB,"SELECT count(1) FROM pinjam WHERE status ='sukses' "));
                    $lab_count = mysqli_fetch_array(mysqli_query($myDB,"SELECT count(1) FROM lab "));
                    $users_count = mysqli_fetch_array(mysqli_query($myDB,"SELECT count(1) FROM users "));

                ?>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Jumlah Peminjaman</span>
                                <span class="info-box-number"><?= $pinjam_count[0] ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Jumlah Lab</span>
                                <span class="info-box-number"><?= $lab_count[0] ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Peminjaman Selesai</span>
                                <span class="info-box-number"><?= $pinjam_sukses_count[0] ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Users</span>
                                <span class="info-box-number"><?= $users_count[0] ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
               <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <div class="col-md-8">
                        <!-- TABLE: LATEST ORDERS -->
                        <div class="box">
                            <div class="box-header ">
                                <h3 class="box-title">Peminjaman</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>ID Peminjaman</th>
                                                <th>Peminjam</th>
                                                <th>Lab</th>
                                                <th>Status</th>
                                                <th>Tanggal Pinjam</th>
                                                <th>Admin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 1;
                                                foreach($pinjam as $data):
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><a href="../admin/pinjamdtl?id=<?= $data['id_pinjam'] ?>&uid=<?= $uid ?>">LPJ<?= $data['id_pinjam'] ?></a></td>
                                                <td><?= $data['nama'] ?></td>
                                                <td><?= $data['nama_lab'] ?></td>
                                                <td>
                                                    <?php
                                                        if($data['status'] == 'sukses'){
                                                            ?>
                                                                <span class="label label-success">Sukses</span>
                                                            <?php
                                                        }elseif ($data['status'] == 'gagal' ) {
                                                            ?>
                                                                <span class="label label-danger">Gagal</span>
                                                            <?php
                                                        }else{
                                                            ?>
                                                                <span class="label label-primary">-</span>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?= $data['created_at'] ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    
                                                        $id_admin = $data['admin'];
                                                        $admin = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM users WHERE id_user = '$id_admin' "));

                                                        echo $admin['nama'];
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                               $no++; endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer clearfix">
                                <a href="../admin/pinjam?uid=<?= $uid ?>" class="btn btn-sm btn-info btn-flat pull-left">Tambah Peminjaman</a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-4">

                        <!-- PRODUCT LIST -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Lab Moklet</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <ul class="products-list product-list-in-box">
                                    <?php 
                                        foreach($lab as $data):
                                    ?>
                                    <li class="item">
                                        <div class="product-img">
                                            <img src="data:image/jpeg;base64,<?= base64_encode( $data['img_lab'] )?>" alt="Product Image">
                                        </div>
                                        <div class="product-info">
                                            <a href="../admin/lab?id=<?= $data['id_lab'] ?>&uid=<?= $uid ?>" class="product-title"><?= $data['nama_lab'] ?>
                                                <span class="label label-default pull-right"><?= $data['status_lab'] ?></span></a>
                                            <span class="product-description">
                                                <?= $data['deskripsi'] ?>
                                            </span>
                                        </div>
                                    </li>

                                    <?php 
                                        endforeach;
                                    ?>
                                </ul>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer text-center">
                                <a href="../admin/labadd?uid=<?= $uid ?>" class="uppercase">Tambah Lab</a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
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
    $(function() {
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
    })
    </script>
</body>

</html>