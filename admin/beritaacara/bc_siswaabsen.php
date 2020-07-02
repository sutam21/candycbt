<?php
require("../../config/config.default.php");
//$id_kelas = $_POST['id_kelas'];
$sesi = $_POST['sesi'];
$ruang = $_POST['ruang'];
$sql = mysqli_query($koneksi, "SELECT * FROM siswa WHERE ruang ='$ruang' and sesi='$sesi'");
echo "<option value=''>Pilih Siswa</option>";
while ($siswa = mysqli_fetch_array($sql)) {
    echo "<option value='$siswa[no_peserta]'>$siswa[no_peserta] - $siswa[nama]</option>";
}
