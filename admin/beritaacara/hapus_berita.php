<?php

require("../../config/config.default.php");
require("../../config/config.function.php");
$kode = $_POST['id'];
cek_session_admin();
$exec = mysqli_query($koneksi, "DELETE FROM berita WHERE id_berita='$kode'");
