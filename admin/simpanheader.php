<?php
require("../config/config.default.php");
	require("../config/config.function.php");
	cek_session_admin();
	$exec = mysqli_query($koneksi, "UPDATE setting set header_kartu='$_POST[jawab]' where id_setting='1'");
