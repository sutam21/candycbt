<?php
require "../config/config.default.php";
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:login.php') : null;
$pengawas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas  WHERE id_pengawas='$id_pengawas'"));
$password = $_POST['password'];
if (!password_verify($password, $pengawas['password'])) {
    echo "password salah";
} else {
    if (!empty($_POST['data'])) {
        $data = $_POST['data'];
        if ($data <> '') {
            foreach ($data as $table) {
                if ($table <> 'pengawas') {
                    mysqli_query($koneksi, "TRUNCATE $table");
                } else {
                    mysqli_query($koneksi, "DELETE FROM $table WHERE level!='admin'");
                }
            }
            echo "ok";
        }
    }
}
