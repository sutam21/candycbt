<?php
require "../config/config.default.php";
if ($koneksi) {
    $idujian = $_POST['id'];
    $query = mysqli_query($koneksi, "select * from nilai where id_ujian='$idujian' and status is null");
    $cek = mysqli_num_rows($query);
    if ($cek <> 0) {
        $array_nilai = array();
        while ($nilai = mysqli_fetch_assoc($query)) {
            $array_nilai[] = $nilai;
        }
        $payload = json_encode($array_nilai);

        $url = $setting['url_host'] . '/syncnilai.php?token=' . $setting['token_api'];


        //Initiate cURL.
        $ch = curl_init($url);

        //attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        //set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        //return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute the POST request
        $result = curl_exec($ch);

        //close cURL resource
        curl_close($ch);

        echo '<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i>Berhasil!</h4>
        Data berhasil dikirimkan ...
      </div>';
        if ($result == 'berhasil') {
            mysqli_query($koneksi, "UPDATE nilai SET status='1' where id_ujian='$idujian'");
        }
    } else {
        echo '<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Ehmmm!</h4>
        Tidak ada data yang dikirimkan
      </div>';
    }
} else {
    echo "server tidak terhubung";
}
