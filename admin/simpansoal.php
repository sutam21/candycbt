<?php
require("../config/config.default.php");
require("../config/config.function.php");
cek_session_guru();
if (isset($_POST['mapel'])) {
	$nomor = $_POST['nomor'];
	$jenis = $_POST['jenis'];
	$id_mapel = $_POST['mapel'];
	$mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id_mapel'"));
	if ($jenis == '1') {
		$jumsoal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND  nomor='$nomor' AND jenis='1'"));
		$soalQ = mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND  nomor='$nomor' AND jenis='1'");
	}
	if ($jenis == '2') {
		$jumsoal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND  nomor='$nomor' AND jenis='2'"));
		$soalQ = mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND  nomor='$nomor' AND jenis='2'");
	}
	$soal = mysqli_fetch_array($soalQ);
	$isi_soal = addslashes($_POST['isi_soal']);
	$ektensi = ['jpg', 'png', 'mp3', 'jpeg'];
	if ($jenis == '1') {
		$pilA = addslashes($_POST['pilA']);
		$pilB = addslashes($_POST['pilB']);
		$pilC = addslashes($_POST['pilC']);
		$pilD = addslashes($_POST['pilD']);

		$pilE = addslashes($_POST['pilE']);

		if (isset($_FILES['file']['name']) && $_FILES['file']['name'] <> '') {
			$file = $_FILES['file']['name'];
			$temp = $_FILES['file']['tmp_name'];
			$size = $_FILES['file']['size'];
			$ext = explode('.', $file);
			$ext = end($ext);
			if (in_array($ext, $ektensi)) {
				$url = 'files/' . $id_mapel . '_' . $nomor . '_1.' . $ext;
				$urlx = $id_mapel . '_' . $nomor . '_1.' . $ext;
				$upload = move_uploaded_file($temp, '../' . $url);
				$que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$urlx','$id_mapel')");
				(!$upload) ? $url = $soal['file'] : null;
			}
		} else {
			$urlx = $soal['file'];
		}
		if (isset($_FILES['file1']['name']) && $_FILES['file1']['name'] <> '') {
			$file1 = $_FILES['file1']['name'];
			$temp = $_FILES['file1']['tmp_name'];
			$size = $_FILES['file1']['size'];
			$ext = explode('.', $file1);
			$ext = end($ext);
			if (in_array($ext, $ektensi)) {
				$file1 = 'files/' . $id_mapel . '_' . $nomor . '_2.' . $ext;
				$filex1 = $id_mapel . '_' . $nomor . '_2.' . $ext;
				$upload = move_uploaded_file($temp, '../' . $file1);
				$que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filex1','$id_mapel')");
				(!$upload) ? $file1 = $soal['file1'] : null;
			}
		} else {
			$filex1 = $soal['file1'];
		}
		if (isset($_FILES['fileA']['name']) && $_FILES['fileA']['name'] <> '') {
			$fileA = $_FILES['fileA']['name'];
			$temp = $_FILES['fileA']['tmp_name'];
			$size = $_FILES['fileA']['size'];
			$ext = explode('.', $fileA);
			$ext = end($ext);
			if (in_array($ext, $ektensi)) {
				$fileA = 'files/' . $id_mapel . '_' . $nomor . '_A.' . $ext;
				$filexA = $id_mapel . '_' . $nomor . '_A.' . $ext;
				$upload = move_uploaded_file($temp, '../' . $fileA);
				$que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexA','$id_mapel')");
				(!$upload) ? $fileA = $soal['fileA'] : null;
			}
		} else {
			$filexA = $soal['fileA'];
		}
		if (isset($_FILES['fileB']['name']) && $_FILES['fileB']['name'] <> '') {
			$fileB = $_FILES['fileB']['name'];
			$temp = $_FILES['fileB']['tmp_name'];
			$size = $_FILES['fileB']['size'];
			$ext = explode('.', $fileB);
			$ext = end($ext);
			if (in_array($ext, $ektensi)) {
				$fileB = 'files/' . $id_mapel . '_' . $nomor . '_B.' . $ext;
				$filexB = $id_mapel . '_' . $nomor . '_B.' . $ext;
				$upload = move_uploaded_file($temp, '../' . $fileB);
				$que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexB','$id_mapel')");
				(!$upload) ? $fileB = $soal['fileB'] : null;
			}
		} else {
			$filexB = $soal['fileB'];
		}
		if (isset($_FILES['fileC']['name']) && $_FILES['fileC']['name'] <> '') {
			$fileC = $_FILES['fileC']['name'];
			$temp = $_FILES['fileC']['tmp_name'];
			$size = $_FILES['fileC']['size'];
			$ext = explode('.', $fileC);
			$ext = end($ext);
			if (in_array($ext, $ektensi)) {
				$fileC = 'files/' . $id_mapel . '_' . $nomor . '_C.' . $ext;
				$filexC = $id_mapel . '_' . $nomor . '_C.' . $ext;
				$upload = move_uploaded_file($temp, '../' . $fileC);
				$que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexC','$id_mapel')");
				(!$upload) ? $fileC = $soal['fileC'] : null;
			}
		} else {
			$filexC = $soal['fileC'];
		}
		if (isset($_FILES['fileD']['name']) && $_FILES['fileD']['name'] <> '') {
			$fileD = $_FILES['fileD']['name'];
			$temp = $_FILES['fileD']['tmp_name'];
			$size = $_FILES['fileD']['size'];
			$ext = explode('.', $fileD);
			$ext = end($ext);
			if (in_array($ext, $ektensi)) {
				$fileD = 'files/' . $id_mapel . '_' . $nomor . '_D.' . $ext;
				$filexD = $id_mapel . '_' . $nomor . '_D.' . $ext;
				$upload = move_uploaded_file($temp, '../' . $fileD);
				$que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexD','$id_mapel')");
				(!$upload) ? $fileD = $soal['fileD'] : null;
			}
		} else {
			$filexD = $soal['fileD'];
		}

		if (isset($_FILES['fileE']['name']) && $_FILES['fileE']['name'] <> '') {
			$fileE = $_FILES['fileE']['name'];
			$temp = $_FILES['fileE']['tmp_name'];
			$size = $_FILES['fileE']['size'];
			$ext = explode('.', $fileE);
			$ext = end($ext);
			if (in_array($ext, $ektensi)) {
				$fileE = 'files/' . $id_mapel . '_' . $nomor . '_E.' . $ext;
				$filexE = $id_mapel . '_' . $nomor . '_E.' . $ext;
				$upload = move_uploaded_file($temp, '../' . $fileE);
				$que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filexE','$id_mapel')");
				(!$upload) ? $fileE = $soal['fileE'] : null;
			}
		} else {
			$filexE = $soal['fileE'];
		}

		$jawaban = $_POST['jawaban'];
		if ($jumsoal == 0) {
			$exec = mysqli_query($koneksi, "INSERT INTO soal (id_mapel,nomor,soal,jenis,pilA,pilB,pilC,pilD,pilE,jawaban,file,file1,fileA,fileB,fileC,fileD,fileE) VALUES ('$id_mapel','$nomor','$isi_soal','1','$pilA','$pilB','$pilC','$pilD','$pilE','$jawaban','$urlx','$filex1','$filexA','$filexB','$filexC','$filexD','$filexE')");
		} else {
			$exec = mysqli_query($koneksi, "UPDATE soal SET soal='$isi_soal',pilA='$pilA',pilB='$pilB',pilC='$pilC',pilD='$pilD',pilE='$pilE',jawaban='$jawaban',file='$urlx',file1='$filex1',fileA='$filexA',fileB='$filexB',fileC='$filexC',fileD='$filexD',fileE='$filexE' WHERE id_mapel='$id_mapel' AND nomor='$nomor' AND jenis='1'");
		}
	}
	if ($jenis == '2') {
		if (isset($_FILES['file']['name']) && $_FILES['file']['name'] <> '') {
			$file = $_FILES['file']['name'];
			$temp = $_FILES['file']['tmp_name'];
			$size = $_FILES['file']['size'];
			$ext = explode('.', $file);
			$ext = end($ext);
			$url = 'files/' . $id_mapel . '_' . $nomor . '_E1.' . $ext;
			$urlx = $id_mapel . '_' . $nomor . '_E1.' . $ext;
			$upload = move_uploaded_file($temp, '../' . $url);
			$que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$urlx','$id_mapel')");
			(!$upload) ? $url = $soal['file'] : null;
		} else {
			$urlx = $soal['file'];
		}
		if (isset($_FILES['file1']['name']) && $_FILES['file1']['name'] <> '') {
			$file1 = $_FILES['file1']['name'];
			$temp = $_FILES['file1']['tmp_name'];
			$size = $_FILES['file1']['size'];
			$ext = explode('.', $file1);
			$ext = end($ext);
			$file1 = 'files/' . $id_mapel . '_' . $nomor . '_E2.' . $ext;
			$filex1 = $id_mapel . '_' . $nomor . '_E2.' . $ext;
			$upload = move_uploaded_file($temp, '../' . $file1);
			$que = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel)values('$filex1','$id_mapel')");
			(!$upload) ? $file1 = $soal['file1'] : null;
		} else {
			$filex1 = $soal['file1'];
		}
		if ($jumsoal == 0) {
			$exec = mysqli_query($koneksi, "INSERT INTO soal (id_mapel,nomor,soal,jenis,file,file1) VALUES ('$id_mapel','$nomor','$isi_soal','2','$urlx','$filex1')");
		} else {
			$exec = mysqli_query($koneksi, "UPDATE soal SET soal='$isi_soal',file='$urlx',file1='$filex1' WHERE id_mapel='$id_mapel' AND nomor='$nomor' AND jenis='2'");
		}
	}
	(!$exec) ? $info = info('Gagal menyimpan soal!', 'NO') : $info = info('Berhasil menyimpan soal!', 'OK');
}
