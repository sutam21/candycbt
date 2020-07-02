<?php
require("../config/config.default.php");
require("../config/config.function.php");
if (isset($_POST['id'])) {
	$idu = $_POST['id'];
	$mapelQ = mysqli_query($koneksi, "SELECT * from jawaban WHERE id_ujian='$idu' ");

	while ($jawab = mysqli_fetch_array($mapelQ)) {
		$jawab_essai = addslashes($jawab['esai']);
		$exec = mysqli_query($koneksi, "INSERT INTO hasil_jawaban (id_siswa,id_mapel,id_soal,jawaban,jenis,esai,nilai_esai,ragu,id_ujian,jawabx)VALUES('$jawab[id_siswa]','$jawab[id_mapel]','$jawab[id_soal]','$jawab[jawaban]','$jawab[jenis]','$jawab_essai','$jawab[nilai_esai]','$jawab[ragu]','$jawab[id_ujian]','$jawab[jawabx]')");
	}
	$exec = mysqli_query($koneksi, "DELETE FROM jawaban WHERE id_ujian='$idu'");
} else {
	exit('Anda tidak dizinkan mengakses langsung script ini!');
}
