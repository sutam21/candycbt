<?php
function url_exists($url)
{
	$result = false;
	$url = filter_var($url, FILTER_VALIDATE_URL);

	/* Open curl connection */
	$handle = curl_init($url);

	/* Set curl parameter */
	curl_setopt_array($handle, array(
		CURLOPT_FOLLOWLOCATION => TRUE,     // we need the last redirected url
		CURLOPT_NOBODY => TRUE,             // we don't need body
		CURLOPT_HEADER => FALSE,            // we don't need headers
		CURLOPT_RETURNTRANSFER => FALSE,    // we don't need return transfer
		CURLOPT_SSL_VERIFYHOST => FALSE,    // we don't need verify host
		CURLOPT_SSL_VERIFYPEER => FALSE     // we don't need verify peer
	));

	/* Get the HTML or whatever is linked in $url. */
	$response = curl_exec($handle);

	$httpCode = curl_getinfo($handle, CURLINFO_EFFECTIVE_URL);  // Try to get the last url
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);      // Get http status from last url

	/* Check for 200 (file is found). */
	if ($httpCode == 200) {
		$result = true;
	}

	return $result;

	/* Close curl connection */
	curl_close($handle);
}
function multiple_download($urls, $save_path = '../files')
{
	$multi_handle = curl_multi_init();
	$file_pointers = [];
	$curl_handles = [];
	// Add curl multi handles, one per file we don't already have
	foreach ($urls as $key => $url) {
		//if (url_exists($url)) {
		$file = $save_path . '/' . basename($url);
		if (!is_file($file)) {
			$curl_handles[$key] = curl_init($url);
			$file_pointers[$key] = fopen($file, "w");
			curl_setopt($curl_handles[$key], CURLOPT_FILE, $file_pointers[$key]);
			curl_setopt($curl_handles[$key], CURLOPT_HEADER, 0);
			curl_setopt($curl_handles[$key], CURLOPT_CONNECTTIMEOUT, 60);
			curl_multi_add_handle($multi_handle, $curl_handles[$key]);
		}
		//}
	}
	// Download the files
	do {
		curl_multi_exec($multi_handle, $running);
	} while ($running > 0);
	// Free up objects
	// foreach ($urls as $key => $url) {
	// 	curl_multi_remove_handle($multi_handle, $curl_handles[$key]);
	// 	curl_close($curl_handles[$key]);
	// 	fclose($file_pointers[$key]);
	// }
	curl_multi_close($multi_handle);
}
function http_request($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}
function getBrowser()
{
	$u_agent = $_SERVER['HTTP_USER_AGENT'];
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version = "";

	//First get the platform?
	if (preg_match('/linux/i', $u_agent)) {
		$platform = 'linux';
	} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
		$platform = 'mac';
	} elseif (preg_match('/windows|win32/i', $u_agent)) {
		$platform = 'windows';
	}

	// Next get the name of the useragent yes seperately and for good reason
	if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
		$bname = 'Internet Explorer';
		$ub = "MSIE";
	} elseif (preg_match('/Firefox/i', $u_agent)) {
		$bname = 'Mozilla Firefox';
		$ub = "Firefox";
	} elseif (preg_match('/OPR/i', $u_agent)) {
		$bname = 'Opera';
		$ub = "Opera";
	} elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
		$bname = 'Google Chrome';
		$ub = "Chrome";
	} elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
		$bname = 'Apple Safari';
		$ub = "Safari";
	} elseif (preg_match('/Netscape/i', $u_agent)) {
		$bname = 'Netscape';
		$ub = "Netscape";
	} elseif (preg_match('/Edge/i', $u_agent)) {
		$bname = 'Edge';
		$ub = "Edge";
	} elseif (preg_match('/Trident/i', $u_agent)) {
		$bname = 'Internet Explorer';
		$ub = "MSIE";
	}

	// finally get the correct version number
	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	if (!preg_match_all($pattern, $u_agent, $matches)) {
		// we have no matching number just continue
	}
	// see how many we have
	$i = count($matches['browser']);
	if ($i != 1) {
		//we will have two since we are not using 'other' argument yet
		//see if version is before or after the name
		if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
			$version = $matches['version'][0];
		} else {
			$version = $matches['version'][1];
		}
	} else {
		$version = $matches['version'][0];
	}

	// check if we have a number
	if ($version == null || $version == "") {
		$version = "?";
	}

	return array(
		'userAgent' => $u_agent,
		'name'      => $bname,
		'version'   => $version,
		'platform'  => $platform,
		'pattern'    => $pattern
	);
}
function enkripsi($string)
{
	$output = false;

	$encrypt_method = "AES-256-CBC";
	$secret_key = 'abcdefghijklmnopqrstuvwxyzABNCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+|}{:?><';
	$secret_iv = 'abcdefghijklmnopqrstuvwxyzABNCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+|}{:?><';

	// hash
	$key = hash('sha256', $secret_key);

	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	$output = base64_encode($output);

	return $output;
}

function dekripsi($string)
{
	$output = false;

	$encrypt_method = "AES-256-CBC";
	$secret_key = 'abcdefghijklmnopqrstuvwxyzABNCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+|}{:?><';
	$secret_iv = 'abcdefghijklmnopqrstuvwxyzABNCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+|}{:?><';

	// hash
	$key = hash('sha256', $secret_key);

	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

	return $output;
}
function cek_session_admin()
{

	$level = $_SESSION['level'];
	if ($level != 'admin') {
		echo "<script>document.location='.';</script>";
	}
}
function cek_session_superadmin()
{

	$level = $_SESSION['level'];
	if ($level != 'superadmin') {
		echo "<script>document.location='.';</script>";
	}
}
function cek_session_guru()
{
	$level = $_SESSION['level'];
	if ($level != 'guru' and $level != 'admin') {
		echo "<script>document.location='.';</script>";
	}
}

function jump($page)
{
	echo "<script>location=('$page');</script>";
}
function info($string, $type = null)
{
	if ($type == 'OK') {
		$class = "success";
		$icon = "fa-check";
	} elseif ($type == 'NO') {
		$class = "danger";
		$icon = "fa-warning";
	} else {
		$class = "warning";
		$icon = "fa-info-circle";
	}
	return "<p class='text-$class'><i class='fa $icon'></i> $string</p>";
}
function timeAgo($tanggal)
{
	$ayeuna = date('Y-m-d H:i:s');
	$detik = strtotime($ayeuna) - strtotime($tanggal);
	if ($detik <= 0) {
		return "Baru saja";
	} else {
		if ($detik < 60) {
			return $detik . " detik yang lalu";
		} else {
			$menit = $detik / 60;
			if ($menit < 60) {
				return number_format($menit, 0) . " menit yang lalu";
			} else {
				$jam = $menit / 60;
				if ($jam < 24) {
					return number_format($jam, 0) . " jam yang lalu";
				} else {
					$hari = $jam / 24;
					if ($hari < 2) {
						return "Kemarin";
					} elseif ($hari < 3) {
						return number_format($hari, 0) . " hari yang lalu";
					} else {
						return $tanggal;
					}
				}
			}
		}
	}
}
function size($bytes = 0)
{
	$size = $bytes;
	$b = "B";
	if ($size > 1024) {
		$size = number_format($bytes / 1024, 2, '.', '');
		$b = "KB";
		if ($size > 1024) {
			$size = number_format($bytes / 1024 / 1024, 2, '.', '');
			$b = "MB";
			if ($size > 1024) {
				$size = number_format($bytes / 1024 / 1024 / 1024, 2, '.', '');
				$b = "GB";
				if ($size > 1024) {
					$size = number_format($bytes / 1024 / 1024 / 1024 / 1024, 2, '.', '');
					$b = "TB";
				}
			}
		}
	}
	$size = str_replace('.00', '', $size);
	return $size . ' ' . $b;
}

function bulan_indo($tanggal)
{
	$bulan = array(
		1 =>
		'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	return $bulan[(int) $pecahkan[1]];
}

function buat_tanggal($format, $time = null)
{
	$time = ($time == null) ? time() : strtotime($time);
	$str = date($format, $time);
	for ($t = 1; $t <= 9; $t++) {
		$str = str_replace("0$t ", "$t ", $str);
	}
	$str = str_replace("Jan", "Januari", $str);
	$str = str_replace("Feb", "Februari", $str);
	$str = str_replace("Mar", "Maret", $str);
	$str = str_replace("Apr", "April", $str);
	$str = str_replace("May", "Mei", $str);
	$str = str_replace("Jun", "Juni", $str);
	$str = str_replace("Jul", "Juli", $str);
	$str = str_replace("Aug", "Agustus", $str);
	$str = str_replace("Sep", "September", $str);
	$str = str_replace("Oct", "Oktober", $str);
	$str = str_replace("Nov", "Nopember", $str);
	$str = str_replace("Dec", "Desember", $str);
	$str = str_replace("Mon", "Senin", $str);
	$str = str_replace("Tue", "Selasa", $str);
	$str = str_replace("Wed", "Rabu", $str);
	$str = str_replace("Thu", "Kamis", $str);
	$str = str_replace("Fri", "Jumat", $str);
	$str = str_replace("Sat", "Sabtu", $str);
	$str = str_replace("Sun", "Minggu", $str);
	return $str;
}
function enum($bool)
{
	$bool = ($bool == 1) ? 'Ya' : 'Tidak';
	return $bool;
}
function html2str($str)
{
	$str = str_replace('"', "”", $str);
	$str = str_replace("'", "’", $str);
	$str = str_replace("<", "&lt;", $str);
	$str = str_replace(">", "&gt;", $str);
	return $str;
}

function create_zip($files = array(), $destination = '', $overwrite = false)
{
	//if the zip file already exists and overwrite is false, return false 	
	if (file_exists($destination) && !$overwrite) {
		return false;
	}
	//vars 	$valid_files = array(); 	 	
	//if files were passed in... 	
	if (is_array($files)) {
		//cycle through each file 		
		foreach ($files as $file) {
			//make sure the file exists
			if (file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	} elseif (is_dir($files)) {
		if ($handle = opendir($files)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && !is_dir($files . '/' . $entry)) {
					$valid_files[] = $files . '/' . $entry;
				}
			}
			closedir($handle);
		}
	}
	//if we have good files...
	if (count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach ($valid_files as $file) {
			$zip->addFile($file, $file);
		}
		//close the zip -- done!
		$zip->close();
		//check to make sure the file exists
		return file_exists($destination);
	} else {
		return false;
	}
}


function genPass($panjang)
{
	$karakter = 'abcdefghijklmnopqrstuvwxyz123456789';
	$string = '';
	for ($i = 0; $i < $panjang; $i++) {
		$pos = rand(0, strlen($karakter) - 1);
		$string .= $karakter[
			$pos];
	}
	return $string;
}

if (!function_exists('cutText')) {

	function cutText($text, $length, $mode = 2)
	{
		if ($mode != 1) {
			$char = $text[
				$length - 1];
			switch ($mode) {
				case 2:
					while ($char != ' ') {
						$char = $text[
							--$length];
					}
				case 3:
					while ($char != ' ') {
						$char = $text[
							++$num_char];
					}
			}
		}
		return substr($text, 0, $length);
	}
}

function lamaujian($seconds)
{

	if ($seconds) {
		$gmdate = gmdate("z:H:i:s", $seconds);
		$data = explode(":", $gmdate);

		$string = isset($data[0]) && $data[0] > 0 ? $data[0] . " Hari" : "";
		$string .= isset($data[1]) && $data[1] > 0 ? $data[1] . " Jam " : "";
		$string .= isset($data[2]) && $data[2] > 0 ? $data[2] . " Menit " : "";
		// $string .= isset($data[3]) && $data[3] > 0 ? $data[3] . " Detik " : "";
	} else {
		$string = '--';
	}
	return $string;
}
