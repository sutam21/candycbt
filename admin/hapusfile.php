<?php

require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
$kode = $_POST['kode'];

$exec = mysqli_query($koneksi, "DELETE FROM file_pendukung WHERE id_file in (" . $kode . ")");
foreach ($kode as $kode) {

    $file = fetch($koneksi, 'file_pendukung', ['id_file' => $kode]);
    $files = "../file/" . $file['nama_file'];
    if (file_exists($files)) {
        unlink($files);
    }
}

if ($exec) {
    echo 1;
} else {
    echo 0;
}
