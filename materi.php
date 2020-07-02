<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'><i class="fas fa-edit    "></i> Materi Siswa</h3>
            </div><!-- /.box-header -->
            <div class='box-body'>

                <?php
                $siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$_SESSION[id_siswa]'"));
                $mapelQ = mysqli_query($koneksi, "SELECT * FROM materi");

                ?>
                <?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
                    <?php
                    if ($mapel['tgl_mulai'] < date('Y-m-d H:i:s')) {
                        $datakelas = unserialize($mapel['kelas']);
                        $guru = fetch($koneksi, 'pengawas', ['id_pengawas' => $mapel['id_guru']]);
                    ?>
                        <?php if (in_array($siswa['id_kelas'], $datakelas) or in_array('semua', $datakelas)) :

                            $warna = array('bg-red', 'bg-blue',  'bg-green', 'bg-gray', 'bg-purple');

                        ?>
                            <div class="col-md-4">
                                <a href="<?= $homeurl . '/lihatmateri/' . enkripsi($mapel['id_materi']) ?>">
                                    <!-- Widget: user widget style 1 -->
                                    <div class="box box-widget widget-user-2">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header <?= $warna[rand(0, count($warna) - 1)] ?> " style="padding: 6px">
                                            <div class="widget-user-image">
                                                <img src="dist/img/soal.png" alt="">
                                            </div>
                                            <!-- /.widget-user-image -->
                                            <span style="font-size: 20px"> <b>
                                                    <?php
                                                    if (strlen($mapel['mapel']) > 30) {
                                                        echo substr($mapel['mapel'], 0, 30) . "...";
                                                    } else {
                                                        echo $mapel['mapel'];
                                                    }
                                                    ?>

                                                </b></span>
                                            <p>Guru : <?= $guru['nama'] ?></p>
                                            <?= $mapel['tgl_mulai'] ?>
                                        </div>

                                        <div class="box-footer">
                                            <center>
                                                <?= $mapel['judul'] ?>
                                            </center>
                                        </div>
                                    </div>
                                    <!-- /.widget-user -->
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php } ?>
                <?php endwhile; ?>

            </div>
        </div>
    </div>
</div>