<?php
session_start();
include "config.php";

$username = $_POST['username'];
$password = $_POST['password'];
$op = $_GET['op'];

// Check if the connection is successful
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($op == "in") {
    // Gunakan prepared statement untuk mencegah SQL injection
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM user WHERE username=? AND password=?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $qry = mysqli_fetch_array($result);
        $_SESSION['username'] = $qry['username'];
        $_SESSION['nama'] = $qry['nama'];
        $_SESSION['level'] = $qry['level'];

        if ($qry['level'] == "admin" || $qry['level'] == "user") {
            header("location:../template/index.php");
        }
    } else {
?>
        <script language="JavaScript">
            alert('Username atau Password tidak sesuai. Silahkan diulang kembali!');
            document.location='../index.php';
        </script>
<?php
    }
    mysqli_stmt_close($stmt);
} else if ($op == "out") {
    unset($_SESSION['username']);
    unset($_SESSION['level']);
    header("location:../index.php");
}

// Tutup koneksi setelah digunakan
mysqli_close($koneksi);
?>
