<?php
$id_mapel = $_GET['id'];
$mapelQ = mysqli_query($koneksi, "SELECT * FROM mapel where id_mapel='$id_mapel'");
$mapel = mysqli_fetch_array($mapelQ);
$cekmapel = mysqli_num_rows($mapelQ);
?>
<div class='row'>
    <div id="boxpesan"></div>
    <div class='col-md-12'>

        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'>Import Soal Candy</h3>
                <div class='box-tools pull-right '>

                    <a href='?pg=<?= $pg ?>' class='btn btn-sm bg-maroon' title='Batal'><i class='fa fa-times'></i></a>
                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <div class='col-md-6'>
                    <form id="formsoalcandy" method='post' enctype='multipart/form-data'>
                        <div class='box box-solid'>
                            <div class='box-header with-border'>
                                <h3 class='box-title'>Import Soal Candy</h3>
                                <div class='box-tools pull-right '>
                                    <button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Import</button>
                                    <a href='?pg=<?= $pg ?>' class='btn btn-sm bg-maroon' title='Batal'><i class='fa fa-times'></i></a>
                                </div>
                            </div><!-- /.box-header -->
                            <div class='box-body'>
                                <?= $info ?>
                                <div class='form-group'>
                                    <label>Mata Pelajaran</label>
                                    <input type='hidden' name='id_mapel' class='form-control' value="<?= $mapel['id_mapel'] ?>" />
                                    <input type='text' name='mapel' class='form-control' value="<?= $mapel['nama'] ?>" disabled />
                                </div>
                                <div class='form-group'>
                                    <label>Pilih File</label>
                                    <input type='file' name='file' class='form-control' required='true' />
                                </div>
                                <p>
                                    Sebelum meng-import pastikan file yang akan anda import sudah dalam bentuk Ms. Excel 97-2003 Workbook (.xls) dan format penulisan harus sesuai dengan yang telah ditentukan. <br />
                                </p>
                            </div><!-- /.box-body -->
                            <div class='box-footer'>
                                <a href='importdatasoal.xls'><i class='fa fa-file-excel-o'></i> Download Format</a>
                            </div>

                        </div><!-- /.box -->
                    </form>
                </div>
                <div class='col-md-6'>
                    <form id="formsoalword" action='<?= $homeurl ?>/admin/pages/word_import/import/index.php/word_import' method='post' enctype='multipart/form-data'>
                        <div class='box box-solid'>
                            <div class='box-header with-border'>
                                <h3 class='box-title'>Import Soal Ms Word</h3>
                                <div class='box-tools pull-right '>
                                    <button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Import</button>
                                    <a href='?pg=<?= $pg ?>' class='btn btn-sm bg-maroon' title='Batal'><i class='fa fa-times'></i></a>
                                </div>
                            </div><!-- /.box-header -->
                            <div class='box-body'>
                                <div class='form-group'>
                                    <label>Mata Pelajaran</label>
                                    <input type='hidden' name='id_mapel' class='form-control' value="<?= $mapel['id_mapel'] ?>" />
                                    <input type='text' name='mapel' class='form-control' value="<?= $mapel['nama'] ?>" disabled />
                                </div>
                                <tr>
                                    <td>
                                        <input type='hidden' name='id_bank_soal' value=<?= $_REQUEST['id'] ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <input type='hidden' name='id_lokal' value='<?= $homeurl ?>'></td>
                                </tr>
                                <tr>
                                    <td> <input type='hidden' name='cid' value='1'></td>
                                </tr>
                                <tr>
                                    <td> <input type='hidden' name='lid' value='2'></td>
                                </tr>
                                <tr>
                                    <td> <input type='hidden' name='question_split' value='/Q:[0-9]+\)/'></td>
                                </tr>
                                <tr>
                                    <td><input type='hidden' name='description_split' value='/FileQ:/'></td>
                                </tr>
                                <tr>
                                    <td><input type='hidden' name='question_gambar' value='/Gambar:/'></td>
                                </tr>
                                <tr>
                                    <td><input type='hidden' name='question_video' value='/Video:/'></td>
                                </tr>
                                <tr>
                                    <td><input type='hidden' name='question_audio' value='/Audio:/'></td>
                                </tr>
                                <tr>
                                    <td><input type='hidden' name='option_split' value='/[A-Z]:\)/'></td>
                                </tr>
                                <tr>
                                    <td><input type='hidden' name='option_file' value='/FileO:/'></td>
                                </tr>
                                <tr>
                                    <td><input type='hidden' name='correct_split' value='/Kunci:/'></td>
                                </tr>
                                <div class='form-group'>
                                    <label>Pilih File</label>
                                    <input type='file' name='word_file' class='form-control' required='true' />
                                </div>
                                <p>
                                    Sebelum meng-import pastikan file yang akan anda import sudah dalam bentuk Ms. Word (.docx) dan format penulisan harus sesuai dengan yang telah ditentukan. <br />
                                </p>
                            </div><!-- /.box-body -->
                            <div class='box-footer'>
                                <a href='<?= $homeurl ?>/admin/pages/word_import/import/sample/sample.docx'><i class='fa fa-file-word-o'></i> Download Format</a>
                            </div>
                        </div><!-- /.box -->
                    </form>
                </div>
                <div class='col-md-6'>
                    <form id='formsoalbee' action='' method='post' enctype='multipart/form-data'>
                        <div class='box box-solid'>
                            <div class='box-header with-border'>
                                <h3 class='box-title'>Import Soal Excel (Bee)</h3>
                                <div class='box-tools pull-right '>
                                    <button type='submit' name='importbee' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Import</button>
                                    <a href='?pg=<?= $pg ?>' class='btn btn-sm bg-maroon' title='Batal'><i class='fa fa-times'></i></a>
                                </div>
                            </div><!-- /.box-header -->
                            <div class='box-body'>
                                <div class='form-group'>
                                    <label>Mata Pelajaran</label>
                                    <input type='hidden' name='id_mapel' class='form-control' value="<?= $mapel['id_mapel'] ?>" />
                                    <input type='text' name='mapel' class='form-control' value="<?= $mapel['nama'] ?>" disabled />
                                </div>
                                <div class='form-group'>
                                    <label>Pilih File</label>
                                    <input type='file' name='file' class='form-control' required='true' />
                                </div>
                                <p>
                                    Sebelum meng-import pastikan file yang akan anda import sudah dalam bentuk Ms. Excel 97-2003 Workbook (.xls) dan format penulisan harus sesuai dengan yang telah ditentukan. <br />
                                </p>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </form>
                </div>
                <div class='col-md-6'>
                    <div class='box box-solid'>
                        <div class='box-header with-border'>
                            <h3 class='box-title'>File Pendukung Soal</h3>
                        </div>
                        <div class='box-body'>

                            <div class='alert alert-danger '>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                                <h4><i class='icon fa fa-info'></i> Info</h4>
                                Upload hanya file bertipe zip
                            </div>
                            <form id="formfilesoal" method="post" enctype="multipart/form-data">

                                <div class='col-md-6'>
                                    <div class='form-group'>

                                        <input class='form-control' type="file" name="zip_file" />
                                    </div>
                                </div>

                                <button type="submit" name="btn_zip" class="btn btn-info">Upload File</button>

                            </form>
                            <br />
                            <p>
                                Silahkan upload file pendukung soal seperti gambar dan audio ke dalam arsip bertipe zip setelah itu upload kesini dan komputer akan mengekstraknya ke dalam folder files <br />
                            </p>
                            <?php
                            if (isset($output)) {
                                echo $output;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->

        </div><!-- /.box -->

    </div>


</div>


<script>
    function notify(pesan) {
        toastr.success(pesan);
    }

    function notifygagal(pesan) {
        toastr.error(pesan);
    }
    //IMPORT FILE PENDUKUNG 
    $('#formfilesoal').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'soal/import_file.php',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.loader').css('display', 'block');
            },
            success: function(response) {
                $('.loader').css('display', 'none');
                $('#boxpesan').html(response);
                if (response == 'OK') {
                    notify('berhasil');
                } else {
                    notifygagal('gagal menyimpan');
                }

            }
        });
    });

    //IMPORT FILE PENDUKUNG 
    $('#formsoalcandy').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'soal/import_candy.php',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.loader').css('display', 'block');
            },
            success: function(response) {
                $('.loader').css('display', 'none');
                $('#boxpesan').html(response);
                notify(response);
            }
        });
    });

    //IMPORT SOAL BEE
    $('#formsoalbee').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'soal/import_bee.php',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('.loader').css('display', 'block');
            },
            success: function(response) {
                $('.loader').css('display', 'none');
                $('#boxpesan').html(response);
                notify(response);
            }
        });
    });
</script>