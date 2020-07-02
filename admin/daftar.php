<?php
	require("../config/config.default.php");
	require("../config/config.function.php");
	require("../config/dis.php");
	
	if(isset($_POST['submit'])){	
		$npsn = enkripsi($_POST['npsn']);
		$ns = enkripsi($_POST['ns']);
		$alamat = $_POST['alamat'];

		$select=mysqli_query($koneksi, "select * from syskey where npsn = '$npsn'");
		if($select >= 1){
			$cek = mysqli_query($koneksi, "insert into school (npsn,ns,alamat) values ('$npsn','$ns','$alamat')");
			$npsn = enkripsi($_POST['npsn']);
			if($cek >= 1){
				?><script language="javascript"> alert('Sekolah anda berhasil Teregistrasi'); document.location='index.php';</script><?php
			}else{
				$dl = mysqli_query($koneksi, "TRUNCATE school");
				?><script language="javascript"> alert('Gagal Meregistasi Sekolah'); document.location='daftar.php';</script><?php
			}
		}else{ ?><script language="javascript"> alert('Sekolah Anda Belum Terdaftar, Silahkan Hubungi ICT MKKSMK'); document.location='daftar.php';</script><?php }

}

?>

<!DOCTYPE html>
		<html>
			<head>
				<meta charset='utf-8'/>
				<meta http-equiv='X-UA-Compatible' content='IE=edge'/>
				<title>School Registration</title>
				<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'/>
				<link rel='stylesheet' href='../dist/css/bootstrap.min.css'/>
				<link rel='stylesheet' href='../plugins/font-awesome-4.4.0/css/font-awesome.min.css'/>
				<link rel='stylesheet' href='../dist/css/AdminLTE.min.css'/>
				<link rel='stylesheet' href='../dist/css/skins/skin-blue.min.css'/>
				<!--[if lt IE 9]>
				<script src='//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js'></script>
				<script src='//oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
				<![endif]-->
			</head>
			<body class='hold-transition login-page'>
				<div class='login-box'>
					<div class='login-logo'>
						<a href='$homeurl'><b>Registrasi Sekolah</b></a>
					</div><!-- /.login-logo -->
					<div class='login-box-body'>
						<form action='' method='post'>
							<div class='form-group'>
								<label>NPSN</label>
									<input type='text' name='npsn' class='form-control' required='true'/>
							</div>
							<div class='form-group'>
								<label>Nama Sekolah</label>
									<input type='text' name='ns' class='form-control' required='true'/>
							</div>
							<div class='form-group'>
								<label>Alamat</label>
									<input type='text' name='alamat' class='form-control' required='true'/>
							</div>
							<div class='row'>
								<div class='col-xs-7'>
								<!--	$info -->
								</div><!-- /.col -->
								<div class='col-xs-5'>
									<button type='submit' name='submit' class='btn btn-primary btn-block btn-flat'><i class='fa fa-sign-in margin-r-5'></i> Registasi</button>
								</div><!-- /.col -->
							</div>
						</form>

					</div><!-- /.login-box-body -->
				</div><!-- /.login-box -->

				<script src='$homeurl/plugins/jQuery/jQuery-2.1.4.min.js'></script>
				<script src='$homeurl/dist/js/bootstrap.min.js'></script>
			</body>
		</html>