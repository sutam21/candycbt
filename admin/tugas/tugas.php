<?php defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); ?>
<?php if ($ac == '') { ?>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-solid'>
                <div class='box-header with-border '>
                    <h3 class='box-title'> Daftar Tugas Terstruktur</h3>
                    <div class='box-tools pull-right '>

                    </div>
                </div><!-- /.box-header -->
                <div class='box-body'>
                    <!-- Button trigger modal -->
                    <div class="form-group">
                        <button type="button" class="btn btn-primary mb-5" data-toggle="modal" data-target="#modaltugas">
                            <i class="fas fa-plus-circle    "></i> Buat Tugas
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modaltugas" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="formtugas">
                                    <div class="modal-body">

                                        <input type="hidden" class="form-control" name="id_mapel" value="<?= $id_mapel ?>">
                                        <div class="form-group">

                                            <input type="text" class="form-control" name="mapel" aria-describedby="helpId" placeholder="Mata Pelajaran" required>

                                        </div>
                                        <div class="form-group">

                                            <input type="text" class="form-control" name="judul" aria-describedby="helpId" placeholder="Judul Tugas" required>

                                        </div>
                                        <div class="form-group">
                                            <textarea name='isitugas' class='editor1' rows='10' cols='80' style='width:100%;'></textarea>
                                        </div>
                                        <div class='form-group'>
                                            <div class='row'>
                                                <div class='col-md-4'>
                                                    <label>Pilih Kelas</label><br>
                                                    <select name='kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                                                        <option value='semua'>Semua</option>
                                                        <?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
                                                        <?php while ($kelas = mysqli_fetch_array($lev)) : ?>

                                                            <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"

                                                        <?php endwhile ?>
                                                    </select>
                                                </div>
                                                <div class='col-md-4'>
                                                    <label>Tanggal Mulai</label>
                                                    <input type='text' name='tgl_mulai' class='tgl form-control' autocomplete='off' required='true' />
                                                </div>
                                                <div class='col-md-4'>
                                                    <label>Tanggal Selesai</label>
                                                    <input type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' />
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="file">File Pendukung</label>
                                            <input type="file" class="form-control-file" name="file" placeholder="" aria-describedby="fileHelpId">
                                            <small id="fileHelpId" class="form-text text-muted">format file (doc/docx/xls/xlsx/pdf)</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id='tabletugas' class='table-responsive'>
                        <table id="example1" class='table table-bordered table-striped  table-hover'>
                            <thead>
                                <tr>
                                    <th width='5px'>#</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                    <th>Judul Tugas</th>
                                    <th>Tgl Mulai</th>
                                    <th>Tgl Selesai</th>
                                    <th>Kelas</th>
                                    <th>File</th>
                                    <th width='200px'></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pengawas['level'] == 'guru') {
                                    $tugasQ = mysqli_query($koneksi, "SELECT * FROM tugas where id_guru='$_SESSION[id_pengawas]'");
                                } else {
                                    $tugasQ = mysqli_query($koneksi, "SELECT * FROM tugas ");
                                }
                                ?>
                                <?php while ($tugas = mysqli_fetch_array($tugasQ)) : ?>
                                    <?php
                                    $guru = mysqli_fetch_array(mysqli_query($koneksi, "select * from pengawas where id_pengawas='$tugas[id_guru]'"));
                                    $no++
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td>
                                            <?= $tugas['mapel'] ?>
                                        </td>
                                        <td>
                                            <?= $guru['nama'] ?>
                                        </td>
                                        <td>
                                            <?= $tugas['judul'] ?>
                                        </td>

                                        <td style="text-align:center">
                                            <?= $tugas['tgl_mulai'] ?>
                                        </td>
                                        <td style="text-align:center">
                                            <?= $tugas['tgl_selesai'] ?>
                                        </td>
                                        <td style="text-align:center">
                                            <?php $kelas = unserialize($tugas['kelas']);
                                            foreach ($kelas as $kelas) {
                                                echo $kelas . " ";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($tugas['file'] <> '0') { ?>
                                                <a href="../berkas/<?= $tugas['file'] ?>" target="_blank">Lihat</a>
                                            <?php } ?>
                                        </td>
                                        <td style="text-align:center">
                                            <div class=''>
                                                <a href='?pg=tugas&ac=jawaban&id=<?= $tugas['id_tugas'] ?>' class='btn btn-sm btn-success '><i class='fas fa-eye'></i> Lihat</a>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modaledit<?= $tugas['id_tugas'] ?>">
                                                    <i class="fas fa-edit    "></i>
                                                </button>


                                                <button data-id='<?= $tugas['id_tugas'] ?>' class="hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt    "></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modaledit<?= $tugas['id_tugas'] ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="formedittugas<?= $tugas['id_tugas'] ?>">
                                                    <div class="modal-body">
                                                        <input type="hidden" value="<?= $tugas['id_tugas'] ?>" name='id'>
                                                        <div class="form-group">

                                                            <input type="text" class="form-control" name="mapel" aria-describedby="helpId" placeholder="Mata Pelajaran" value="<?= $tugas['mapel'] ?>" required>

                                                        </div>
                                                        <div class="form-group">

                                                            <input type="text" class="form-control" name="judul" aria-describedby="helpId" placeholder="Judul Tugas" value="<?= $tugas['judul'] ?>" required>

                                                        </div>
                                                        <div class="form-group">
                                                            <textarea name='isitugas' class='editor1' rows='10' cols='80' style='width:100%;'><?= $tugas['tugas'] ?></textarea>
                                                        </div>
                                                        <div class='form-group'>
                                                            <div class='row'>
                                                                <div class='col-md-4'>
                                                                    <label>Pilih Kelas</label><br>
                                                                    <select name='kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                                                                        <option value='semua'>Semua</option>
                                                                        <?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
                                                                        <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                                                                            <?php if (in_array($kelas['id_kelas'], unserialize($tugas['kelas']))) : ?>
                                                                                <option value="<?= $kelas['id_kelas'] ?>" selected><?= $kelas['id_kelas'] ?></option>"
                                                                            <?php else : ?>
                                                                                <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"
                                                                            <?php endif; ?>
                                                                        <?php endwhile ?>
                                                                    </select>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <label>Tanggal Mulai</label>
                                                                    <input type='text' name='tgl_mulai' class='tgl form-control' autocomplete='off' required='true' value="<?= $tugas['tgl_mulai'] ?>" />
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <label>Tanggal Selesai</label>
                                                                    <input type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' value="<?= $tugas['tgl_selesai'] ?>" />
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="file">File Pendukung</label>
                                                            <input type="file" class="form-control-file" name="file" id="file" placeholder="" aria-describedby="fileHelpId">
                                                            <small id="fileHelpId" class="form-text text-muted">format file (doc/docx/xls/xlsx/pdf)</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('#formedittugas<?= $tugas['id_tugas'] ?>').submit(function(e) {
                                            e.preventDefault();
                                            var data = new FormData(this);
                                            $.ajax({
                                                type: 'POST',
                                                url: 'tugas/edit_tugas.php',
                                                enctype: 'multipart/form-data',
                                                data: data,
                                                cache: false,
                                                contentType: false,
                                                processData: false,
                                                success: function(data) {
                                                    //toastr.error(data);
                                                    if (data == "ok") {
                                                        toastr.success("tugas berhasil dirubah");
                                                    } else {
                                                        toastr.error(data);
                                                    }
                                                    $('#modaledit<?= $tugas['id_tugas'] ?>').modal('hide');
                                                    setTimeout(function() {
                                                        location.reload();
                                                    }, 2000);

                                                }
                                            });
                                            return false;
                                        });
                                    </script>
                                <?php endwhile ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
<?php } elseif ($ac == 'jawaban') { ?>
    <?php $id = $_GET['id']; ?>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-solid'>
                <div class='box-header with-border '>
                    <h3 class='box-title'> Daftar Jawaban Siswa</h3>
                    <div class='box-tools pull-right '>
                        <button onclick="frames['printtugas'].print()" class='btn btn-sm btn-flat btn-success'><i class='fa fa-print'></i> Print</button>
                        <iframe name='printtugas' src='tugas/print_jawaban.php?id=<?= $id ?>' style='display:none'></iframe>
                    </div>
                </div><!-- /.box-header -->
                <div class='box-body' id="tablejawaban">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>

                                <th>File</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $jawabx = mysqli_query($koneksi, "select * from jawaban_tugas where id_tugas='$id'");
                            $no = 0;
                            while ($jawab = mysqli_fetch_array($jawabx)) {
                                $no++;
                                $siswa = fetch($koneksi, 'siswa', ['id_siswa' => $jawab['id_siswa']]);
                            ?>
                                <tr>
                                    <td scope="row"><?= $no ?></td>
                                    <td><?= $siswa['nama'] ?></td>
                                    <td><?= $siswa['id_kelas'] ?></td>
                                    <td>
                                        <?php if ($jawab['file'] <> null) { ?>
                                            <a href="../tugas/<?= $jawab['file'] ?>" target="_blank">Lihat</a>
                                        <?php } ?>
                                    </td>
                                    <td><?= $jawab['nilai'] ?></td>

                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalnilai<?= $no ?>">
                                            <i class="fas fa-edit    "></i> Input Nilai
                                        </button>
                                        <button data-id='<?= $jawab['id_jawaban'] ?>' class="hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt    "></i></button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalnilai<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form id="formnilaitugas<?= $jawab['id_jawaban'] ?>">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" class="form-control" name="id" value="<?= $jawab['id_jawaban'] ?>">
                                                            <div class="form-group">
                                                                <label for="nilai">Input Nilai</label>
                                                                <input type="text" class="form-control" name="nilai<?= $jawab['id_jawaban'] ?>" aria-describedby="helpId" placeholder="">
                                                                <small id="helpId" class="form-text text-muted">masukan nilai</small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Jawaban Siswa</label>
                                                                <p><?= $jawab['jawaban'] ?>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            $("#formnilaitugas<?= $jawab['id_jawaban'] ?>").submit(function(e) {
                                                e.preventDefault();
                                                var id = '<?= $jawab['id_jawaban'] ?>';
                                                $.ajax({
                                                    type: "POST",
                                                    url: "tugas/simpan_nilai.php",
                                                    data: $(this).serialize(),
                                                    success: function(result) {
                                                        toastr.success(result);
                                                        $('#modalnilai<?= $no ?>').modal('hide');
                                                        setTimeout(function() {
                                                            location.reload();
                                                        }, 1000);


                                                    }
                                                });
                                            });
                                        </script>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $('#formtugas').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        //console.log(data);
        $.ajax({
            type: 'POST',
            url: 'tugas/buat_tugas.php',
            enctype: 'multipart/form-data',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                $('#modaltugas').modal('hide');
                if (data = 'ok') {
                    toastr.success("Tugas berhasil disimpan");
                    $("#tabletugas").load(window.location + " #tabletugas");
                } else {
                    toastr.error("tugas gagal dibuat");
                }
                //toastr.error(data);


            }
        });
        return false;
    });
    $('#tabletugas').on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        swal({
            title: 'Apa anda yakin?',
            text: "akan menghapus tugas ini!",

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'tugas/hapus_tugas.php',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                        toastr.success('tugas berhasil dihapus');
                        $("#tabletugas").load(window.location + " #tabletugas");
                    }
                });
            }
        })

    });
    $('#tablejawaban').on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        swal({
            title: 'Apa anda yakin?',
            text: "akan menghapus nilai ini!",

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'tugas/hapus_nilai.php',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                        toastr.success('tugas berhasil dihapus');
                        $("#tablejawaban").load(window.location + " #tablejawaban");
                    }
                });
            }
        })

    });
</script>
<script>
    tinymce.init({
        selector: '.editor1',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste formula'
        ],

        toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | formula code | imagetools link image paste ',
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        paste_data_images: true,

        images_upload_handler: function(blobInfo, success, failure) {
            success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
        },
        image_class_list: [{
            title: 'Responsive',
            value: 'img-responsive'
        }],
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }
    });
</script>