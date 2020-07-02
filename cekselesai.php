<?php
require "config/config.default.php";
require "config/config.function.php";
require "config/functions.crud.php";
$id_mapel = $_POST['id_mapel'];
$id_siswa = $_POST['id_siswa'];
$id_ujian = $_POST['id_ujian'];
$cekpg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='1'"));
$cekesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='2'"));
$quero = mysqli_fetch_array(mysqli_query($koneksi, "SELECT tampil_pg,tampil_esai FROM mapel WHERE id_mapel='$id_mapel'"));

if ($cekpg >= $quero['tampil_pg']) {
    $soalpg = $quero['tampil_pg'];
} else {
    $soalpg = $cekpg;
}
if ($cekesai >= $quero['tampil_esai']) {
    $soalesai = $quero['tampil_esai'];
} else {
    $soalpg = $cekesai;
}
$jumjawab = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM jawaban WHERE id_mapel='$id_mapel' AND id_siswa='$id_siswa' AND id_ujian='$id_ujian'"));
$cekragu = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM jawaban WHERE id_mapel='$id_mapel' AND id_siswa='$id_siswa' AND id_ujian='$id_ujian' and ragu='1'"));
$jumsoal = $soalpg + $soalesai;
if ($jumsoal == $jumjawab) {
    if ($cekragu == 0) {
        echo "ok";
    } else {
        echo "ragu";
    }
} else {
    echo "belum";
}
