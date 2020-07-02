<?php session_start();
 
header("Content-type: image/png");
 
// menentukan session
$_SESSION["Captcha"]="";
 
// membuat gambar dengan menentukan ukuran
$gbr = imagecreate(220, 50);
 
//warna background captcha
imagecolorallocate($gbr, 69, 179, 157);
 
// pengaturan font captcha
$color = imagecolorallocate($gbr, 253, 252, 252);
$font = "LobsterTwo-Bold.otf"; 
$ukuran_font = 20;
$posisi = 35;
// membuat nomor acak dan ditampilkan pada gambar
for($i=0;$i<=5;$i++) {
	// jumlah karakter
	$angka=rand(0, 9);
 
	$_SESSION["Captcha"].=$angka;
 
	$kemiringan= rand(30, 50);
 	
	imagettftext($gbr, $ukuran_font, $kemiringan, 20+30*$i, $posisi, $color, $font, $angka);	
}
//untuk membuat gambar 
imagepng($gbr); 
imagedestroy($gbr);
?>