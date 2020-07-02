<?php
require "../../config/config.default.php";
require "../../config/config.function.php";
if (!isset($_SESSION['id_pengawas'])) {
    header('Location:login.php');
} else {
    $pengawas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas  WHERE id_pengawas='$_SESSION[id_pengawas]'"));

    $tgl_ujian = $_POST['tgl_ujian'];
    $tgl_selesai = $_POST['tgl_selesai'];
    $kode_ujian = $_POST['kode_ujian'];
    $idmapel = $_POST['idmapel'];
    $mapelx = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$idmapel'"));
    $namamapel = $mapelx['nama'];
    $mapely = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mata_pelajaran WHERE kode_mapel='$namamapel'"));
    $nama_mapel = $mapely['nama_mapel'];
    $jmlsoal = $mapelx['jml_soal'];
    $jml_esai = $mapelx['jml_esai'];
    $bobot_pg = $mapelx['bobot_pg'];
    $bobot_esai = $mapelx['bobot_esai'];
    $tampil_pg = $mapelx['tampil_pg'];
    $tampil_esai = $mapelx['tampil_esai'];
    $opsi = $mapelx['opsi'];
    $level = $mapelx['level'];
    $id_pk = $mapelx['idpk'];
    $wkt = explode(" ", $tgl_ujian);
    $wkt_ujian = $wkt[1];
    $lama_ujian = $_POST['lama_ujian'];
    $sesi = $_POST['sesi'];
    $idguru = $mapelx['idguru'];
    $kelas = $mapelx['kelas'];
    $acak = (isset($_POST['acak'])) ? 1 : 0;
    $token = (isset($_POST['token'])) ? 1 : 0;
    $hasil = (isset($_POST['hasil'])) ? 1 : 0;
    $acakopsi = (isset($_POST['acakopsi'])) ? 1 : 0;
    $reset = (isset($_POST['reset'])) ? 1 : 0;
    $kkm = $mapelx['kkm'];
    $agama = $mapelx['soal_agama'];
    $kodenama = $mapelx['kode'];
    // $ulang = $_POST['ulang'];
    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM ujian WHERE kode_nama='$kodenama' and sesi='$sesi' "));
?>
<?php if ($cek == 0) :
        if ($pengawas['level'] == 'admin') {
            $exec = mysqli_query($koneksi, "INSERT INTO ujian (id_pk, id_mapel, nama,jml_soal,jml_esai,lama_ujian, tgl_ujian, tgl_selesai, waktu_ujian, level, sesi, acak, token, status, bobot_pg, bobot_esai, id_guru, tampil_pg, tampil_esai, hasil, kelas, opsi, kode_ujian, kkm,ulang,soal_agama,kode_nama,reset) VALUES ('$id_pk','$idmapel','$nama_mapel','$jmlsoal','$jml_esai','$lama_ujian','$tgl_ujian','$tgl_selesai','$wkt_ujian','$level','$sesi','$acak','$token','1','$bobot_pg','$bobot_esai','$idguru','$tampil_pg','$tampil_esai','$hasil','$kelas','$opsi','$kode_ujian', '$kkm','$acakopsi','$agama','$kodenama','$reset')");
        } else {
            $exec = mysqli_query($koneksi, "INSERT INTO ujian (id_pk, id_mapel, nama,jml_soal,jml_esai,lama_ujian, tgl_ujian, tgl_selesai, waktu_ujian, level, sesi, acak, token, status ,bobot_pg, bobot_esai, id_guru, tampil_pg, tampil_esai, hasil, kelas, opsi, kode_ujian, kkm,ulang,soal_agama,kode_nama,reset) VALUES ('$id_pk','$idmapel','$nama_mapel','$jmlsoal','$jml_esai','$lama_ujian','$tgl_ujian','$tgl_selesai','$wkt_ujian','$level','$sesi','$acak','$token','1','$bobot_pg','$bobot_esai','$_SESSION[id_pengawas]','$tampil_pg','$tampil_esai','$hasil','$kelas','$opsi','$kode_ujian', '$kkm','$acakopsi','$agama','$kodenama','$reset')");
        }
        if ($exec) {
            echo "OK";
        }
    endif;
}
