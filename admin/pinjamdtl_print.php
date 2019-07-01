<?php 
session_start();

include '../conn.php';

$dec_id = $_GET['uid'];
$dec_id_pinjam = $_GET['id'];

$id_dec = base64_decode($dec_id);
$id_pinjam = base64_decode($dec_id_pinjam);

$id = base64_decode($id_dec);

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
    <title><?= $data['nama'] ?> | Peminjaman</title>
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
</head>
<body onload="window.print();window.close();">
<div class="wrapper">
  <section class="invoice">
    <h1>
      Lembar Peminjaman
      <small>#LPJ<?= $id_pinjam ?></small>
    </h1>
  </section>

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
                    }else{
                    ?>
                        <span class="label label-primary">-</span>
                    <?php
                    }
                   ?>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
        <div class="col-sm-4"></div>
        <div class="col-sm-4"><small>**Jika ada masalah silahkan hubungi admin</small></div>
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <p> Terima Kasih </p>
        </div>
      </div>
    </section>
    <div>
    </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
</div>
</body>
</html>