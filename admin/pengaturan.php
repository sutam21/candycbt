<?php
cek_session_admin();
$info1 = $info2 = $info3 = $info4 = '';
$admin = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE level='admin' AND id_pengawas='1'"));
$setting = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting WHERE id_setting='1'"));
$setting['alamat'] = str_replace('<br />', '', $setting['alamat']);
$setting['header'] = str_replace('<br />', '', $setting['header']);
?>
<div class='row'>
	<div class='col-md-12'>
		<div class="box box-solid">
			<!-- Add the bg color to the header using any of the bg-* classes -->
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fas fa-tools fa-2x fa-fw"></i> Pengaturan</h3>
			</div>
			<div class="box-body no-padding ">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Pengaturan Umum</a></li>
						<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Hapus Data</a></li>
						<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Backup & Restore</a></li>
						<li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Backup Master Soal</a></li>

					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							<form id="formpengaturan" action='' method='post' enctype='multipart/form-data'>

								<div class='box-body'>
									<button type='submit' name='submit1' class='btn btn-flat pull-right btn-success' style='margin-bottom:5px'><i class='fa fa-check'></i> Simpan</button>
									<?= $info1 ?>
									<div class='form-group'>
										<label>Nama Aplikasi</label>
										<input type='text' name='aplikasi' value="<?= $setting['aplikasi'] ?>" class='form-control' required='true' />
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Nama Sekolah</label>
												<input type='text' name='sekolah' value="<?= $setting['sekolah'] ?>" class='form-control' required='true' />
											</div>
											<div class='col-md-6'>
												<label>Kode Sekolah</label>
												<input type='text' name='kode' value="<?= $setting['kode_sekolah'] ?>" class='form-control' required='true' />
											</div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Alamat Server / Ip Server</label>
												<input type='text' name='ipserver' value="<?= $setting['ip_server'] ?>" class='form-control' />
											</div>
											<div class='col-md-6'>
												<label>Waktu Server</label>
												<select name='waktu' class='form-control' required='true'>
													<option value="<?= $setting['waktu'] ?>"><?= $setting['waktu'] ?></option>
													<option value='Asia/Jakarta'>Asia/Jakarta</option>
													<option value='Asia/Makassar'>Asia/Makassar</option>
													<option value='Asia/Jayapura'>Asia/Jayapura</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class='form-group'>
												<label>Token Sinkronisasi</label>
												<div class="input-group input-group-sm">
													<input type="text" name='token_api' class="form-control" id='tokenapi' value="<?= $setting['token_api'] ?>" readonly>
													<span class="input-group-btn">
														<button type="button" class="btn btn-info btn-flat" id='buattoken'><i class="fas fa-spinner    "></i></button>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class='form-group'>
												<label>Jenjang</label>
												<select name='jenjang' class='form-control' required='true'>
													<option value="<?= $setting['jenjang'] ?>"><?= $setting['jenjang'] ?></option>
													<option value='SD'>SD/MI</option>
													<option value='SMP'>SMP/MTS</option>
													<option value='SMK'>SMK/SMA/MA</option>
												</select>
											</div>
										</div>
									</div>
									<div class='form-group'>
										<label>Kepala Sekolah</label>
										<input type='text' name='kepsek' value="<?= $setting['kepsek'] ?>" class='form-control' />
									</div>
									<div class='form-group'>
										<label>NIP Kepala Sekolah</label>
										<input type='text' name='nip' value="<?= $setting['nip'] ?>" class='form-control' />
									</div>
									<div class='form-group'>
										<label>Alamat</label>
										<textarea name='alamat' class='form-control' rows='3'><?= $setting['alamat'] ?></textarea>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Kecamatan</label>
												<input type='text' name='kecamatan' value="<?= $setting['kecamatan'] ?> " class='form-control' />
											</div>
											<div class='col-md-6'>
												<label>Kota/Kabupaten</label>
												<input type='text' name='kota' value="<?= $setting['kota'] ?>" class='form-control' />
											</div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Telepon</label>
												<input type='text' name='telp' value="<?= $setting['telp'] ?>" class='form-control' />
											</div>
											<div class='col-md-6'>
												<label>Fax</label>
												<input type='text' name='fax' value="<?= $setting['fax'] ?>" class='form-control' />
											</div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Website</label>
												<input type='text' name='web' value="<?= $setting['web'] ?>" class='form-control' />
											</div>
											<div class='col-md-6'>
												<label>E-mail</label>
												<input type='text' name='email' value="<?= $setting['email'] ?>" class='form-control' />
											</div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Logo</label>
												<input type='file' name='logo' class='form-control' />
											</div>
											<div class='col-md-2'>
												&nbsp;<br />
												<img class='img img-responsive' src="<?= $homeurl ?>/<?= $setting['logo'] ?>" height='50' />
											</div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Tanda Tangan</label>
												<input type='file' name='ttd' class='form-control' />
											</div>
											<div class='col-md-2'>
												&nbsp;<br />
												<img class='img img-responsive' src="
												<?php echo $homeurl . '/dist/img/ttd.png' . '?date=' . time(); ?> ?>" height='50' />
											</div>
										</div>
									</div>
									<div class='form-group'>
										<label>Header Laporan</label>
										<textarea name='header' class='form-control' rows='3'><?= $setting['header'] ?></textarea>
									</div>
								</div><!-- /.box-body -->

							</form>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="tab_2">
							<form id='formhapusdata' action='' method='post'>
								<div class='box-body'>
									<?= $info4 ?>

									<div class='form-group'>
										<label>Pilih Data</label>
										<div class='row'>
											<div class='col-md-5'>
												<div class='checkbox'>
													<small class='label bg-purple'>Pilih Data Hasil Nilai</small><br />
													<label><input type='checkbox' name='data[]' value='nilai' /> Data Nilai</label><br />

													<label><input type='checkbox' name='data[]' value='jawaban' /> Data Jawaban</label><br />
													<small class='label bg-green'>Pilih Data Ujian</small><br />
													<label><input type='checkbox' name='data[]' value='soal' /> Data Soal</label><br />
													<label><input type='checkbox' name='data[]' value='mapel' /> Data Bank Soal</label><br />
													<label><input type='checkbox' name='data[]' value='ujian' /> Data Jadwal Ujian</label><br />
													<label><input type='checkbox' name='data[]' value='berita' /> Data Berita Acara</label><br />
													<label><input type='checkbox' name='data[]' value='tugas' /> Data Tugas</label><br />
													<label><input type='checkbox' name='data[]' value='jawaban_tugas' /> Data Jawaban Tugas</label><br />

													<small class='label label-danger'>Pilih Data Master</small><br />
													<label><input type='checkbox' name='data[]' value='siswa' /> Data Siswa</label><br />
													<label><input type='checkbox' name='data[]' value='kelas' /> Data Kelas</label><br />
													<label><input type='checkbox' name='data[]' value='mata_pelajaran' /> Data Mata Pelajaran</label><br />
													<label><input type='checkbox' name='data[]' value='pk' /> Data Jurusan</label><br />
													<label><input type='checkbox' name='data[]' value='level' /> Data Level</label><br />
													<label><input type='checkbox' name='data[]' value='ruang' /> Data Ruangan</label><br />
													<label><input type='checkbox' name='data[]' value='sesi' /> Data Sesi</label><br />

												</div>
											</div>
											<div class='col-md-7'>
												<button type='submit' name='submit3' class='btn btn-sm bg-maroon'><i class='fa fa-trash-o'></i> Kosongkan</button>
												<div class='form-group'>
													<label>Password Admin</label>
													<input type='password' name='password' class='form-control' required='true' />
												</div>

												<p class='text-danger'><i class='fa fa-warning'></i> <strong>Mohon di ingat!</strong> Data yang telah dikosongkan tidak dapat dikembalikan.</p>
											</div>
										</div>
									</div>
								</div><!-- /.box-body -->
							</form>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="tab_3">
							<div class='col-md-12 notif'></div>
							<div class='col-md-6'>
								<div class='box box-solid'>
									<div class='box-header '>
										<h3 class='box-title'>Backup Data</h3>
									</div><!-- /.box-header -->
									<div class='box-body'>
										<p>Klik Tombol dibawah ini untuk membackup database </p>
										<button id='btnbackup' class='btn btn-flat btn-success'><i class='fa fa-database'></i> Backup Data</button>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
							<div class='col-md-6'>
								<div class='box box-solid'>
									<div class='box-header '>
										<h3 class='box-title'>Restore Data</h3>
									</div><!-- /.box-header -->
									<div class='box-body'>
										<form id='formrestore'>
											<p>Klik Tombol dibawah ini untuk merestore database </p>
											<div class='col-md-8'>
												<input class='form-control' name='datafile' type='file' required />
											</div>
											<button name='restore' class='btn btn-flat btn-success'><i class='fa fa-database'></i> Restore Data</button>
										</form>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
						</div>
						<div class="tab-pane" id="tab_4">
							<div class="row">
								<div class='col-md-12 notif_mapel'></div>
								<div class='col-md-12'>
									<div class="panel panel-default">
										<div class="panel-body">
											<label for="mapel" class="col-sm-2">Mapel yang Tersedia</label>
											<div class="col-sm-10">
												<select name="mapel_id" id="mapel_id" class="form-control select2" style="width: 100%;" required>
													<?php $mapelbackup = mysqli_query($koneksi, "SELECT a.id_mapel, b.kode_mapel, b.nama_mapel FROM mapel a INNER JOIN mata_pelajaran b ON a.nama = b.kode_mapel INNER JOIN soal c ON a.id_mapel = c.id_mapel GROUP BY c.id_mapel ASC"); ?>
													<?php while ($mapelb = mysqli_fetch_array($mapelbackup)) : ?>
														<option value="<?= $mapelb['id_mapel'] . ";" . $mapelb['kode_mapel'] ?>"><?= $mapelb['id_mapel'] . " - " . $mapelb['nama_mapel'] ?></option>
													<?php endwhile ?>
												</select>
											</div>
										</div>
										<div class="panel-footer clearfix">
											<div class="pull-right">
												<button id='mastersoal' class='btn btn-flat btn-success'><i class='fa fa-database'></i> Proses</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$("#buattoken").click(function() {
		// set the length of the string
		var stringLength = 15;

		// list containing characters for the random string
		var stringArray = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];


		var rndString = "";

		// build a string with random characters
		for (var i = 1; i < stringLength; i++) {
			var rndNum = Math.ceil(Math.random() * stringArray.length) - 1;
			rndString = rndString + stringArray[rndNum];
		};

		$("#tokenapi").val(rndString);

	});
	$('#formrestore').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		//console.log(data);
		$.ajax({
			type: 'POST',
			url: 'restore.php',
			enctype: 'multipart/form-data',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$('.loader').show();
			},
			success: function(data) {
				$('.loader').hide();
				toastr.success(data);

			}
		});
		return false;
	});
	$('#formpengaturan').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		//console.log(data);
		$.ajax({
			type: 'POST',
			url: 'simpan_setting.php',
			enctype: 'multipart/form-data',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {

				toastr.success("pengaturan berhasil disimpan");

			}
		});
		return false;
	});
	$('#formhapusdata').submit(function(e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'simpan_hapusdata.php',
			data: $(this).serialize(),
			success: function(data) {
				console.log(data);
				if (data == "ok") {
					toastr.success("Data Terpilih telah dikosongkan");
				} else {
					toastr.error(data);
				}

			}
		});
		return false;
	});
</script>