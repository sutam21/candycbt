<?php
require '../config/config.default.php';
require '../config/config.function.php';
$datax = http_request($setting['url_host'] . "/syncsiswa.php?token=" . $setting['token_api'] .  "&server=" . $setting['id_server']);
$r = json_decode($datax, TRUE);
if ($r <> null) {
    echo "<h3 class='text-green'>Terhubung</h3>Kode Server $setting[id_server]";
} else {
    echo "<h3 class='text-red'>Tidak Ada Koneksi</h3>Periksa kembali settingan anda";
}
