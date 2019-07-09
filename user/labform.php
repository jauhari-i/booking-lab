<?php
  include "../conn.php";

  session_start();

  $id_lab = $_GET['id'];

  if(isset($_SESSION['id'])){
     $id = $_SESSION['id'];

      $user = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM users WHERE id_user = '$id' "));
      $cek = mysqli_query($myDB,"SELECT * FROM `pinjam` WHERE `status` = '-' AND `id` = '$id' ");
            if(mysqli_num_rows($cek) > 0){
              $data = mysqli_fetch_assoc($cek);
              $_SESSION['dis'] = $data['id_pinjam'];
            }else{
              unset($_SESSION['dis']);
            }
  }else{
     $_SESSION['log'] = "Silahkan Masuk Terlebih Dahulu !";
     header("location: ../auth/login");
  }


    $lab_info = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM lab WHERE id_lab = '$id_lab' "));
      if($lab_info['status_lab'] == 'DIgunakan' ){
        $pinjam_info = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM pinjam INNER JOIN users ON pinjam.id=users.id_user WHERE id_lab = '$id_lab' "));
        $_SESSION['error'] = 'Lab Ini sedang digunakan oleh '.$pinjam_info['nama'];
      }

      if(isset($_POST['pinjam'])){
        $id_user = $user['id_user'];
        $id_lab = $_POST['lab'];
        $in = $_POST['tgl_pinjam'];
        $out = $_POST['tgl_kembali'];
        $alasan = $_POST['alasan'];
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
                $insert = mysqli_query($myDB,"INSERT INTO `pinjam`(`id_pinjam`, `id`, `id_lab`,`alasan`, `tgl_pinjam`, `tgl_kembali`, `status`, `admin`, `created_at`) VALUES (NULL, '$id_user', '$id_lab', '$alasan', '$in', '$out', '$status', NULL, CURRENT_TIMESTAMP); ");
                if($insert){
                    $last_id = mysqli_insert_id($myDB);
                    // echo $last_id;
                    $update = mysqli_query($myDB,"UPDATE lab SET status_lab = 'DIgunakan' WHERE id_lab = '$id_lab' ");
                    $_SESSION['success'] = 'Booking telah dicatat !! Id Booking anda adalah LPJ'.$last_id ;
                    $_SESSION['dis'] = $last_id;
                }else{
                    $_SESSION['error'] = "Maaf Server Error silahkan coba beberapa saat lagi";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
          include "../guest/head.php"; 
        ?>
    </head>
    <body>

        <div class="site-wrap">

            <div class="site-mobile-menu">
                <div class="site-mobile-menu-header">
                    <div class="site-mobile-menu-close mt-3">
                        <span class="icon-close2 js-menu-toggle"></span>
                    </div>
                </div>
                <div class="site-mobile-menu-body"></div>
            </div>
            <!-- .site-mobile-menu -->

            <div class="site-navbar-wrap js-site-navbar bg-white">
                <div class="container">
                    <div class="site-navbar bg-white">
                        <div class="py-1">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <h2 class="mb-0 site-logo">
                                        <a href="../user/index">Labku.id</a>
                                    </h2>
                                </div>
                                <div class="col-10">
                                    <nav class="site-navigation text-right" role="navigation">
                                        <div class="container">

                                            <div class="d-inline-block d-lg-none  ml-md-0 mr-auto py-3">
                                                <a href="#" class="site-menu-toggle js-menu-toggle">
                                                    <span class="icon-menu h3"></span></a>
                                            </div>
                                            <ul class="site-menu js-clone-nav d-none d-lg-block">
                                                <li class="active">
                                                    <a href="../user/index">Home</a>
                                                </li>
                                                <li class="has-children">
                                                    <p style="margin-top: 10px;" class="btn btn-primary btn-flat">
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                        <?= $user['nama'] ?></p>
                                                    <ul class="dropdown">
                                                        <?php if($user['admin'] == 1){ ?>
                                                        <li>
                                                            <a href="../admin">Admin Dashboard</a>
                                                        </li><?php } ?>
                                                        <li>
                                                            <a href="../user/profile?id=<?= $id ?>">Lihat Profil</a>
                                                        </li>
                                                        <li>
                                                            <a href="../user/peminjaman">Lihat Peminjaman</a>
                                                        </li>
                                                        <li>
                                                            <a href="../auth/logout">Log Out
                                                                <i class="fas fa-external-link-alt"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="site-blocks-cover overlay"
                style="background-image: url(../assets/bg-02.jpg);"
                data-aos="fade"
                data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-12 text-center" data-aos="fade">
                            <span class="caption mb-3">Peminjaman</span>
                            <h1 class="mb-4"><?= $lab_info['nama_lab'] ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <?php

                    $time = strtotime($lab_info['lab_created_at']);

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
                            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?' ':'');
                        }

                    }
                ?>
            <div class="site-section site-section-sm">
                <div class="col-md-12">
                    <?php if(isset($_SESSION['success'])){ ?>
                      <div class="alert alert-success alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4>
                              <i class="icon fa fa-check"></i>
                              Alert!</h4>
                          <?= $_SESSION['success'] ?>
                      </div>
                    <?php unset($_SESSION['success']); }?>

                    <?php if(isset($_SESSION['error'])){?>
                      <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4 style="color: red;">
                              <i class="icon fa fa-ban"></i>
                              Alert!</h4>
                          <?= $_SESSION['error'] ?>
                      </div>
                    <?php unset($_SESSION['error']); } ?>

                    <?php if(isset($_SESSION['dis'])){?>
                      <div class="alert alert-info alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4 style="color: #0c5460;">
                              <i class="icon fa fa-info"></i>
                              Info!</h4>
                          <p>Anda memiliki peminjaman yang berlangsung anda tidak dapat meminjam lagi klik <a href="../user/peminjamandtl?id=<?= $_SESSION['dis'] ?>">lihat</a> untuk melihat detail peminjaman anda</p>
                      </div>
                    <?php } ?>
                </div>
                <div class="container">
                    <div class="col-md-7 text-center">
                        <h1 class="mb-4"><?= $lab_info['nama_lab'] ?>
                            <small>
                                Info</small>
                        </h1>
                    </div>
                    <div class="row">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="hotel-room text-center">
                                    <a href="" class="d-block mb-4 thumbnail"><img
                                        src="data:image/jpeg;base64,<?= base64_encode( $lab_info['img_lab'] )?>"
                                        alt="Image"
                                        class="img-fluid"></a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="pl-4 mb-0">
                                    <h3 style="color: #e61912;" class="heading mb-0"><?= $lab_info['nama_lab'] ?></h3>
                                </div>
                                <div class="p-4 mb-3 bg-white">
                                    <h3 class="h5 text-black mb-3">Lab Info</h3>
                                    <p class="mb-0 font-weight-bold">Kapasitas</p>
                                    <p style="color: #e61912;" class="mb-4"><?= $lab_info['kapasitas'] ?></p>

                                    <p class="mb-0 font-weight-bold">Deskripsi Lab</p>
                                    <p style="color: #e61912;" class="mb-4"><?= $lab_info['deskripsi'] ?></p>

                                    <p class="mb-0 font-weight-bold">Status Lab</p>
                                    <p style="color: #e61912;" class="mb-4">
                                      <?php
                                        if($lab_info['status_lab'] != 'DIgunakan' ){
                                          echo $lab_info['status_lab'];
                                        }else{
                                          $lab_id = $lab_info['id_lab'];
                                          $pinjam_info = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM pinjam INNER JOIN users ON pinjam.id=users.id_user WHERE id_lab = '$lab_id' "));

                                          echo 'Sedang digunakan oleh '.$pinjam_info['nama'];
                                        }
                                      ?>
                                    </p>

                                    <p class="mb-0 font-weight-bold">Terdaftar pada</p>
                                    <p style="color: #e61912;" class="mb-4"><?= humanTiming($time) ?>
                                        yang lalu(<?= $lab_info['lab_created_at'] ?>)</p>

                                </div>
                            </div>
                            <div class="col-md-12 col-lg-8 mb-5">

                                <form
                                    action=""
                                    method="post"
                                    class="p-5 bg-white"
                                    enctype="multipart/form-data">

                                    <div class="row form-group">
                                        <div class="col-md-12 mb-3 mb-md-0">
                                            <label class="font-weight-bold" for="fullname">Nama Peminjam</label>
                                            <input
                                                type="text"
                                                id="fullname"
                                                name="myname"
                                                class="form-control"
                                                value="<?= $user['nama'] ?>"
                                                required="required"
                                                disabled
                                                placeholder="Full Name">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12"> 
                                            <label class="font-weight-bold" for="email">Email Peminjam</label>
                                            <input
                                                type="email"
                                                id="email"
                                                name="email"
                                                class="form-control"
                                                value="<?= $user['email'] ?>"
                                                required="required"
                                                disabled
                                                placeholder="Email Address">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-md-12 mb-3 mb-md-0">
                                            <label class="font-weight-bold" for="lab">Lab</label>
                                            <select class="form-control" name="lab" id="lab">
                                                <option value="<?= $lab_info['id_lab'] ?>"><?= $lab_info['nama_lab'] ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-md-6">
                                          <label class="font-weight-bold" for="tgl_pinjam">Tanggal Kembali</label>
                                          <input class="form-control" type="date" name="tgl_pinjam" id="tgl_pinjam">
                                        </div>
                                        <div class="col-md-6">
                                          <label class="font-weight-bold" for="tgl_kembali">Tanggal Kembali</label>
                                          <input class="form-control" type="date" name="tgl_kembali" id="tgl_kembali">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <label class="font-weight-bold" for="alasan">Keperluan</label>
                                            <textarea name="alasan" id="alasan" class="form-control" cols="30" rows="7"></textarea>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <?php
                                              if($lab_info['status_lab'] != 'DIgunakan' ){
                                                if(isset($_SESSION['dis'])){
                                            ?>
                                              <input
                                                type="submit"
                                                value="Pinjam"
                                                name="pinjam"
                                                disabled
                                                class="btn btn-primary pill px-4 py-2">
                                            <?php 
                                              }else{
                                                ?>
                                                <input
                                                  type="submit"
                                                  value="Pinjam"
                                                  name="pinjam"
                                                  class="btn btn-primary pill px-4 py-2">
                                                <?php
                                              }}else{
                                            ?> 
                                              <input
                                                type="submit"
                                                value="Pinjam"
                                                name="pinjam"
                                                disabled
                                                class="btn btn-primary pill px-4 py-2">
                                            <?php
                                              }
                                            ?>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>

            <div class="py-5 quick-contact-info">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div>
                                <span class="icon-room text-white h2 d-block"></span>
                                <h2>Lokasi</h2>
                                <p class="mb-0">SMK Telkom Malang
                                    <br>
                                    Sawojajar, Kota Malang</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <span class="icon-clock-o text-white h2 d-block"></span>
                                <h2>Waktu Beroperasi</h2>
                                <p class="mb-0">Senin - Kamis -> 07:00 - 15:00
                                    <br>
                                    Jumat -> 07.00 - 10:00 -> 13.00 - 15.00
                                    <br>
                                    Sabtu - Minggu Libur</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div>
                                <span class="icon-comments text-white h2 d-block"></span>
                                <h2>Hubungi Kami</h2>
                                <p class="mb-0">Hubungi Tim
                                    <br>
                                    Diatas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php 
        include "../guest/footer.php";
        ?>
        <script>
            $(document).ready(function () {
                $(this).scrollTop(0);
            });
        </script>
    </body>
</html>