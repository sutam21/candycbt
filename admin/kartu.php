<style type="text/css">
	.ttd{
		position: absolute;
		z-index: -1;
	}
</style>
<?php
require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
require("../config/dis.php");
include "phpqrcode/qrlib.php";
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:index.php') : null;
$id_kelas = @$_GET['id_kelas'];


if (date('m') >= 7 and date('m') <= 12) {
	$ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
	$ajaran = (date('Y') - 1) . "/" . date('Y');
}
$kelas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$id_kelas'"));
?>
<style>
	* {
		font-size: x-small;
	}

	.box {
		border: 1px solid #000;
		width: 100%;
		height: 150px;
	}
	.ukuran{
		font-size: 15px;
	}
	.ukuran2{
		font-size: 12px;
	}
	.user{
		font-size: 15px;
	}
</style>

<table width='100%' align='center' cellpadding='10'>
	<tr>
		<?php $siswaQ = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$id_kelas' ORDER BY nama ASC"); ?>
		<?php while ($siswa = mysqli_fetch_array($siswaQ)) : ?>
			<?php
				$nopeserta = $siswa['no_peserta'];
				$no++;
				?>
			<td width='50%'>
				<div style='width:10.4cm;border:1px solid #666;'>
					<table style="text-align:center; width:100%">
						<tr>
							<td style="text-align:left; vertical-align:top">
								<?php
									$tempdir = '../foto/qrcode/';
									$tempatpng = $tempdir . $nopeserta . '.png';
									$tempatip = $tempdir . 'qrcodeip.png';

									if (!file_exists($tempatpng)) {
										QRcode::png($nopeserta, $tempatpng, 'L', 1);
									}
									if (!file_exists($tempatip)) {
										QRcode::png($setting['ip_server'], $tempatip, 'M', 1);
									}
									?>
								<img src='../foto/logo_tut.svg' height='60px'>
							</td>
							<td style="text-align:center">
								<!-- <b>
									KARTU PESERTA UJIAN<br>
									<?= strtoupper($setting['nama_ujian']) ?><BR>
									TAHUN PELAJARAN <?= $ajaran ?>
								</b> -->
								<b class="ukuran">
									<?= strtoupper($setting['header_kartu']) ?><BR>
									<?= strtoupper($setting['sekolah']) ?><BR>
									TAHUN PELAJARAN <?= $ajaran ?>
								</b>
							</td>
							<td style="text-align:right; vertical-align:top">
								<img src="../<?= $setting['logo'] ?>" height='60px' />
							</td>
						</tr>
					</table>
					<hr>
					<table style="text-align:left; width:100%">
						<tr>
							<td style="text-align:center; vertical-align:top; width:100px" rowspan="5">
								<?php
									if ($siswa['foto'] <> '') {
										if (!file_exists("../foto/fotosiswa/$siswa[foto]")) {
											echo "<img src='$homeurl/dist/img/avatar_default.png' class='img'  style='max-width:60px' alt='+'>";
										} else {
											echo "<img src='$homeurl/foto/fotosiswa/$siswa[foto]' class='img'  style='max-width:60px' >";
										}
									} else {
										echo "<img src='$homeurl/dist/img/foto.svg' class='img'  style='max-width:60px' alt='+'>";
									}

									?>
							</td>
						</tr>
						<tr>
							<td class="ukuran" valign='top' width="30%">No Peserta</td>
							<td class="ukuran" valign='top'>: <?= $siswa['no_peserta'] ?></td>
						</tr>
						<tr>
							<td class="ukuran" valign='top'>Nama</td>
							<td class="ukuran2" valign='top'>: <?= $siswa['nama'] ?></td>
						</tr>
						<tr>
							<td  class="ukuran" valign='top'>Kelas / Sesi Ujian</td>
							<td class="ukuran" valign='top'>: <?= $kelas['nama'] ?> / Sesi <?= $siswa['sesi'] ?></td>
						</tr>
						<tr>
							<td class="ukuran" valign='top'>Username</td>
							<td class="ukuran" valign='top'>:<b class="user"> <?= $siswa['username'] ?></b></td>
						</tr>
						<tr>
							<td width='100px' valign='top' style="text-align:center" rowspan='3'>
								<?php if($tempatpng==""){ ?>
								<img src='<?= $tempatip ?>' height='50px' />
							<?php }else{ ?>
								<img src='<?= $tempatpng ?>' height='50px' />
							<?php } ?>
							</td>
							<td class="ukuran" valign='top'>Password</td>
							<td class="ukuran" valign='top'>: <b class="user"><?= $siswa['password'] ?></b></td>
							
						</tr>
						<tr>
							<td class="ukuran" valign='top'>Ruang</td>
							<td class="ukuran" valign='top'>: <?= $siswa['ruang'] ?>
								<div style="padding-top: 12px; padding-left: 49px;" class="ttd"><img  src='<?php echo '../dist/img/ttd.png'.'?date='.time(); ?> ?>' height='40px'></div>
							</td>
						</tr>
						
						<tr>
							<td valign='top'></td>
							<td class="ukuran2" valign='top' align='center'>
								Kepala Sekolah<br><br>
								<br>
								<b><?= $setting['kepsek'] ?></b><br>
								<b>NIP. <?= $setting['nip'] ?></b>

							</td>
						</tr>
					</table>
				</div>
				<?php if (($no % 8) == 0) : ?>
					<div style='page-break-before:always;'></div>
				<?php endif; ?>
			</td>
			<?php if (($no % 2) == 0) : ?>
	</tr>
	<tr>
			<?php endif; ?>
		<?php endwhile; ?>
	</tr>
</table>