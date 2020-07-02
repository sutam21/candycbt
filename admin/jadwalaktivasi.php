<?php
require '../config/config.default.php';
if ($_GET['key'] <> '1616161616') {
    echo "script tidak bisa diakses";
} else {

    foreach ($_POST['ujian'] as $ujian) {
        if ($_POST['aksi'] <> 'hapus') {
            $exec = mysqli_query($koneksi, "UPDATE ujian set status='$_POST[aksi]',sesi='$_POST[sesi]' where id_ujian='$ujian'");
            if ($exec) {
                echo "update";
            }
        } else {
            $exec = mysqli_query($koneksi, "DELETE from ujian where id_ujian='$ujian'");

            if ($exec) {
                echo "hapus";
            }
        }
    }
}
