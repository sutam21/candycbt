<?php
require "../../config/config.default.php";
require "../../config/config.function.php";
cek_session_guru();
$id = $_POST['idm'];
$mapel = mysqli_fetch_array(mysqli_query($koneksi, "select * from mapel where id_mapel='$id'"));
$kode = str_replace(' ', '_', $_POST['kodebank']);
$nama = $mapel['nama'];
$jml_esai = $mapel['jml_esai'];
$jml_soal = $mapel['jml_soal'];
$bobot_pg = $mapel['bobot_pg'];
$bobot_esai = $mapel['bobot_esai'];
$tampil_pg = $mapel['tampil_pg'];
$tampil_esai = $mapel['tampil_esai'];
$level = $mapel['level'];
$status = $mapel['status'];
$opsi = $mapel['opsi'];
$kkm = $mapel['kkm'];
$agama = $mapel['agama'];
$kelas = $mapel['kelas'];
$id_pk = $mapel['idpk'];
$guru = $mapel['idguru'];
$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mapel WHERE  kode='$kode'"));

if ($cek > 0) :
    echo "Maaf Kode Bank Soal Sudah ada !";
else :
    $exec = mysqli_query($koneksi, "INSERT INTO mapel (kode, idpk, nama, jml_soal,jml_esai,level,status,idguru,bobot_pg,bobot_esai,tampil_pg,tampil_esai,kelas,opsi,kkm,soal_agama) VALUES ('$kode','$id_pk','$nama','$jml_soal','$jml_esai','$level','$status','$guru','$bobot_pg','$bobot_esai','$tampil_pg','$tampil_esai','$kelas','$opsi','$kkm','$agama')");
    if ($exec) {
        echo "OK";
    }
endif;
