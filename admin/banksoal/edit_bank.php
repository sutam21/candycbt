<?php
require "../../config/config.default.php";
require "../../config/config.function.php";
cek_session_admin();
$pengawas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas  WHERE id_pengawas='$_SESSION[id_pengawas]'"));
$id = $_POST['idm'];
$kode = str_replace(' ', '', $_POST['kode']);
$nama = $_POST['nama'];
$nama = str_replace("'", "&#39;", $nama);
if ($setting['jenjang'] == "SMK") {
    $id_pk = $_POST['id_pk'];
} else {
    $id_pk = ["semua"];
}
$jml_soal = $_POST['jml_soal'];
$jml_esai = $_POST['jml_esai'];
$bobot_pg = $_POST['bobot_pg'];
$bobot_esai = $_POST['bobot_esai'];
$tampil_pg = $_POST['tampil_pg'];
$tampil_esai = $_POST['tampil_esai'];
$level = $_POST['level'];
$status = $_POST['status'];
$opsi = $_POST['opsi'];
$guru = $_POST['guru'];
$kkm = $_POST['kkm'];
$agama = $_POST['agama'];
$kelas = serialize($_POST['kelas']);
$idpk = serialize($id_pk);
if ($pengawas['level'] == 'admin') {
    $exec = mysqli_query($koneksi, "UPDATE mapel SET soal_agama='$agama', kkm='$kkm',kode='$kode', idpk='$idpk',nama='$nama',level='$level',jml_soal='$jml_soal',jml_esai='$jml_esai',status='$status',idguru='$guru',bobot_pg='$bobot_pg',bobot_esai='$bobot_esai',tampil_pg='$tampil_pg',tampil_esai='$tampil_esai',kelas='$kelas',opsi='$opsi' WHERE id_mapel='$id'");
    if ($exec) {
        echo "OK";
    } else {
        echo mysqli_error($koneksi);
    }
} elseif ($pengawas['level'] == 'guru') {
    $exec = mysqli_query($koneksi, "UPDATE mapel SET soal_agama='$agama',kkm='$kkm', kode='$kode', idpk='$idpk',nama='$nama',level='$level',jml_soal='$jml_soal',jml_esai='$jml_esai',status='$status',bobot_pg='$bobot_pg',bobot_esai='$bobot_esai',tampil_pg='$tampil_pg',tampil_esai='$tampil_esai',kelas='$kelas',opsi='$opsi' WHERE id_mapel='$id'");
    if ($exec) {
        echo "OK";
    } else {
        echo mysqli_error($koneksi);
    }
}
