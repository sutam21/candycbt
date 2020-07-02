<?php
require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
// Basic example of PHP script to handle with jQuery-Tabledit plug-in.
// Note that is just an example. Should take precautions such as filtering the input data.
$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {
	$update_field = '';
	if (isset($input['nis'])) {
		$update_field .= "nis='" . $input['nis'] . "'";
	} else if (isset($input['nopes'])) {
		$update_field .= "no_peserta='" . $input['nopes'] . "'";
	} else if (isset($input['nama'])) {
		$update_field .= "nama='" . $input['nama'] . "'";
	} else if (isset($input['level'])) {
		$update_field .= "level='" . $input['level'] . "'";
	} else if (isset($input['kelas'])) {
		$update_field .= "id_kelas='" . $input['kelas'] . "'";
	} else if (isset($input['jurusan'])) {
		$update_field .= "idpk='" . $input['jurusan'] . "'";
	} else if (isset($input['sesi'])) {
		$update_field .= "sesi='" . $input['sesi'] . "'";
	} else if (isset($input['username'])) {
		$update_field .= "username='" . $input['username'] . "'";
	} else if (isset($input['password'])) {
		$update_field .= "password='" . $input['password'] . "'";
	}
	if ($update_field && $input['id']) {
		$exec = mysqli_query($koneksi, "UPDATE siswa SET $update_field WHERE id_siswa='" . $input['id'] . "'");
	}
} else if ($input['action'] === 'delete') {
	$exec = mysqli_query($koneksi, "DELETE FROM siswa WHERE id_siswa='" . $input['id'] . "'");
}
