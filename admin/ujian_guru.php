<div id="bodyreset">
    <?php

    $mapelQ = mysqli_query($koneksi, "SELECT * FROM ujian where id_guru='$id_pengawas' ORDER BY status DESC, tgl_ujian ASC, waktu_ujian ASC");

    ?>
    <?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
        <?php if ($mapel['tgl_ujian'] > date('Y-m-d H:i:s') and $mapel['tgl_selesai'] > date('Y-m-d H:i:s')) {
            $color = "bg-gray";
            $status = "BELUM MULAI";
        } elseif ($mapel['tgl_ujian'] < date('Y-m-d H:i:s') and $mapel['tgl_selesai'] > date('Y-m-d H:i:s')) {
            $color = "bg-blue";
            $status = "<i class='fa fa-spinner fa-spin'></i> MULAI UJIAN";
        } else {
            $color = "bg-red";
            $status = "<i class='fa fa-times'></i> WAKTU SUDAH HABIS";
        } ?>
        <div class="col-md-4">

            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header <?= $color  ?>" style="padding: 6px">
                    <div class="widget-user-image">
                        <img src="../dist/img/soal.png" alt="">
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username"><?= $mapel['kode_nama'] ?></h3>
                    <h5 class="widget-user-desc">
                        <i class="fa fa-tag"></i> <?= $mapel['kode_ujian'] ?> &nbsp;
                        <i class="fa fa-user"></i> <?= $mapel['level'] ?> &nbsp;
                        <i class="fa fa-wrench"></i> <?php
                                                        $dataArray = unserialize($mapel['id_pk']);
                                                        foreach ($dataArray as $key => $value) :
                                                            echo "<small class='label label-success'>$value </small>&nbsp;";
                                                        endforeach;

                                                        ?>
                    </h5>
                    <h5 class="widget-user-desc">
                        <i class="fa fa-circle text-green"></i>
                        <?=
                            $useronline = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_ujian='$mapel[id_ujian]' and ujian_selesai is null"));
                        ?> Mengerjakan
                        <i class="fa fa-circle text-danger"></i>
                        <?=
                            $userend = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_ujian='$mapel[id_ujian]' and ujian_selesai <> ''"));
                        ?> Selesai
                    </h5>
                </div>

                <div class="box-footer no-padding">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?= $mapel['id_ujian'] ?>">
                        <center>
                            <h3> <?= $status ?></h3>
                        </center>
                    </a>

                    <div id="collapseThree<?= $mapel['id_ujian'] ?>" class="panel-collapse collapse" aria-expanded="true">
                        <ul class="nav nav-stacked">


                            <li>
                                <a href="#">
                                    <i class='fas fa-clock'></i> Ujian Dimulai
                                    <span class="pull-right badge bg-green"><?= $mapel['tgl_ujian'] ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class='fas fa-clock'></i> Ujian Ditutup
                                    <span class="pull-right badge bg-red"><?= $mapel['tgl_selesai'] ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class='fas  fa-hourglass'></i> Durasi Ujian
                                    <span class="pull-right badge bg-purple"><?= $mapel['tampil_pg'] ?> Soal / <?= $mapel['lama_ujian'] ?> menit</span>
                                </a>
                            </li>

                            <li><a href="#">
                                    <i class='fas fa-stamp'></i> Status Ujian
                                    <span class="pull-right">
                                        <?php
                                        if ($mapel['status'] == 1) {
                                            echo " <label class='badge bg-green'>Aktif</label> <label class='badge bg-red'>Sesi $mapel[sesi]</label>";
                                        } elseif ($mapel['status'] == 0) {
                                            echo "<label class='badge bg-red'>Tidak Aktif</label>";
                                        }
                                        ?>
                                    </span>
                                </a>
                            </li>

                            <li><a>
                                    <center>
                                        <?php if ($mapel['acak'] == 1) : ?>
                                            <span class="badge bg-blue">Acak Soal</span>
                                        <?php endif; ?>
                                        <?php if ($mapel['ulang'] == 1) : ?>
                                            <span class="badge bg-blue">Acak Opsi</span>
                                        <?php endif; ?>
                                        <?php if ($mapel['token'] == 1) : ?>
                                            <span class="badge bg-blue">Token </span>
                                        <?php endif; ?>
                                        <?php if ($mapel['hasil'] == 1) : ?>
                                            <span class="badge bg-blue">Hasil Tampil</span>
                                        <?php endif; ?>

                                    </center>
                                </a>
                            </li>

                        </ul>
                        <center style="padding: 8px">
                            <a class="btn btn-primary " href="?pg=nilai&id=<?= $mapel['id_ujian'] ?>"><i class="fa fa-hand-peace "></i> Nilai</a>


                        </center>
                    </div>
                </div>
            </div>
            <!-- /.widget-user -->
        </div>

    <?php endwhile; ?>
</div>