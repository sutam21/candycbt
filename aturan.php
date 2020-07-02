<?php

//defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
$idu = dekripsi($ac);

$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$idu'"));
$idmapel = $query['id_mapel'];

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
    'id_mapel' => $idmapel

);
$wherepg = array(
    'id_mapel' => $idmapel,
    'jenis' => '1'

);
$where2 = array(
    'id_mapel' => $idmapel,
    'jenis' => '2',
);

$mapel = fetch($koneksi, 'ujian', array('id_mapel' => $idmapel, 'id_ujian' => $idu));
$r = ($mapel['acak'] == 1) ? mt_rand(0, 17) : 0;
$m = ($mapel['acak'] == 1) ? mt_rand(0, 17) : 0;
$soal = select($koneksi, 'soal', $wherepg, $order[$r], $mapel['tampil_pg']);

$id_soal = '';
$id_esai = '';
$id_opsi = "";
$id_acak = [];
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
$soalsoal = select($koneksi, 'soal', $where, $order[$r]);
foreach ($soalsoal as $soalnya) :
    $id_acak[] = $soalnya;
endforeach;
$acak = json_encode($id_acak);
$acak = enkripsi($acak);

if ($mapel['jml_esai'] <> 0) {
    $soalesai = select($koneksi, 'soal', $where2, $ordera[$m], $mapel['tampil_esai']);
    foreach ($soalesai as $m) :
        $id_esai .= $m['id_soal'] . ',';

    endforeach;
}

$logdata = array(
    'id_siswa' => dekripsi($id_siswa),
    'type' => 'testongoing',
    'text' => 'sedang ujian',
    'date' => $datetime
);
if ($mapel['reset'] == 1) {
    $reset = 1;
} else {
    $reset = 0;
}
if ($mapel['ulang'] == 1) {
    $nilaidata = array(
        'id_mapel' => $idmapel,
        'id_ujian' => $idu,
        'id_siswa' => dekripsi($id_siswa),
        'kode_ujian' => $mapel['kode_ujian'],
        'ujian_mulai' => $datetime,
        'ujian_berlangsung' => $datetime,
        'ipaddress' => $_SERVER['REMOTE_ADDR'],
        'hasil' => $query['hasil'],
        'online' => $reset,
        'id_soal' => $id_soal . $id_esai,
        'id_opsi' => $id_opsi


    );
} else {
    $nilaidata = array(
        'id_mapel' => $idmapel,
        'id_ujian' => $idu,
        'id_siswa' => dekripsi($id_siswa),
        'kode_ujian' => $mapel['kode_ujian'],
        'ujian_mulai' => $datetime,
        'ujian_berlangsung' => $datetime,
        'ipaddress' => $_SERVER['REMOTE_ADDR'],
        'hasil' => $query['hasil'],
        'online' => $reset,
        'id_soal' => $id_soal . $id_esai


    );
}

$ref = "";

$ujian = select($koneksi, 'ujian', array('id_mapel' => $idmapel, 'id_ujian' => $idu));
$ujianarray = [];
foreach ($ujian as $ujianya) :
    $ujianarray[] = $ujianya;
endforeach;
$ujianarray = json_encode($ujianarray);
$ujianarray = enkripsi($ujianarray);
$insertnilai = insert($koneksi, 'nilai', $nilaidata);
if ($insertnilai) {
    insert($koneksi, 'log', $logdata);
} ?>
<script>
    var acak = '<?= $acak ?>';
    var acakpg = '<?= $id_soal . $id_esai ?>';
    var ujian = '<?= $ujianarray ?>';
    localStorage.setItem("ujianya", JSON.stringify(ujian));
    localStorage.setItem("soallokal", JSON.stringify(acak));
    localStorage.setItem("pengacakpg", JSON.stringify(acakpg));
</script>
<?php if ($mapel['ulang'] == 1) { ?>
    <script>
        var acakopsi = '<?= $id_opsi ?>';
        localStorage.setItem("pengacakpil", JSON.stringify(acakopsi));
    </script>
<?php } ?>