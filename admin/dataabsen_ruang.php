<?php
require("../config/config.default.php");
//$id_kelas = $_POST['id_kelas'];
$sql = mysqli_query($koneksi, "SELECT * FROM siswa  GROUP BY ruang");
echo "<option value=''>Pilih Ruang</option>";
while ($ruang = mysqli_fetch_array($sql)) {
	echo "<option value='$ruang[ruang]'>$ruang[ruang]</option>";
}
