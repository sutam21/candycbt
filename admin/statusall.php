<?php
if (!isset($_GET['id'])) {
    die("Anda tidak dizinkan mengakses langsung script ini!");
} else {
    if ($_GET['id'] <> '76310EEFF2B5D3C887F238976A421B638CFEB0942AB8249CD0A29B125C91B3E5') {
        die("Anda tidak dizinkan mengakses langsung script ini!");
    }
}
include "../config/config.default.php";
include "../config/config.function.php";
$pengawas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas  WHERE id_pengawas='$_SESSION[id_pengawas]'"));
$tglsekarang = date('Y-m-d');
if ($pengawas['level'] == 'admin') {
    $nilaiq = mysqli_query($koneksi, "SELECT *  FROM nilai  s LEFT JOIN ujian c ON s.id_ujian=c.id_ujian  where c.status='1' and s.id_siswa<>'' GROUP by s.id_nilai DESC");
} else {
    $nilaiq = mysqli_query($koneksi, "SELECT *  FROM nilai  s LEFT JOIN ujian c ON s.id_ujian=c.id_ujian  where c.status='1' and s.id_siswa<>'' and c.id_guru='$_SESSION[id_pengawas]' GROUP by s.id_nilai DESC");
}
while ($nilai = mysqli_fetch_array($nilaiq)) {
    $tglx = strtotime($nilai['ujian_mulai']);
    $tgl = date('Y-m-d', $tglx);
    if ($tgl == $tglsekarang) {
        $no++;
        $ket = '';
        $lama = $jawaban = $skor = '--';
        $siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$nilai[id_siswa]' "));
        $kelas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$siswa[id_kelas]'"));
        $mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$nilai[id_mapel]'"));
        $nilaiQ = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_siswa='$siswa[id_siswa]'");
        $nilaiC = mysqli_num_rows($nilaiQ);

        if ($nilaiC <> 0) {
            $lama = '';
            if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] <> '') {
                $selisih = strtotime($nilai['ujian_selesai']) - strtotime($nilai['ujian_mulai']);

                $jawaban = "<small class='label bg-green'>$nilai[jml_benar] <i class='fa fa-check'></i></small>  <small class='label bg-red'>$nilai[jml_salah] <i class='fa fa-times'></i></small>";
                $skor = "<small class='label bg-green'>" . number_format($nilai['skor'], 2, '.', '') . "</small>";
                $ket = "<label class='label label-success'>Tes Selesai</label>";
                $btn = "<button data-id='$nilai[id_nilai]' class='ulang btn btn-xs btn-danger'>ulang</button>";
            } elseif ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] == '') {
                $selisih = strtotime($nilai['ujian_berlangsung']) - strtotime($nilai['ujian_mulai']);

                $ket = "<label class='label label-danger'><i class='fa fa-spin fa-spinner' title='Sedang ujian'></i>&nbsp;Masih Dikerjakan</label>";

                $btn = "<button data-id='$nilai[id_nilai]' class='hapus btn btn-xs btn-danger'>selesai</button>";
            }
        }
        echo "
																<tr>
																	<td>$no</td>
																	<td>$siswa[nis]</td>
																	<td>$siswa[nama]</td>
																	<td>$kelas[nama]</td>
																	<td><small class='label bg-red'>$nilai[kode_ujian]</small> <small class='label bg-purple'>$mapel[nama]</small> <small class='label bg-blue'>$mapel[level]</small></td>
																	<td>" . lamaujian($selisih) . "</td>
																	<td>$jawaban</td>
																	<td>$skor</td>
																	<td>$nilai[ipaddress]</td>
																	<td>$ket</td>
																	<td>$btn</td>
																	
																</tr>
															";
    }
}
?>
<script>
    $(document).on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        swal({
            title: 'Apa anda yakin?',
            text: "aksi ini akan menyelesaikan secara paksa ujian yang sedang berlangsung!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'selesaikan.php',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                        $('#htmlujianselesai').html('1');
                        toastr.success(data);
                    }
                });
            }
        })
    });

    $(document).on('click', '.ulang', function() {
        var id = $(this).data('id');
        console.log(id);
        swal({
            title: 'Apa anda yakin?',
            text: "Akan Mengulang Ujian Ini ??",

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'ulangujian.php',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                        toastr.success("berhasil diulang");
                    }
                });
            }
        })
    });
</script>