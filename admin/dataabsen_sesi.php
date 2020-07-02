<?php
require("../config/config.default.php");
//$id_kelas = $_POST['id_kelas'];
$ruang = $_POST['ruang'];
$sql = mysqli_query($koneksi, "SELECT * FROM siswa WHERE ruang ='$ruang' GROUP BY sesi");
echo "<option value=''>Pilih Sesi</option>";
while ($sesi = mysqli_fetch_array($sql)) {
	echo "<option value='$sesi[sesi]'>$sesi[sesi]</option>";
}
