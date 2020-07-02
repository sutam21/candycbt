<?php

$banksoalx = mysqli_num_rows(mysqli_query($koneksi, "select * from mapel where status='1'"));
$soalx = mysqli_num_rows(mysqli_query($koneksi, 'select * from soal'));
$siswax = mysqli_num_rows(mysqli_query($koneksi, "select * from siswa "));
$ujianx = mysqli_num_rows(mysqli_query($koneksi, "select * from ujian "));
?>

<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'><i class='fa fa-download'></i> Tarik Data</h3>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <div class='box box-solid'>
                    <div class='box-header with-border'>

                        <h5 class='box-title'><i class='fa fa-feed'></i> CEK STATUS DATA </h5>

                    </div>
                    <div class='box-body'>
                        <center><button class='btn btn-primary' id='btnstatus' data-toggle='modal' data-target='#cekstatus'><i class='fa fa-refresh'></i>&nbsp;Sinkronisasi</button>
                            <button class='btn btn-danger' id='btnreset' data-toggle='modal' data-target='#resetsinkron'><i class='fa fa-close'></i>&nbsp;Reset Sinkroniasi</button>
                        </center>
                    </div>
                </div>
                <div class='box box-solid'>
                    <div class='box-header with-border'>

                        <h5 class='box-title'><i class='fa fa-spinner fa-spin'></i> STATUS SINKRONISASI </h5>

                    </div>
                    <div class='box-body' id='resethasil'>

                        <div id='hasilsinkron'>
                            <center><img id='loading-image2' src='ajax-loader.gif' style='display:none; width:50px;' />
                                <center>
                        </div>
                        <table class='table table-striped' id='tablestatus'>
                            <thead>
                                <th>No</th>
                                <th>Nama Data</th>
                                <th>Jumlah</th>
                                <th>Update Terakhir</th>
                                <th>Status Sinkron</th>
                                <!-- <th>Proses Sinkron</th> -->
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                $dataq = mysqli_query($koneksi, "select * from sinkron");
                                while ($data = mysqli_fetch_array($dataq)) {
                                    if ($data['status_sinkron'] <> 0) {
                                        $status = "<label class='label bg-green'>sudah sinkron</label>";
                                        //$button = "<button data-id='$data[nama_data]' class='sinkron btn bg-yellow'><i class='fa fa-recycle'></i> Ulang Sinkron</button>";
                                    } else {
                                        $status = "<label class='label bg-red'>belum sinkron</label>";
                                        // $button = "<button data-id='$data[nama_data]' class='sinkron btn bg-purple'><i class='fa fa-play'></i> Mulai Sinkron</button>";
                                    }
                                    if ($data['tanggal'] <> null) {
                                        $update = "<button class='btn btn-flat bg-blue'>$data[tanggal]</button>";
                                    } else {
                                        $update = "<button class='btn btn-flat bg-blue'>BELUM ADA</button>";
                                    }
                                    $no++; ?>

                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $data['nama_data'] ?> - <?= $data['data'] ?></td>
                                        <td><?= $data['jumlah'] ?></td>
                                        <td><?= $update ?></td>
                                        <td><?= $status ?></td>
                                        <!-- <td><?= $button ?></td> -->
                                    </tr>
                                <?php    } ?>

                            </tbody>

                        </table>

                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
<div class='modal fade' id='cekstatus' style='display: none;'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header bg-blue'>
                <h3 class='modal-title'>Status Data Server</h3>
            </div>
            <div class='modal-body' id='bodystatu'>

                <div id='bodystatu'>
                    <center><img id='loading-image' src='../dist/img/ajax-loader.gif' style='display:none; width:50px;' />
                    </center>
                </div>
                <form id="formsinkron">
                    <center>
                        <div class="form-group">
                            <label for="tokenapi">Masukan Token API</label>
                            <input type="text" class="form-control" name="tokenapi" id="tokenapi" value="<?= $setting['token_api'] ?>" aria-describedby="helpId" placeholder="">

                        </div>
                        <button type="submit" class="btn btn-primary">Mulai Sinkronisasi Data</button>
                    </center>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="datasinkron[]" value="siswa">
                            Sinkron data siswa
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="datasinkron[]" value="soal">
                            Sinkron data soal
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="datasinkron[]" value="jadwal">
                            Sinkron data jadwal
                        </label>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<div class='modal fade' id='resetsinkron' style='display: none;'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header bg-blue'>
                <h3 class='modal-title'>Reset Sinkronisasi</h3>
            </div>
            <div class='modal-body' id='bodystatu'>
                <center>Aksi ini akan menyebabkan semua data yang telah masuk terhapus, dan harus sinkronisasi ulang, apa anda yakin akan melanjutkan ??</center>
            </div>
            <div class='modal-footer'>

                <center>
                    <button class='btn btn-danger' name='reset' id='btnresetsinkron'><i class='fa fa-close'></i> IYA, Reset Sinkronisasi</button>
                </center>

            </div>
        </div>
    </div>
</div>

<script>
    $('#btnstatus').click(function() {
        $.ajax({
            type: 'POST',
            url: 'sinkronstatus.php',
            beforeSend: function() {
                $('#loading-image').show();
            },
            success: function(response) {
                $('#bodystatus').html(response);

                $('#mulaitarik').removeAttr('disabled');

            },
            complete: function() {
                $('#loading-image').hide();
            },
        });

    });
    $('#formsinkron').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'sinkron.php',
            data: $(this).serialize(),
            beforeSend: function() {
                $(this).attr('disabled', 'disabled');
                $('.loader').css('display', 'block');

            },

            success: function(response) {
                $('.loader').css('display', 'none');
                $('#cekstatus').modal('hide');
                $('#hasilsinkron').html(response);
                $('#tablestatus').load(location.href + ' #tablestatus');
            }
        });
        return false;
    });

    $('#btnresetsinkron').click(function() {
        $.ajax({
            type: 'POST',
            url: 'sinkronreset.php',
            beforeSend: function() {
                $(this).attr('disabled', 'disabled');
                $('.loader').css('display', 'block');
            },
            success: function(response) {
                $('.loader').css('display', 'none');
                $('#tablestatus').load(location.href + ' #tablestatus');
            }
        });
    });
</script>