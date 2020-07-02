<?php
require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
require("../config/excel_reader2.php");

$file = $_FILES['file']['name'];
$temp = $_FILES['file']['tmp_name'];
$ext = explode('.', $file);
$ext = end($ext);
if ($ext <> 'xls') {
	$info = info('Gunakan file Ms. Excel 93-2007 Workbook (.xls)', 'NO');
} else {
	$data = new Spreadsheet_Excel_Reader($temp);
	$hasildata = $data->rowcount($sheet_index = 0);
	$sukses = $gagal = 0;
	$exec = mysqli_query($koneksi, "TRUNCATE siswa");
	for ($i = 2; $i <= $hasildata; $i++) {
		$id_siswa = $data->val($i, 1);
		$nis = $data->val($i, 2);
		$no_peserta = $data->val($i, 3);
		$nama = $data->val($i, 4);
		$nama = addslashes($nama);
		$level = str_replace(' ', '', $data->val($i, 5));
		$kelas = str_replace(' ', '', $data->val($i, 6));
		if ($setting['jenjang'] == 'SMK') {
			$pk = str_replace(' ', '', $data->val($i, 7));
			$sesi = str_replace(' ', '', $data->val($i, 8));
			$ruang = str_replace(' ', '', $data->val($i, 9));
			$username = $data->val($i, 10);
			$username = str_replace("'", "", $username);
			$username = str_replace("-", "", $username);
			$password = $data->val($i, 11);
			$foto = $data->val($i, 12);
		} else {
			$pk = "semua";
			$sesi = str_replace(' ', '', $data->val($i, 7));
			$ruang = str_replace(' ', '', $data->val($i, 8));
			$username = $data->val($i, 9);
			$username = str_replace("'", "", $username);
			$username = str_replace("-", "", $username);
			$password = $data->val($i, 10);
			$foto = $data->val($i, 11);
		}
		$qkelas = mysqli_query($koneksi, "SELECT id_kelas FROM kelas WHERE id_kelas='$kelas'");
		$cekkelas = mysqli_num_rows($qkelas);
		if (!$cekkelas <> 0) {
			$exec = mysqli_query($koneksi, "INSERT INTO kelas (id_kelas,level,nama)VALUES('$kelas','$level','$kelas')");
		}
		if ($setting['jenjang'] == 'SMK') {
			$qpk = mysqli_query($koneksi, "SELECT id_pk FROM pk WHERE id_pk='$pk'");
			$cekpk = mysqli_num_rows($qpk);
			if (!$cekpk <> 0) {
				$exec = mysqli_query($koneksi, "INSERT INTO pk (id_pk,program_keahlian)VALUES('$pk','$pk')");
			}
		}
		$qlevel = mysqli_query($koneksi, "SELECT kode_level FROM level WHERE kode_level='$level'");
		$ceklevel = mysqli_num_rows($qlevel);
		if (!$ceklevel <> 0) {
			$exec = mysqli_query($koneksi, "INSERT INTO level (kode_level,keterangan)VALUES('$level','$level')");
		}
		$qruang = mysqli_query($koneksi, "SELECT kode_ruang FROM ruang WHERE kode_ruang='$ruang'");
		$cekruang = mysqli_num_rows($qruang);
		if (!$cekruang <> 0) {
			$exec = mysqli_query($koneksi, "INSERT INTO ruang (kode_ruang,keterangan)VALUES('$ruang','$ruang')");
		}
		$qsesi = mysqli_query($koneksi, "SELECT kode_sesi FROM sesi WHERE kode_sesi='$sesi'");
		$ceksesi = mysqli_num_rows($qsesi);
		if (!$ceksesi <> 0) {
			$exec = mysqli_query($koneksi, "INSERT INTO sesi (kode_sesi,nama_sesi)VALUES('$sesi','$sesi')");
		}

		$exec = mysqli_query($koneksi, "INSERT INTO siswa (id_siswa,id_kelas,idpk,nis,no_peserta,nama,level,sesi,ruang,username,password,foto) VALUES ('$id_siswa','$kelas','$pk','$nis','$no_peserta','$nama','$level','$sesi','$ruang','$username','$password','$foto')");

		($exec) ? $sukses++ : $gagal++;
	}
	$total = $hasildata - 1;
	$info = info("Berhasil: $sukses | Gagal: $gagal | Dari: $total", 'OK');
}
echo "Berhasil: $sukses | Gagal: $gagal | Dari: $total";
