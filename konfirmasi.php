<?php
require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");
$ac = $_POST['idm'];
$id_siswa = $_POST['ids'];
$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$ac'"));
$idmapel = $query['id_mapel'];
$namamapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$ac'"));
$pesan = '';


?>
<div class='row'>
    <div class='col-md-3'></div>
    <div class='col-md-6'>
        <div class='box box-solid'>
            <div class='box-header'>
                <h3 class='box-title'>Konfirmasi Tes</h3>
                <div class='box-title pull-right'>
                    <a href='<?= $homeurl ?>'><span class='btn btn-sm btn-default'>Kembali</span></a>
                </div>
            </div>
            <div class='box-body'>

                <div class='table-responsive'>
                    <form id="formmulaiujian" action='' method='post'>
                        <input type='hidden' value='<?= $id_siswa ?>' name='ids'>
                        <input type='hidden' value='<?= $ac ?>' name='idm'>
                        <table class='table no-margin'>
                            <tbody>
                                <tr>
                                    <td>
                                        <b>Nama Tes</b><br />
                                        <small class='label bg-red'><?= $namamapel['kode_ujian'] ?></small>
                                        <small class='label bg-purple'><?= $namamapel['nama'] ?></small>
                                        <small class='label bg-blue'><?= $namamapel['level'] ?></small>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Status Tes</b><br />
                                        <small class='label bg-red'>Tersedia</small>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Jumlah Soal</b><br />
                                        <small class='label bg-purple'><?= $namamapel['tampil_pg'] . 'PG / ' . $namamapel['tampil_esai'] ?> Esai</small>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Tanggal Waktu Tes</b><br />
                                        <small class='label bg-green'> <?= buat_tanggal('D, d M Y') ?></small>
                                        <small class='label bg-red'><?= $namamapel['waktu_ujian'] ?></small>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Guru Pengampu</b>
                                        <br>
                                        <?php $guru = mysqli_fetch_array(mysqli_query($koneksi, "SELECT nama FROM pengawas WHERE id_pengawas='$namamapel[id_guru]'")); ?>
                                        <small class='label bg-red'><?= $guru['nama'] ?></small>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Alokasi Waktu Tes</b><br />
                                        <small class='label bg-blue'><?= $namamapel['lama_ujian'] ?> menit</small>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <?php if ($namamapel['token'] == 1) : ?>
                                        <td>
                                            <input type='text' class='form-control' name='token' placeholder='masukan token' autofocus />
                                        </td>
                                    <?php endif ?>
                                    <td>
                                        <button type='submit' name='mulai' class='btn btn-success btn-block'>Mulai Test</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#formmulaiujian').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'cekkonfirmasi.php',
            data: $(this).serialize(),
            success: function(data) {
                toastr.success(data);
            }
        });
        return false;
    });
</script>