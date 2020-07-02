<?php
require("../config/config.default.php");
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:login.php') : null;

function &backup_tables($host, $user, $pass, $name, $tables = '*')
{

	$data = "\n/*---------------------------------------------------------------" .
		"\n  SQL DB BACKUP " . date("d.m.Y H:i") . " " .
		"\n  HOST: {$host}" .
		"\n  DATABASE: {$name}" .
		"\n  TABLES: {$tables}" .
		"\n  ---------------------------------------------------------------*/\n";
	$con = mysqli_connect($host, $user, $pass);
	mysqli_select_db($con, $name);
	mysqli_query($con,  "SET NAMES `utf8` COLLATE `utf8_general_ci`"); // Unicode

	if ($tables == '*') {
		$tables = array();
		$result = mysqli_query($con, "SHOW TABLES");
		while ($row = mysqli_fetch_row($result)) {
			$tables[] = $row[0];
		}
	} else {
		$tables = is_array($tables) ? $tables : explode(',', $tables);
	}

	foreach ($tables as $table) {
		$data .= "\n/*---------------------------------------------------------------" .
			"\n  TABLE: `{$table}`" .
			"\n  ---------------------------------------------------------------*/\n";
		$data .= "DROP TABLE IF EXISTS `{$table}`;\n";
		$res = mysqli_query($con, "SHOW CREATE TABLE `{$table}`");
		$row = mysqli_fetch_row($res);
		$data .= $row[1] . ";\n";

		$result = mysqli_query($con, "SELECT * FROM `{$table}`");
		$num_rows = mysqli_num_rows($result);

		if ($num_rows > 0) {
			$vals = array();
			$z = 0;
			for ($i = 0; $i < $num_rows; $i++) {
				$items = mysqli_fetch_row($result);
				$vals[$z] = "(";
				for ($j = 0; $j < count($items); $j++) {
					if (isset($items[$j])) {
						$vals[$z] .= "'" . mysqli_real_escape_string($con, $items[$j]) . "'";
					} else {
						$vals[$z] .= "NULL";
					}
					if ($j < (count($items) - 1)) {
						$vals[$z] .= ",";
					}
				}
				$vals[$z] .= ")";
				$z++;
			}
			$data .= "INSERT INTO `{$table}` VALUES ";
			$data .= "  " . implode(";\nINSERT INTO `{$table}` VALUES ", $vals) . ";\n";
		}
	}

	mysqli_close($con);
	return $data;
}

if (!file_exists('backup')) {
	mkdir('backup', 0777, true);
}

$tabel = "*";
$backup_file = 'backup/candycbt_' . time() . '.sql';
$mybackup = backup_tables($host, $user, $pass, $debe, $tabel);

// save to file
$handle = fopen($backup_file, 'w+');
fwrite($handle, $mybackup);
fclose($handle);

?>
<div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	Database <?= $tabel; ?> telah di Backup<br />
	silahkan untuk mendownload database klik
	<a href="<?= $backup_file ?>"><button class="btn btn-danger"> download database</button></a>
</div>