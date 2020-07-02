<?php
	require("../config/config.default.php");
	require("../config/config.function.php");
	require("../config/functions.crud.php");
	require("../config/dis.php");
	(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:login.php'):null;
	$id_mapel = $_GET['m'];
	$mapel = fetch($koneksi, 'mapel',array('id_mapel'=>$id_mapel));
	if(date('m')>=7 AND date('m')<=12) {
		$ajaran = date('Y')."/".(date('Y')+1);
	}
	elseif(date('m')>=1 AND date('m')<=6) {
		$ajaran = (date('Y')-1)."/".date('Y');
	}
	$file = "SOAL_".$mapel['nama'];
	$file = str_replace(" ","-",$file);
	$file = str_replace(":","",$file);
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8");
	header("Pragma: no-cache");
	header("Expires: 0");
	header("Content-Disposition: attachment; filename=".$file.".xls");
	header("Cache-Control: max-age=0");
	echo "
		
		<table border='1'>
			<tr>
				<td >No.</td>
				<td  width='500px'>Soal</td>
				<td >jenis</td>
				<td >pilA</td>
				<td >pilB</td>
				<td >pilC</td>
				<td >pilD</td>
				<td >pilE</td>
				<td >file</td>
				<td >file1</td>
				<td >fileA</td>
				<td >fileB</td>
				<td >fileC</td>
				<td >fileD</td>
				<td >fileE</td>
				<td >jawaban</td>
				
				
			</tr>";
				
			$soal = select($koneksi, 'soal',array('id_mapel'=>$id_mapel));
			foreach($soal as $soal) {
				$no++;
				$soaltanya=strip_tags($soal['soal']);
				$jenis=strip_tags($soal['jenis']);
				$pilA=strip_tags($soal['pilA']);
				$pilB=strip_tags($soal['pilB']);
				$pilC=strip_tags($soal['pilC']);
				$pilD=strip_tags($soal['pilD']);
				$pilE=strip_tags($soal['pilE']);
				$file=strip_tags($soal['file']);
				$file1=strip_tags($soal['file1']);
				$fileA=strip_tags($soal['fileA']);
				$fileB=strip_tags($soal['fileB']);
				$fileC=strip_tags($soal['fileC']);
				$fileD=strip_tags($soal['fileD']);
				$fileE=strip_tags($soal['fileE']);
				echo "
					<tr>
						<td>$no</td>
						<td>$soaltanya</td>
						<td>$jenis</td>
						<td>$pilA</td>
						<td>$pilB</td>
						<td>$pilC</td>
						<td>$pilD</td>
						<td>$pilE</td>
						<td>$file</td>
						<td>$file1</td>
						<td>$fileA</td>
						<td>$fileB</td>
						<td>$fileC</td>
						<td>$fileD</td>
						<td>$fileE</td>
						<td>$soal[jawaban]</td>
					</tr>
				";
			}
			echo "
		</table>
	";
	exit;
?>