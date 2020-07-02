<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border '>
                <h3 class='box-title'> Berita Acara</h3>
                <div class='box-tools pull-right '>

                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <!-- Button trigger modal -->
                <div class="form-group">
                    <button type="button" class="btn btn-primary mb-5" data-toggle="modal" data-target="#modalberita">
                        <i class="fas fa-plus-circle    "></i> Buat Berita Acara
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modalberita" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Buat Berita Acara</h5>
                            </div>
                            <form id="formberita">
                                <div class="modal-body">

                                    <div class='col-md-4'>
                                        <div class='form-group'>
                                            <label>Nama Ujian</label>
                                            <select name="id_ujian" class='select2 form-control' style="width: 100%" required='true'>
                                                <?php $sql_mapel = mysqli_query($koneksi, "SELECT * FROM ujian group by id_mapel"); ?>
                                                <option value=''>Pilih Jadwal Ujian</option>
                                                <?php while ($mapel = mysqli_fetch_array($sql_mapel)) : ?>
                                                    <option value="<?= $mapel['id_ujian'] ?>"><?php echo "$mapel[nama] $mapel[level] $mapel[id_pk]" ?></option>
                                                <?php endwhile ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-md-4'>
                                        <div class='form-group'>
                                            <label>Sesi</label>
                                            <select class="form-control" id="bcsesi" name="sesi" required>
                                                <option>Sesi</option>
                                                <?php $sesi = mysqli_query($koneksi, "select * from siswa group by sesi"); ?>
                                                <?php while ($ses = mysqli_fetch_array($sesi)) : ?>
                                                    <option value="<?= $ses['sesi'] ?>"><?= $ses['sesi'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-md-4'>
                                        <div class='form-group'>
                                            <label>Ruang</label>
                                            <select class="form-control" id="bcruang" name="ruang" required>
                                                <option>Ruang</option>
                                                <?php $ruang = mysqli_query($koneksi, "select * from siswa group by ruang"); ?>
                                                <?php while ($ruang = mysqli_fetch_array($ruang)) : ?>
                                                    <option value="<?= $ruang['ruang'] ?>"><?= $ruang['ruang'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-md-4'>
                                        <div class='form-group'>
                                            <label>Tanggal Ujian</label>
                                            <input name='tgl_ujian' value="<?= $berita['tgl_ujian'] ?>" class='datepicker form-control' autocomplete=off />
                                        </div>
                                    </div>
                                    <div class='col-md-2'>
                                        <div class='form-group'>
                                            <label>Mulai</label>
                                            <input id='waktumulai' type='text' name='mulai' value="<?= $berita['mulai'] ?>" class='timer form-control' autocomplete=off />
                                        </div>
                                    </div>
                                    <div class='col-md-2'>
                                        <div class='form-group'>
                                            <label>Selesai</label>
                                            <input id='waktumulai' type='text' name='selesai' value="<?= $berita['selesai'] ?>" class='timer form-control' autocomplete=off />
                                        </div>
                                    </div>
                                    <div class='col-md-2'>
                                        <div class='form-group'>
                                            <label>Hadir</label>
                                            <input type='number' name='hadir' value="<?= $berita['ikut'] ?>" class='form-control' required='true' />
                                        </div>
                                    </div>
                                    <div class='col-md-2'>
                                        <div class='form-group'>
                                            <label>Absen</label>
                                            <input type='number' name='tidakhadir' value="<?= $berita['susulan'] ?>" class='form-control' required='true' />
                                        </div>
                                    </div>
                                    <div class='col-md-12'>
                                        <div class='form-group'>
                                            <label>Siswa Tidak Hadir</label><br>
                                            <select name='nosusulan[]' id="bcsiswaabsen" class='form-control select2' multiple='multiple' style='width:100%'>

                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label>Nama Proktor</label>
                                            <input type='text' name='nama_proktor' value="<?= $berita['nama_proktor'] ?>" class='form-control' required='true' />
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label>NIP Proktor</label>
                                            <input type='text' name='nip_proktor' value="<?= $berita['nip_proktor'] ?>" class='form-control' required='true' />
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label>Nama Pengawas</label>
                                            <input type='text' name='nama_pengawas' value="<?= $berita['nama_pengawas'] ?>" class='form-control' required='true' />
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class='form-group'>
                                            <label>NIP Pengawas</label>
                                            <input type='text' name='nip_pengawas' value="<?= $berita['nip_pengawas'] ?>" class='form-control' required='true' />
                                        </div>
                                    </div>
                                    <div class='col-md-12'>
                                        <div class='form-group'>
                                            <label>Catatan</label>
                                            <textarea type='text' name='catatan' class='form-control' required='true'><?= $berita['catatan'] ?></textarea>
                                        </div>
                                    </div>
                                    <input type='hidden' id='idm' name='idu' value="<?= $berita['id_berita'] ?>" />

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id='tableberita' class='table-responsive'>
                    <table class='table table-bordered table-striped  table-hover'>
                        <thead>
                            <tr>
                                <th width='5px'>#</th>
                                <th>Mata Pelajaran</th>
                                <th>Level/Jur/Kelas</th>
                                <th>Sesi</th>
                                <th>Ruang</th>
                                <th>Hadir</th>
                                <th>Tidak Hadir</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Pengawas</th>
                                <th width='100px'></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $beritaQ = mysqli_query($koneksi, "SELECT * FROM berita");
                            ?>
                            <?php while ($berita = mysqli_fetch_array($beritaQ)) : ?>
                                <?php
                                $mapel = mysqli_fetch_array(mysqli_query($koneksi, "select * from mapel a left join mata_pelajaran b ON a.nama=b.kode_mapel where a.id_mapel='$berita[id_mapel]'"));
                                $no++
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td>
                                        <b><small class='label bg-purple'><?= $mapel['nama_mapel'] ?></small></b> <small class='label bg-red'><?= $berita['jenis'] ?></small>
                                    </td>
                                    <td>
                                        <small class='label label-primary'><?= $mapel['level'] ?></small>
                                        <?php
                                        $dataArray = unserialize($mapel['idpk']);
                                        foreach ($dataArray as $key => $value) {
                                            echo "<small class='label label-success'>$value </small>&nbsp;";
                                        }
                                        ?>
                                        <?php
                                        $dataArray = unserialize($mapel['kelas']);
                                        foreach ($dataArray as $key => $value) {
                                            echo "<small class='label label-success'>$value </small>&nbsp;";
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align:center">
                                        <b><small class='label bg-purple'><?= $berita['sesi'] ?></small></b>
                                    </td>
                                    <td style="text-align:center">
                                        <small class='label bg-green'><?= $berita['ruang'] ?></small>
                                    </td>
                                    <td style="text-align:center">
                                        <?= $berita['ikut'] ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?= $berita['susulan'] ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?= $berita['mulai'] ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?= $berita['selesai'] ?>
                                    </td>
                                    <td>
                                        <?= $berita['nama_pengawas'] ?>
                                    </td>
                                    <td style="text-align:center">
                                        <div class=''>
                                            <a href='?pg=beritaacara&id=<?= $berita['id_berita'] ?>' class='btn btn-sm btn-success '><i class='glyphicon glyphicon-print'></i></a>
                                            <button data-id='<?= $berita['id_berita'] ?>' class="hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt    "></i></button>
                                        </div>
                                    </td>
                                </tr>


                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>

<script>
    $('#formberita').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'beritaacara/buat_berita.php',
            data: $(this).serialize(),
            success: function(data) {
                if (data == 'oke') {
                    toastr.success(data);
                    $('#modalberita').modal('hide');
                    $("#tableberita").load(window.location + " #tableberita");
                } else {
                    toastr.error(data);
                }
            }
        });
        return false;
    });
    $('#tableberita').on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        swal({
            title: 'Apa anda yakin?',
            text: "akan menghapus berita acara ini!",

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'beritaacara/hapus_berita.php',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                        toastr.success('berita berhasil dihapus');
                        $("#tableberita").load(window.location + " #tableberita");
                    }
                });
            }
        })

    });
</script>