<?php 
    session_start();
    require 'functions.php';
    
    if ( !isset($_SESSION["loginAdmin"])  ){
        header("Location: loginAdmin.php");
        exit;
    }
    
    $kode_buku = $_GET["id"];
    
    $data = show("SELECT * FROM buku WHERE kode_buku = '$kode_buku'");
    
    if (isset ($_POST["update"])){
        if (edit_buku($_POST) > 0){
            echo "
            <script>
                alert('Data buku berhasil di update');
                document.location.href = 'admin_kelolaBuku.php';
            </script>
            ";
        }else{
            echo "
            <script>
                alert('Data buku gagal di update');
                document.location.href = 'admin_kelolaBuku.php';
            </script>
            ";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap-4.5.0-dist/css/style_kelolaBuku.css">
    <title>Admin - Edit</title>
</head>

<body>
    <div class="testbox">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="banner">
                <h1>Halaman Admin - Edit Data Buku</h1>
            </div>
            <?php
                foreach ($data as $d) {
            ?>
            <div class="item">
                <input type="hidden" class="form-control" name="kode_buku" value="<?= $d["kode_buku"]; ?>">
            </div>
            <div class="item">
                <input type="hidden" class="form-control" name="gambarLama" value="<?= $d["image"]; ?>">
            </div>
            <div class="item">
                <label for="judul">Judul </label>
                <input type="text" class="form-control" name="judul" id="judul" required value="<?= $d["judul"]; ?>">
            </div>
            <div class="item">
                <label for="pengarang">Pengarang </label>
                <input type="text" class="form-control" name="pengarang" id="pengarang" required value="<?= $d["pengarang"]; ?>">
            </div>
            <div class="item">
                <label for="penerbit">Penerbit </label>
                <input type="text" class="form-control" name="penerbit" id="penerbit" required value="<?= $d["penerbit"]; ?>">
            </div>
            <div class="item">
                <label for="deskripsi">Deskripsi </label>
                <!-- <textarea type="text" class="form-control" name="deskripsi" id="deskripsi" required value="<?= $d["deskripsi"]; ?>"></textarea> -->
                <input type="text" class="form-control" name="deskripsi" id="deskripsi" required value="<?= $d["deskripsi"]; ?>">
            </div>
            <div class="item">
                <label for="stok">Stok </label>
                <input type="number" min="1" class="form-control" name="stok" id="stok" required value="<?= $d["stok"]; ?>">
            </div>
            <div class="item">
                <label for="gambar">Gambar</label> <br>
                <img src="img/<?= $d['image']; ?>" alt="" width="100"> <br>
                <input type="file" class="form-control-file" name="gambar" id="gambar" value="<?= $d["image"]; ?>">
            </div>
            <div class="btn-block">
                <button type="submit" name="update" class="btn btn-primary">Edit</button>
            </div>
            <?php
                }
            ?>
        </form>
    </div>
</body>

</html>