<?php
require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:index.php') : null;
$idserver = $setting['kode_sekolah'];
echo "<link rel='stylesheet' href='$homeurl/dist/css/cetak.min.css'>";

$sesi = @$_GET['id_sesi'];
$mapel = @$_GET['id_mapel'];
$ruang = @$_GET['id_ruang'];
$kelas = $_GET['id_kelas'];

if ($sesi == '' and $ruang == '' and $mapel == '') {
	die('Tidak ada data yang dicetak. Anda harus memilih semua variabel: mapel, sesi dan ruang');
}
$lebarusername = '10%';
$lebarnopes = '17%';
$namaruang = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ruang WHERE kode_ruang='$ruang'"));
$querytanggal = mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_mapel='$mapel' and sesi='$sesi'");
$cektanggal = mysqli_fetch_array($querytanggal);
$mapelx = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$mapel'"));
$namamapel =	mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mata_pelajaran WHERE kode_mapel='$mapelx[nama]'"));
if (date('m') >= 7 and date('m') <= 12) {
	$ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
	$ajaran = (date('Y') - 1) . "/" . date('Y');
}
$querysetting = mysqli_query($koneksi, "SELECT * FROM setting WHERE id_setting='1'");
$setting = mysqli_fetch_array($querysetting);
$jurus = unserialize($mapelx['idpk']);
$jurusan = implode(',', $jurus);
if (!$sesi == '' && !$ruang == '' && !$kelas == '') {
	$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE sesi='$sesi' and ruang='$ruang' and id_kelas='$kelas'");
} elseif ($sesi == '' and !$ruang == '' and !$kelas == '') {
	$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE ruang='$ruang' and id_kelas='$kelas'");
} elseif ($sesi == '' and $ruang == '' and !$kelas == '') {
	$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$kelas'");
} elseif (!$sesi == '' and $ruang == '' and $kelas == '') {
	$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE sesi='$sesi'");
} elseif (!$sesi == '' and !$ruang == '' and $kelas == '') {
	$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE sesi='$sesi' and ruang='$ruang'");
} elseif ($sesi == '' and !$ruang == '' and $kelas == '') {
	$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE ruang='$ruang'");
} else {
	$ckck = mysqli_query($koneksi, "SELECT * FROM siswa");
}

$jumlahData = mysqli_num_rows($ckck);
if ($jumlahData == 0) {
	echo "<span style='font-size:30; color:red'>Tidak ada Peserta Ujian dengan mapel" . $mapelx["nama"] . ", pada: <br>= sesi: " . $sesi . ", <br>= ruang: " . $ruang . ", <br>= kelas: " . $kelas . "</span>";
	echo mysqli_error($koneksi);
	die;
}
$jumlahn = '25';
$n = ceil($jumlahData / $jumlahn);

$nomer = 1;

$date = date_create($cektanggal['tgl_ujian']);
?>

<?php for ($i = 1; $i <= $n; $i++) : ?>
	<?php
	$mulai = $i - 1;
	$batas = ($mulai * $jumlahn);
	$startawal = $batas;
	$batasakhir = $batas + $jumlahn;
	?>

	<?php if ($i == $n) : ?>
		<div class='page'>
			<table width='100%'>
				<tr>
					<td width='100'><img src='../foto/logo_tut.svg' width='80'></td>
					<td style="text-align:center">
						<strong class='f12'>
							DAFTAR HADIR PESERTA <BR>
							<?= strtoupper($setting['nama_ujian']) ?><BR>
							TAHUN PELAJARAN <?= $ajaran ?>
						</strong>
					</td>
					<td width='100'><img src="<?= $homeurl . '/' . $setting['logo'] ?>" height='75'></td>
				</tr>
			</table>
			<table class='detail'>
				<tr>
					<td>SEKOLAH/MADRASAH</td>
					<td>:</td>
					<td><span style='width:350px;'>&nbsp;<?= $setting['sekolah'] ?></span></td>
					<td>ID SERVER</td>
					<td>:</td>
					<td><span style='width:150px;'>&nbsp;<?= $setting['kode_sekolah'] ?></span></td>
				</tr>
				<tr>
					<td>RUANG</td>
					<td>:</td>
					<td><span style='width:350px;'>&nbsp;<?= $namaruang['keterangan'] ?></span></td>
					<td>SESI</td>
					<td>:</td>
					<td><span style='width:150px;'>&nbsp;<?= $sesi ?></span></td>
				</tr>
				<tr>
					<td>HARI</td>
					<td>:</td>
					<td>
						<span style='width:90px;'>&nbsp;<?= strtoupper(buat_tanggal('D', $cektanggal['tgl_ujian'])) ?></span>
						TANGGAL : <span style='width:190px;'>&nbsp;<?= strtoupper(buat_tanggal('d M Y', $cektanggal['tgl_ujian'])) ?></span>
					</td>
					<td>PUKUL</td>
					<td>:</td>
					<td><span style='width:150px;'>&nbsp;<?= buat_tanggal('H:i', $cektanggal['tgl_ujian']) . " - " . buat_tanggal('H:i', $cektanggal['tgl_selesai']) ?></span></td>
				</tr>
				<tr>
					<td>MATA PELAJARAN</td>
					<td>:</td>
					<td colspan='4'><span style='width:350px;'>&nbsp;<?= $namamapel['nama_mapel'] ?></span></td>
				</tr>
			</table>
			<table class='it-grid it-cetak' width='100%'>
				<tr height=40px>
					<th>No.</th>
					<th>Username</th>
					<th>No Peserta</th>
					<th>Nama Peserta<BR> </th>
					<th>Tanda Tangan</th>
					<th>Ket</th>
				</tr>
				<?php
				if (!$sesi == '' && !$ruang == '' && !$kelas == '') {

					$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE sesi='$sesi' AND ruang='$ruang' AND id_kelas='$kelas' limit $batas,$jumlahn");
				} elseif ($sesi == '' and !$ruang == '' and !$kelas == '') {

					$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE ruang='$ruang' and id_kelas='$kelas' limit $batas,$jumlahn");
				} elseif ($sesi == '' and $ruang == '' and !$kelas == '') {

					$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$kelas' limit $batas,$jumlahn");
				} elseif (!$sesi == '' and $ruang == '' and $kelas == '') {

					$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE sesi='$sesi' limit $batas,$jumlahn");
				} elseif (!$sesi == '' and !$ruang == '' and $kelas == '') {

					$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE sesi='$sesi' and ruang='$ruang' limit $batas,$jumlahn");
				} elseif ($sesi == '' and !$ruang == '' and $kelas == '') {

					$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE ruang='$ruang' limit $batas,$jumlahn");
				} else {

					$ckck = mysqli_query($koneksi, "SELECT * FROM siswa limit $batas,$jumlahn");
				}
				?>
				<?php while ($f = mysqli_fetch_array($ckck)) : ?>
					<?php if ($nomer % 2 == 0) : ?>
						<tr>
							<td style="text-align:center;width:15">&nbsp;<?= $nomer ?>.</td>
							<td width='<?= $lebarusername ?>' style="text-align:center">&nbsp;<?= $f['username'] ?></td>
							<td width='<?= $lebarnopes ?>' style="text-align:center">&nbsp;<?= $f['no_peserta'] ?></td>
							<td width='*'>&nbsp;<?= $f['nama'] ?></td>
							<td width='150'><span style='float:right;width:80px;'>&nbsp;<?= $nomer ?>.</span></td>
							<td width='6%'>&nbsp;</td>
						</tr>
					<?php else : ?>
						<tr>
							<td style="text-align:center;width:15">&nbsp;<?= $nomer ?>.</td>
							<td width='<?= $lebarusername ?>' style="text-align:center">&nbsp;<?= $f['username'] ?></td>
							<td width='<?= $lebarnopes ?>' style="text-align:center">&nbsp;<?= $f['no_peserta'] ?></td>
							<td width='*'>&nbsp;<?= $f['nama'] ?></td>
							<td width='150'><span style='float:left;width:80px;'>&nbsp;<?= $nomer ?>.</span></td>
							<td width='6%'>&nbsp;</td>
						</tr>
					<?php endif; ?>
					<?php
					$nomer++;
					$jlhhdr = ($nomer - 1);
					?>
				<?php endwhile; ?>
			</table>
			<table>
				<tr>
					<td colspan='2'><strong><i>Keterangan : </i></strong></td>
				</tr>
				<tr>
					<td>1. Dibuat rangkap 3 (tiga), masing-masing untuk sekolah, Cabang Dinas dan Provinsi.</td>
				</tr>
				<tr>
					<td>2. Pengawas ruang menyilang Nama Peserta yang tidak hadir.</td>
				</tr>
			</table>
			<table width='100%'>
				<tr>
					<td>
						<table style='border:1px solid black'>
							<tr>
								<td>Jumlah Peserta yang Seharusnya Hadir</td>
								<td>:</td>
								<td> <?= $jlhhdr ?> orang</td>
							</tr>
							<tr>
								<td>Jumlah Peserta yang Tidak Hadir</td>
								<td>:</td>
								<td>_____ orang</td>
							</tr>
							<tr style='border-top:1px solid black'>
								<td>Jumlah Peserta Hadir</td>
								<td>:</td>
								<td>_____ orang</td>
							</tr>
						</table>
					</td>
					<td style="text-align:center; width:200">
						Proktor<BR><BR><BR><BR><BR>(<nip></nip>)<BR><BR>&nbsp;&nbsp;&nbsp;&nbsp;NIP. <nip></nip>
					</td>
					<td style="text-align:center; width:175">
						Pengawas<BR><BR><BR><BR><BR>(<nip></nip>)<BR><BR>&nbsp;&nbsp;&nbsp;&nbsp;NIP. <nip></nip>
					</td>
				</tr>
			</table>
			<div class='footer'>
				<table width='100%' height='30'>
					<tr>
						<td width='25px' style='border:1px solid black'></td>
						<td width='5px'>&nbsp;</td>
						<td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'><?= strtoupper($setting['nama_ujian']) . " " . $setting['sekolah'] ?></td>
						<td width='5px'>&nbsp;</td>
						<td width='25px' style='border:1px solid black'></td>
					</tr>
				</table>
			</div>
		</div>
		<?php break; ?>
	<?php endif; ?>
	<div class='page'>
		<table width='100%'>
			<tr>
				<td width='100'><img src='../foto/tut.jpg' width='80'></td>
				<td style="text-align:center">
					<strong class='f12'>
						DAFTAR HADIR PESERTA <BR>
						<?= strtoupper($setting['nama_ujian']) ?><BR>
						TAHUN PELAJARAN <?= $ajaran ?>
					</strong>
				</td>
				<td width='100'><img src="<?= $homeurl . '/' . $setting['logo'] ?>" height='75'></td>
			</tr>
		</table>
		<table class='detail'>
			<tr>
				<td>SEKOLAH/MADRASAH</td>
				<td>:</td>
				<td><span style='width:350px;'>&nbsp;<?= $setting['sekolah'] ?></span></td>
				<td>ID SERVER</td>
				<td>:</td>
				<td><span style='width:150px;'>&nbsp;<?= $setting['kode_sekolah'] ?></span></td>
			</tr>
			<tr>
				<td>RUANG</td>
				<td>:</td>
				<td><span style='width:350px;'>&nbsp;<?= $namaruang['keterangan'] ?></span></td>
				<td>SESI</td>
				<td>:</td>
				<td><span style='width:150px;'>&nbsp;<?= $sesi ?></span></td>
			</tr>
			<tr>
				<td>HARI</td>
				<td>:</td>
				<td>
					<span style='width:90px;'>&nbsp;<?= strtoupper(buat_tanggal('D', $cektanggal['tgl_ujian'])) ?></span>
					TANGGAL : <span style='width:190px;'>&nbsp;<?= strtoupper(buat_tanggal('d M Y', $cektanggal['tgl_ujian'])) ?></span>
				</td>
				<td>PUKUL</td>
				<td>:</td>
				<td><span style='width:150px;'>&nbsp;<?= buat_tanggal('H:i', $cektanggal['tgl_ujian']) . " - " . buat_tanggal('H:i', $cektanggal['tgl_selesai']) ?></span></td>
			</tr>
			<tr>
				<td>MATA PELAJARAN</td>
				<td>:</td>
				<td colspan='4'><span style='width:350px;'>&nbsp;<?= $namamapel['nama_mapel'] ?></span></td>
			</tr>
		</table>

		<table class='it-grid it-cetak' width='100%'>
			<tr height=40px>
				<th>No.</th>
				<th>Username</th>
				<th>No Peserta</th>
				<th>Nama Peserta<BR> </th>
				<th>Tanda Tangan</th>
				<th>Ket</th>
			</tr>
			<?php
			$s = $i - 1;

			if (!$sesi == '' and !$ruang == '' and !$kelas == '') {

				$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE sesi='$sesi' and ruang='$ruang' and id_kelas='$kelas' limit $batas,$jumlahn");
			} elseif ($sesi == '' and !$ruang == '' and !$kelas == '') {

				$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE ruang='$ruang' and id_kelas='$kelas' limit $batas,$jumlahn");
			} elseif ($sesi == '' and $ruang == '' and !$kelas == '') {

				$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$kelas' limit $batas,$jumlahn");
			} elseif (!$sesi == '' and $ruang == '' and $kelas == '') {

				$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE sesi='$sesi' limit $batas,$jumlahn");
			} elseif (!$sesi == '' and !$ruang == '' and $kelas == '') {

				$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE sesi='$sesi' and ruang='$ruang' limit $batas,$jumlahn");
			} elseif ($sesi == '' and !$ruang == '' and $kelas == '') {

				$ckck = mysqli_query($koneksi, "SELECT * FROM siswa WHERE ruang='$ruang' limit $batas,$jumlahn");
			} else {

				$ckck = mysqli_query($koneksi, "SELECT * FROM siswa limit $batas,$jumlahn");
			}
			?>
			<?php while ($f = mysqli_fetch_array($ckck)) : ?>
				<?php if ($nomer % 2 == 0) : ?>
					<tr>
						<td style="text-align:center;width:15">&nbsp;<?= $nomer ?>.</td>
						<td width='<?= $lebarusername ?>' style="text-align:center">&nbsp;<?= $f['username'] ?></td>
						<td width='<?= $lebarnopes ?>' style="text-align:center">&nbsp;<?= $f['no_peserta'] ?></td>
						<td width='*'>&nbsp;<?= $f['nama'] ?></td>
						<td width='150'><span style='float:right;width:80px;'>&nbsp;<?= $nomer ?>.</span></td>
						<td width='6%'>&nbsp;</td>
					</tr>
				<?php else : ?>
					<tr>
						<td style="text-align:center;width:15">&nbsp;<?= $nomer ?>.</td>
						<td width='<?= $lebarusername ?>' style="text-align:center">&nbsp;<?= $f['username'] ?></td>
						<td width='<?= $lebarnopes ?>' style="text-align:center">&nbsp;<?= $f['no_peserta'] ?></td>
						<td width='*'>&nbsp;<?= $f['nama'] ?></td>
						<td width='150'><span style='float:left;width:80px;'>&nbsp;<?= $nomer ?>.</span></td>
						<td width='6%'>&nbsp;</td>
					</tr>
				<?php endif; ?>
				<?php
				$nomer++;
				$jlhhdr = ($nomer - 1);
				?>
			<?php endwhile; ?>
		</table>

		<div class='footer'>
			<table width='100%' height='30'>
				<tr>
					<td width='25px' style='border:1px solid black'></td>
					<td width='5px'>&nbsp;</td>
					<td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'><?= strtoupper($setting['nama_ujian']) . " " . $setting['sekolah'] ?></td>
					<td width='5px'>&nbsp;</td>
					<td width='25px' style='border:1px solid black'></td>
				</tr>
			</table>
		</div>
	</div>
<?php endfor; ?>