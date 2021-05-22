<?php 
    session_start();
    include 'functions.php';
    $data = show("SELECT * FROM buku");
    if (!isset($_SESSION["loginAdmin"])) {
        header("Location: loginAdmin.php");
        exit;
    }

    if(isset($_GET['page'])){
        // menangkap data berdasarkan kode_buku
        $kode_buku = $_GET["kode_buku"];
        if ( hapus_buku($kode_buku)> 0 ) {
            echo "
                    <script>
                        alert('Data berhasil dihapus!');
                        document.location.href = 'admin_kelolaBuku.php';
                    </script>
                ";
        } else { echo "
                    <script>
                        alert('Data gagal dihapus!');
                        document.location.href = 'admin_kelolaBuku.php';
                    </script>
                ";
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap-4.5.0-dist/css/all.css">
    <link rel="stylesheet" href="bootstrap-4.5.0-dist/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <title>Halaman Admin</title>
</head>

<body>

    <!-- Navbar -->
    <section>
        <nav class="navbar navbar-expand-lg navbar-light montserrat" style="background-color: #FFC0DB;">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav text-uppercase mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="admin_kelolaPinjaman.php?semua">Daftar Pinjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>

    <!-- Konten  -->
    <section class="diskon mt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="font1">Kelola Daftar Buku</h3>
                    <br>
                    <div class="mb-2">
                        <a class="btn btn-primary" href="admin_tambahBuku.php" role="button">Tambah Data Buku</a>
                    </div>
                </div>
            </div>


            <div class="row pt-3 ">
                <?php
                    foreach ($data as $d) {
                ?>
                <div class="col-md-6 ">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="img/<?= $d["image"]; ?>" alt="buku">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $d["judul"] ?></h4>
                                    <p class="card-text">Pengarang : <?php echo $d["pengarang"] ?></p>
                                    <p class="card-text">Penerbit : <?php echo $d["penerbit"] ?></p>
                                    <p class="card-text">Deskripsi : <?php echo $d["deskripsi"] ?></p>
                                    <p class="card-text">Stok : <?php echo $d["stok"] ?></p>
                                    <div class="mb-2">
                                        <a class="btn btn-outline-primary" href="admin_editBuku.php?kode_buku&id=<?php echo $d["kode_buku"] ?>">Edit</a>
                                        <a class="btn btn-outline-primary" href="admin_kelolaBuku.php?page=&kode_buku=<?= $d["kode_buku"]; ?>" onclick="return confirm('Data ini akan dihapus');">Hapus</a>
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
    <section class="tnav  ">
        <div class="container">
            <div class="row">
                <div class="col-4 pt-3">
                    <a href="https://www.facebook.com/tina.kurniana" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/tinakurniana/" target="_blank"><i class="fab fa-instagram square ml-4"></i></a>
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
    <script 
        src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>
</body>

</html>