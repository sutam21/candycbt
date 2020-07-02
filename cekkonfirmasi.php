
<?php
require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");
$ac = enkripsi($_POST['idm']);
$id_siswa = enkripsi($_POST['ids']);
$idu = $_POST['idm'];
$ids = $_POST['ids'];
$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$idu'"));
$idmapel = $query['id_mapel'];
if ($query['token'] == 1) :
    $token = $_POST['token'];
    $tokencek = mysqli_fetch_array(mysqli_query($koneksi, "SELECT token FROM token"));
    if ($token == $tokencek['token']) :

        $query = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_mapel='$idmapel' AND id_siswa='$ids' AND id_ujian='$idu'");
        $nilaix = mysqli_fetch_array($query);
        $ceknilai = mysqli_num_rows($query);
        if ($ceknilai <> 0) :
            if ($nilaix['ujian_selesai'] == '') :
                include_once("aturanlanjut.php");
                mysqli_query($koneksi, "UPDATE nilai set online='1' where id_mapel='$idmapel' AND id_siswa='$ids' AND id_ujian='$idu'");
                jump("$homeurl/testongoing/$ac/$id_siswa");
            endif;
        else :
            include_once("aturan.php");
            jump("$homeurl/testongoing/$ac/$id_siswa");
        endif;
    else :
        echo "Kode Token Salah";
    endif;
else :
    $query = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_mapel='$idmapel' AND id_siswa='$ids' AND id_ujian='$idu'");
    $nilaix = mysqli_fetch_array($query);
    $ceknilai = mysqli_num_rows($query);
    if ($ceknilai <> 0) {
        if ($nilaix['ujian_selesai'] == '') :
            include_once("aturanlanjut.php");
            mysqli_query($koneksi, "UPDATE nilai set online='1' where id_mapel='$idmapel' AND id_siswa='$ids' AND id_ujian='$idu'");
            jump("$homeurl/testongoing/$ac/$id_siswa");
        endif;
    } else {
        include_once("aturan.php");
        jump("$homeurl/testongoing/$ac/$id_siswa");
    }
endif;
