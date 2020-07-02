<?php
require "../config/config.database.php";
$exec = mysqli_query($koneksi, "truncate siswa");
$exec = mysqli_query($koneksi, "truncate mapel");
$exec = mysqli_query($koneksi, "truncate soal");
$exec = mysqli_query($koneksi, "truncate ujian");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='DATA1'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', jumlah='', status_sinkron='0',tanggal='' where nama_data='DATA2'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='DATA3'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='DATA4'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='DATA5'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='DATA6'");
$files = glob('../files/*'); //get all file names
foreach ($files as $file) {
    if (is_file($file))
        unlink($file); //delete file
}
echo "
												Reset berhasil ...";
