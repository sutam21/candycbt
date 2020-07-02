<?php
require("../../config/excel_reader2.php");
require("../../config/config.default.php");
if (isset($_FILES['file']['name'])) {
    $id_mapel = $_POST['id_mapel'];
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $ext = explode('.', $file);
    $ext = end($ext);
    if ($ext <> 'xls') {
        echo "harap pilih file excel .xls";
    } else {
        $data = new Spreadsheet_Excel_Reader($temp);
        $hasildata = $data->rowcount($sheet_index = 0);
        $sukses = $gagal = 0;
        $exec = mysqli_query($koneksi, "DELETE FROM soal WHERE id_mapel='$id_mapel' ");
        for ($i = 2; $i <= $hasildata; $i++) :
            $no = $data->val($i, 1);
            $soal = addslashes($data->val($i, 2));
            $pilA = addslashes($data->val($i, 3));
            $pilB = addslashes($data->val($i, 4));
            $pilC = addslashes($data->val($i, 5));
            $pilD = addslashes($data->val($i, 6));
            $pilE = addslashes($data->val($i, 7));
            $jawaban = $data->val($i, 8);
            $jenis = $data->val($i, 9);
            $file1 = $data->val($i, 10);
            $file2 = $data->val($i, 11);
            $fileA = $data->val($i, 12);
            $fileB = $data->val($i, 13);
            $fileC = $data->val($i, 14);
            $fileD = $data->val($i, 15);
            $fileE = $data->val($i, 16);
            $id_mapel = $_POST['id_mapel'];

            if ($soal <> '' and $jenis <> '') {
                $exec = mysqli_query($koneksi, "INSERT INTO soal (id_mapel,nomor,soal,pilA,pilB,pilC,pilD,pilE,jawaban,jenis,file,file1,fileA,fileB, fileC,fileD,fileE) VALUES ('$id_mapel','$no','$soal','$pilA','$pilB','$pilC','$pilD','$pilE','$jawaban','$jenis','$file1','$file2','$fileA','$fileB','$fileC','$fileD','$fileE')");
                if ($file1 <> '') {
                    $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$file1','$id_mapel')");
                }
                if ($file2 <> '') {
                    $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$file2','$id_mapel')");
                }
                if ($fileA <> '') {
                    $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileA','$id_mapel')");
                }
                if ($fileB <> '') {
                    $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileB','$id_mapel')");
                }
                if ($fileC <> '') {
                    $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileC','$id_mapel')");
                }
                if ($fileD <> '') {
                    $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileD','$id_mapel')");
                }
                if ($fileE <> '') {
                    $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileE','$id_mapel')");
                }

                ($exec) ? $sukses++ : $gagal++;
            } else {
                $gagal++;
            }
        endfor;
        $total = $hasildata - 1;
        echo "Berhasil: $sukses | Gagal: $gagal | Dari: $total";
    }
} else {
    echo "gagal";
}
