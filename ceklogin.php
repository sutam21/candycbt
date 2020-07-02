<?php
require("config/config.default.php");

$username = mysqli_escape_string($koneksi, $_POST['username']);
$password = mysqli_escape_string($koneksi, $_POST['password']);
$siswaQ = mysqli_query($koneksi, "SELECT * FROM siswa WHERE username='$username'");
if ($username <> "" and $password <> "") {
	if (mysqli_num_rows($siswaQ) == 0) {
		echo "td";
	} else {
		$siswa = mysqli_fetch_array($siswaQ);
		//$ceklogin=mysqli_num_rows(mysqli_query($koneksi, "select * from login where id_siswa='$siswa[id_siswa]'"));

		if ($password <> $siswa['password']) {
			echo "nopass";
		} else {
			//if($ceklogin==0){
			$_SESSION['id_siswa'] = $siswa['id_siswa'];
			mysqli_query($koneksi, "INSERT INTO log (id_siswa,type,text,date) VALUES ('$siswa[id_siswa]','login','masuk','$tanggal $waktu')");
			mysqli_query($koneksi, "UPDATE siswa set online='1' where id_siswa='$siswa[id_siswa]'");
			echo "ok";
			//}else{
			//	echo "nologin";
			//}
		}
	}
}
