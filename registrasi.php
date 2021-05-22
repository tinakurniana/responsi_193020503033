<?php
    include 'functions.php';
	if(isset($_POST["regis"])){
        if(regis($_POST)>0){
            echo "<script>
                alert('Registrasi berhasil');
                document.location.href = 'index.php';
            </script>";
        }else{
            echo "<script>
                alert('Registrasi gagal');
                document.location.href = 'index.php';
            </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap-4.5.0-dist/css/style.css">
</head>

<body class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="brand">
                        <img src="img/login.png" alt="logo">
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title d-flex justify-content-center">Form Registrasi</h4>
                            <form action="" method="POST" class="my-login-validation">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input id="username" type="text" class="form-control" name="username" required autofocus>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input id="nama" type="text" class="form-control" name="nama" required>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input id="tgl_lahir" type="date" class="form-control" name="tgl_lahir" required>
                                </div>

                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input id="nik" type="text" class="form-control" name="nik" required>
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input id="alamat" type="text" class="form-control" name="alamat" required>
                                </div>

                                <div class="form-group">
                                    <label for="no_hp">No HP</label>
                                    <input id="no_hp" type="text" class="form-control" name="no_hp" required>
                                </div>

                                <div class="form-group m-0">
                                    <button type="submit" name="regis" class="btn btn-primary btn-block">Registrasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer">
                        Tina Kurniana | 193020503033
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>