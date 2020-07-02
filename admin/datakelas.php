<?php
require("../config/config.default.php");
$id_level = $_POST['level'];
$sql = mysqli_query($koneksi, "SELECT * FROM kelas WHERE level='" . $id_level . "'");
echo "<option value='semua'>Semua Kelas</option>";
while ($data = mysqli_fetch_array($sql)) {
	echo "<option value='$data[id_kelas]'>$data[id_kelas]</option>";
}
