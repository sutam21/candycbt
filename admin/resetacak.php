<?php

require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
$idpengacak = $_POST['id'];
$ac = $_POST['idu'];
echo $ac . "=" . $idpengacak;
$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$ac'"));
$idmapel = $query['id_mapel'];
$mapel = fetch($koneksi, 'ujian', array('id_mapel' => $idmapel, 'id_ujian' => $ac));
$order = array(
    "nomor ASC",
    "nomor DESC",
    "soal ASC",
    "soal DESC",
    "pilA ASC",
    "pilA DESC",
    "pilB ASC",
    "pilB DESC",
    "pilC ASC",
    "pilC DESC",
    "pilD ASC",
    "pilD DESC",
    "pilE ASC",
    "pilE DESC",
    "jawaban ASC",
    "jawaban DESC",
    "file ASC",
    "file DESC"
);
$ordera = array(
    "nomor ASC",
    "nomor DESC",
    "soal ASC",
    "soal DESC",
    "file ASC",
    "file DESC"
);
$where = array(
    'id_mapel' => $idmapel,
    'jenis' => '1',
);
$where2 = array(
    'id_mapel' => $idmapel,
    'jenis' => '2',
);
$r = ($mapel['acak'] == 1) ? mt_rand(0, 17) : 0;
$m = ($mapel['acak'] == 1) ? mt_rand(0, 17) : 0;
$soal = select($koneksi, 'soal', $where, $order[$r]);
$id_soal = '';
$id_esai = '';
$id_opsi = "";
foreach ($soal as $s) :
    if ($mapel['opsi'] == 5) :
        $acz = array("A", "B", "C", "D", "E");
    elseif ($mapel['opsi'] == 4) :
        $acz = array("A", "B", "C", "D");
    elseif ($mapel['opsi'] == 3) :
        $acz = array("A", "B", "C");
    endif;
    shuffle($acz);
    $ack1 = $acz[0];
    $ack2 = $acz[1];
    $ack3 = $acz[2];
    if ($mapel['opsi'] == 3) :
        $id_soal .= $s['id_soal'] . ',';
        $id_opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',';
    elseif ($mapel['opsi'] == 4) :
        $ack4 = $acz[3];
        $id_soal .= $s['id_soal'] . ',';
        $id_opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',' . $ack4 . ',';
    elseif ($mapel['opsi'] == 5) :
        $ack4 = $acz[3];
        $ack5 = $acz[4];
        $id_soal .= $s['id_soal'] . ',';
        $id_opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',' . $ack4 . ',' . $ack5 . ',';
    endif;
endforeach;
if ($mapel['jml_esai'] <> 0) {
    $soalesai = select($koneksi, 'soal', $where2, $ordera[$m]);
    foreach ($soalesai as $m) :
        $id_esai .= $m['id_soal'] . ',';
    endforeach;
}
$query = mysqli_query($koneksi, "UPDATE pengacak set id_soal='$id_soal',id_opsi='$id_opsi' where id_pengacak='$idpengacak'");
if ($query) {
    echo '1';
} else { }
echo mysqli_error($koneksi);
