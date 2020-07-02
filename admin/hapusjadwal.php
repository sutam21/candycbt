<?php

require("../config/config.default.php");
require("../config/config.function.php");
$kode = $_POST['kode'];

$exec = mysqli_query($koneksi, "DELETE FROM ujian WHERE id_ujian in (" . $kode . ")");

if ($exec) {
	echo 1;
} else {
	echo 0;
}
