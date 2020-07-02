<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();
$id = $_POST['id'];
$id_mapel = addslashes($_POST['mapel']);
$id_guru = $_SESSION['id_pengawas'];
$materi = addslashes($_POST['isimateri']);
$judul = $_POST['judul'];
$tgl_mulai = $_POST['tgl_mulai'];
$youtube = $_POST['youtube'];
$kelas = serialize($_POST['kelas']);

$ektensi = ['jpg', 'png', 'docx', 'pdf', 'xlsx'];
if ($_FILES['file']['name'] <> '') {
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $ext = explode('.', $file);
    $ext = end($ext);
    if (in_array($ext, $ektensi)) {
        $dest = '../../berkas/';
        $path = $dest . $file;
        $upload = move_uploaded_file($temp, $path);
        if ($upload) {
            $data = array(
                'mapel' => $id_mapel,
                'kelas' => $kelas,
                'judul' => $judul,
                'materi' => $materi,
                'tgl_mulai' => $tgl_mulai,
                'youtube' => $youtube,
                'file' => $file
            );
            update($koneksi, 'materi', $data, ['id_materi' => $id]);
            echo 'ok';
        } else {
            echo "gagal";
        }
    }
} else {
    $data = array(
        'mapel' => $id_mapel,
        'kelas' => $kelas,
        'judul' => $judul,
        'materi' => $materi,
        'tgl_mulai' => $tgl_mulai,
        'youtube' => $youtube

    );
    update($koneksi, 'materi', $data, ['id_materi' => $id]);
    // echo mysqli_error($koneksi);
    echo "ok";
}
