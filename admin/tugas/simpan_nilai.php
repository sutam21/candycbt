
<?php

require("../../config/config.default.php");
require("../../config/config.function.php");
cek_session_guru();
$kode = $_POST['id'];
$nilai = $_POST['nilai' . $kode];
$query = mysqli_query($koneksi, "UPDATE jawaban_tugas set nilai='$nilai' where id_jawaban = '$kode'");
echo mysqli_error($koneksi);
echo "nilai berhasil disimpan";
