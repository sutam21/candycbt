<?php
require("config/config.default.php");
require("config/config.function.php");
$token = isset($_GET['token']) ? $_GET['token'] : 'false';
$server = isset($_GET['server']) ? $_GET['server'] : '';
$querys = mysqli_query($koneksi, "select token_api from setting where token_api='$token'");
$cektoken = mysqli_num_rows($querys);

if ($cektoken <> 0) {

    $sql_server = '';
    if (!empty($server)) {
        $sql_server = " where server='$server'";
    }
    $query = mysqli_query($koneksi, "select * from siswa " . $sql_server);
    $array_data = array();
    while ($baris = mysqli_fetch_assoc($query)) {
        $array_data[] = $baris;
    }

    echo json_encode([
        'siswa' => $array_data
    ]);
} else {
    echo "<script>location.href='.'</script>";
}
