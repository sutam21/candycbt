<?php
require "../config/config.default.php";
require "../config/config.function.php";
if (isset($_POST["uplod"])) {
    $output = '';
    if ($_FILES['zip_file']['name'] != '') {
        $file_name = $_FILES['zip_file']['name'];
        $array = explode(".", $file_name);
        $name = $array[0];
        $ext = $array[1];
        if ($ext == 'zip') {
            $path = '../foto/fotosiswa/';
            $location = $path . $file_name;
            if (move_uploaded_file($_FILES['zip_file']['tmp_name'], $location)) {
                $zip = new ZipArchive;
                if ($zip->open($location)) {
                    $zip->extractTo($path);
                    $zip->close();
                }
                $files = scandir($path);
                foreach ($files as $file) {
                    $file_ext = pathinfo($file, PATHINFO_EXTENSION);
                    $allowed_ext = array('jpg', 'JPG', 'png');
                    if (in_array($file_ext, $allowed_ext)) {
                        $tmp = explode(".", $file);
                        $nama = $tmp[0];
                        $output .= '<div class="col-md-3"><div style="padding:16px; border:1px solid #CCC;"><img class="img img-responsive" style="height:150px;" src="../foto/fotosiswa/' . $file . '" /></div></div>';
                        mysqli_query($koneksi, "UPDATE siswa set foto='$file' where username='$nama'");
                    }
                }
                unlink($location);
                $pesan = "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-check'></i> Info</h4>Upload File zip berhasil</div>";
            }
        } else {
            $pesan = "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-info'></i> Gagal Upload</h4>Mohon Upload file zip</div>";
        }
    }
}
