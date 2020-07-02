<?php
$info1 = '';
if (isset($_POST['simpanserver'])) :
    $exec = mysqli_query($koneksi, "UPDATE setting SET id_server='$_POST[id_server]', url_host='$_POST[url_host]', token_api='$_POST[token_api]' WHERE id_setting='1'");
    if ($exec) {
        $info1 = info('Berhasil menyimpan pengaturan!', 'OK');
    }
endif; ?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'><i class='fa fa-gear'></i> Setting Sinkronisasi</h3>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <div class='box box-solid '>
                    <div class='box-header with-border'>
                        <h3 class='box-title'><i class='fa fa-desktop'></i> Status Server</h3>

                    </div><!-- /.box-header -->
                    <div class='box-body'>
                        <center><img id='loading-image' src='../dist/img/ajax-loader.gif' style='display:none; width:50px;' />
                            <center>
                                <div id='statusserver'>
                                </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <form action='' method='post' enctype='multipart/form-data'>

                    <div class='box-body'>

                        <?= $info1 ?>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label>ID SERVER</label>
                                    <input type='text' name='id_server' value="<?= $setting['id_server'] ?>" class='form-control' required='true' />
                                </div>

                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label>Alamat IP / Nama Domain</label>
                                    <input type='text' name='url_host' value="<?= $setting['url_host'] ?>" class='form-control' required='true' />
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label>Token Sinkron</label>
                                    <input type='text' name='token_api' value="<?= $setting['token_api'] ?>" class='form-control' required='true' />
                                </div>
                            </div>
                        </div>

                        <div class='col-md-6'>
                            <button type='submit' name='simpanserver' class='btn btn-flat pull-right btn-success' style='margin-bottom:5px'><i class='fa fa-check'></i> Simpan</button>
                        </div>
                    </div><!-- /.box-body -->

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajax({
        type: 'POST',
        url: 'statusserver.php',
        beforeSend: function() {
            $('#loading-image').show();
        },
        success: function(response) {
            $('#statusserver').html(response);
            $('#loading-image').hide();

        }
    });
</script>