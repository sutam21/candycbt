<?php
	require("../config/config.default.php");
	require("../config/config.function.php");
	require("../config/functions.crud.php");
	
	(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas == 0) ? header('location:index.php') : null;
?>
<link rel='stylesheet' href='../dist/css/bootstrap.min.css' />
<style type="text/css">
	@font-face {
		font-family: 'tulisan_keren';
		src: url('../dist/fonts/poppins/Poppins-Light.ttf');
	}

	body {
		font-family: 'tulisan_keren';
		line-height: 1.42857143;
		color: #000;
		width: 100%;
		height: 100%;
		margin: 0;
		padding: 0;
		background-color: #FAFAFA;
		font-size: 13px;
	}

	.footer {
		position: absolute;
		bottom: 1.5cm;
		left: 1.5cm;
		right: 1.5cm;
		width: auto;
		height: 30px
	}

	* {
		box-sizing: border-box;
		-moz-box-sizing: border-box;
	}

	@page {
		size: A4;
		margin: 10mm;
	}

	@media print {

		html,
		body {
			width: 210mm;
			height: 297mm;
		}

		.page {
			margin: 10mm;
			border: initial;
			border-radius: initial;
			width: initial;
			min-height: initial;
			box-shadow: initial;
			background: initial;
			page-break-after: always;
		}

		.footer {
			bottom: .7cm;
			left: .7cm;
			right: .7cm
		}
	}
</style>

<?php
if(!isset($_GET['id'])){
	exit('Anda tidak dizinkan mengakses langsung script ini!');
}
$idujian = @$_GET['id'];
$sqlx = mysqli_query($koneksi, "SELECT * FROM berita a LEFT JOIN mapel b ON a.id_mapel=b.id_mapel LEFT JOIN mata_pelajaran c ON b.nama=c.kode_mapel WHERE a.id_berita='$idujian'");
$ujian = mysqli_fetch_array($sqlx);
$kodeujian = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jenis WHERE id_jenis='$ujian[jenis]'"));
$hari = buat_tanggal('D', $ujian['tgl_ujian']);
$tanggal = buat_tanggal('d', $ujian['tgl_ujian']);
// $bulan = buat_tanggal('F', $ujian['tgl_ujian']);
$bulan = bulan_indo($ujian['tgl_ujian']);

$tahun = buat_tanggal('Y', $ujian['tgl_ujian']);
if (date('m') >= 7 and date('m') <= 12) {
	$ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
	$ajaran = (date('Y') - 1) . "/" . date('Y');
}
?>
<div style='background:#fff; width:97%; margin:0 auto; height:90%;'>
	<table border='0' width='100%'>
		<tr>
			<!-- <td rowspan='4' width='120' align='center'> -->
			<td rowspan='4' style="width:'120'; text-align:center">
				<img src='../foto/tut.jpg' width='80'>
			</td>
			<!-- <td colspan='2' align='center'> -->
			<td colspan='2' style="text-align:center">
				<span style="font-size:110%">
					<b>BERITA ACARA PELAKSANAAN</b>
				</span>
			</td>
			<!-- <td rowspan='7' width='120' align='center'> -->
			<td rowspan='7' style="width:'120'; text-align:center">
				<img src="../<?= $setting['logo'] ?>" width='65'>
			</td>
		</tr>
		<tr>
			<!-- <td colspan='2' align='center'> -->
			<td colspan='2' style="text-align:center">
				<span style="font-size:110%">
					<b><?= strtoupper($kodeujian['nama']) ?></b>
				</span>
			</td>
		</tr>
		<tr>
			<!-- <td colspan='2' align='center'> -->
			<td colspan='2' style="text-align:center">
				<span style="font-size:110%">
					<b>TAHUN PELAJARAN <?= $ajaran ?></b>
				</span>
			</td>
		</tr>
	</table>
	<br>
	<table style="width:95%">
		<tr height='30'>
			<td colspan='4' style="height:'30'; text-align: justify;">
				Pada hari ini <b> <?= $hari ?> </b> tanggal <b><?= $tanggal ?></b> bulan <b><?= $bulan ?></b> tahun <b><?= $tahun ?></b>, di <?= $setting['sekolah'] ?> telah diselenggarakan "<?= ucwords(strtolower($kodeujian['nama'])) ?>" untuk Mata Pelajaran <b><?= $ujian['nama_mapel'] ?></b> dari pukul <?= $ujian['mulai'] ?> sampai dengan pukul <?= $ujian['selesai'] ?>
			</td>
		</tr>
		<tr height='30'>
			<td height='30' width='5%'>1.</td>
			<td height='30' width='30%'>Kode Sekolah</td>
			<td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $setting['kode_sekolah'] ?></td>
		</tr>
		<tr height='30'>
			<td height='30' width='10px'></td>
			<td height='30'>Sekolah/Madrasah</td>
			<td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $setting['sekolah'] ?></td>
		</tr>
		<tr height='30'>
			<td height='30' width='5%'>.</td>
			<td height='30' width='30%'>Sesi</td>
			<td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ujian['sesi'] ?></td>
		</tr>
		<tr height='30'>
			<td height='30' width='5%'>.</td>
			<td height='30' width='30%'>Ruang</td>
			<td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ujian['ruang'] ?></td>
		</tr>
		<tr height='30'>
			<td height='30' width='10px'></td>
			<td height='30'>Jumlah Peserta Seharusnya</td>
			<td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ujian['ikut'] + $ujian['susulan'] ?></td>
		</tr>
		<tr height='30'>
			<td height='30' width='5%'></td>
			<td height='30' width='30%'>Jumlah Hadir (Ikut Ujian)</td>
			<td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ujian['ikut'] ?></td>
		</tr>
		<tr height='30'>
			<td height='30' width='10px'></td>
			<td height='30'>Jumlah Tidak Hadir</td>
			<td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ujian['susulan'] ?></td>
		</tr>
		<tr height='30'>
			<td height='30' width='10px'></td>
			<td height='30'>Nomer Peserta</td>
			<td height='30' width='60%' style='border-bottom:thin solid #000000'>
				<?php
					$dataArray = unserialize($ujian['no_susulan']);
					if ($dataArray) {
						foreach ($dataArray as $key => $value) {
							echo "<small class='label label-success'>$value </small>&nbsp;";
						}
					}
				?>
			</td>
		</tr>
		<tr height='30'>
			<td height='30' width='10px'></td>
		</tr>
		<tr height='30'>
			<td height='30' width='5%'>2.</td>
			<td colspan='2' height='30' width='30%'>
				Catatan selama pelaksanaan ujian "<?= ucwords(strtolower($kodeujian['nama'])) ?>"
			</td>
		</tr>
		<tr height='120px'>
			<td height='30' width='5%'></td>
			<td colspan='2' style='border:solid 1px black'><?= $ujian['catatan'] ?></td>
		</tr>

		<tr height='30'>
			<td height='30' colspan='2' width='5%'>Yang membuat berita acara: </td>
		</tr>
	</table>
	<table style="width:95%; margin-left:10px">
		<tr>
			<td colspan='4'></td>
			<td height='30' width='30%'>TTD</td>
		<tr>
			<td width='10%'>1. </td>
			<td width='20%'>Proktor</td>
			<td width='30%' style='border-bottom:thin solid #000000'><?= $ujian['nama_proktor'] ?></td>
			<td height='30' width='5%'></td>
			<td height='30' width='35%'></td>
		</tr>
		<tr>
			<td width='10%'> </td>
			<td width='20%'>NIP. </td>
			<td width='30%' style='border-bottom:thin solid #000000'><?= $ujian['nip_proktor'] ?></td>
			<td height='30' width='5%'></td>
			<td height='30' width='35%' style='border-bottom:thin solid #000000'> 1. </td>
		</tr>
		<tr>
			<td colspan='4'></td>

		<tr>
			<td width='10%'>2. </td>
			<td width='20%'>Pengawas</td>
			<td width='30%' style='border-bottom:thin solid #000000'><?= $ujian['nama_pengawas'] ?></td>
			<td height='30' width='5%'></td>
			<td height='30' width='35%'></td>
		</tr>
		<tr>
			<td width='10%'> </td>
			<td width='20%'>NIP. </td>
			<td width='30%' style='border-bottom:thin solid #000000'><?= $ujian['nip_pengawas'] ?></td>
			<td height='30' width='5%'></td>
			<td height='30' width='35%' style='border-bottom:thin solid #000000'> 2. </td>
		</tr>
		<tr>
			<td colspan='4'></td>

		<tr>
			<td width='10%'>3. </td>
			<td width='20%'>Kepala Sekolah</td>
			<td width='30%' style='border-bottom:thin solid #000000'><?= $setting['kepsek'] ?></td>
			<td height='30' width='5%'></td>
			<td height='30' width='35%'></td>
		</tr>
		<tr>
			<td width='10%'> </td>
			<td width='20%'>NIP. </td>
			<td width='30%' style='border-bottom:thin solid #000000'><?= $setting['nip'] ?></td>
			<td height='30' width='5%'></td>
			<td height='30' width='35%' style='border-bottom:thin solid #000000'> 3. </td>
		</tr>
	</table><br><br><br><br><br>
	<div class="footer">
		<table width="100%" height="30">
			<tr>
				<td width="25px" style="border:1px solid black"></td>
				<td width="5px">&nbsp;</td>
				<td style="border:1px solid black;font-weight:bold;font-size:14px;text-align:center;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</td>
				<td width="5px">&nbsp;</td>
				<td width="25px" style="border:1px solid black"></td>
			</tr>
		</table>
	</div>
</div>