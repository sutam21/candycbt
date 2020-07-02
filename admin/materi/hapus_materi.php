<?php

require("../../config/config.default.php");
require("../../config/config.function.php");
$kode = $_POST['id'];
cek_session_guru();
$exec = mysqli_query($koneksi, "DELETE FROM materi WHERE id_materi='$kode'");
$exec = mysqli_query($koneksi, "DELETE FROM jawaban_materi WHERE id_materi='$kode'");
