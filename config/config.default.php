<?php
session_start();
error_reporting(0);
(isset($_SESSION['id_user'])) ? $id_user = $_SESSION['id_user'] : $id_user = 0;
//JIKA DIINSTAL DISUBDOMAIN HOSTING HAPUS BARIS DIBAWAH INI
$uri = $_SERVER['REQUEST_URI'];
$pageurl = explode("/", $uri);
if ($uri == '/') {
	$homeurl = "http://" . $_SERVER['HTTP_HOST'];
	(isset($pageurl[1])) ? $pg = $pageurl[1] : $pg = '';
	(isset($pageurl[2])) ? $ac = $pageurl[2] : $ac = '';
	(isset($pageurl[3])) ? $id = $pageurl[3] : $id = 0;
} else {
	$homeurl = "http://" . $_SERVER['HTTP_HOST'] . "/" . $pageurl[1];
	(isset($pageurl[2])) ? $pg = $pageurl[2] : $pg = '';
	(isset($pageurl[3])) ? $ac = $pageurl[3] : $ac = '';
	(isset($pageurl[4])) ? $id = $pageurl[4] : $id = 0;
}
//HAPUS SAMPAI SINI

//JIKA DIINSTAL DISUBDOMAIN HOSTING HAPUS TANDA // BARIS DIBAWAH INI

$uri = $_SERVER['REQUEST_URI'];
$pageurl = explode("/",$uri);

$homeurl = "http://".$_SERVER['HTTP_HOST'];
(isset($pageurl[1])) ? $pg = $pageurl[1] : $pg = '';
(isset($pageurl[2])) ? $ac = $pageurl[2] : $ac = '';
(isset($pageurl[3])) ? $id = $pageurl[3] : $id = 0;

//HAPUS SAMPAI BARIS DIATAS INI

require "config.database.php";

$no = $jam = $mnt = $dtk = 0;
$info = '';
$waktu = date('H:i:s');
$tanggal = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');

define("KEY", "76310EEFF2B5D3C887F238976A421B638CFEB0942AB8249CD0A29B125C91B3E5");
