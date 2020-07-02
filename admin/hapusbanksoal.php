<?php
require("../config/config.default.php");
require("../config/config.function.php");
$kode = $_POST['kode'];
$exec = mysqli_query($koneksi, "DELETE a.*, b.* FROM mapel a JOIN soal b ON a.id_mapel = b.id_mapel WHERE a.id_mapel in (" . $kode . "')");
$exec = mysqli_query($koneksi, "DELETE FROM soal WHERE id_mapel in (" . $kode . ")");
$exec = mysqli_query($koneksi, "DELETE FROM mapel  WHERE id_mapel in (" . $kode . ")");

if ($exec) {
	echo 1;
} else {
	echo 0;
}
