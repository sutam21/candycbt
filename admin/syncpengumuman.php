<?php
require "../config/config.default.php";
require "../config/config.function.php";
$token = $_GET['token'];
$data = http_request("http://apk.candycbt.id/syncpengumuman.php?token=" . $token);
$pengumuman = json_decode($data, true);
if ($pengumuman <> null) { ?>
    <ul class='timeline'>

        <?php foreach ($pengumuman as $pengumuman) { ?>

            <?php if ($pengumuman['type'] == 'internal') {
                $bg = 'bg-green';
                $color = 'text-green';
            } else {
                $bg = 'bg-blue';
                $color = 'text-blue';
            } ?>
            <li>
                <div class='timeline-item'>
                    <span class='time'> <i class='fa fa-calendar'></i> <?= buat_tanggal('d-m-Y', $pengumuman['date']) ?><i class='fa fa-clock-o'></i> <?= buat_tanggal('h:i', $pengumuman['date']) ?></span>
                    <h3 class='timeline-header' style='background-color:#f9f0d5'><a class='$color' href='#'><?= $pengumuman['judul'] ?></a>

                    </h3>
                    <div class='timeline-body'>
                        <?= ucfirst($pengumuman['text']) ?>
                    </div>

                </div>

            <?php } ?>
            </li>
    </ul>
<?php   } else {
    echo '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-ban"></i> Sinkron Pengumuman Gagal!</h4>
    Silahkan periksa koneksi internet dan token anda
  </div>';
} ?>