<?php

require("../config/config.default.php");
require("../config/config.function.php");
$kode = $_POST['id'];
$query = mysqli_query($koneksi, "UPDATE nilai set online='0' where id_nilai = '$kode'");
if ($query) {
	echo 1;
} else {
	echo 0;
}
