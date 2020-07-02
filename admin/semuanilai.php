<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>

<?php if ($ac == '') : ?>
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'><i class="fas fa-file-signature fa-fw   "></i> DATA UJIAN AKTIF</h3>
					<div class='box-tools pull-right btn-group'>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'><?= $info ?>
					<?php $jq = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
					<?php while ($jenis = mysqli_fetch_array($jq)) : ?>
						<div class="col-lg-2 ">
							<div class="small-box bg-blue">
								<div class="inner">
									<h4><?= $jenis['id_kelas'] ?></h4>

								</div>
								<!-- <div class="icon">
									<i class="fa fa-school"></i>
								</div> -->
								<a href="?pg=<?= $pg ?>&ac=lihat&idk=<?= $jenis['id_kelas'] ?>" class="small-box-footer">Lihat Nilai <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>

					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
<?php elseif ($ac == 'lihat') : ?>
	<?php
	$id_kelas = $_GET['idk'];
	$mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel")); ?>
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'><i class="fas fa-file-signature fa-fw   "></i> REKAP NILAI KELAS <?= $id_kelas ?></h3>
					<div class='box-tools pull-right'>
						<a class='btn btn-sm btn-primary' href='report_excel_all.php?k=<?= $id_kelas ?>'><i class='fa fa-download'></i> Excel</a>
						<a class='btn btn-sm btn-danger' href='?pg=semuanilai'><i class='fa fa-times'></i> Keluar</a>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<div class='table-responsive'>
						<table id='example' class='table table-bordered table-striped'>
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
											<td style="text-align:center"><?= $nilai['skor'] ?></td>
										<?php endwhile; ?>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
<?php endif; ?>