<?php
require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
require("../config/dis.php");


$id_mapel = $_GET['m'];	//==> kode mapel di bank soal
$id_kelas = $_GET['k'];


// $pengawas = fetch($koneksi, pengawas', array('id_pengawas' => $id_pengawas));

echo "
	<link rel='stylesheet' href='$homeurl/dist/bootstrap/css/bootstrap.min.css'/>
	<link rel='stylesheet' href='$homeurl/dist/css/cetak.min.css'>";

$mapel = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT mapel.*, mata_pelajaran.nama_mapel FROM mapel INNER JOIN mata_pelajaran ON mapel.nama=mata_pelajaran.kode_mapel WHERE id_mapel='$id_mapel'"));
$jenis = mysqli_fetch_array(mysqli_query($koneksi, "select * from jenis where status='aktif'"));
if (date('m') >= 7 and date('m') <= 12) {
	$ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
	$ajaran = (date('Y') - 1) . "/" . date('Y');
}

$querysetting = mysqli_query($koneksi, "SELECT * FROM setting WHERE id_setting='1'");
$setting = mysqli_fetch_assoc($querysetting);


$query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$id_kelas' order by nama");

$jumlahData = mysqli_num_rows($query);
$jumlahn = '28';	//jumlah baris yang ingin ditampilkan
$n = ceil($jumlahData / $jumlahn);	//jumlah halaman
$nomer = 1;
$tglsekarang = buat_tanggal('d M Y');

for ($i = 1; $i <= $n; $i++) {
	$mulai = $i - 1;
	$batas = ($mulai * $jumlahn);	//jumlah baris yang tidak ingin ditampilkan
	$startawal = $batas;
	$batasakhir = $batas + $jumlahn;
	if ($i == $n) {
		echo "
			<div class='page'>
				<table width='100%'>
					<tr>
						<td width='100'><img src='$homeurl/dist/img/tutwuri.jpg' height='75'></td>
						<td>
							<CENTER>
								<strong class='f12'>
									REKAPITULASI NILAI <BR>
									" . strtoupper($jenis['nama']) . "<BR>TAHUN PELAJARAN $ajaran
								</strong>
							</CENTER></td>
							<td width='100'><img src='$homeurl/$setting[logo]' height='75'></td>
					</tr>
				</table>
				<hr/>
				<table class='detail'>
					<tr>
						<td>SEKOLAH/MADRASAH</td><td>:</td><td><span style='width:450px;'>&nbsp;$setting[sekolah]</span></td>
					</tr>
					<tr>
						<td>UJIAN/KELAS</td><td>:</td><td><span style='width:450px;'>&nbsp;$jenis[id_jenis] / $id_kelas</span></td>
					</tr>
					<tr>
						<td>MATA PELAJARAN</td><td>:</td><td colspan='4'><span style='width:450px;'>&nbsp;$mapel[nama_mapel]</span></td>
					</tr>
				</table>
				<table class='it-grid it-cetak' width='100%'>
				<tr height=40px>
					<th width='4%'>No</th>
					
					<th width='17%'>No Peserta</th>
					<th>Nama</th>
					<th width='7%'>NPG</th>
					<th width='7%'>NEssai</th>
					<th width='7%'>Total</th>
					<th width='7%'>Keterangan</th>
				</tr>";


		$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$id_kelas' order by nama limit $batas, $jumlahn");

		while ($siswa = mysqli_fetch_array($ckck)) {
			$no++;
			$lama = $jawaban = $skor = $totalskor = $skoresai = $keterangan = '--';

			$nilaiQ = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_mapel='$id_mapel' AND id_siswa='$siswa[id_siswa]'");
			$nilaiC = mysqli_num_rows($nilaiQ);
			$nilai = mysqli_fetch_array($nilaiQ);

			if ($nilaiC <> 0) {
				if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] <> '') {
					$jawaban = "$nilai[jml_benar] benar / $nilai[jml_salah] salah";
					$skor = number_format($nilai['skor'], 2, '.', '');
					$totalskor = number_format($nilai['total'], 2, '.', '');
					$skoresai = number_format($nilai['nilai_esai'], 2, '.', '');
					if ($nilai['total'] <= $mapel['kkm']) {
						$keterangan = "REMEDIAL";
					} else {
						$keterangan = "LULUS";
					}
				}
			}
			echo "
						<tr>
							<td align='center'>$no</td>
							
							<td align='center'>$siswa[no_peserta]</td>
							<td>$siswa[nama]</td>
							<td align='center'>$skor</td>
							<td align='center'>$skoresai</td>
							<td align='center'>$totalskor</td>
							<td align='center'>$keterangan</td>
						</tr>";
		}
		echo "
				</table>
				<br>
				<table width='100%'>
					<tr>
						<td width='70%'>&nbsp;</td>
						<td width='30%'>$setting[kota], $tglsekarang</td>
					</tr>
					<tr>
						<td width='70%'>&nbsp;</td>
						<td width='30%'>Kepala Sekolah,</td>
					</tr>
					<tr>
						<td width='70%'>&nbsp;</td>
						<td width='30%'><br><br><br><br><strong>$setting[kepsek]</strong></td>
					</tr>
					<tr>
						<td width='70%'>&nbsp;</td>
						<td width='30%'>NIP. $setting[nip]</td>
					</tr>
				</table>
				<div class='footer'>
					<table width='100%' height='30'>
						<tr>
							<td width='25px' style='border:1px solid black'></td>
							<td width='5px'>&nbsp;</td>
							<td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'>$setting[sekolah] - " . strtoupper($jenis['nama']) . "</td>
							<td width='5px'>&nbsp;</td>
							<td width='25px' style='border:1px solid black'></td>
						</tr>
					</table>
				</div>
			</div>";
		break;
	}
	echo "
		<div class='page'>
			<table width='100%'>
				<tr>
					<td width='100'><img src='$homeurl/dist/img/tutwuri.jpg' height='75'></td>
					<td>
						<CENTER>
							<strong class='f12'>
								REKAPITULASI NILAI <BR>
								" . strtoupper($jenis['nama']) . "<BR>TAHUN PELAJARAN $ajaran
							</strong>
						</CENTER></td>
						<td width='100'><img src='$homeurl/$setting[logo]' height='75'></td>
				</tr>
			</table>
			<hr/>
			<table class='detail'>
				<tr>
					<td>SEKOLAH/MADRASAH</td><td>:</td><td><span style='width:450px;'>&nbsp;$setting[sekolah]</span></td>
				</tr>
				<tr>
					<td>UJIAN/KELAS</td><td>:</td><td><span style='width:450px;'>&nbsp;$jenis[id_jenis] / $id_kelas</span></td>
				</tr>
				<tr>
					<td>MATA PELAJARAN</td><td>:</td><td colspan='4'><span style='width:450px;'>&nbsp;$mapel[nama_mapel]</span></td>
				</tr>
			</table>
			<table class='it-grid it-cetak' width='100%'>
			<tr height=40px>
				<th width='4%'>No</th>
				
				<th width='17%'>No Peserta</th>
				<th>Nama</th>
				<th width='7%'>NPG</th>
				<th width='7%'>NEssai</th>
				<th width='7%'>Total</th>
				<th width='7%'>Keterangan</th>
			</tr>";

	$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$id_kelas' order by nama limit $batas, $jumlahn");

	while ($siswa = mysqli_fetch_array($ckck)) {
		$no++;
		$lama = $jawaban = $skor = $totalskor = $skoresai = $keterangan = '--';

		$nilaiQ = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_mapel='$id_mapel' AND id_siswa='$siswa[id_siswa]'");
		$nilaiC = mysqli_num_rows($nilaiQ);
		$nilai = mysqli_fetch_array($nilaiQ);
		if ($nilaiC <> 0) {
			if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] <> '') {
				$jawaban = "$nilai[jml_benar] benar / $nilai[jml_salah] salah";
				$skor = number_format($nilai['skor'], 2, '.', '');
				$totalskor = number_format($nilai['total'], 2, '.', '');
				$skoresai = number_format($nilai['nilai_esai'], 2, '.', '');
				if ($nilai['total'] <= $mapel['kkm']) {
					$keterangan = "REMEDIAL";
				} else {
					$keterangan = "LULUS";
				}
			}
		}
		echo "
					<tr>
						<td align='center'>$no</td>
						
						<td align='center'>$siswa[no_peserta]</td>
						<td>$siswa[nama]</td>
						<td align='center'>$skor</td>
						<td align='center'>$skoresai</td>
						<td align='center'>$totalskor</td>
						<td align='center'>$keterangan</td>
					</tr>";
	}
	echo "
			</table>
			<div class='footer'>
				<table width='100%' height='30'>
					<tr>
						<td width='25px' style='border:1px solid black'></td>
						<td width='5px'>&nbsp;</td>
						<td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'>$setting[sekolah] - " . strtoupper($jenis['nama']) . " </td>
						<td width='5px'>&nbsp;</td>
						<td width='25px' style='border:1px solid black'></td>
					</tr>
				</table>
			</div>
		</div>";
}
