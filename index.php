<!DOCTYPE html>
<html lang="en">
  <head>
    <?php 
        include "guest/head.php"; 
        include "conn.php";

        session_start();

        $teams = mysqli_query($myDB,"SELECT * FROM users INNER JOIN kelas ON users.id_kelas=kelas.id_kelas WHERE admin = '1' ");
        $lab = mysqli_query($myDB,"SELECT * FROM lab ORDER BY nama_lab ")
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
        <div class="site-navbar bg-light">
          <div class="py-1">
            <div class="row align-items-center">
              <div class="col-2">
                <h2 class="mb-0 site-logo"><a href="">Labku.id</a></h2>
              </div>
              <div class="col-10">
                <nav class="site-navigation text-right" role="navigation">
                  <div class="container">
                    
                    <div class="d-inline-block d-lg-none  ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu h3"></span></a></div>
                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                      <li class="active">
                        <a href="">Home</a>
                      </li>
                      <li><a onclick="document.getElementById('lab').scrollIntoView({ behavior: 'smooth' });" style="cursor: pointer;">Lab</a></li>
                      <li><a onclick="document.getElementById('fitur').scrollIntoView({ behavior: 'smooth' });" style="cursor: pointer;">FItur</a></li>
                      <li><a onclick="document.getElementById('team').scrollIntoView({ behavior: 'smooth' });" style="cursor: pointer;">Teams</a></li>
                      <li class="has-children">
                        <p style="margin-top: 10px;" class="btn btn-primary btn-flat">Login / Register</p>
                        <ul class="dropdown">
                          <li><a href="auth/login">Log In</a></li>
                          <li><a href="auth/register">Register</a></li>
                          <!-- <li><a href="#">Single Room</a></li> -->
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
  
    
    <div class="slide-one-item home-slider owl-carousel">
      
      <div class="site-blocks-cover overlay" style="background-image: url(assets/bg-02.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-10 text-center" data-aos="fade">  
              <h1 class="mb-2">Selamat Datang</h1>
              <h2 class="caption">Di Labku.id</h2>
            </div>
          </div>
        </div>
      </div>  

      <div class="site-blocks-cover overlay" style="background-image: url(assets/bg-01.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-10 text-center" data-aos="fade">
              <h1 class="mb-2">Website Peminjaman Lab</h1>
              <h2 class="caption">SMK TELKOM MALANG</h2>
            </div>
          </div>
        </div>
      </div> 

      <div class="site-blocks-cover overlay" style="background-image: url(assets/bg-03.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-10 text-center" data-aos="fade">
              <h1 class="mb-2">Gak Perlu Ribet</h1>
              <h2 class="caption">Mudah Digunakan</h2>
            </div>
          </div>
        </div>
      </div> 

    </div>

    <div id="lab" class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mx-auto text-center mb-5 section-heading">
            <h2 class="mb-5">Lab Kami</h2>
          </div> 
        </div>
        <div class="row">
            <?php foreach($lab as $data): ?>
            <div class="col-md-6 col-lg-4 mb-5">
                <div class="hotel-room text-center">
                    <a href="user/labform?id=<?= $data['id_lab'] ?>" class="d-block mb-4 thumbnail"><img src="data:image/jpeg;base64,<?= base64_encode( $data['img_lab'] )?>" style="max-height: 200px;" alt="Image" class="img-fluid"></a>
                    <div class="hotel-room-body">
                        <h3 class="heading mb-0"><a href="#"><?= $data['nama_lab'] ?></a></h3>
                        <strong class="price"><?= $data['deskripsi'] ?></strong><br>
                        <small><?= $data['status_lab'] ?></small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div id="fitur" class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mx-auto text-center mb-5 section-heading">
            <h2 class="mb-5">Fitur Lab</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="text-center p-4 item">
              <span><img src="assets/ico (1).png" style="width: 50px;height:50px;" ></span>
              <h2 class="h5">Wi Fi</h2>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="text-center p-4 item">
              <span><img src="assets/ico (2).png" style="width: 50px;height:50px;" ></span>
              <h2 class="h5">Full AC</h2>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="text-center p-4 item">
              <span><img src="assets/ico (3).png" style="width: 50px;height:50px;" ></span>
              <h2 class="h5">Kabel Ethernet</h2>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="text-center p-4 item">
              <span><img src="assets/ico (4).png" style="width: 50px;height:50px;" ></span>
              <h2 class="h5">PC Desktop</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div id="team" class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mx-auto text-center mb-5 section-heading">
            <h2 class="mb-5">Booking Tim</h2>
          </div>
        </div>
        <div class="row">
          <?php foreach($teams as $data): ?>
          <div class="col-md-6 col-lg-4 mb-5">
            <div class="hotel-room text-center">
              <a href="#" class="d-block mb-4 thumbnail"><img src="data:image/jpeg;base64,<?= base64_encode( $data['img'] )?>" alt="Image" class="img-fluid"></a>
              <div class="p-4">
                <h3 class="heading mb-3"><a href="#"><?= $data['nama'] ?></a></h3>
                <p><?= $data['email'] ?></p>
                <p><?= $data['kelas'] ?></p>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
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
        include "guest/footer.php";
    ?>
    <script>
    $(document).ready(function(){
        $(this).scrollTop(0);
    });
    </script>
  </body>
</html>