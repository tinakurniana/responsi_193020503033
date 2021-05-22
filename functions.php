<?php
    $servername = "localhost";
    $database = "responsi_pwb_193020503033";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($servername, $username, $password, $database);

    function show($query){
        global $conn;
        $result = mysqli_query($conn, $query);

        $rows = [];
        while( $row = mysqli_fetch_assoc($result) ){
            $rows[] = $row;
        }
        return $rows;
    }

    function regis($data){
        global $conn;
        $nama = mysqli_real_escape_string($conn,$data["nama"]);
        $username = mysqli_real_escape_string($conn,$data["username"]);
        $password = mysqli_real_escape_string($conn,$data["password"]);
        $tgl_lahir = mysqli_real_escape_string($conn,$data["tgl_lahir"]);
        $nik = mysqli_real_escape_string($conn,$data["nik"]);
        $alamat = mysqli_real_escape_string($conn,$data["alamat"]);
        $no_hp = mysqli_real_escape_string($conn,$data["no_hp"]);

        $query = mysqli_query($conn, "SELECT MAX(id_user) AS id FROM user");

        // menangkap data dari hasil perintah query dan membentuknya ke dalam array asosiatif dan array numerik
        $data = mysqli_fetch_array($query);

        $id_user = $data['id'];
        
        // mengambil angka dari kode barang terbesar, menggunakan fungsi substr untuk memotong string
        // dan diubah ke integer dengan (int)
        $urutan = (int) substr($id_user, 3, 3);
        
        // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
        $urutan++;
        
        // membentuk kode barang baru
        // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
        // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
        // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
        $huruf = "USR";
        $id_user = $huruf . sprintf("%03s", $urutan);

        $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
        if( mysqli_fetch_assoc($result) ){
            echo "<script>
                    alert('Username sudah terdaftar! Silahkan buat username lain')
                </script>";
            return false;
        }
        $pass = password_hash($password, PASSWORD_DEFAULT);

        // tambahkan user baru ke database
        mysqli_query($conn, "CALL Insert_User('$id_user','$username','$pass','$nama')");

        $query = mysqli_query($conn, "SELECT MAX(id_anggota) AS idanggota FROM anggota");
        $data = mysqli_fetch_array($query);
        $id_anggota = $data['idanggota'];
        $urutan = (int) substr($id_anggota, 3, 3);
        $urutan++;
        $huruf = "AGT";
        $id_anggota = $huruf . sprintf("%03s", $urutan);

        mysqli_query($conn, "CALL Insert_Anggota('$id_anggota','$id_user','$tgl_lahir','$nik','$alamat','$no_hp')");

        return mysqli_affected_rows($conn);
    }

    function pinjam($data){
        global $conn;

        $kode_buku = $data["kode_buku"]; 
        $id_user = $data["id_user"];
        $jumlah = $data["jumlah"];
        $tanggal = $data["tanggal"];
        $status = "Sedang dipinjam";

        $jlh = mysqli_query($conn,"SELECT stok FROM buku WHERE kode_buku = '$kode_buku'");
        $jlharr = mysqli_fetch_assoc($jlh);
        $j = implode($jlharr);
        
        // Jika jumlah stok buku lebih dari nol
        if($j>0){
            // Jika jumlah yg akan dipinjam kurang dari jumlah stok
            if($jumlah<=$j){
                mysqli_query($conn, "CALL Insert_Pinjaman('$id_user','$kode_buku','$jumlah','$tanggal','$status')");
            // Jika jumlah yg dipinjam lbh dari jumlah stok buku
            }else{
                echo "<script>
                    alert('Stok tidak mencukupi');
                    document.location.href = 'index.php';
                    </script>";
                return false;
            }
        // Jika jumlah stok <= 0
        }else{
            echo "<script>
                alert('Stok abis');
                document.location.href = 'index.php';
            </script>";
            return false;
        }
        return mysqli_affected_rows($conn);
    }

    function tambah_buku($data){
        global $conn;
        $judul = $data["judul"];
        $pengarang = $data["pengarang"];
        $penerbit = $data["penerbit"];
        $deskripsi = $data["deskripsi"];
        $stok = $data["stok"];
        // $gambar = $data["gambar"];

        $query = mysqli_query($conn, "SELECT MAX(kode_buku) AS kode FROM buku");

        $data = mysqli_fetch_array($query);
        $kode_buku = $data['kode'];
        
        // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
        // dan diubah ke integer dengan (int)
        $urutan = (int) substr($kode_buku, 3, 3);
        
        // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
        $urutan++;
        
        // membentuk kode barang baru
        // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
        // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
        // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
        $huruf = "KBK";
        $kode_buku = $huruf . sprintf("%03s", $urutan);

        $gambar = upload();
        if( !$gambar) {
            return false;
        }
        mysqli_query($conn, "CALL Insert_Buku('$kode_buku', '$judul', '$pengarang', '$penerbit', '$deskripsi', '$stok', '$gambar')");
        // cek apakah data berhasil ditambahkan atau tidak
        return mysqli_affected_rows($conn);
    }

    function upload(){
        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        // cek apakah tidak ada gambar yang diupload
        if( $error === 4) {
            echo "<script>
                    alert('Pilih gambar terlebih dahulu!');
                </script>";
            return false;    
        }

        // cek apakah yang diupload adalah gambar
        $eksetensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if ( !in_array($ekstensiGambar, $eksetensiGambarValid) ) {
            echo "<script>
                    alert('Yang anda upload bukan gambar!');
                </script>";
            return false;
        }

        // cek jika ukuran terlalu besar
        if( $ukuranFile > 1000000 ) {
            echo "<script>
                    alert('Ukuran gambar terlalu besar! (Max. 1MB)');
                </script>";
            return false;
        }

        // lolos pengecekan, gambar siap diupload
        // generate nama gambar baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;
        move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
        return $namaFileBaru;
    }

    function hapus_buku($kode_buku){
        global $conn;
        mysqli_query($conn, "CALL Delete_Buku('$kode_buku')");
        
        // cek apakah data berhasil dihapuskan atau tidak
        return mysqli_affected_rows($conn);	
    }

    function edit_buku($data){
        global $conn;
        $kode_buku = $_POST["kode_buku"];
        $judul = $_POST["judul"];
        $penerbit = $_POST["penerbit"];
        $pengarang = $_POST["pengarang"];
        $deskripsi = $_POST["deskripsi"];
        $stok = $_POST["stok"];
        // $gambar = $_POST["gambar"];
        $gambarLama = htmlspecialchars($data["gambarLama"]);

            // cek apakah user pilih gambar baru atau tidak
            if( $_FILES['gambar']['error'] === 4 ){
                $gambar = $gambarLama;
            } else {
                $gambar = upload();
            }

        mysqli_query($conn, "CALL Update_Buku('$kode_buku', '$judul','$pengarang','$penerbit','$deskripsi', '$stok', '$gambar')");

        return mysqli_affected_rows($conn);
    }

    function update_status($data){
        global $conn;
        $id_user = $data["id_user"];
        $kode_buku = $data["kode_buku"];
        $id_pinjaman = $data["id_pinjaman"];

        mysqli_query($conn,"CALL Update_Status_Pinjaman('$id_pinjaman','$id_user','$kode_buku')");
        return mysqli_affected_rows($conn);
    }

    function cari($keyword){
        $query = "SELECT * FROM buku WHERE judul LIKE '%$keyword%'";
        return show($query);
    }
    
?> 