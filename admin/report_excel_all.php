<?php
require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
require("../config/dis.php");
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:login.php') : null;
echo "<style> .str{ mso-number-format:\@; } </style>";
$id_kelas = $_GET['k'];
$pengawas = fetch($koneksi, 'pengawas', array('id_pengawas' => $id_pengawas));
$mapel = fetch($koneksi, 'mapel', array('id_mapel' => null));
$kelas = fetch($koneksi, 'kelas', array('id_kelas' => $id_kelas));

if (date('m') >= 7 and date('m') <= 12) :
	$ajaran = date('Y') . "/" . (date('Y') + 1);
elseif (date('m') >= 1 and date('m') <= 6) :
	$ajaran = (date('Y') - 1) . "/" . date('Y');
endif;

$file = "REKAP NILAI KELAS " . $kelas['nama'];
$file = str_replace(" ", "_", $file);
$file = str_replace(":", "", $file);
header("Content-type: application/octet-stream");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: attachment; filename=" . $file . ".xls");
?>
	REKAP NILAI HASIL UJIAN
	<br>
	<?= $setting['sekolah'] ?>
<table border='1'>
<thead>
								<tr>
									<th rowspan='3' style="vertical-align:middle; width:5px">#</th>
									<th style='text-align:center;vertical-align:middle' rowspan='3'>No Peserta</th>
									<th style='text-align:center;vertical-align:middle' rowspan='3'>Nama Peserta</th>
									<th style='text-align:center;vertical-align:middle' rowspan='3'>Kelas</th>
									<?php
									$kodeujian=mysqli_fetch_array(mysqli_query($koneksi,"select * from jenis where status='aktif'"));
									$mapelQ = mysqli_query($koneksi, "SELECT * FROM mapel a JOIN nilai b ON a.id_mapel=b.id_mapel where b.kode_ujian='$kodeujian[id_jenis]' GROUP BY b.id_mapel ");
									while ($mapel = mysqli_fetch_array($mapelQ)) :
										echo "<th style='text-align:center' colspan='3'>$mapel[nama]</th>";
									endwhile;
									?>
								</tr>
								<tr>
									<?php
									$kode = mysqli_query($koneksi, "SELECT * FROM mapel a JOIN nilai b ON a.id_mapel=b.id_mapel where b.kode_ujian='$kodeujian[id_jenis]' GROUP BY b.id_mapel");
									while ($mapel = mysqli_fetch_array($kode)) :
										echo "<th style='text-align:center' colspan='3'>$mapel[kode_ujian]</th>";
									endwhile;
									?>
								</tr>
								<tr>
									<?php $mapelQ = mysqli_query($koneksi, "SELECT * FROM mapel a JOIN nilai b ON a.id_mapel=b.id_mapel where b.kode_ujian='$kodeujian[id_jenis]' GROUP BY b.id_mapel "); ?>
									<?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
										<th style='text-align:center'>B</th>
										<th style='text-align:center'>S</th>
										<th style='text-align:center'>SKOR</th>
									<?php endwhile; ?>
								</tr>
							</thead>
							<tbody>
								<?php $siswaQ = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$id_kelas' ORDER BY nama ASC"); ?>
								<?php while ($siswa = mysqli_fetch_array($siswaQ)) : ?>
									<?php
									$no++;
									$ket = '';
									$esai = $lama = $jawaban = $skor = $total = '--';
									?>
									<tr>
										<td><?= $no ?></td>
										<td style="text-align:center"><?= $siswa['no_peserta'] ?></td>
										<td><?= $siswa['nama'] ?></td>
										<td style="text-align:center"><?= $siswa['id_kelas'] ?></td>
										<?php $mapelQ = mysqli_query($koneksi, "SELECT * FROM mapel a JOIN nilai b ON a.id_mapel=b.id_mapel where b.kode_ujian='$kodeujian[id_jenis]' GROUP BY b.id_mapel "); ?>
										<?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
											<?php
											$nilaiQ = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_mapel='$mapel[id_mapel]' AND id_siswa='$siswa[id_siswa]' ");
											$nilaiC = mysqli_num_rows($nilaiQ);
											$nilai = mysqli_fetch_array($nilaiQ);
											?>
											<td style="text-align:center"><?= $nilai['jml_benar'] ?></td>
											<td style="text-align:center"><?= $nilai['jml_salah'] ?></td>
											<td style="text-align:center" class='str'><?= $nilai['skor'] ?></td>
										<?php endwhile; ?>
									</tr>
								<?php endwhile; ?>
							</tbody>
</table>