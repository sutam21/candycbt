<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<?php if ($ac == '') : ?>
	<?php
	if (isset($_POST['tambahsiswa'])) {
		$nis = $_POST['nis'];
		$no_peserta = $_POST['no_peserta'];
		$nama = $_POST['nama'];
		$nama = str_replace("'", "&#39;", $nama);
		$username = $_POST['username'];
		$id_kelas = $_POST['id_kelas'];
		$idpk = $_POST['idpk'];
		$sesi = $_POST['idsesi'];
		$ruang = $_POST['ruang'];
		$level = $_POST['level'];
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		$server = $_POST['server'];
		$agama = $_POST['agama'];
		$cekuser = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa WHERE username='$username'"));
		if ($cekuser > 0) {
			$info = info("Username $username sudah ada!", "NO");
		} else {
			if ($pass1 <> $pass2) {
				$info = info("Password tidak cocok!", "NO");
			} else {
				if ($setting['jenjang'] == 'SMK') {
					$exec = mysqli_query($koneksi, "INSERT INTO siswa (id_kelas,idpk,nis,no_peserta,nama,sesi,ruang,level,username,password,server,agama) VALUES ('$id_kelas','$idpk','$nis','$no_peserta','$nama','$sesi','$ruang','$level','$username','$pass1','$server','$agama')");
				} else {
					$exec = mysqli_query($koneksi, "INSERT INTO siswa (id_kelas,nis,no_peserta,nama,sesi,ruang,level,username,password,server,agama) VALUES ('$id_kelas','$nis','$no_peserta','$nama','$sesi','$ruang','$level','$username','$pass1','$server','$agama')");
				}
				(!$exec) ? $info = info("Gagal menyimpan!", "NO") : jump("?pg=$pg");
			}
		}
	}
	?>
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid'>
				<div class='box-header with-border '>
					<h3 class='box-title'><i class="fas fa-user-friends fa-fw   "></i> Peserta Ujian</h3>
					<div class='box-tools pull-right'>
						<?php if ($pengawas['level'] == 'admin') : ?>
							<?php if ($setting['server'] == 'pusat') : ?>
								<a data-toggle='modal' data-backdrop="static" data-target='#tambahsiswa' class='btn btn-sm btn-primary'><i class='glyphicon glyphicon-plus'></i> <span class='hidden-xs'>Tambah</span></a>
							<?php endif; ?>
							<a href='?pg=uplfotosiswa' class='btn btn-sm btn-danger'><i class='fa fa-image'></i> <span class='hidden-xs'>Upload Foto</span></a>
							<a href='ekspor_siswa.php' class='btn btn-sm btn-success'><i class='fa fa-download'></i> <span class='hidden-xs'>Download Data</span></a>
						<?php endif ?>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<div class='table-responsive'>
						<table style="font-size: 11px" id='tabelsiswa' class='table table-bordered table-striped'>
							<thead>
								<tr>
									<th width='3px'></th>
									<th>No_Peserta</th>
									<th>Nama</th>
									<th>Level</th>
									<th>Kelas</th>
									<?php if ($setting['jenjang'] == 'SMK') : ?>
										<th>Jurusan</th>
									<?php endif ?>
									<th>sesi</th>
									<th>ruang</th>
									<th>Username</th>
									<th>Password</th>
									<th>Server</th>
									<th>Agama</th>
									<?php if ($pengawas['level'] == 'admin') : ?>
										<?php if ($setting['server'] == 'pusat') : ?>
											<th width='70px'></th>
										<?php endif ?>
									<?php endif ?>
								</tr>
							</thead>
						</table>
					</div>
					<div class='modal fade' id='tambahsiswa' style='display: none;'>
						<div class='modal-dialog'>
							<div class='modal-content'>
								<div class='modal-header bg-maroon'>
									<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
									<h4 class='modal-title'><i class="fas fa-user-friends fa-fw   "></i> Tambah Siswa</h4>
								</div>
								<div class='modal-body'>
									<form action='' method='post'>
										<div class='form-group'>
											<div class='row'>
												<div class='col-md-6'>
													<label>NIS</label>
													<input type='text' name='nis' class='form-control' required='true' />
												</div>
												<div class='col-md-6'>
													<label>Nomor Peserta</label>
													<input type='text' name='no_peserta' class='form-control' required='true' />
												</div>
											</div>
										</div>
										<div class='form-group'>
											<label>Nama</label>
											<input type='text' name='nama' class='form-control' required='true' />
										</div>
										<div class='form-group'>
											<div class='row'>
												<div class='col-md-4'>
													<label>Kelas</label>
													<select name='id_kelas' class='form-control' required='true'>
														<option value=''></option>
														<?php
														$kelasQ = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama ASC");
														while ($kelas = mysqli_fetch_array($kelasQ)) {
															echo "<option value='$kelas[id_kelas]' $s>$kelas[nama]</option>";
														}
														?>
													</select>
												</div>
												<div class='col-md-4'>
													<label>Level</label>
													<select name='level' class='form-control' required='true'>
														<option value=''></option>
														<?php
														$pkQ = mysqli_query($koneksi, "SELECT * FROM level ");
														while ($pk = mysqli_fetch_array($pkQ)) {
															echo "<option value='$pk[kode_level]'>$pk[kode_level]</option>";
														}
														?>
													</select>
												</div>
												<?php if ($setting['jenjang'] == 'SMK') : ?>
													<div class='col-md-4'>
														<label>Jurusan</label>
														<select name='idpk' class='form-control' required='true'>
															<option value=''></option>
															<?php
															$pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
															while ($pk = mysqli_fetch_array($pkQ)) {
																echo "<option value='$pk[id_pk]'>$pk[program_keahlian]</option>";
															}
															?>
														</select>
													</div>
												<?php endif ?>
											</div>
										</div>
										<div class='form-group'>
											<div class='row'>
												<div class='col-md-4'>
													<label>Sesi</label>
													<select name='idsesi' class='form-control' required='true'>
														<option value=''></option>
														<?php
														$sesiQ = mysqli_query($koneksi, "SELECT * FROM sesi ");
														while ($sesi = mysqli_fetch_array($sesiQ)) {

															echo "<option value='$sesi[kode_sesi]' $s>$sesi[kode_sesi]</option>";
														}
														?>
													</select>
												</div>
												<div class='col-md-4'>
													<label>Ruang</label>
													<select name='ruang' class='form-control' required='true'>
														<option value=''></option>
														<?php
														$pkQ = mysqli_query($koneksi, "SELECT * FROM ruang ");
														while ($pk = mysqli_fetch_array($pkQ)) {
															echo "<option value='$pk[kode_ruang]'>$pk[kode_ruang]</option>";
														}
														?>
													</select>
												</div>
												<div class='col-md-4'>
													<label>Server</label>
													<select name='server' class='form-control' required='true'>
														<option value=''></option>
														<?php
														$pkQ = mysqli_query($koneksi, "SELECT * FROM server ");
														while ($sr = mysqli_fetch_array($pkQ)) {
															echo "<option value='$sr[kode_server]'>$sr[kode_server]</option>";
														}
														?>
													</select>
												</div>
												<div class='col-md-4'>
													<label>Agama</label>
													<select name='agama' class='form-control' required='true'>
														<option value=''></option>
														<?php
														$agamaQ = mysqli_query($koneksi, "SELECT * FROM agama ");
														while ($ag = mysqli_fetch_array($agamaQ)) {
															echo "<option value='$ag[agamaku]'>$ag[agamaku]</option>";
														}
														?>
													</select>
												</div>
											</div>
										</div>
										<div class='form-group'>
											<label>Username</label>
											<input type='text' name='username' class='form-control' required='true' />
										</div>
										<div class='form-group'>
											<div class='row'>
												<div class='col-md-6'>
													<label>Password</label>
													<input type='password' name='pass1' class='form-control' required='true' />
												</div>
												<div class='col-md-6'>
													<label>Ulang Password</label>
													<input type='password' name='pass2' class='form-control' required='true' />
												</div>
											</div>
										</div>
										<div class='modal-footer'>
											<div class='box-tools pull-right btn-group'>
												<button type='submit' name='tambahsiswa' class='btn btn-sm btn-primary'><i class='fa fa-check'></i> Simpan</button>
												<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
<?php elseif ($ac == 'edit') : ?>
	<?php
	$id = $_GET['id'];
	$siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$id'"));
	if (isset($_POST['submit'])) {
		$nis = $_POST['nis'];
		$nopes = $_POST['no_peserta'];
		$idpk = $_POST['idpk'];
		$nama = $_POST['nama'];
		$nama = str_replace("'", "&#39;", $nama);
		$kelas = $_POST['id_kelas'];
		$sesi = $_POST['idsesi'];
		$ruang = $_POST['ruang'];
		$level = $_POST['level'];
		$username = $_POST['username'];
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		$level = $_POST['level'];
		$server = $_POST['server'];
		$agama = $_POST['agama'];
		if ($pass1 <> '' && $pass2 <> '') {
			if ($pass1 <> $pass2) {
				$info = info("Password tidak cocok!", "NO");
			} else {
				if ($setting['jenjang'] == 'SMK') {
					$exec = mysqli_query($koneksi, "UPDATE siswa SET nis='$nis',no_peserta='$nopes', idpk='$idpk',id_kelas='$kelas',nama='$nama',sesi='$sesi',ruang='$ruang',username='$username',password='$pass1',level='$level',server='$server',agama='$agama' WHERE id_siswa='$id'");
				} else {
					$exec = mysqli_query($koneksi, "UPDATE siswa SET nis='$nis',no_peserta='$nopes', id_kelas='$kelas',nama='$nama',sesi='$sesi',ruang='$ruang',username='$username',password='$pass1',level='$level',server='$server',agama='$agama' WHERE id_siswa='$id'");
				}
			}
		} else {
			if ($setting['jenjang'] == 'SMK') {
				$exec = mysqli_query($koneksi, "UPDATE siswa SET nis='$nis',no_peserta='$nopes', idpk='$idpk',id_kelas='$kelas',nama='$nama',sesi='$sesi',ruang='$ruang',username='$username',level='$level',server='$server',agama='$agama' WHERE id_siswa='$id'");
			} else {
				$exec = mysqli_query($koneksi, "UPDATE siswa SET nis='$nis',no_peserta='$nopes', id_kelas='$kelas',nama='$nama',sesi='$sesi',ruang='$ruang',username='$username',level='$level',server='$server',agama='$agama' WHERE id_siswa='$id'");
			}
		}
		jump("?pg=$pg");
	}
	?>
	<div class='row'>
		<div class='col-md-2'></div>
		<div class='col-md-7'>
			<form action='' method='post'>
				<div class='box box-success'>
					<div class='box-header with-border'>
						<h3 class='box-title'>Edit</h3>
						<div class='box-tools pull-right btn-group'>
							<button type='submit' name='submit' class='btn btn-sm btn-success'><i class='fa fa-check'></i> Simpan</button>
							<a href='?pg=<?= $pg ?>' class='btn btn-sm btn-danger' title='Batal'><i class='fa fa-times'></i></a>
						</div>
					</div><!-- /.box-header -->
					<div class='box-body'>
						<input type='hidden' name='idu' value="<?= $siswa['id_siswa'] ?>" />
						<div class='form-group'>
							<div class='row'>
								<div class='col-md-6'>
									<label>NIS</label>
									<input type='text' name='nis' class='form-control' value="<?= $siswa['nis'] ?>" required='true' />
								</div>
								<div class='col-md-6'>
									<label>Nomor Peserta</label>
									<input type='text' name='no_peserta' class='form-control' value="<?= $siswa['no_peserta'] ?>" required='true' />
								</div>
							</div>
						</div>
						<div class='form-group'>
							<label>Nama</label>
							<input type='text' name='nama' class='form-control' value="<?= $siswa['nama'] ?>" required='true' />
						</div>
						<div class='form-group'>
							<div class='row'>
								<div class='col-md-4'>
									<label>Kelas</label>
									<select name='id_kelas' class='form-control' required='true'>
										<option value=''></option>
										<?php
										$kelasQ = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama ASC");
										while ($kelas = mysqli_fetch_array($kelasQ)) {
											($kelas['id_kelas'] == $siswa['id_kelas']) ? $s = 'selected' : $s = '';
											echo "<option value='$kelas[id_kelas]' $s>$kelas[nama]</option>";
										}
										?>
									</select>
								</div>
								<div class='col-md-4'>
									<label>Level</label>
									<select name='level' class='form-control' required='true'>
										<option value=''></option>
										<?php
										$pkQ = mysqli_query($koneksi, "SELECT * FROM level ");
										while ($pk = mysqli_fetch_array($pkQ)) {
											($pk['kode_level'] == $siswa['level']) ? $s = 'selected' : $s = '';
											echo "<option value='$pk[kode_level]' $s>$pk[kode_level]</option>";
										}
										?>
									</select>
								</div>
								<?php if ($setting['jenjang'] == 'SMK') : ?>
									<div class='col-md-4'>
										<label>Jurusan</label>
										<select name='idpk' class='form-control' required='true'>
											<option value=''></option>
											<?php
											$pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
											while ($pk = mysqli_fetch_array($pkQ)) {
												($pk['id_pk'] == $siswa['idpk']) ? $s = 'selected' : $s = '';
												echo "<option value='$pk[id_pk]' $s>$pk[program_keahlian]</option>";
											}
											?>
										</select>
									</div>
								<?php endif ?>
							</div>
						</div>
						<div class='form-group'>
							<div class='row'>
								<div class='col-md-4'>
									<label>Sesi</label>
									<select name='idsesi' class='form-control' required='true'>
										<option value=''></option>
										<?php
										$sesiQ = mysqli_query($koneksi, "SELECT * FROM sesi ");
										while ($sesi = mysqli_fetch_array($sesiQ)) {
											($sesi['kode_sesi'] == $siswa['sesi']) ? $s = 'selected' : $s = '';
											echo "<option value='$sesi[kode_sesi]' $s>$sesi[kode_sesi]</option>";
										}
										?>
									</select>
								</div>
								<div class='col-md-4'>
									<label>Ruang</label>
									<select name='ruang' class='form-control' required='true'>
										<option value=''></option>
										<?php
										$pkQ = mysqli_query($koneksi, "SELECT * FROM ruang ");
										while ($pk = mysqli_fetch_array($pkQ)) {
											($pk['kode_ruang'] == $siswa['ruang']) ? $s = 'selected' : $s = '';
											echo "<option value='$pk[kode_ruang]' $s>$pk[kode_ruang]</option>";
										}
										?>
									</select>
								</div>
								<div class='col-md-4'>
									<label>Server</label>
									<select name='server' class='form-control' required='true'>
										<option value=''></option>
										<?php
										$pkQ = mysqli_query($koneksi, "SELECT * FROM server ");
										while ($sr = mysqli_fetch_array($pkQ)) {
											($sr['kode_server'] == $siswa['server']) ? $s = 'selected' : $s = '';
											echo "<option value='$sr[kode_server]' $s>$sr[kode_server]</option>";
										}
										?>
									</select>
								</div>
								<div class='col-md-4'>
									<label>Agama</label>
									<select name='agama' class='form-control' required='true'>
										<option value=''></option>
										<?php
										$agamaQ = mysqli_query($koneksi, "SELECT * FROM agama ");
										while ($agama = mysqli_fetch_array($agamaQ)) {
											($ag['agamaku'] == $siswa['agama']) ? $s = 'selected' : $s = '';
											echo "<option value='$ag[agamaku]' $s>$ag[agamaku]</option>";
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class='row'>
							<div class='col-md-6'>
								<div class='form-group'>
									<label>Username</label>
									<input type='text' name='username' class='form-control' value="<?= $siswa['username'] ?>" required='true' />
								</div>
							</div>
							<div class='col-md-6'>
								<div class='form-group'>
									<label>Agama</label>
									<input type='text' name='agama' class='form-control' value="<?= $siswa['agama'] ?>" required='true' />
								</div>
							</div>
						</div>
						<div class='form-group'>
							<div class='row'>
								<div class='col-md-6'>
									<label>Password</label>
									<input type='password' name='pass1' class='form-control' />
								</div>
								<div class='col-md-6'>
									<label>Ulang Password</label>
									<input type='password' name='pass2' class='form-control' />
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php elseif ($ac == 'hapussiswa') : ?>
	<?php
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$exec = mysqli_query($koneksi, "DELETE FROM siswa WHERE id_siswa='$id'");
		jump("?pg=$pg");
	}
	?>
<?php endif ?>

<script>
	$(document).ready(function() {
		var t = $('#tabelsiswa').DataTable({
			'ajax': 'datasiswa.php',
			'order': [
				[1, 'asc']
			],
			'columns': [{
					'data': null,
					'width': '10px',
					'sClass': 'text-center'
				},
				{
					'data': 'no_peserta'
				},
				{
					'data': 'nama'
				},
				{
					'data': 'level'
				},
				{
					'data': 'id_kelas'
				},
				<?php if ($setting['jenjang'] == 'SMK') : ?> {
						'data': 'idpk'
					},
				<?php endif; ?> {
					'data': 'sesi'
				},
				{
					'data': 'ruang'
				},
				{
					'data': 'username'
				},
				{
					'data': 'password'
				},
				{
					'data': 'server'
				},
				{
					'data': 'agama'
				},
				<?php if ($pengawas['level'] == 'admin') { ?>
					<?php if ($setting['server'] == 'pusat') { ?> {
							'data': 'id_siswa',
							'width': '60px',
							'sClass': 'text-center',
							'orderable': false,
							'mRender': function(data) {
								return '<a class="btn btn-flat btn-xs bg-yellow" href="?pg=siswa&ac=edit&id=' + data + '"><i class="fas fa-edit"></i></a>\n\
                                <a class="btn btn-flat btn-xs bg-maroon" href="?pg=siswa&ac=hapussiswa&id=' + data + '" onclick="javascript:return confirm(\'Anda yakin akan menghapus data ini?\');"><i class="fa fa-trash"></i></a>';
							}
						}
					<?php } ?>
				<?php } ?>
			]
		});
		t.on('order.dt search.dt', function() {
			t.column(0, {
				search: 'applied',
				order: 'applied'
			}).nodes().each(function(cell, i) {
				cell.innerHTML = i + 1;
			});
		}).draw();
	});
</script>