<?php
require("config/config.default.php");
require("config/config.function.php");
//Make sure that it is a POST request.
$token = isset($_GET['token']) ? $_GET['token'] : 'false';
$querys = mysqli_query($koneksi, "select token_api from setting where token_api='$token'");
$cektoken = mysqli_num_rows($querys);

if ($cektoken <> 0) {
    if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0) {
        throw new Exception('Request method must be POST!');
    }

    //Make sure that the content type of the POST request has been set to application/json
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if (strcasecmp($contentType, 'application/json') != 0) {
        throw new Exception('Content type must be: application/json');
    }

    //Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));

    //Attempt to decode the incoming RAW post data from JSON.
    $decoded = json_decode($content, true);

    //If json_decode failed, the JSON is invalid.
    if (!is_array($decoded)) {
        throw new Exception('Received content contained invalid JSON!');
    }

    foreach ($decoded as $nilai) {
        $cek = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_siswa='$nilai[id_siswa]' and id_ujian='$nilai[id_ujian]' and id_mapel='$nilai[id_mapel]' "));
        if ($cek == 0) {
            mysqli_query($koneksi, "insert into nilai (id_ujian,id_mapel,id_siswa,kode_ujian,ujian_mulai,ujian_berlangsung,ujian_selesai,jml_benar,jml_salah,skor,total,ipaddress,hasil,jawaban,jawaban_esai)
        values ('$nilai[id_ujian]','$nilai[id_mapel]','$nilai[id_siswa]','$nilai[kode_ujian]','$nilai[ujian_mulai]','$nilai[ujian_berlangsung]','$nilai[ujian_selesai]','$nilai[jml_benar]','$nilai[jml_salah]','$nilai[skor]','$nilai[total]','$nilai[ipaddress]','$nilai[hasil]','$nilai[jawaban]','$nilai[jawaban_esai]')");
        }
    }

    echo "berhasil";
} else {
    echo "<script>location.href='.'</script>";
}
