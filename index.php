<?php 
    include 'functions.php';
    session_start();
    $data_buku = show("SELECT * FROM buku");
    if(isset($_POST["regis"])){
        if(regis($_POST)>0){
            echo "<script>
                alert('Registrasi berhasil!');
                document.location.href = 'login.php';
            </script>";
        }else{
            echo "<script>
                alert('Registrasi gagal!');
                document.location.href = 'index.php';
            </script>";
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap-4.5.0-dist/css/all.css">
    <link rel="stylesheet" href="bootstrap-4.5.0-dist/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <title>Perpustakaan</title>
</head>

<body>

    <!-- Navbar -->
    <section>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FFC0DB;">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="nav pull-right">
                        <?php 
                            if(!isset($_SESSION["login"])){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php" style="color:#6e7582; font-size:18px;">LOGIN</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="loginAdmin.php" style="color:#6e7582; font-size:18px;">LOGIN
                                ADMIN</a>
                        </li>
                        <?php 
                            }
                            else { 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php" style="color:#6e7582; font-size:18px;">LOGOUT</a>
                        </li>
                    </ul>
                    <div class="icon-list">
                        <a href="daftarPinjaman.php?semua">
                            <i class="far fa-list-alt"></i>
                        </a>
                    </div>

                    <?php 
                        }
                    ?>
                </div>
            </div>
        </nav>
    </section>

    <!-- Jumbotron -->
    <section>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="container">
                    <div class="carousel-item active">
                        <div class="row justify-content-center pt-5">
                            <div class="col-md-4  text-center ">
                                <h1 class="loraa">e-Perpus Teknik Informatika UPR</h1>
                                <br>
                                <p>Pada sistem ini mahasiswa dapat meminjam buku secara online kemudian dapat mengambil
                                    buku di Perpustakaan Teknik Informatika Universitas Palangka Raya</p>
                            </div>

                            <div class="col-3 d-sm-none d-sm-block  offset-1">
                                <a href="#">
                                    <img src="img/upr.png" class="img-fluid">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center pt-5">
                            <div class="col-4  text-center">
                                <h1 class="loraa">Jam Operasional</h1>
                                <br>
                                <p>Perpustakaan buka setiap hari Senin - Jumat, pukul 09.00-14.00</p>
                            </div>

                            <div class="col-3 d-none d-sm-block offset-1">
                                <img src="img/perpus2.jpg" class="img-fluid" style="max-width: 350px; border-radius: 10%;">
                            </div>
                        </div>

                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
    </section>


    <!-- Konten -->
    <section class="konten mt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="font1">Katalog Buku</h1>
                    <p>Klik pinjam untuk melakukan peminjaman. Cek stok buku yang tersedia.</p>
                </div>
            </div>

            <div class="d-flex justify-content-start mb-4">
                <form action="" method="post">
                    <div class="input-group rounded">
                        <input type="search" name="keyword" id="keyword" class="form-control rounded" placeholder="Cari judul buku" aria-label="Search" aria-describedby="search-addon" size="50" />
                        <span class="input-group-text border-0" id="search-addon">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </form>
            </div>


            <div class="row pt-3 " id="result">
                <?php
                    foreach ($data_buku as $data) {
                ?>
                <div class="col-md-6 ">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="img/<?= $data["image"]; ?>" alt="buku" class="align-self-baseline">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title"><?= $data["judul"] ?></h4>
                                    <p class="card-text">Pengarang : <?= $data["pengarang"] ?></p>
                                    <p class="card-text">Penerbit : <?= $data["penerbit"] ?></p>
                                    <p class="card-text">Deskripsi : <?= $data["deskripsi"] ?></p>
                                    <p class="card-text">Stok : <?= $data["stok"] ?></p>
                                    <div class="mb-2">
                                        <a class="btn btn-outline-primary" href="formPinjam.php?pinjam&id=<?php echo $data["kode_buku"] ?>">Pinjam</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    } 
                ?>
            </div>

            <hr>
        </div>
    </section>

    <!-- Footer -->
    <section class="tnav">
        <div class="container">
            <div class="row">
                <div class="col-4 pt-3">
                    <a href="https://www.facebook.com/tina.kurniana" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/tinakurniana/" target="_blank"><i
                            class="fab fa-instagram square ml-4"></i></a>
                    <p class="mt-2">Copyright © 2021, Tina Kurniana - 193020503033.</p>
                </div>

                <div class="col pt-5 mr-5">
                    <p>Responsi Pemrograman Web dan Mobile I</p>
                </div>

                <div class="col-4 pt-5 mr-5">
                    <p>Universitas Palangka Raya
                        Jln. Yos Sudarso Palangka Raya
                        73111, Kalimantan Tengah
                    </p>
                </div>
            </div>
        </div>
    </section>
    <script src="js/ajax.js"></script>
    <script 
        src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>
</body>

</html>