<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
if (isset($_POST['submit'])) {
	$ruang = str_replace(' ', '', $_POST['ruang']);
	$ket = $_POST['keterangan'];

	$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM ruang WHERE kode_ruang='$ruang'"));
	if ($cek > 0) {
		$info = info("ruang atau tingkat $ruang sudah ada!", "NO");
	} else {
		$exec = mysqli_query($koneksi, "INSERT INTO ruang (kode_ruang,keterangan) VALUES ('$ruang','$ket')");
		if (!$exec) {
			$info = info("Gagal menyimpan!", "NO");
		} else {
			jump("?pg=$pg");
		}
	}
}

echo "
								<div class='row'>
									<div class='col-md-12'>
										<div class='box box-solid'>
											<div class='box-header with-border'>
												<h3 class='box-title'>Tambah Ruang Ujian</h3>
												<div class='box-tools pull-right'>
												<button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#tambahruang'><i class='fa fa-check'></i> Tambah Ruang</button>
												</div>
											</div><!-- /.box-header -->
											<div class='box-body'>
												<table id='tableruang' class='table table-bordered table-striped'>
													<thead>
														<tr>
															<th width='5px'>#</th>
															
															<th >Kode Ruangan</th>
															<th >Nama Ruangan</th>
															
														</tr>
													</thead>
													<tbody>";
$ruanginQ = mysqli_query($koneksi, "SELECT * FROM ruang ");
while ($ruang = mysqli_fetch_array($ruanginQ)) {
	$no++;

	echo "
															<tr>
																<td>$no</td>
																
																<td>$ruang[kode_ruang]</td>
																<td>$ruang[keterangan]</td>
																
															</tr>
														";
}
echo "
													</tbody>
												</table>
											</div><!-- /.box-body -->
										</div><!-- /.box -->
									</div>
									<div class='modal fade' id='tambahruang' style='display: none;'>
										<div class='modal-dialog'>
											<div class='modal-content'>
												<div class='modal-header bg-blue'>
												<button  class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
													<h3 class='modal-title'>Tambah Ruang</h3>
												</div>
												<div class='modal-body'>
													<form action='' method='post'>
														<div class='form-group'>
															<label>Kode Ruang</label>
															<input type='text' name='ruang' class='form-control'  required='true'/>
														</div>
														<div class='form-group'>
															<label>Nama Ruang</label>
															<input type='text' name='keterangan'  class='form-control' required='true'/>
														</div>
													<div class='modal-footer'>
															<div class='box-tools pull-right btn-group'>
																<button type='submit' name='submit' class='btn btn-sm btn-success'><i class='fa fa-check'></i> Simpan</button>
																<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
															</div>
													</div>
													</form>
												</div>
											</div>					
										</div>											
									</div>
									
								</div>
							";
