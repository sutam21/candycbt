<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
$ac = dekripsi($ac);
echo $ac;
$materi = mysqli_fetch_array(mysqli_query($koneksi, "select * from materi where id_materi='$ac'"))
?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>

                <h3 class='box-title'><i class="fas fa-file-signature    "></i> Detail materi Siswa</h3>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <table class='table table-bordered table-striped'>
                    <tr>
                        <th width='150'>Mata Pelajaran</th>
                        <td width='10'>:</td>
                        <td><?= $materi['mapel'] ?></td>

                    </tr>

                    <tr>
                        <th>Tgl Publish</th>
                        <td width='10'>:</td>
                        <td><?= $materi['tgl_mulai'] ?></td>
                    </tr>

                </table>
                <!-- <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Materi & Soal</a></li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1"> -->
                <?php if ($materi['file'] <> null) { ?>
                    Download Materi Pendukung<p>
                        <a target="_blank" href='<?= $homeurl ?>/berkas/<?= $materi['file'] ?>' class="btn btn-primary"><?= $materi['file'] ?></a>
                    <?php } ?>
                    <center>
                        <div class="callout">
                            <strong>
                                <h3><?= $materi['judul'] ?></h3>
                            </strong>
                        </div>
                    </center>
                    <?php if ($materi['youtube'] <> null) {  ?>
                        <div class="col-md-3"></div>
                        <div class="callout col-md-6">
                            <iframe width="100%" height="315" src="<?= $materi['youtube'] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    <?php } ?>
                    <div class="col-md-12">
                        <?= $materi['materi'] ?>
                    </div>
            </div>

        </div>
        <!-- </div>
            </div>
        </div> -->
    </div>
</div>
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

<div class="fb-comments" data-href="https://cbtcandy.com/<?= $ac ?>" data-numposts="5" data-width="100%"></div>