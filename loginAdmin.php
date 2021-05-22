<?php
	session_start();

	include 'functions.php';

	// cek apakah berhasil login
	if (isset($_SESSION["loginAdmin"])) {
		header("Location: admin_kelolaBuku.php");
		exit;
	}

	// cek apakah tombol login sudah ditekan atau belum
	if (isset($_POST["login"])) {
		$username = $_POST["username"];
		$password = $_POST["password"];

		if ($username == "admin" && $password == "admin") {

				$_SESSION["loginAdmin"] = $username;
				header("Location: admin_kelolaBuku.php");
				exit;
		}

		$error = true;
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Halaman Login Admin</title>
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
                            <h4 class="card-title d-flex justify-content-center">Login Admin</h4>
                            <form action="" method="POST" class="my-login-validation">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input id="username" type="text" class="form-control" name="username" required autofocus>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>

                                <div class="form-group m-0">
                                    <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                                </div>
                                <?php if (isset($error)) : ?>
                                <p style="color: red; font-style: italic;">
                                    Username / Password salah!
                                </p>
                                <?php endif; ?>
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