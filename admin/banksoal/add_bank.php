<?php
require "../../config/config.default.php";
require "../../config/config.function.php";
cek_session_guru();
$pengawas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas  WHERE id_pengawas='$_SESSION[id_pengawas]'"));
$id_pengawas=$pengawas['id_pengawas'];
$kode = str_replace(' ', '', $_POST['kode']);
$nama = $_POST['nama'];
$nama = str_replace("'", "&#39;", $nama);
if ($setting['jenjang'] == "SMK") {
    $id_pk = $_POST['id_pk'];
} else {
    $id_pk = ["semua"];
}
$jml_esai = ($_POST['jml_esai'] <> '') ? $_POST['jml_esai'] : 0;
$jml_soal = $_POST['jml_soal'];
$bobot_pg = $_POST['bobot_pg'];
$bobot_esai = ($_POST['bobot_esai'] <> '') ? $_POST['bobot_esai'] : 0;
$tampil_pg = $_POST['tampil_pg'];
$tampil_esai = ($_POST['tampil_esai'] <> '') ? $_POST['tampil_esai'] : 0;
$level = $_POST['level'];
$status = $_POST['status'];
$opsi = $_POST['opsi'];
$kkm = $_POST['kkm'];
$agama = $_POST['agama'];
$kelas = serialize($_POST['kelas']);
$id_pk = serialize($id_pk);
$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mapel WHERE  kode='$kode'"));

if ($pengawas['level'] == 'admin') {
    $guru = $_POST['guru'];
    if ($cek > 0) :
        echo "Maaf kode Soal Sudah ada !";
    else :
        $exec = mysqli_query($koneksi, "INSERT INTO mapel (kode, idpk, nama, jml_soal,jml_esai,level,status,idguru,bobot_pg,bobot_esai,tampil_pg,tampil_esai,kelas,opsi,kkm,soal_agama) VALUES ('$kode','$id_pk','$nama','$jml_soal','$jml_esai','$level','$status','$guru','$bobot_pg','$bobot_esai','$tampil_pg','$tampil_esai','$kelas','$opsi','$kkm','$agama')");

        if ($exec) {
            echo "OK";
        } else {
            echo mysqli_error($koneksi);
        }
    endif;
} elseif ($pengawas['level'] == 'guru') {
    if ($cek > 0) :
        echo "Maaf kode Sudah ada !";
    else :
        $exec = mysqli_query($koneksi, "INSERT INTO mapel (kode, idpk, nama, jml_soal,jml_esai,level,status,idguru,bobot_pg,bobot_esai,tampil_pg,tampil_esai,kelas,opsi,kkm,soal_agama) VALUES ('$kode','$id_pk','$nama','$jml_soal','$jml_esai','$level','$status','$id_pengawas','$bobot_pg','$bobot_esai','$tampil_pg','$tampil_esai','$kelas','$opsi','$kkm','$agama')");
        if ($exec) {
            echo "OK";
        }
    endif;
}
