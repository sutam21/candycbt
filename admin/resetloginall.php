<?php

require("../config/config.default.php");
require("../config/config.function.php");
	$kode=$_POST['kode'];
	$query = mysqli_query($koneksi, "UPDATE nilai set online='0' where id_nilai in (".$kode.")");
	if($query){
		echo 1;
	}
	else{
		echo 0;
	}
