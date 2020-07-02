<?php
	require("../config/config.default.php");
	require("../config/dis.php");
	session_destroy();
	echo "<script>location.href = '.';</script>";
