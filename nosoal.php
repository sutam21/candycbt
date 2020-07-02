<?php
require "config/config.default.php";
require "config/config.function.php";
require "config/functions.crud.php";
$id_mapel = $_POST['id_mapel'];
$id_siswa = $_POST['id_siswa'];
$id_ujian = $_POST['idu'];
$pengacak = $_POST['pengacak'];
$pengacak = explode(',', $pengacak);
$pengacakpil = $_POST['pengacakpil'];
$pengacakpil = explode(',', $pengacakpil);
$cekpg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='1'"));
$cekesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='2'"));
$quero = mysqli_fetch_array(mysqli_query($koneksi, "SELECT tampil_pg,tampil_esai FROM mapel WHERE id_mapel='$id_mapel'"));

if ($cekpg >= $quero['tampil_pg']) {
    $soalpg = $quero['tampil_pg'];
} else {
    $soalpg = $cekpg;
}
if ($cekesai >= $quero['tampil_esai']) {
    $soalesai = $quero['tampil_esai'];
} else {
    $soalpg = $cekesai;
}
$jumsoal = $soalpg + $soalesai;
?>
<div class='row' id='nomorsoal'>

    <?php for ($n = 0; $n < $jumsoal; $n++) : ?>
        <?php
        $id_soal = $pengacak[$n];
        $cekjwb = rowcount($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $id_soal,  'id_ujian' => $id_ujian));
        $ragu = fetch($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $id_soal,  'id_ujian' => $id_ujian));

        $color1 = ($cekjwb <> 0) ? 'green' : 'gray';
        $color = ($ragu['ragu'] == 1) ? 'yellow' : $color1;
        $nomor = $n + 1;
        $nomor = ($nomor < 10) ? "0" . $nomor : $nomor;

        $jawabannya = $ragu['jawabx'];

        ?>
        <a style="min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium" class='btn btn-app bg-<?= $color ?>' id='badge<?= $id_soal ?>' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $n ?>)"> <?= $nomor ?> <span id='jawabtemp<?= $id_soal ?>' class='badge bg-red' style="font-size:medium"><?= $jawabannya ?></span></a>
    <?php endfor; ?>
</div>