<?php

require("../config/config.default.php");
require("../config/config.function.php");
$kode = $_POST['id'];

$exec = mysqli_query($koneksi, "DELETE FROM hasil_jawaban WHERE id_ujian='$kode'");
