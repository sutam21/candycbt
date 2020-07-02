<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();

$id_mapel = addslashes($_POST['mapel']);
$id_guru = $_SESSION['id_pengawas'];
$tugas = addslashes($_POST['isitugas']);
$judul = addslashes($_POST['judul']);
$tgl_mulai = $_POST['tgl_mulai'];
$tgl_selesai = $_POST['tgl_selesai'];
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
            'id_guru' => $id_guru,
            'judul' => $judul,
            'tugas' => $tugas,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'file' => $file
         );
         insert($koneksi, 'tugas', $data);
         echo "ok";
      } else {
         echo "gagal";
      }
   }
} else {
   $data = array(
      'mapel' => $id_mapel,
      'kelas' => $kelas,
      'id_guru' => $id_guru,
      'judul' => $judul,
      'tugas' => $tugas,
      'tgl_mulai' => $tgl_mulai,
      'tgl_selesai' => $tgl_selesai
   );
   insert($koneksi, 'tugas', $data);
   echo "ok";
}
