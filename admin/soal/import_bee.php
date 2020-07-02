<?php
require("../../config/excel_reader2.php");
require("../../config/config.default.php");
if (isset($_FILES['file']['name'])) :
    $id_mapel = $_POST['id_mapel'];
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $ext = explode('.', $file);
    $ext = end($ext);
    if ($ext <> 'xls') {
        $infobee = info('Gunakan file Ms. Excel 93-2007 Workbook (.xls)', 'NO');
    } else {

        $data = new Spreadsheet_Excel_Reader($temp);
        $hasildata = $data->rowcount($sheet_index = 0);
        $sukses = $gagal = 0;
        $exec = mysqli_query($koneksi, "delete from soal where id_mapel='$id_mapel' ");
        for ($i = 3; $i <= $hasildata; $i++) :
            $no = $data->val($i, 1);
            $soal = addslashes($data->val($i, 5));
            $pilA = addslashes($data->val($i, 6));
            $pilB = addslashes($data->val($i, 8));
            $pilC = addslashes($data->val($i, 10));
            $pilD = addslashes($data->val($i, 12));
            $pilE = addslashes($data->val($i, 14));
            $jawab = $data->val($i, 19);
            if ($jawab == '1') {
                $jawaban = 'A';
            } elseif ($jawab == '2') {
                $jawaban = 'B';
            } elseif ($jawab == '3') {
                $jawaban = 'C';
            } elseif ($jawab == '4') {
                $jawaban = 'D';
            } elseif ($jawab == '5') {
                $jawaban = 'E';
            }
            $jenis = $data->val($i, 2);
            $file1 = $data->val($i, 18);
            $file2 = $data->val($i, 17);
            $fileA = $data->val($i, 7);
            $fileB = $data->val($i, 9);
            $fileC = $data->val($i, 11);
            $fileD = $data->val($i, 13);
            $fileE = $data->val($i, 15);
            $id_mapel = $_POST['id_mapel'];

            if ($jenis <> '' and $soal <> '') {
                $exec = mysqli_query($koneksi, "INSERT INTO soal (id_mapel,nomor,soal,pilA,pilB,pilC,pilD,pilE,jawaban,jenis,file,file1,fileA,fileB, fileC,fileD,fileE) VALUES ('$id_mapel','$no','$soal','$pilA','$pilB','$pilC','$pilD','$pilE','$jawaban','$jenis','$file1','$file2','$fileA','$fileB','$fileC','$fileD','$fileE')");
                ($exec) ? $sukses++ : $gagal++;
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
            } else {
                $gagal++;
            }
        endfor;
        $total = $hasildata - 1;
        echo "Berhasil: $sukses | Gagal: $gagal | Dari: $total";
    }
endif;
