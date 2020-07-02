<?php

require("../../config/config.default.php");
require("../../config/config.function.php");
$kode = $_POST['id'];
cek_session_guru();
$exec = mysqli_query($koneksi, "DELETE FROM tugas WHERE id_tugas='$kode'");
$exec = mysqli_query($koneksi, "DELETE FROM jawaban_tugas WHERE id_tugas='$kode'");
