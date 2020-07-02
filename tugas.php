<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'><i class="fas fa-edit    "></i> Tugas Siswa</h3>
            </div><!-- /.box-header -->
            <div class='box-body'>

                <?php
                $siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$_SESSION[id_siswa]'"));
                $mapelQ = mysqli_query($koneksi, "SELECT * FROM tugas");

                ?>
                <?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
                    <?php
                    if ($mapel['tgl_selesai'] > date('Y-m-d H:i:s')) {
                        $datakelas = unserialize($mapel['kelas']);
                        $guru = fetch($koneksi, 'pengawas', ['id_pengawas' => $mapel['id_guru']]);
                    ?>
                        <?php if (in_array($siswa['id_kelas'], $datakelas) or in_array('semua', $datakelas)) : ?>
                            <div class="col-md-4">

                                <!-- Widget: user widget style 1 -->
                                <div class="box box-widget widget-user-2">
                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                    <div class="widget-user-header bg-red" style="padding: 6px">
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
                                    </div>

                                    <div class="box-footer no-padding">
                                        <ul class="nav nav-stacked">
                                            <li>
                                                <center>
                                                    <a href="#">
                                                        <?php
                                                        if (strlen($mapel['judul']) > 25) {
                                                            echo substr($mapel['judul'], 0, 25) . "...";
                                                        } else {
                                                            echo $mapel['judul'];
                                                        }
                                                        ?>

                                                    </a>
                                                </center>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class='fas fa-clock'></i> Ujian Dimulai
                                                    <span class="pull-right badge bg-green"><?= $mapel['tgl_mulai'] ?></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class='fas fa-clock'></i> Ujian Ditutup
                                                    <span class="pull-right badge bg-red"><?= $mapel['tgl_selesai'] ?></span>
                                                </a>
                                            </li>

                                        </ul>
                                        <center style="padding: 8px">
                                            <?php if ($mapel['tgl_mulai'] > date('Y-m-d H:i:s') and $mapel['tgl_selesai'] > date('Y-m-d H:i:s')) { ?>
                                                TUGAS BELUM MULAI
                                            <?php } elseif ($mapel['tgl_mulai'] < date('Y-m-d H:i:s') and $mapel['tgl_selesai'] > date('Y-m-d H:i:s')) { ?>
                                                <a href="<?= $homeurl . '/lihattugas/' . enkripsi($mapel['id_tugas']) ?>" class="btn btn-primary">
                                                    <i class="fa fa-edit"></i> Lihat Tugas
                                                </a>
                                            <?php } ?>
                                            <!-- Button trigger modal -->


                                        </center>

                                    </div>
                                </div>
                                <!-- /.widget-user -->
                            </div>
                        <?php endif; ?>
                    <?php } ?>
                <?php endwhile; ?>

            </div>
        </div>
    </div>
</div>