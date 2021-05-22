<?php
    session_start();
    include 'functions.php';
    
    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }
    
    
    $idarr = $_SESSION["login"][0];
    $id = implode($idarr);
    $data = show("SELECT * FROM data_pinjam WHERE id_user = '$id'");
    
    if(isset($_POST["pinjam"])){
        if(pinjam($_POST)>0){
            echo "<script>
                alert('Peminjaman berhasil');
                document.location.href = 'index.php';
            </script>";
        }else{
            echo "<script>
                alert('Peminjaman gagal');
                document.location.href = 'index.php';
            </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <title>Daftar Pinjaman</title>
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
                    <ul class="navbar-nav text-uppercase mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="daftarPinjaman.php?semua">Semua Pinjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="daftarPinjaman.php?belum">Sedang dipinjam</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="daftarPinjaman.php?sudah">Sudah dikembalikan</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>

    <!-- Konten -->
    <section class="mt-4">
        <div class="container">
            <?php
            if (isset($_GET["semua"])) {
                $idarr = $_SESSION["login"][0];
                $id = implode($idarr);
                $data = show("SELECT * FROM data_pinjam WHERE id_user = '$id'");
            ?>
            <table class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $d) : ?>
                    <tr>
                        <td><?php echo $d["nama_lengkap"]?></td>
                        <td><?php echo $d["judul"] ?></td>
                        <td><?php echo $d["pengarang"] ?></td>
                        <td><?php echo $d["penerbit"] ?></td>
                        <td><?php echo $d["jumlah"] ?></td>
                        <td><?php echo $d["status"] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php
                } elseif (isset($_GET["belum"])) {
                $belum = show("SELECT * FROM data_pinjam WHERE status = 'Sedang dipinjam' AND id_user = '$id'");
            ?>
            <table class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($belum as $b) : ?>
                    <tr>
                        <td><?php echo $b["nama_lengkap"]?></tb>
                        <td><?php echo $b["judul"] ?></td>
                        <td><?php echo $b["pengarang"] ?></td>
                        <td><?php echo $b["penerbit"] ?></td>
                        <td><?php echo $b["jumlah"] ?></td>
                        <td><?php echo $b["status"] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-end font-weight-bold">
            <?php 
                $jumlah = mysqli_query($conn,"SELECT Hitung_Jumlah_Pinjam('$id')");
                $jumlaharr = mysqli_fetch_assoc($jumlah);
                $jlh = implode($jumlaharr);
                echo "Jumlah pinjaman : ".$jlh;
            ?>
            </div>

            <?php
                } elseif (isset($_GET["sudah"])) {
                    $sudah = show("SELECT * FROM data_pinjam WHERE status='Sudah dikembalikan' AND id_user = '$id'");
            ?>
            <table class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($sudah as $s) : ?>
                    <tr>
                        <td><?php echo $s["nama_lengkap"]?></tb>
                        <td><?php echo $s["judul"] ?></td>
                        <td><?php echo $s["pengarang"] ?></td>
                        <td><?php echo $s["penerbit"] ?></td>
                        <td><?php echo $s["jumlah"] ?></td>
                        <td><?php echo $s["status"] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php
                }
            ?>
        </div>
        </div>
    </section>
</body>

</html>