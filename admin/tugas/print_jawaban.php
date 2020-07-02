<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
//require("../config/dis.php");
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:login.php') : null;
$id_tugas = $_GET['id'];
//$id_kelas = $_GET['k'];
//$pengawas = fetch($koneksi, 'pengawas', array('id_pengawas' => $id_pengawas));
$tugas = fetch($koneksi, 'tugas', array('id_tugas' => $id_tugas));
$guru = fetch($koneksi, 'pengawas', array('id_pengawas' => $tugas['id_guru']));
//$kelas = fetch('kelas',array('id_kelas'=>$id_kelas));
if (date('m') >= 7 and date('m') <= 12) {
	$ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
	$ajaran = (date('Y') - 1) . "/" . date('Y');
}
echo "
		<!DOCTYPE html>
		<html>
			<head>
				<title>LAPORAN</title>
				<style>
					* { margin:auto; padding:0; line-height:100%; }
					body { max-width:793.700787402px; }
					td { padding:1px 3px 1px 3px; }
					.garis { border:1px solid #000; border-left:0px; border-right:0px; padding:1px; margin-top:5px; margin-bottom:5px; }
				</style>
			</head>
			<body>
				<table border='0' width='793.700787402px' align='center' cellspacing='0' cellpadding='0'>
					<tr>
						<td align='left'><img src='$homeurl/$setting[logo]' width='90px'/></td>
						<td align='center' valign='top'>
							<font size=+2><b>$setting[header]</b></font><br/>
							<font size=+3><b>$setting[sekolah]</b></font><br/>
							<small>$setting[alamat] &nbsp; Telp. $setting[telp] Fax. $setting[fax]</small><br/>
							<small><i>Email: $setting[email] &nbsp; Web: $setting[web]</i></small><br/>
						</td>
						<td align='right'></td>
					</tr>
				</table>
				<div class='garis'></div>
				<br/>
				<div align='center'>
					<b>LAPORAN TUGAS TERSTRUKTUR</b><br/>
					<b>MATA PELAJARAN " . strtoupper($tugas['mapel']) . "</b><br/>
					<b>TAHUN AJARAN $ajaran</b><br/>
				</div>
				Guru Pengampu : $guru[nama]
				<table border='1' width='793.700787402px' align='center' cellspacing='0' cellpadding='0'>
					<thead>
						<tr>
							<th width='5px'>No</th>
							<th>NIS</th>
							<th>Nama</th>
							<th>Kelas</th>
							<th>Nilai</th>
							
						</tr>
					</thead>
					<tbody>";
$tugasQ = select($koneksi, 'jawaban_tugas', array('id_tugas' => $id_tugas));
foreach ($tugasQ as $jtugas) {
	$no++;
	$siswa = fetch($koneksi, 'siswa', ['id_siswa' => $jtugas['id_siswa']]);
	echo "
							<tr>
								<td align='center'>$no</td>
								<td align='center' width='100px'>$siswa[nis]</td>
								<td>$siswa[nama]</td>
								<td>$siswa[id_kelas]</td>
								<td width='130px'>$jtugas[nilai]</td>
								
							</tr>
						";
}
echo "
					</tbody>
				</table>
				<br/>
				<table border='0' width='793.700787402px' align='center' cellspacing='0' cellpadding='0'>
					<tr>
					
						<td>
							Mengetahui, <br/>
							Kepala Sekolah <br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<u>$setting[kepsek]</u><br/>
							$setting[nip]
						</td>
						<td width='230px'>
							Bekasi, " . buat_tanggal('d M Y') . "<br/>
							Guru Pengampu<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<u>$guru[nama]</u><br/>
							$guru[nip]
						</td>
					</tr>
				</table>
			</body>
		</html>
	";
