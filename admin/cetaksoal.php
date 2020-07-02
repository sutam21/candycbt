<?php
	require("../config/config.default.php");
	require("../config/config.function.php");
	require("../config/functions.crud.php");
	require("../config/dis.php");
	
	(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:login.php'):null;
	$id_mapel = $_GET['id'];
	
	$pengawas = fetch($koneksi, 'pengawas',array('id_pengawas'=>$id_pengawas));
	$mapel=mysqli_fetch_array(mysqli_query($koneksi, "select * from mapel where id_mapel='$id_mapel'"));
	if($mapel['idpk']=='0'){
		$jurusan='Semua Jurusan';
	}else{
		$jurusan=$mapel['idpk'];
	}
	$guru = fetch($koneksi, 'pengawas',array('id_pengawas'=>$mapel['idguru']));
	$namasekolah=fetch($koneksi, 'setting');
	if(date('m')>=7 AND date('m')<=12) {
		$ajaran = date('Y')."/".(date('Y')+1);
	}
	elseif(date('m')>=1 AND date('m')<=6) {
		$ajaran = (date('Y')-1)."/".date('Y');
	}
	echo "
		<!DOCTYPE html>
		<html>
			<head>
				<title>	Print Soal</title>
				<style>
					* { margin:auto; padding:0; line-height:100%; }
					
					td { padding:1px 3px 1px 3px; }
					.garis { border:1px solid #000; border-left:0px; border-right:0px; padding:1px; margin-top:5px; margin-bottom:5px; }
				</style>
			</head>
			<body>
				
			<table  >
			<tr>
			<td rowspan='5'>
				<img src='$homeurl/$setting[logo]' width='90px'/>
			</td>
			<td width=200>Mata Pelajaran </td>
			<td width=200>: $mapel[nama] </td> 
			<td rowspan='5' width=300></td>					
			</tr>
			<tr>
				<td>Tingkat | Jurusan </td>
				<td>: $mapel[level] | $jurusan </td>
			</tr>
			<tr>
				<td>Pembuat Soal</td>
				<td>: $guru[nama]</td>
			</tr>
			<tr>
				<td>Satuan Pendidikan</td>
				<td>: $namasekolah[sekolah]</td>
			</tr>
			</table>
			
				<div class='garis'></div>
				<br/>
				<h3 class='panel-title'>
				<b>A. Soal Pilihan Ganda</b>
				</h3>
				<br/>
				
				";
			
			$nomer = 1;
			$sql = mysqli_query($koneksi, "SELECT * FROM soal where id_mapel=$id_mapel and jenis='1' order by nomor");			
			while($sp = mysqli_fetch_array($sql))
			{
			
				$Jawab1 = str_replace("<p>","",$sp['pilA']);
				$Jawab1 = str_replace("</p>","",$Jawab1);		
				$Jawab1 = str_replace("<span>","",$Jawab1);	
				$Jawab1 = str_replace("</span>","",$Jawab1);
				$Jawab1 = str_replace("<br /><br />","",$Jawab1);
									
				$Jawab2 = str_replace("<p>","",$sp['pilB']);
				$Jawab2 = str_replace("</p>","",$Jawab2);		
				$Jawab2 = str_replace("<span>","",$Jawab2);	
				$Jawab2 = str_replace("</span>","",$Jawab2);
				$Jawab2 = str_replace("<br /><br />","",$Jawab2);
									
				$Jawab3 = str_replace("<p>","",$sp['pilC']);
				$Jawab3 = str_replace("</p>","",$Jawab3);		
				$Jawab3 = str_replace("<span>","",$Jawab3);	
				$Jawab3 = str_replace("</span>","",$Jawab3);
				$Jawab3 = str_replace("<br /><br />","",$Jawab3);									
									
				$Jawab4 = str_replace("<p>","",$sp['pilD']);
				$Jawab4 = str_replace("</p>","",$Jawab4);		
				$Jawab4 = str_replace("<span>","",$Jawab4);	
				$Jawab4 = str_replace("</span>","",$Jawab4);
				$Jawab4 = str_replace("<br /><br />","",$Jawab4);
									
				$Jawab5 = str_replace("<p>","",$sp['pilE']);
				$Jawab5 = str_replace("</p>","",$Jawab5);		
				$Jawab5 = str_replace("<span>","",$Jawab5);	
				$Jawab5 = str_replace("</span>","",$Jawab5);
				$Jawab5 = str_replace("<br /><br />","",$Jawab5);
			
				$soalnye=$sp['soal'];		
				$soalnye = str_replace("<span >","",$soalnye);	
				$soalnye = str_replace("</span>","",$soalnye);
				$soalnye = str_replace("`","'",$soalnye);
				$soalnye = str_replace("<p>&nbsp;</p>","",$soalnye);	
				echo "	
					<table width=100% border=0>
					<tr>
					<td width=30px valign=top><p>$nomer</p></td>
					<td valign=top>
					";
																if($sp['file']<>'') {
																		$audio = array('mp3','wav','ogg','MP3','WAV','OGG');
																		$image = array('jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP');
																		$ext = explode(".",$sp['file']);
																		$ext = end($ext);
																		if(in_array($ext,$image)) {
																			echo "
																				
																				<img src='$homeurl/files/$sp[file]' style='max-width:200px;'/>
																			";
																		}
																		elseif(in_array($ext,$audio)) {
																			echo "
																				
																				<audio controls><source src='$homeurl/files/$sp[file]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
																			";
																		} else {
																			echo "File tidak didukung!";
																		}
																		
																}
																if($sp['file1']<>'') {
																		$audio = array('mp3','wav','ogg','MP3','WAV','OGG');
																		$image = array('jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP');
																		$ext = explode(".",$sp['file1']);
																		$ext = end($ext);
																		if(in_array($ext,$image)) {
																			echo "
																				
																				<img src='$homeurl/files/$sp[file1]' style='max-width:200px;'/>
																			";
																		}
																		elseif(in_array($ext,$audio)) {
																			echo "
																				
																				<audio controls><source src='$homeurl/files/$sp[file1]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
																			";
																		} else {
																			echo "File tidak didukung!";
																		}
																} 
																echo "
					<p>$soalnye</td>						
					</tr>
					</table>";
				if(!$Jawab1=="")
				{ 
				echo "
					<table width=100% border=0>
					<tr>											
						<td width=30px valign=top>&nbsp;</td>
						<td width=4px valign=top>A.</td>
						<td width=300px colspan=2 valign=top> 
						$Jawab1 <br>";
																if($sp['fileA']<>'') {
																		$audio = array('mp3','wav','ogg','MP3','WAV','OGG');
																		$image = array('jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP');
																		$ext = explode(".",$sp['fileA']);
																		$ext = end($ext);
																		if(in_array($ext,$image)) {
																			echo "
																				
																				<img src='$homeurl/files/$sp[fileA]' style='max-width:100px;'/>
																			";
																		}
																		elseif(in_array($ext,$audio)) {
																			echo "
																				
																				<audio controls><source src='$homeurl/files/$sp[fileA]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
																			";
																		} else {
																			echo "File tidak didukung!";
																		}
																		
																}
						echo "
						</td>
										
						<td width=30px valign=top>&nbsp;</td>
						<td width=4px valign=top>C.</td>
						<td width=300px colspan=2 valign=top>
						$Jawab3  <br>";
																if($sp['fileC']<>'') {
																		$audio = array('mp3','wav','ogg','MP3','WAV','OGG');
																		$image = array('jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP');
																		$ext = explode(".",$sp['fileC']);
																		$ext = end($ext);
																		if(in_array($ext,$image)) {
																			echo "
																				
																				<img src='$homeurl/files/$sp[fileC]' style='max-width:100px;'/>
																			";
																		}
																		elseif(in_array($ext,$audio)) {
																			echo "
																				
																				<audio controls><source src='$homeurl/files/$sp[fileC]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
																			";
																		} else {
																			echo "File tidak didukung!";
																		}
																		
																}
						echo "
						
						</td>";
							if($mapel['opsi']==5){		
						echo "
						<td width=30px valign=top>&nbsp;</td>
						<td width=4px valign=top>E.</td>
						<td width=300px colspan=2 valign=top>
						$Jawab5 <br>";
																if($sp['fileE']<>'') {
																		$audio = array('mp3','wav','ogg','MP3','WAV','OGG');
																		$image = array('jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP');
																		$ext = explode(".",$sp['fileE']);
																		$ext = end($ext);
																		if(in_array($ext,$image)) {
																			echo "
																				
																				<img src='$homeurl/files/$sp[fileE]' style='max-width:100px;'/>
																			";
																		}
																		elseif(in_array($ext,$audio)) {
																			echo "
																				
																				<audio controls><source src='$homeurl/files/$sp[fileE]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
																			";
																		} else {
																			echo "File tidak didukung!";
																		}
																		
																}
						echo "
						</td>";
							}
						echo "
										    
						</tr>
						<tr>
						<td width=30px>&nbsp;</td>
						<td width=4px valign=top>B.&nbsp;</td>
						<td width=300px colspan=2>
						$Jawab2 <br>";
																if($sp['fileB']<>'') {
																		$audio = array('mp3','wav','ogg','MP3','WAV','OGG');
																		$image = array('jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP');
																		$ext = explode(".",$sp['fileB']);
																		$ext = end($ext);
																		if(in_array($ext,$image)) {
																			echo "
																				
																				<img src='$homeurl/files/$sp[fileB]' style='max-width:100px;'/>
																			";
																		}
																		elseif(in_array($ext,$audio)) {
																			echo "
																				
																				<audio controls><source src='$homeurl/files/$sp[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
																			";
																		} else {
																			echo "File tidak didukung!";
																		}
																		
																}
						echo "
						</td>
						";
						if($mapel['opsi']<>3){
						echo "
						<td width=30px>&nbsp;</td>
						<td width=4px valign=top>D.</td>
						<td width=300px colspan=2>
						$Jawab4 <br>";
																if($sp['fileD']<>'') {
																		$audio = array('mp3','wav','ogg','MP3','WAV','OGG');
																		$image = array('jpg','jpeg','png','gif','bmp','JPG','JPEG','PNG','GIF','BMP');
																		$ext = explode(".",$sp['fileD']);
																		$ext = end($ext);
																		if(in_array($ext,$image)) {
																			echo "
																				
																				<img src='$homeurl/files/$sp[fileD]' style='max-width:100px;'/>
																			";
																		}
																		elseif(in_array($ext,$audio)) {
																			echo "
																				
																				<audio controls><source src='$homeurl/files/$sp[fileD]' type='audio/$ext'>Your browser does not support the audio tag.</audio>
																			";
																		} else {
																			echo "File tidak didukung!";
																		}
																		
																}
						echo "
						</td>";
						}
						echo "
						</tr>
						</table>
						";
				}
				$nomer++;
			}
			echo" <br>
			<h3 class='panel-title'>
				<b>B. Soal Essai</b>
				</h3>";
			$sql = mysqli_query($koneksi, "SELECT * FROM soal where id_mapel=$id_mapel and jenis='2' order by nomor");	
			$nomer=1;
			while($sp = mysqli_fetch_array($sql))
			{
				$soalnye=$sp['soal'];		
				$soalnye = str_replace("<span >","",$soalnye);	
				$soalnye = str_replace("</span>","",$soalnye);
				$soalnye = str_replace("`","'",$soalnye);
				$soalnye = str_replace("<p>&nbsp;</p>","",$soalnye);	
				echo "	
					<table width=100% border=0>
					<tr>
					<td width=30px valign=top><p>$nomer</p></td>
					<td valign=top><p>$soalnye</td>						
					</tr>
					</table>";
				
				$nomer++;
			}
			
				
			    		
?>
