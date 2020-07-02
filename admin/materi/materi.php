<?php defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); ?>
<?php if ($ac == '') { ?>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-solid'>
                <div class='box-header with-border '>
                    <h3 class='box-title'> Daftar materi</h3>
                    <div class='box-tools pull-right '>

                    </div>
                </div><!-- /.box-header -->
                <div class='box-body'>
                    <!-- Button trigger modal -->
                    <div class="form-group">
                        <button type="button" class="btn btn-primary mb-5" data-toggle="modal" data-target="#modalmateri">
                            <i class="fas fa-plus-circle    "></i> Buat materi
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalmateri" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="formmateri">
                                    <div class="modal-body">

                                        <input type="hidden" class="form-control" name="id_mapel" value="<?= $id_mapel ?>">
                                        <div class="form-group">

                                            <select name='mapel' class='form-control' style='width:100%' required>
                                                <option value=''>Pilih Mata Pelajaran</option>
                                                <?php $que = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran"); ?>
                                                <?php while ($mapel = mysqli_fetch_array($que)) : ?>

                                                    <option value="<?= $mapel['kode_mapel'] ?>"><?= $mapel['nama_mapel'] ?></option>"

                                                <?php endwhile ?>
                                            </select>
                                        </div>
                                        <div class="form-group">

                                            <input type="text" class="form-control" name="judul" aria-describedby="helpId" placeholder="Judul materi" required>

                                        </div>
                                        <div class="form-group">
                                            <textarea name='isimateri' class='editor1' rows='10' cols='80' style='width:100%;'></textarea>
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
                                                    <label>Tanggal Publish</label>
                                                    <input type='text' name='tgl_mulai' class='tgl form-control' autocomplete='off' required='true' />
                                                </div>
                                                <div class='col-md-4'>
                                                    <label>Link Youtube</label>
                                                    <input type='text' name='youtube' class='form-control' autocomplete='off' />
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
                    <div id='tablemateri' class='table-responsive'>
                        <table id="example1" class='table table-bordered table-striped  table-hover'>
                            <thead>
                                <tr>
                                    <th width='5px'>#</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                    <th>Judul materi</th>
                                    <th>Tgl Publish</th>
                                    <th>Kelas</th>
                                    <th>File</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pengawas['level'] == 'guru') {
                                    $materiQ = mysqli_query($koneksi, "SELECT * FROM materi where id_guru='$_SESSION[id_pengawas]'");
                                } else {
                                    $materiQ = mysqli_query($koneksi, "SELECT * FROM materi ");
                                }
                                ?>
                                <?php while ($materi = mysqli_fetch_array($materiQ)) : ?>
                                    <?php
                                    $guru = mysqli_fetch_array(mysqli_query($koneksi, "select * from pengawas where id_pengawas='$materi[id_guru]'"));
                                    $no++
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td>
                                            <?= $materi['mapel'] ?>
                                        </td>
                                        <td>
                                            <?= $guru['nama'] ?>
                                        </td>
                                        <td>
                                            <?= $materi['judul'] ?>
                                        </td>

                                        <td style="text-align:center">
                                            <?= $materi['tgl_mulai'] ?>
                                        </td>
                                        <td style="text-align:center">
                                            <?php $kelas = unserialize($materi['kelas']);
                                            foreach ($kelas as $kelas) {
                                                echo $kelas . " ";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($materi['file'] <> null) { ?>
                                                <a href="../berkas/<?= $materi['file'] ?>" target="_blank">Lihat</a>
                                            <?php } ?>
                                        </td>
                                        <td style="text-align:center">
                                            <div class=''>
                                                <a href='?pg=materi&ac=lihat&id=<?= $materi['id_materi'] ?>' class='btn btn-sm btn-success '><i class='fas fa-comment'></i></a>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modaledit<?= $materi['id_materi'] ?>">
                                                    <i class="fas fa-edit    "></i>
                                                </button>


                                                <button data-id='<?= $materi['id_materi'] ?>' class="hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt    "></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modaledit<?= $materi['id_materi'] ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="formeditmateri<?= $materi['id_materi'] ?>">
                                                    <div class="modal-body">
                                                        <input type="hidden" value="<?= $materi['id_materi'] ?>" name='id'>
                                                        <div class="form-group">
                                                            <select name='mapel' class='form-control' style='width:100%' required>
                                                                <option value='<?= $materi['mapel'] ?>' selected><?= $materi['mapel'] ?></option>
                                                                <?php $que = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran"); ?>
                                                                <?php while ($mapel = mysqli_fetch_array($que)) : ?>

                                                                    <option value="<?= $mapel['kode_mapel'] ?>"><?= $mapel['nama_mapel'] ?></option>"

                                                                <?php endwhile ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">

                                                            <input type="text" class="form-control" name="judul" aria-describedby="helpId" placeholder="Judul materi" value="<?= $materi['judul'] ?>" required>

                                                        </div>
                                                        <div class="form-group">
                                                            <textarea name='isimateri' class='editor1' rows='10' cols='80' style='width:100%;'><?= $materi['materi'] ?></textarea>
                                                        </div>
                                                        <div class='form-group'>
                                                            <div class='row'>
                                                                <div class='col-md-4'>
                                                                    <label>Pilih Kelas</label><br>
                                                                    <select name='kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                                                                        <option value='semua'>Semua</option>
                                                                        <?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
                                                                        <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                                                                            <?php if (in_array($kelas['id_kelas'], unserialize($materi['kelas']))) : ?>
                                                                                <option value="<?= $kelas['id_kelas'] ?>" selected><?= $kelas['id_kelas'] ?></option>"
                                                                            <?php else : ?>
                                                                                <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"
                                                                            <?php endif; ?>
                                                                        <?php endwhile ?>
                                                                    </select>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <label>Tanggal Publish</label>
                                                                    <input type='text' name='tgl_mulai' class='tgl form-control' autocomplete='off' required='true' value="<?= $materi['tgl_mulai'] ?>" />
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <label>Video Youtube</label>
                                                                    <input type='text' name='youtube' class='form-control' autocomplete='off' required='true' value="<?= $materi['youtube'] ?>" />
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
                                        $('#formeditmateri<?= $materi['id_materi'] ?>').submit(function(e) {
                                            e.preventDefault();
                                            var data = new FormData(this);
                                            $.ajax({
                                                type: 'POST',
                                                url: 'materi/edit_materi.php',
                                                enctype: 'multipart/form-data',
                                                data: data,
                                                cache: false,
                                                contentType: false,
                                                processData: false,
                                                success: function(data) {
                                                    //toastr.error(data);
                                                    if (data == "ok") {
                                                        toastr.success("materi berhasil dirubah");
                                                    } else {
                                                        toastr.error(data);
                                                    }
                                                    $('#modaledit<?= $materi['id_materi'] ?>').modal('hide');
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
<?php } elseif ($ac == 'lihat') { ?>
    <?php $id = $_GET['id']; ?>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-solid'>
                <div class='box-header with-border '>
                    <h3 class='box-title'> Daftar Komentar Siswa</h3>

                </div><!-- /.box-header -->
                <div class='box-body' id="tablejawaban">
                    <div id="fb-root"></div>
                    <script>
                        (function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v6.0&appId=900893573760224';
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));
                    </script>

                    <div class="fb-comments" data-href="https://cbtcandy.com/<?= $id ?>" data-numposts="5" data-width="100%"></div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $('#formmateri').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        //console.log(data);
        $.ajax({
            type: 'POST',
            url: 'materi/buat_materi.php',
            enctype: 'multipart/form-data',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                $('#modalmateri').modal('hide');
                if (data = 'ok') {
                    toastr.success(data);
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    toastr.error(data);
                }
                //toastr.error(data);


            }
        });
        return false;
    });
    $('#tablemateri').on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        swal({
            title: 'Apa anda yakin?',
            text: "akan menghapus materi ini!",

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'materi/hapus_materi.php',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                        toastr.success('materi berhasil dihapus');
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
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
                    url: 'materi/hapus_nilai.php',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                        toastr.success('materi berhasil dihapus');
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
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