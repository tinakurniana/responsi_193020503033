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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap-4.5.0-dist/css/style_formPinjam.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
</head>

<body>
    <section class="mt-4">
        <div class="container">
            <div class="mb-4 d-flex justify-content-center">
                <h3>Form Peminjaman</h3>
            </div>
            <form action="daftarPinjaman.php" method="post" enctype="multipart/form-data" class="decor">
                <div class="form-left-decoration"></div>
                <div class="form-right-decoration"></div>
                <div class="circle"></div>
                <div class="form-inner">
                    <div class="form-group">
                        <input type="hidden" name="id_user" value="<?php echo $id?>">
                    </div>
                    <div class="form-group font-weight-bold">
                        <label for="kode_buku">Kode Buku : <?php echo $_GET["id"]?></label>
                        <input type="hidden" name="kode_buku" value="<?php echo $_GET["id"]?>">
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Peminjaman</label>
                        <input type="number" min="1" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah Buku" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Tanggal Peminjaman</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" required>
                    </div>
                    <div>
                        <button type="submit" name="pinjam" class="btn btn-primary">Ajukan Peminjaman</button>
                    </div>
            </form>

</body>

</html>