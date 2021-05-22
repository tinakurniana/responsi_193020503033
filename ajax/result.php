<?php 
    require '../functions.php';
    $keyword = $_GET["keyword"];
    $query = "SELECT * FROM buku WHERE judul LIKE '%$keyword%'";
    $data_buku = show($query);
?>

<div class="container">
    <div class="row pt-3 " id="result">
        <?php
            foreach ($data_buku as $data) {
        ?>
        <div class="col-md-6 ">
            <div class="card mb-3" style="max-width: 1000px;">
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
                                <a class="btn btn-outline-primary"
                                    href="pinjam.php?pinjam&id=<?php echo $data["kode_buku"] ?>">Pinjam</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>