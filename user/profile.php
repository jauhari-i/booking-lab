<?php 
        include "../conn.php";

        session_start();
        $id = $_GET['id'];

        if(!isset($_SESSION['id'])){
                $_SESSION['error'] = "Please Log In First !";
                header("location: ../auth/login");
        }

        if(isset($_POST['edit'])){
            $nama = $_POST['myname'];
            $email = $_POST['email'];
            $kelas = $_POST['kelas'];
            $file = $_FILES['pp']['tmp_name'];
            $newpw = $_POST['password'];
            $newpw2 = $_POST['password2'];
            $oldpw = $_POST['password3'];

            if(empty($newpw2 || $newpw)){
                if(empty($file)){
                    $update = mysqli_query($myDB,"UPDATE users SET nama='$nama',email='$email',id_kelas='$kelas' WHERE id_user = '$id' ");   
                    $_SESSION['success'] = "User Data Modifed Successfully";    
                }else{
                    $file = addslashes(file_get_contents($_FILES['pp']['tmp_name']));
                    $update = mysqli_query($myDB,"UPDATE users SET nama='$nama',email='$email',id_kelas='$kelas',img='$file' WHERE id_user = '$id' "); 
                    $_SESSION['success'] = "User Data Modifed Successfully";
                }
            }else{

                $oldpw_enc = sha1($oldpw);
                $cek_query = mysqli_query($myDB,"SELECT password FROM users WHERE password = '$oldpw_enc' ");
                if(mysqli_num_rows($cek_query) > 0){
                    if($newpw == $newpw2){
                        $newpw_enc = sha1($newpw);

                        if(empty($file)){
                            $update = mysqli_query($myDB,"UPDATE users SET nama='$nama',email='$email',id_kelas='$kelas',password='$newpw_enc' WHERE id_user = '$id' ");   
                            $_SESSION['success'] = "User Data/Password Telah Diperbarui!";    
                        }else{
                            $file = addslashes(file_get_contents($_FILES['pp']['tmp_name']));
                            $update = mysqli_query($myDB,"UPDATE users SET nama='$nama',email='$email',id_kelas='$kelas',img='$file',password='$newpw_enc' WHERE id_user = '$id' "); 
                            $_SESSION['success'] = "User Data/Password Telah DIperbarui!";
                        }
                    }else{
                        $_SESSION['error'] = "Password Baru Tidak Sama";
                    }
                }else{
                    $_SESSION['error'] = "Password Lama Tidak Sama";
                }

            }
        }

        $user = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM users INNER JOIN kelas ON users.id_kelas=kelas.id_kelas WHERE id_user = '$id' "));
        $kelas = mysqli_query($myDB,"SELECT * FROM kelas ORDER BY id_kelas ASC");
        $data_kelas = mysqli_fetch_assoc($kelas);
        // print_r($_REQUEST);

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
    </div> <!-- .site-mobile-menu -->
    
    
    <div class="site-navbar-wrap js-site-navbar bg-white">
      <div class="container">
        <div class="site-navbar bg-white">
          <div class="py-1">
            <div class="row align-items-center">
              <div class="col-2">
                <h2 class="mb-0 site-logo"><a href="../user/index">Labku.id</a></h2>
              </div>
              <div class="col-10">
                <nav class="site-navigation text-right" role="navigation">
                  <div class="container">
                    
                    <div class="d-inline-block d-lg-none  ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu h3"></span></a></div>
                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                      <li class="active">
                        <a href="../user/index">Home</a>
                      </li>
                      <li class="has-children">
                        <p style="margin-top: 10px;" class="btn btn-primary btn-flat"><i class="fa fa-user" aria-hidden="true"></i> <?= $user['nama'] ?></p>
                        <ul class="dropdown">
                           <?php 
                            if($user['admin'] == 1){
                                ?><li><a href="../admin">Admin Dashboard</a></li><?php
                            }
                           ?> 
                          <li class="active"><a href="../user/profile?id=<?= $id ?>">Lihat Profil</a></li>
                          <li><a href="../user/peminjaman">Lihat Peminjaman</a></li>
                          <li><a href="../auth/logout">Log Out <i class="fas fa-external-link-alt    "></i></a></li>
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
  
    
    <div class="site-blocks-cover overlay" style="background-image: url(../assets/bg-02.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-12 text-center" data-aos="fade">
              <span class="caption mb-3">Profile</span>
              <h1 class="mb-4"><?= $user['nama'] ?></h1>
            </div>
          </div>
        </div>
      </div>  



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
                            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?' ':'');
                        }

                    }
                ?>
      <div class="site-section site-section-sm">
        <div class="col-md-12">
        <?php 
        if(isset($_SESSION['success'])){
            ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                    <?= $_SESSION['success'] ?>
              </div>
            <?php
            unset($_SESSION['success']);
        }
      ?>
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
        </div>
      <div class="container">
            <div class="col-md-7 text-center">
              <h1 class="mb-4"><?= $user['nama'] ?><small> Profile</small></h1>
            </div>
        <div class="row">
            <div class="row">
            <div class="col-lg-6">
            <div class="hotel-room text-center">
              <a href="" class="d-block mb-4 thumbnail"><img src="data:image/jpeg;base64,<?= base64_encode( $user['img'] )?>" alt="Image" class="img-fluid"></a>
            </div>
          </div>
          <div class="col-lg-6">
          <div class="pl-4 mb-0">
              <h3 style="color: #e61912;" class="heading mb-0"><?= $user['nama'] ?></h3>
              </div>
            <div class="p-4 mb-3 bg-white">
              <h3 class="h5 text-black mb-3">Contact Info</h3>
              <p class="mb-0 font-weight-bold">Kelas</p>
              <p style="color: #e61912;" class="mb-4"><?= $user['kelas'] ?></p>

              <p class="mb-0 font-weight-bold">Email Address</p>
              <p style="color: #e61912;" class="mb-4"><?= $user['email'] ?></p>

              <p class="mb-0 font-weight-bold">Bergabung Sejak</p>
              <p style="color: #e61912;" class="mb-4"><?= humanTiming($time) ?> yang lalu(<?= $user['tgl_register'] ?>)</p>


            </div>
            </div>
          <div class="col-md-12 col-lg-8 mb-5">
          
            
          
            <form action="" method="post" class="p-5 bg-white" enctype="multipart/form-data">

              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="font-weight-bold" for="fullname">Nama</label>
                  <input type="text" id="fullname" name="myname" class="form-control" value="<?= $user['nama'] ?>" required placeholder="Full Name">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <label class="font-weight-bold" for="email">Email</label>
                  <input type="email" id="email" name="email" class="form-control" value="<?= $user['email'] ?>" required placeholder="Email Address">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="font-weight-bold" for="kelas">Kelas</label>
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

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="font-weight-bold" for="password">Ganti Password</label>
                  <input type="password" id="password" name="password" class="form-control" placeholder="Password Baru">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="font-weight-bold" for="password2">Konfirmasi Password</label>
                  <input type="password" id="password2" name="password2" class="form-control" placeholder="Konfirmasi Password Baru">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="font-weight-bold" for="password3">Password Lama</label>
                  <input type="password" id="password3" name="password3" class="form-control" placeholder="Password Lama">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                <label for="img" class="font-weight-bold">Update Foto</label>
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="file" name="pp" id="pp"  accept="image/*">
                        <p class="help-block">Tipe FIle: jpg, png, gif, jpeg
                                                    <br><small>Opsional</small> </p>
                    </div>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Edit" name="edit" class="btn btn-primary pill px-4 py-2">
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
              <p class="mb-0">SMK Telkom Malang <br>  Sawojajar, Kota Malang</p>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <div>
              <span class="icon-clock-o text-white h2 d-block"></span>
              <h2>Waktu Beroperasi</h2>
              <p class="mb-0">Senin - Kamis -> 07:00 - 15:00 <br>
              Jumat -> 07.00 - 10:00 -> 13.00 - 15.00 <br>
              Sabtu - Minggu Libur</p>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <div>
              <span class="icon-comments text-white h2 d-block"></span>
              <h2>Hubungi Kami</h2>
              <p class="mb-0">Hubungi Tim <br> Diatas</p>
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
    $(document).ready(function(){
        $(this).scrollTop(0);
    });
    </script>
  </body>
</html> 