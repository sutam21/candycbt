<?php
require "../config/config.default.php";
require "../config/config.function.php";
cek_session_admin();
$alamat = nl2br($_POST['alamat']);
$header = nl2br($_POST['header']);
$exec = mysqli_query($koneksi, "UPDATE setting SET token_api='$_POST[token_api]', aplikasi='$_POST[aplikasi]',sekolah='$_POST[sekolah]',kode_sekolah='$_POST[kode]',jenjang='$_POST[jenjang]',kepsek='$_POST[kepsek]',nip='$_POST[nip]',alamat='$alamat',kecamatan='$_POST[kecamatan]',kota='$_POST[kota]',telp='$_POST[telp]',fax='$_POST[fax]',web='$_POST[web]',email='$_POST[email]',header='$header',ip_server='$_POST[ipserver]',waktu='$_POST[waktu]' WHERE id_setting='1'");
if ($exec) {
    $ektensi = ['jpg', 'png'];
    if ($_FILES['logo']['name'] <> '') {
        $logo = $_FILES['logo']['name'];
        $temp = $_FILES['logo']['tmp_name'];
        $ext = explode('.', $logo);
        $ext = end($ext);
        if (in_array($ext, $ektensi)) {
            $dest = 'dist/img/logo' . rand(1, 100) . '.' . $ext;
            $upload = move_uploaded_file($temp, '../' . $dest);
            if ($upload) {
                $exec = mysqli_query($koneksi, "UPDATE setting SET logo='$dest' WHERE id_setting='1'");
            } else {
                echo "gagal";
            }
        }
    }
    if ($_FILES['ttd']['name'] <> '') {
        $logo = $_FILES['ttd']['name'];
        $temp = $_FILES['ttd']['tmp_name'];
        $ext = explode('.', $logo);
        $ext = end($ext);
        if (in_array($ext, $ektensi)) {
            $dest = 'dist/img/ttd' . '.' . $ext;
            $upload = move_uploaded_file($temp, '../' . $dest);
        }
    }
} else {
    echo "Gagal menyimpan";
}
