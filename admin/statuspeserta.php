<?php
include "../config/config.default.php";
include "../config/config.function.php";
$tglsekarang = date('Y-m-d');
$id = $_GET['id'];
$idu = $_GET['idu'];

$nilaiq = mysqli_query($koneksi, "SELECT *  FROM nilai  s LEFT JOIN ujian c ON s.id_mapel=c.id_mapel  where c.status='1' and s.id_siswa<>'' and s.id_mapel='$id' and s.id_ujian='$idu' GROUP by s.id_nilai DESC");
while ($nilai = mysqli_fetch_array($nilaiq)) {

	$tglx = strtotime($nilai['ujian_mulai']);
	$tgl = date('Y-m-d', $tglx);
	//if ($tgl == $tglsekarang) {
	$no++;
	$ket = '';
	$jawaban = $skor = '--';
	$status = "<span class='text-danger'><i class='fa fa-skull-crossbones'></i> Offline</span>";
	$selisih = 0;
	$siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$nilai[id_siswa]'"));
	$kelas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$siswa[id_kelas]'"));
	$mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$nilai[id_mapel]'"));

	$nilaiQ = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_siswa='$siswa[id_siswa]'");
	$nilaiC = mysqli_num_rows($nilaiQ);

	if ($nilaiC <> 0) {
		$selisih = '';
		if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] <> '') {
			$selisih = strtotime($nilai['ujian_selesai']) - strtotime($nilai['ujian_mulai']);
			$bg = "";
			$jawaban = "<small class='label bg-green'>$nilai[jml_benar] <i class='fa fa-check'></i></small>  <small class='label bg-red'>$nilai[jml_salah] <i class='fa fa-times'></i></small>";
			$skor = "<small class='label bg-green'>" . number_format($nilai['skor'], 2, '.', '') . "</small>";
			$ket = "<span class='text-success'>Tes Selesai</span>";
			$btn = "<button data-id='$nilai[id_nilai]' class='ulang btn btn-danger btn-block'><i class='fa fa-redo-alt'></i> Ulang</button>";
		} elseif ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] == '') {
			$bg = "text-success";
			$selisih = strtotime($nilai['ujian_berlangsung']) - strtotime($nilai['ujian_mulai']);

			$ket = "<i class='fa fa-spin fa-spinner' title='Sedang ujian'></i>&nbsp;Masih Dikerjakan";
			if ($nilai['online'] == '1') {
				$status = "<span class='text-success'><i class='fa fa-smile-beam'></i> Online</span>";
			} else {
			}
			$btn = "
			<button data-id='$nilai[id_nilai]' class='reset btn btn-warning '><i class='fa fa-recycle'></i> Reset Login</button>
			<button data-id='$nilai[id_nilai]' class='hapus btn btn-danger '><i class='fa fa-hand-rock'></i> Selesai</button>";
		}
	}
?>
	<div class="col-md-3">
		<div class="box box-primary">
			<div class="box-body box-profile <?= $bg ?>">
				<div class="direct-chat-msg">
					<div class="direct-chat-info clearfix">
						<span class="direct-chat-name pull-right">(<?= $siswa['nis'] ?>) <?= $siswa['nama'] ?></span>

					</div>
					<!-- /.direct-chat-info -->
					<span class='direct-chat-img'><i class='fa fa-user fa-3x'></i></span><!-- /.direct-chat-img -->
					<div class="direct-chat-text">
						<?= $ket ?>
					</div>
					<span class='direct-chat-timestamp pull-right'><?= $nilai['ipaddress'] ?> <?= $jawaban ?> <?= $skor ?></span>
					<!-- /.direct-chat-text -->
				</div>
				<ul class="list-group list-group-unbordered" style="margin-bottom: 5px;">
					<li class="list-group-item">
						<?= $status ?> <a class="pull-right"><i class="fas fa-clock    "></i> <?= lamaujian($selisih) ?></a>
					</li>
				</ul>
				<?= $btn ?>
			</div>
			<!-- /.box-body -->
		</div>

	</div>


<?php } ?>
<script>
	$(document).on('click', '.hapus', function() {
		var id = $(this).data('id');
		console.log(id);
		$('#htmlujianselesai').html('bbbbbbbbbbbbbbbbbbbbbbbbb');
		swal({
			title: 'Apa anda yakin?',
			text: "aksi ini akan menyelesaikan secara paksa ujian yang sedang berlangsung!",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: 'selesaikan.php',
					method: "POST",
					data: 'id=' + id,
					success: function(data) {
						$('#htmlujianselesai').html('1');
						toastr.success("berhasil diselesaikan");

					}
				});
			}
		})
	});

	$(document).on('click', '.ulang', function() {
		var id = $(this).data('id');
		console.log(id);
		swal({
			title: 'Apa anda yakin?',
			text: "Akan Mengulang Ujian Ini ??",

			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: 'ulangujian.php',
					method: "POST",
					data: 'id=' + id,
					success: function(data) {
						toastr.success("berhasil diulang");
					}
				});
			}
		})
	});
	$(document).on('click', '.reset', function() {
		var id = $(this).data('id');
		console.log(id);
		swal({
			title: 'Apa anda yakin?',
			text: "Akan Mereset Peserta Ujian Ini ??",

			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: 'resetlogin.php',
					method: "POST",
					data: 'id=' + id,
					success: function(data) {
						toastr.success("berhasil direset");

					}
				});
			}
		})
	});
</script>