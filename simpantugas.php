<?php
require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");

if(!isset($_SESSION['id_siswa'])){
    header('location:logout.php');
}else{
$id_tugas = $_POST['id_tugas'];
$id_siswa = $_SESSION['id_siswa'];
$jawaban = addslashes($_POST['jawaban']);

$datetime = date('Y-m-d H:i:s');
$ektensi = ['jpg', 'png', 'docx', 'pdf', 'xlsx'];
if ($_FILES['file']['name'] <> '') {
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $ext = explode('.', $file);
    $ext = end($ext);
    if (in_array($ext, $ektensi)) {
        $dest = 'tugas/';
        $file = $id_tugas . '_' . $id_siswa . '.' . $ext;
        $path = $dest . $file;
        $upload = move_uploaded_file($temp, $path);
        if ($upload) {
            $data = array(
                'id_tugas' => $id_tugas,
                'id_siswa' => $id_siswa,
                'jawaban' => $jawaban,
                'file' => $file
            );
            $where = array(
                'id_siswa' => $id_siswa,
                'id_tugas' => $id_tugas
            );
            $cek = rowcount($koneksi, 'jawaban_tugas', $where);
            if ($cek == 0) {
                insert($koneksi, 'jawaban_tugas', $data);
            } else {
                update($koneksi, 'jawaban_tugas', $data, $where);
            }
            echo "ok";
        } else {
            echo "gagal";
        }
    }
} else {
    $data = array(
        'id_tugas' => $id_tugas,
        'id_siswa' => $id_siswa,
        'jawaban' => $jawaban

    );
    $where = array(
        'id_siswa' => $id_siswa,
        'id_tugas' => $id_tugas
    );
    $cek = rowcount($koneksi, 'jawaban_tugas', $where);
    if ($cek == 0) {
        insert($koneksi, 'jawaban_tugas', $data);
    } else {
        update($koneksi, 'jawaban_tugas', $data, $where);
    }
    echo "ok";
}
}
