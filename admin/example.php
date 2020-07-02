<?php
require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
// Basic example of PHP script to handle with jQuery-Tabledit plug-in.
// Note that is just an example. Should take precautions such as filtering the input data.

header('Content-Type: application/json');
if (isset($_GET['pg'])) {

	$input = filter_input_array(INPUT_POST);
	$pg = $_GET['pg'];
	if ($pg == 'jurusan') {
		if ($input['action'] === 'edit') {
			mysqli_query($koneksi, "UPDATE pk SET program_keahlian='" . $input['namajurusan'] . "' WHERE id_pk='" . $input['id'] . "'");
		} else if ($input['action'] === 'delete') {
			mysqli_query($koneksi, "delete from  pk WHERE id_pk='" . $input['id'] . "'");
		}
	}
	if ($pg == 'jenisujian') {
		if ($input['action'] === 'edit') {
			if ($input['status'] == "aktif") {
				$namaujian = $input['namajenis'];
				mysqli_query($koneksi, "UPDATE jenis SET status='tidak'");
				mysqli_query($koneksi, "UPDATE jenis SET nama='" . $input['namajenis'] . "', status='" . $input['status'] . "' WHERE id_jenis='" . $input['id'] . "'");
				mysqli_query($koneksi, "UPDATE setting SET nama_ujian='$namaujian'");
			} else {
				mysqli_query($koneksi, "UPDATE jenis SET nama='" . $input['namajenis'] . "', status='" . $input['status'] . "' WHERE id_jenis='" . $input['id'] . "'");
			}
		} else if ($input['action'] === 'delete') {
			mysqli_query($koneksi, "DELETE FROM jenis WHERE id_jenis='" . $input['id'] . "'");
		}
	}
	if ($pg == 'level') {
		if ($input['action'] === 'edit') {
			mysqli_query($koneksi, "UPDATE level SET keterangan='" . $input['namalevel'] . "' WHERE kode_level='" . $input['id'] . "'");
		} else if ($input['action'] === 'delete') {
			mysqli_query($koneksi, "delete from  level WHERE kode_level='" . $input['id'] . "'");
		}
	}

	if ($pg == 'kelas') {
		if ($input['action'] === 'edit') {
			mysqli_query($koneksi, "UPDATE kelas SET nama='" . $input['namakelas'] . "', level='" . $input['level'] . "' WHERE id_kelas='" . $input['id'] . "'");
		} else if ($input['action'] === 'delete') {
			mysqli_query($koneksi, "delete from  kelas WHERE id_kelas='" . $input['id'] . "'");
		}
	}

	if ($pg == 'mapel') {
		if ($input['action'] === 'edit') {
			mysqli_query($koneksi, "UPDATE mata_pelajaran SET nama_mapel='" . $input['namamapel'] . "' WHERE kode_mapel='" . $input['id'] . "'");
		} else if ($input['action'] === 'delete') {
			mysqli_query($koneksi, "delete from  mata_pelajaran WHERE kode_mapel='" . $input['id'] . "'");
		}
	}
	if ($pg == 'ruang') {
		if ($input['action'] === 'edit') {
			mysqli_query($koneksi, "UPDATE ruang SET keterangan='" . $input['namaruang'] . "' WHERE kode_ruang='" . $input['id'] . "'");
		} else if ($input['action'] === 'delete') {
			mysqli_query($koneksi, "delete from ruang WHERE kode_ruang='" . $input['id'] . "'");
		}
	}
	if ($pg == 'sesi') {
		if ($input['action'] === 'edit') {
			mysqli_query($koneksi, "UPDATE sesi SET nama_sesi='" . $input['namasesi'] . "' WHERE kode_sesi='" . $input['id'] . "'");
		} else if ($input['action'] === 'delete') {
			mysqli_query($koneksi, "delete from sesi WHERE kode_sesi='" . $input['id'] . "'");
		}
	}
}
echo json_encode($input);
