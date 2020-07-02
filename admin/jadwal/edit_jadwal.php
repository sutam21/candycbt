<?php
require "../../config/config.default.php";
$idujian = $_POST['idm'];
$sesi = $_POST['sesi'];
$tglujian = $_POST['mulaiujian'];
$tglselesai = $_POST['selesaiujian'];
$lama = $_POST['lama_ujian'];
$waktu = explode(" ", $tglujian);
$waktu = $waktu[1];
$acak = (isset($_POST['acak'])) ? 1 : 0;
$token = (isset($_POST['token'])) ? 1 : 0;
$hasil = (isset($_POST['hasil'])) ? 1 : 0;
$acakopsi = (isset($_POST['acakopsi'])) ? 1 : 0;
$reset = (isset($_POST['reset'])) ? 1 : 0;
$exec = mysqli_query($koneksi, "UPDATE ujian SET sesi='$sesi',tgl_ujian='$tglujian',tgl_selesai='$tglselesai',waktu_ujian='$waktu',lama_ujian='$lama',acak='$acak',token='$token',hasil='$hasil',ulang='$acakopsi',reset='$reset' WHERE id_ujian='$idujian'");
if ($exec) {
    echo "OK";
}
