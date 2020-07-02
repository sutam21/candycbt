<?php

require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");
require("config/config.candy.php");

(isset($_SESSION['id_siswa'])) ? $id_siswa = $_SESSION['id_siswa'] : $id_siswa = 0;
($id_siswa == 0) ?  header("Location:$homeurl/login.php") : null;
($pg == 'testongoing') ? $sidebar = 'sidebar-collapse' : $sidebar = '';
($pg == 'testongoing') ? $disa = '' : $disa = 'offcanvas';
$siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$id_siswa'"));
$idsesi = $siswa['sesi'];
$idpk = $siswa['idpk'];
$level = $siswa['level'];
$pk = fetch($koneksi, 'pk', array('id_pk' => $idpk));
$tglsekarang = time();

?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />
    <title><?= $setting['aplikasi'] ?></title>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' />
    <link rel='shortcut icon' href='<?= $homeurl ?>/favicon.ico' />
    <link rel='stylesheet' href='<?= $homeurl ?>/dist/bootstrap/css/bootstrap.min.css' />
    <link rel='stylesheet' href='<?= $homeurl ?>/plugins/fontawesome/css/all.css' />
    <link rel='stylesheet' href='<?= $homeurl ?>/dist/css/AdminLTE.min.css' />
    <link rel='stylesheet' href='<?= $homeurl ?>/dist/css/skins/skin-green-light.min.css' />
    <link rel='stylesheet' href='<?= $homeurl ?>/plugins/iCheck/square/green.css' />
    <link rel='stylesheet' href='<?= $homeurl ?>/plugins/animate/animate.min.css'>
    <link rel='stylesheet' href='<?= $homeurl ?>/plugins/sweetalert2/dist/sweetalert2.min.css'>
    <!-- <link rel='stylesheet' href='<?= $homeurl ?>/plugins/slidemenu/jquery-slide-menu.css'> -->
    <link rel='stylesheet' href='<?= $homeurl ?>/plugins/toastr/toastr.min.css'>
    <link rel='stylesheet' href='<?= $homeurl ?>/plugins/radio/css/style.css'>
    <script src='<?= $homeurl ?>/plugins/jQuery/jquery-2.2.3.min.js'></script>
    <script src='<?= $homeurl ?>/plugins/tinymce/tinymce.min.js'></script>

    <style>
        @font-face {
            font-family: 'tulisan_keren';
            src: url('<?= $homeurl ?>/dist/fonts/poppins/Poppins-Light.ttf');
        }
        body {
            font-family: 'tulisan_keren';
            font-size: 12px;
            line-height: 1.42857143;
            color: #000;
        }
        .soal img {
            max-width: 100%;
            height: auto;
        }

        .main-header .sidebar-baru {
            float: left;
            color: white;
            padding: 15px 15px;
            cursor: pointer;
        }

        .callout {
            border-left: 0px;
        }

        .btn {

            border-radius: 20em;
        }

        .btn-primary {
            background-color: blue;
            border-color: #367fa9;
            font-weight: bolder;
        }

        .btn.btn-flat {
            border-radius: 20em;
        }

        .skin-red-light .sidebar-menu>li:hover>a,
        .skin-red-light .sidebar-menu>li.active>a {
            color: #fff;
            background: #e111e8;
        }
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('dist/img/ajax-loader.gif') 50% 50% no-repeat rgb(249, 249, 249);
            opacity: .8;
        }
    </style>
</head>

<body class='hold-transition skin-green-light  fixed <?= $sidebar ?>'>
    <span id='livetime'></span>
    <div class='loader'></div>
    <div class='wrapper'>
        <header class='main-header'>
            <a href='javascript:window.location.reload(true)' class='logo' style='background-color:#f9fafc'>
                <span class='animated flipInX logo-mini'>
                    <img src="<?= $homeurl . "/" . $setting['logo'] ?>" height="30px">
                </span>
                <span class='animated flipInX logo-lg' style="margin:-3px;color:#000">
                    <img src="<?= $homeurl . '/' . $setting['logo'] ?>" height="40px"> <?= $setting['sekolah'] ?>
                </span>
            </a>
            <nav class='navbar navbar-static-top' style='background-color:#2c94de;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)' role='navigation'>
                <a href='#' class='sidebar-baru' data-toggle='<?= $disa ?>' role='button'>
                    <i class="fa fa-bars fa-lg fa-fw"></i>
                </a>

                <div class='navbar-custom-menu'>
                    <ul class='nav navbar-nav'>
                        <li class="visible-xs"><a><?= $siswa['nama'] ?></a></li>
                        <li class='dropdown user user-menu'>
                            <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                                <?php
                                if ($siswa['foto'] <> '') :
                                    if (!file_exists("foto/fotosiswa/$siswa[foto]")) :
                                        echo "<img src='$homeurl/dist/img/avatar_default.png' class='user-image'   alt='+'>";
                                    else :
                                        echo "<img src='$homeurl/foto/fotosiswa/$siswa[foto]' class='user-image'   alt='+'>";
                                    endif;
                                else :
                                    echo "<img src='$homeurl/dist/img/avatar_default.png' class='user-image'   alt='+'>";
                                endif;
                                ?>
                                <span class='hidden-xs'><?= $siswa['nama'] ?> &nbsp; <i class='fa fa-caret-down'></i></span>
                            </a>
                            <ul class='dropdown-menu'>
                                <li class='user-header bg-red'>
                                    <?php
                                    if ($siswa['foto'] <> '') :
                                        if (!file_exists("foto/fotosiswa/$siswa[foto]")) :
                                            echo "<img src='$homeurl/dist/img/avatar_default.png' class='img-circle' alt='User Image'>";
                                        else :
                                            echo "<img src='$homeurl/foto/fotosiswa/$siswa[foto]' class='img-circle' alt='User Image'>";
                                        endif;
                                    else :
                                        echo "<img src='$homeurl/dist/img/avatar_default.png' class='img-circle' alt='User Image'>";
                                    endif;
                                    ?>
                                    <p>
                                        <?= $siswa['nama'] ?>
                                    </p>
                                </li>
                                <li class='user-footer'>
                                    <div class='pull-right'>
                                        <a href='<?= $homeurl ?>/logout.php' class='btn btn-sm btn-default btn-flat'><i class='fa fa-sign-out'></i> Keluar</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class='main-sidebar'>
            <section class='sidebar'>
                <hr style="margin:0px">
                <div class='user-panel'>
                    <div class='pull-left image'>
                        <?php
                        if ($siswa['foto'] <> '') :
                            if (!file_exists("foto/fotosiswa/$siswa[foto]")) :
                                echo "<img src='$homeurl/dist/img/avatar_default.png' class='img'  style='max-width:60px' alt='+'>";
                            else :
                                echo "<img src='$homeurl/foto/fotosiswa/$siswa[foto]' class='img'  style='max-width:60px' alt='+'>";
                            endif;
                        else :
                            echo "<img src='$homeurl/dist/img/avatar_default.png' class='img'  style='max-width:60px' alt='+'>";
                        endif;
                        ?>
                    </div>
                    <div class='pull-left info' style='left:65px'>
                        <?php
                        if (strlen($siswa['nama']) > 15) {
                            $nama = substr($siswa['nama'], 0, 15) . "...";
                        } else {
                            $nama = $siswa['nama'];
                        }
                        ?>
                        <p title="<?= $siswa['nama'] ?>"><?= $nama ?></p>
                        <p><a href='#'><i class='fa fa-circle text-green'></i> online</a>
                        <p><span class="badge bg-red"><?=$siswa['idpk']?></span> <span class="badge bg-green"><?=$siswa['id_kelas']?></span></p>
                    </div>
                </div><br>
                <hr style="margin:0px">
                <ul class='sidebar-menu tree' data-widget='tree'>
                    <li class='header'>Main Menu Peserta Ujian</li>
                    <li><a href='<?= $homeurl ?>'><i class='fas fa-tachometer-alt fa-fw  '></i> <span> Dashboard</span></a></li>
                    <li><a href='<?= $homeurl ?>/jadwal'><i class='fas fa-calendar fa-fw  '></i> <span> Jadwal Ujian</span></a></li>
                    <li><a href='<?= $homeurl ?>/materi'><i class='fas fa-file fa-fw  '></i> <span> Materi Belajar</span></a></li>
                    <li><a href='<?= $homeurl ?>/tugassiswa'><i class='fas fa-edit fa-fw  '></i> <span> Tugas Siswa</span></a></li>
                    
                    <li><a href='<?= $homeurl ?>/hasil'><i class='fas fa-tags fa-fw '></i> <span> Hasil Ujian</span></a></li>
                     <li><a href='brocandycbt.apk'><i class='fas fa-fw  fa-star'></i> <span>Exambro</span></a></li>
                </ul><!-- /.sidebar-menu -->
            </section>
        </aside>
        <div class='content-wrapper' style='background-image: url(admin/backgroun.jpg);background-size: cover;'>
            <section class='content-header' style="height:102px;z-index:0;background:#0979c7">
            </section>
            <section class='content' style="margin-top:-95px">
                <?php if ($pg == '') : ?>
                    <div class='row'>
                      
                        <div class='col-md-12'>
                            <div class='box box-solid'>
                                <div class='box-header with-border'>
                                    <h3 class='box-title'><i class="fas fa-bullhorn    "></i> Pengumuman</h3>
                                </div><!-- /.box-header -->
                                <div class='box-body'>
                                    <div id='pengumuman'>
                                   <?php $logC = 0;
                                        echo "<ul class='timeline'><br>";
                                        $logQ = mysqli_query($koneksi, "SELECT * FROM pengumuman where type='eksternal' ORDER BY date DESC");

                                        while ($log = mysqli_fetch_array($logQ)) {
                                            $logC++;
                                            $user = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE id_pengawas='$log[user]'"));
                                            if ($log['type'] == 'internal') {
                                                $bg = 'bg-green';
                                                $color = 'text-green';
                                            } else {
                                                $bg = 'bg-blue';
                                                $color = 'text-blue';
                                            }
                                            echo "
                                                        
                                                        
                                                        <!-- timeline time label -->
                                                        
                                                        <li><i class='fa fa-envelope $bg'></i>
                                                        <div class='timeline-item'>
                                                        <span class='time'> <i class='fa fa-calendar'></i> " . buat_tanggal('d-m-Y', $log['date']) . " <i class='fa fa-clock-o'></i> " . buat_tanggal('h:i', $log['date']) . "</span>
                                                        <h3 class='timeline-header' style='background-color:#f9f0d5'><a class='$color' href='#'>$log[judul]</a> <small> $user[nama]</small>
                                                        
                                                        </h3>
                                                        <div class='timeline-body'>
                                                        " . ucfirst($log['text']) . "	
                                                        </div>
                                                        
                                                        </div>
                                                        </li>
                                            
                                                        
                                                    ";
                                        }
                                        if ($logC == 0) {
                                            echo "<p class='text-center'>Tidak ada aktifitas.</p>";
                                        }
                                        echo "</ul>";?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                        
                <?php elseif ($pg == 'jadwal') : ?>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='alert alert-info alert-dismissible'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                                <i class='icon fa fa-info'></i>
                                Tombol ujian akan aktif bila waktu sudah sama dengan jadwal ujian,
                                Refresh browser atau tekan F5 jika waktu ujian belum aktif
                                </div>
                        </div>
                        <div id="boxtampil" class='col-md-12'>
                            <div id='formjadwalujian' class='box box-solid'>
                                <div class='box-header with-border'>
                                    <h3 class='box-title'><i class="fas fa-calendar-alt    "></i> Jadwal Ujian Hari ini</h3>
                                    <!-- <div class='box-tools'>
                                        <button class='btn btn-flat btn-primary'><span id='waktu' style="font-family:'OCR A Extended'"><?= $waktu ?> </span></button>
                                    </div> -->
                                </div><!-- /.box-header -->
                                <div class='box-body'>
                                    <?php

                                    $mapelQ = mysqli_query($koneksi, "SELECT * FROM ujian WHERE (level='$level' or level='semua') AND sesi='$idsesi' AND status='1' ORDER BY tgl_ujian ");

                                    ?>
                                    <?php while ($mapelx = mysqli_fetch_array($mapelQ)) : ?>
                                        <?php if (date('Y-m-d', strtotime($mapelx['tgl_selesai'])) >= date('Y-m-d') and date('Y-m-d', strtotime($mapelx['tgl_ujian'])) <= date('Y-m-d')) : ?>
                                            <?php $datakelas = unserialize($mapelx['kelas']); ?>
                                            <?php $datapk = unserialize($mapelx['id_pk']); ?>
                                            <?php if (in_array($siswa['idpk'], $datapk) or in_array('semua', $datapk)) : ?>
                                                <?php if (in_array($siswa['id_kelas'], $datakelas) or in_array('semua', $datakelas)) : ?>
                                                    <?php
                                                    $no++;
                                                    // $pelajaran = explode(' ', $mapelx['nama']);
                                                    $where = array(
                                                       // 'id_ujian' => $mapelx['id_ujian'],
                                                        'id_mapel' => $mapelx['id_mapel'],
                                                        'id_siswa' => $id_siswa
                                                        //'kode_ujian' => $mapelx['kode_ujian']
                                                    );
                                                    $nilai = fetch($koneksi, 'nilai', $where);
                                                    $ceknilai = rowcount($koneksi, 'nilai', $where);
                                                    if ($ceknilai == '0') :
                                                        if (strtotime($mapelx['tgl_ujian']) <= time() and time() <= strtotime($mapelx['tgl_selesai'])) :
                                                            $status = '<label class="label label-success">Tersedia </label>';
                                                            $btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-primary'><i class='fa fa-edit'></i> MULAI</button>";
                                                        elseif (strtotime($mapelx['tgl_ujian']) >= time() and time() <= strtotime($mapelx['tgl_selesai'])) :
                                                            $status = '<label class="label label-danger">Belum Waktunya</label>';
                                                            $btntest = "<button' class='btn btn-block btn-sm btn-danger disabled'> BELUM UJIAN</button>";
                                                        else :
                                                            $status = '<label class="label label-danger">Telat Ujian</label>';
                                                            $btntest = "<button' class='btn btn-block btn-sm btn-danger disabled'> Telat Ujian</button>";
                                                        endif;
                                                    else :
                                                        if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_berlangsung'] <> '' and $nilai['ujian_selesai'] == '') :
                                                            
                                                            if ($mapelx['reset'] == 1) {
                                                                if($nilai['online']==0){
                                                                $status = '<label class="label label-warning">Berlangsung</label>';
                                                                $btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-success'><i class='fas fa-edit'></i> LANJUTKAN</button>";
                                                                }else{
                                                                $status = '<label class="label label-warning">Siswa sedang aktif</label>';
                                                                $btntest = "<button  class=' btn btn-block btn-danger'><i class='fas fa-edit'></i> Minta Reset</button>";
                                                                }
                                                            } else {
                                                                $status = '<label class="label label-warning">Berlangsung</label>';
                                                                $btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-success'><i class='fas fa-edit'></i> LANJUTKAN</button>";
                                                               
                                                            } 
                                                        else :
                                                            if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_berlangsung'] <> '' and $nilai['ujian_selesai'] <> '') {
                                                                $status = '<label class="label label-primary">Selesai</label>';
                                                                $btntest = "<button class='btn btn-block btn-success btn-sm disabled'> Sudah Ujian</button>";
                                                            } else {
                                                                $btntest = "<button class='btn btn-block btn-danger btn-sm disabled'> Eloy</button>";
                                                            }
                                                        endif;
                                                    endif;
                                                    ?>
                                                    <?php if ($mapelx['soal_agama'] <> null) : ?>
                                                        <?php if ($mapelx['soal_agama'] == $siswa['agama']) : ?>

                                                            <div class="col-md-4 animated tada">

                                                                <!-- Widget: user widget style 1 -->
                                                                <div class="box box-widget widget-user-2">
                                                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                                                    <div class="widget-user-header bg-blue" style="padding: 6px">
                                                                        <div class="widget-user-image">
                                                                            <img src="dist/img/soal.png" alt="">
                                                                        </div>
                                                                        <!-- /.widget-user-image -->
                                                                        <h3 class="widget-user-username">
                                                                             <?php
                                                                                if (strlen($mapelx['nama']) > 10) {
                                                                                    echo substr($mapelx['nama'], 0, 10) . "...";
                                                                                } else {
                                                                                    echo $mapelx['nama'];
                                                                                }
                                                                             ?>
                                                                        </h3>
                                                                        <h5 class="widget-user-desc">
                                                                            <i class="fa fa-tag"></i> <?= $mapelx['kode_ujian'] ?> &nbsp;
                                                                            <i class="fa fa-user"></i> <?= $mapelx['level'] ?> &nbsp;
                                                                            <i class="fa fa-wrench"></i> <?php
                                                                                                            $dataArray = unserialize($mapelx['id_pk']);
                                                                                                            foreach ($dataArray as $key => $value) :
                                                                                                                echo "<small class='label label-success'>$value </small>&nbsp;";
                                                                                                            endforeach;

                                                                                                            ?>
                                                                        </h5>
                                                                    </div>
                                                                    <div class="box-footer no-padding">
                                                                        <ul class="nav nav-stacked">
                                                                            <li>
                                                                                <a href="#">
                                                                                    <i class='fa fa-clock-o'></i> Ujian Dimulai
                                                                                    <span class="pull-right badge bg-green"><?= $mapelx['tgl_ujian'] ?></span>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <i class='fa fa-clock-o'></i> Ujian Ditutup
                                                                                    <span class="pull-right badge bg-red"><?= $mapelx['tgl_selesai'] ?></span>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <i class='fa  fa-hourglass-1'></i> Durasi Ujian
                                                                                    <span class="pull-right badge bg-purple"><?= $mapelx['tampil_pg'] + $mapelx['tampil_esai'];  ?> Soal / <?= $mapelx['lama_ujian'] ?> menit</span>
                                                                                </a>
                                                                            </li>
                                                                            <li><a href="#"><i class='fa fa-feed'></i> Status Ujian <span class="pull-right">
                                                                                        <?php
                                                                                        if ($mapelx['status'] == 1) {
                                                                                            echo "<i class='fa fa-spinner fa-spin'></i> <label class='badge bg-green'>Sedang Aktif</label> <label class='badge bg-red'>Sesi $mapelx[sesi]</label>";
                                                                                        } elseif ($mapelx['status'] == 0) {
                                                                                            echo "<label class='badge bg-red'>Tidak Aktif</label>";
                                                                                        }
                                                                                        ?>
                                                                                    </span></a></li>
                                                                            <li>
                                                                                <a href="#">
                                                                                    <i class='fa  fa-hourglass-1'></i> Status Test
                                                                                    <span class="pull-right"><?= $status ?></span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                        <center style="padding: 8px">
                                                                            <?= $btntest ?>
                                                                        </center>
                                                                    </div>
                                                                </div>
                                                                <!-- /.widget-user -->
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php else : ?>

                                                        <div class="col-md-4 animated tada">

                                                            <!-- Widget: user widget style 1 -->
                                                            <div class="box box-widget widget-user-2">
                                                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                                                <div class="widget-user-header bg-blue" style="padding: 6px">
                                                                    <div class="widget-user-image">
                                                                        <img src="dist/img/soal.png" alt="">
                                                                    </div>
                                                                    <!-- /.widget-user-image -->
                                                                    <h5 class="widget-user-usernam"><?php
                                                                                if (strlen($mapelx['nama']) > 25) {
                                                                                    echo substr($mapelx['nama'], 0, 25) . "...";
                                                                                } else {
                                                                                    echo $mapelx['nama'];
                                                                                }
                                                                             ?></h5>
                                                                    <h5 class="widget-user-desc">
                                                                        <i class="fa fa-tag"></i> <?= $mapelx['kode_ujian'] ?> &nbsp;
                                                                        <i class="fa fa-user"></i> <?= $mapelx['level'] ?> &nbsp;
                                                                        <i class="fa fa-wrench"></i> <?php
                                                                                                        $dataArray = unserialize($mapelx['id_pk']);
                                                                                                        foreach ($dataArray as $key => $value) :
                                                                                                            echo "<small class='label label-success'>$value </small>&nbsp;";
                                                                                                        endforeach;

                                                                                                        ?>
                                                                    </h5>
                                                                </div>
                                                                <div class="box-footer no-padding">
                                                                    <ul class="nav nav-stacked">
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class='fa fa-clock-o'></i> Ujian Dimulai
                                                                                <span class="pull-right badge bg-green"><?= $mapelx['tgl_ujian'] ?></span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class='fa fa-clock-o'></i> Ujian Ditutup
                                                                                <span class="pull-right badge bg-red"><?= $mapelx['tgl_selesai'] ?></span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class='fa  fa-hourglass-1'></i> Durasi Ujian
                                                                                <span class="pull-right badge bg-purple"><?= $mapelx['tampil_pg'] + $mapelx['tampil_esai']  ?> Soal / <?= $mapelx['lama_ujian'] ?> menit</span>
                                                                            </a>
                                                                        </li>
                                                                        <li><a href="#"><i class='fa fa-feed'></i> Status Ujian <span class="pull-right">
                                                                                    <?php
                                                                                    if ($mapelx['status'] == 1) {
                                                                                        echo "<i class='fa fa-spinner fa-spin'></i> <label class='badge bg-green'>Sedang Aktif</label> <label class='badge bg-red'>Sesi $mapelx[sesi]</label>";
                                                                                    } elseif ($mapelx['status'] == 0) {
                                                                                        echo "<label class='badge bg-red'>Tidak Aktif</label>";
                                                                                    }
                                                                                    ?>
                                                                                </span></a></li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class='fa  fa-hourglass-1'></i> Status Test
                                                                                <span class="pull-right"><?= $status ?></span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                    <center style="padding: 8px">
                                                                        <?= $btntest ?>
                                                                    </center>
                                                                </div>
                                                            </div>
                                                            <!-- /.widget-user -->
                                                        </div>
                                                    <?php endif; ?>

                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).on('click', '.btnmulaitest', function() {
                            var idm = $(this).data('id');
                            var ids = $(this).data('ids');
                            console.log(idm + '-' + ids);

                            $.ajax({
                                type: 'POST',
                                url: 'konfirmasi.php',
                                data: 'idm=' + idm + '&ids=' + ids,
                                success: function(response) {
                                    $('#formjadwalujian').hide();
                                    $('#boxtampil').html(response).slideDown();

                                }
                            });

                        });
                    </script>
                    
                <?php elseif ($pg == 'tugassiswa') : ?>
                    <?php include "tugas.php" ?>
                <?php elseif ($pg == 'materi') : ?>
                    <?php include "materi.php" ?>
                <?php elseif ($pg == 'lihattugas') : ?>
                    <?php include "lihattugas.php" ?>
                    <?php elseif ($pg == 'lihatmateri') : ?>
                    <?php include "lihatmateri.php" ?>
              
                <?php elseif ($pg == 'lihathasil') : ?>
                    <?php
                    $ac = dekripsi($ac);
                    $nilai = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_siswa='$id_siswa' and id_ujian='$ac'"));
                    if ($nilai['hasil'] == 1) :
                        $mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$nilai[id_mapel]'"));
                    ?>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='box box-solid'>
                                    <div class='box-header with-border'>
                                        <h3 class='box-title'><i class="fas fa-file-signature    "></i> Data Hasil Ujian</h3>
                                    </div><!-- /.box-header -->
                                    <div class='box-body'>
                                        <table class='table table-bordered table-striped'>
                                            <tr>
                                                <th width='150'>No Induk</th>
                                                <td width='10'>:</td>
                                                <td><?= $siswa['nis'] ?></td>
                                                <td style="text-align:center; width:150">Nilai</td>
                                            </tr>
                                            <tr>
                                                <th>Nama</th>
                                                <td width='10'>:</td>
                                                <td><?= $siswa['nama'] ?></td>
                                                <td rowspan='4' style='font-size:30px; text-align:center; width:150'><?= $nilai['total'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kelas</th>
                                                <td width='10'>:</td>
                                                <td><?= $siswa['id_kelas'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Mata Pelajaran</th>
                                                <td width='10'>:</td>
                                                <td><?= $mapel['nama'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Nama Ujian</th>
                                                <td width='10'>:</td>
                                                <td><?= $nilai['kode_ujian'] ?></td>
                                            </tr>
                                        </table>
                                        <br>
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Detail Jawaban</a></li>
                                                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Peringkat</a></li>

                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_1">
                                                    <div class='table-responsive'>
                                                        <table id='example1' class='table table-bordered table-striped'>
                                                            <thead>
                                                                <tr>
                                                                    <th width='5px'>#</th>
                                                                    <th>Soal PG</th>

                                                                    <th style='text-align:center'>Hasil</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $jawaban = unserialize($nilai['jawaban']); ?>
                                                                <?php foreach ($jawaban as $key => $value) : ?>
                                                                    <?php
                                                                    $no++;
                                                                    $soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_soal='$key'"));
                                                                    if ($value == $soal['jawaban']) :
                                                                        $status = "<span class='text-green'><i class='fa fa-check'></i></span>";
                                                                    else :
                                                                        $status = "<span class='text-red'><i class='fa fa-times'></i></span>";
                                                                    endif;
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $no ?></td>
                                                                        <td><?= $soal['soal'] ?></td>

                                                                        <td style='text-align:center'><?= $status ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_2">
                                                    <table class='table-responsive'>
                                                        <table id='example1' class='table table-striped'>
                                                            <thead>
                                                                <tr>
                                                                    <th style='text-align:center' width='5px'>Peringkat</th>
                                                                    <th>Nama Siswa</th>
                                                                    <th style='text-align:center'>Hasil</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $nilaix = mysqli_query($koneksi, "SELECT * FROM nilai WHERE  id_ujian='$ac' order by cast(skor as decimal) DESC "); ?>
                                                                <?php $no = 0; ?>
                                                                <?php while ($peringkat = mysqli_fetch_array($nilaix)) : ?>
                                                                    <?php
                                                                    $no++;
                                                                    $siswa = mysqli_fetch_array(mysqli_query($koneksi, "select * from siswa where id_siswa='$peringkat[id_siswa]'"));
                                                                    if ($peringkat['id_siswa'] == $id_siswa) {
                                                                        $style = "style='background:yellow;font-size:20px;'";
                                                                    } else {
                                                                        $style = "";
                                                                    }
                                                                    ?>
                                                                    <tr <?= $style ?>>
                                                                        <td style='text-align:center'><?= $no ?></td>
                                                                        <td><?= $siswa['nama'] ?></td>
                                                                        <td style='text-align:center'><?= $peringkat['skor'] ?></td>
                                                                    </tr>
                                                                <?php endwhile; ?>
                                                            </tbody>
                                                        </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='box box-solid'>
                                    <div class='box-header with-border'>
                                        <h3 class='box-title'><i class="fas fa-file-signature    "></i> Data Hasil Ujian</h3>
                                    </div>
                                    <div class='box-body'>
                                        <div class='alert alert-success alert-dismissible'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                                            <i class='icon fa fa-info'></i>
                                            maaf untuk hasil nilai belum dapat dilihat, akan diproses terlebih dahulu,,
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php elseif ($pg == 'hasil') : ?>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='box box-solid'>
                                <div class='box-header with-border'>
                                    <h3 class='box-title'><i class="fas fa-file-signature    "></i> Data Hasil Ujian</h3>
                                </div><!-- /.box-header -->
                                <div class='box-body'>
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Hasil Ujian</a></li>
                                            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Hasil Tugas</a></li>
                    
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1">
                                                <div class="alert alert-info" role="alert">
                                                    <strong>Daftar Ujian yang sudah dikerjakan</strong>
                                                </div>
                                                <table id='example1' class='table table-bordered table-striped'>
                                                    <thead>
                                                        <tr>
                                                            <th width='5px'>#</th>
                                                            <th>Kode Tes</th>
                                                            <th class='hidden-xs'>Ujian Selesai</th>
                                                            <th class='hidden-xs'>Status</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $nilaix = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_siswa='$id_siswa' AND ujian_selesai <>'' ORDER BY ujian_selesai ASC "); ?>
                                                        <?php while ($nilai = mysqli_fetch_array($nilaix)) : ?>
                                                            <?php
                                                            $no++;
                                                            $mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$nilai[id_mapel]'"));
                                                            $namamapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mata_pelajaran WHERE kode_mapel='$mapel[nama]'"));
                                                            ?>
                                                            <tr>
                                                                <td><?= $no ?></td>
                                                                <td><?= $mapel['nama'] . '-' . $namamapel['nama_mapel'] ?></td>
                                                                <td class='hidden-xs'><?= $nilai['ujian_selesai'] ?></td>
                                                                <td class='hidden-xs'><label class='label label-primary'>Selesai</label></td>
                                                                <td>
                                                                    <a href="<?= $homeurl . '/lihathasil/' . enkripsi($nilai['id_ujian']) ?>"><button class='btn btn-sm btn-success'><i class='fa fa-search'></i> Lihat Hasil</button></a>
                                                                </td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="tab_2">
                                                <div class="alert alert-success" role="alert">
                                                    <strong>Daftar Tugas yang sudah dikerjakan</strong>
                                                </div>
                                                <table id='example1' class='table table-bordered table-striped'>
                                                    <thead>
                                                        <tr>
                                                            <th width='5px'>#</th>
                                                            <th>Nama Mapel</th>
                                                            
                                                            <th class='hidden-xs'>Update Dikerjakan</th>
                                                            <th>Nilai</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $tugasx = mysqli_query($koneksi, "SELECT * FROM jawaban_tugas WHERE id_siswa='$id_siswa' "); ?>
                                                        <?php while ($tugas = mysqli_fetch_array($tugasx)) : ?>
                                                            <?php
                                                            $nox++;
                                                            $mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tugas WHERE id_tugas='$tugas[id_tugas]'"));
                                                            
                                                            ?>
                                                            <tr>
                                                                <td><?= $nox ?></td>
                                                                <td><?= $mapel['mapel'] ?></td>
                                                                <td class='hidden-xs'><?= $tugas['tgl_update'] ?></td>
                                                                <td ><label class='label label-primary'><?= $tugas['nilai']?></label></td>
                                                                
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif ($pg == 'testongoing') : ?>
                    <?php
                    $ac = dekripsi($ac);
                    $id = dekripsi($id);
                    $qcek = mysqli_query($koneksi, "select * from nilai where id_ujian='$ac' and id_siswa='$id'");
                    $cek = mysqli_num_rows($qcek);
                    if ($cek <> 0) :
                        $query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$ac'"));
                        $idmapel = $query['id_mapel'];
                        $no_soal = 0;
                        $no_prev = $no_soal - 1;
                        $no_next = $no_soal + 1;
                        $id_mapel = $idmapel;
                        $id_siswa = $id;
                        $where = array(
                            'id_siswa' => $id_siswa,
                            'id_mapel' => $id_mapel
                        );
                        $where2 = array(
                            'id_siswa' => $id_siswa,
                            'id_mapel' => $id_mapel,
                            'id_ujian' => $ac
                        );

                        $mapel = fetch($koneksi, 'ujian', array('id_mapel' => $id_mapel, 'id_ujian' => $ac));
                        update($koneksi, 'nilai', array('ujian_berlangsung' => $datetime), $where2);
                        $nilai = fetch($koneksi, 'nilai', $where2);
                        $habis = strtotime($nilai['ujian_berlangsung']) - strtotime($nilai['ujian_mulai']);
                        $detik = ($mapel['lama_ujian'] * 60) - $habis;
                        $dtk = $detik % 60;
                        $mnt = floor(($detik % 3600) / 60);
                        $jam = floor(($detik % 86400) / 3600);
                        
                        $cekpg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='1'"));
                        $cekesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='2'"));
                        $quero = mysqli_fetch_array(mysqli_query($koneksi, "SELECT tampil_pg,tampil_esai FROM mapel WHERE id_mapel='$id_mapel'"));

                        if ($cekpg >= $quero['tampil_pg']) {
                            $soalpg = $quero['tampil_pg'];
                        } else {
                            $soalpg = $cekpg;
                        }
                        if ($cekesai >= $quero['tampil_esai']) {
                            $soalesai = $quero['tampil_esai'];
                        } else {
                            $soalpg = $cekesai;
                        }
                        $jumsoal = $soalpg + $soalesai;

                    ?>
                        <div class='row'>
                            <div class="col-md-1"></div>
                            <div class='col-md-10' >
                                <div class='box box-solid' style="box-shadow: 0 1px 15px 5px rgba(0, 0, 0, 0.25);">
                                    <div class='box-header with-border' >

                                        <h3 class='box-title'><span class='hidden-xs'>SOAL NOMOR </span> <span class='btn bg-green' id='displaynum'><b><?= $no_next ?></b></span></h3>

                                        <div class='box-title pull-right'>

                                            <div class='btn btn-default'>
                                                <span style="font-size:20px">Sisa Waktu </span><span style="font-size:20px" id='countdown'> <span id='htmljam'><?= $jam ?></span>:<span id='htmlmnt'><?= $mnt ?></span>:<span id='htmldtk'><?= $dtk ?></span></span>
                                            </div>
                                            <div class='btn-group'>
                                                <form action='' method='post'>
                                                    <input type='submit' name='done' id='done-submit' style='display:none;' />
                                                </form>
                                            </div>
                                        </div>
                                    </div><!-- /.box-header -->
                                    <div class="box-header with-border bg-gray">

                                        <div class='btn-group'>
                                            <button type='button' id='smaller_font' class='btn bg-purple'> - </button>
                                            <button type='button' id='reset_font' class='btn bg-purple'><i class='fa fa-sync-alt'></i></button>
                                            <button type='button' id='bigger_font' class='btn bg-purple'> + </button>
                                        </div>
                                        <div class='box-title pull-right'>

                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalnosoal">Daftar Soal <i class="fas fa-edit    "></i></button>
                                            <!-- Button trigger modal -->

                                            <!-- Modal -->
                                            <div class="modal fade" id="modalnosoal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><i class="fas fa-edit    "></i> Daftar Soal</h5>

                                                        </div>
                                                        <div class="modal-body">
                                                            <div id="loadnosoal">

                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times    "></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id='loadsoal' >
                                         <div id='loading-image'>
                                            <center>
                                                <img src="<?=$homeurl ?>/dist/img/loader.gif" class="img-fluid" width="150">
                                                <br><b>Sedang memproses soal..</b>
                                                <br><b>jika terlalu lama silahkan logout dan login lagi</b>
                                                <br><b>cek koneksi internet buka menggunakan chrome</b>
                                            </center>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    <?php else : ?>
                        <?php jump($homeurl); ?>
                    <?php endif; ?>
                <?php else : ?>
                    <?php jump($homeurl); ?>
                <?php endif; ?>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <footer class='main-footer hidden-xs'>
            <div class='container'>
                <div class='pull-left hidden-xs'>
                    <strong>
                        <span id='end-sidebar'>
                            &copy; 2019 <?= APLIKASI . " v" . VERSI . " r" . REVISI ?>
                        </span>
                    </strong>
                </div>
        </footer>
    </div><!-- ./wrapper -->
    
    <script src='<?= $homeurl ?>/plugins/zoom-master/jquery.zoom.js'></script>
    <script src='<?= $homeurl ?>/dist/bootstrap/js/bootstrap.min.js'></script>
    <script src='<?= $homeurl ?>/plugins/slimScroll/jquery.slimscroll.min.js'></script>
    <script src='<?= $homeurl ?>/plugins/iCheck/icheck.min.js'></script>
    <script src='<?= $homeurl ?>/dist/js/app.min.js'></script>
    <script src='<?= $homeurl ?>/plugins/sweetalert2/dist/sweetalert2.min.js'></script>
    <!-- <script src='<?= $homeurl ?>/plugins/slidemenu/jquery-slide-menu.js'></script> -->
    <script src='<?= $homeurl ?>/plugins/mousetrap/mousetrap.min.js'></script>
    <script src='<?= $homeurl ?>/plugins/MathJax-2.7.3/MathJax.js?config=TeX-AMS_HTML-full'></script>
    <script src='<?= $homeurl ?>/plugins/toastr/toastr.min.js'></script>
    <script>
        $('.loader').fadeOut('slow');
        var url = window.location;
        $('ul.sidebar-menu a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');
        // for treeview
        $('ul.treeview-menu a').filter(function() {
            return this.href == url;
        }).closest('.treeview').addClass('active');
       
    </script>
    <?php if ($pg == 'testongoing') : ?>
        <script>
            window.history.pushState(null, "", window.location.href);
            window.onpopstate = function() {
                window.history.pushState(null, "", window.location.href);
            };
            var homeurl;
            homeurl = '<?= $homeurl ?>';
            $(document).ready(function() {
                $("#modalnosoal").on('shown.bs.modal', function() {
                    var idmapel = '<?= $id_mapel  ?>';
                    var idsiswa = '<?= $id_siswa  ?>';
                    var pengacak = JSON.parse(localStorage.getItem('pengacakpg'));
                    var pengacakpil = JSON.parse(localStorage.getItem('pengacakpil'));
                    $.ajax({
                        type: 'POST',
                        url: homeurl + '/nosoal.php',
                        data: {
                            id_mapel: idmapel,
                            id_siswa: idsiswa,
                            pengacak: pengacak,
                            pengacakpil: pengacakpil,
                            idu: <?= $ac ?>
                        },
                        success: function(response) {
                            
                            $('#loadnosoal').html(response);

                        }
                    });
                });
            });

            function soalpertama() {
                var idmapel = '<?= $id_mapel  ?>';
                var idsiswa = '<?= $id_siswa  ?>';
                var soalsoal = JSON.parse(localStorage.getItem('soallokal'));
                var ujianya = JSON.parse(localStorage.getItem('ujianya'));
                var pengacak = JSON.parse(localStorage.getItem('pengacakpg'));
                var pengacakpil = JSON.parse(localStorage.getItem('pengacakpil'));
                $.ajax({
                    type: 'POST',
                    url: homeurl + '/soal.php',
                    data: {
                        pg: 'soal',
                        id_mapel: idmapel,
                        id_siswa: idsiswa,
                        no_soal: 0,
                        ujian: ujianya,
                        soal: soalsoal,
                        pengacak: pengacak,
                        pengacakpil: pengacakpil,
                        idu: <?= $ac ?>
                    },
                    beforeSend: function() {
						$('#loading-image').show();
					},
                    success: function(response) {
                        num = 1;
                        $('#loading-image').hide();
                        $('#displaynum').html(num);
                        $('#loadsoal').html(response);
                        $('.fa-spin').hide();
                        
                        soalFont(fontSize);
                        //iCheckform();
                    }
                });
            }
            soalpertama();
            /* Font Adjusments */
            let defaultFontSize = 12;
            let fontSize = 0;
            fontSize = localStorage.getItem('fontSize');
            if (!fontSize) {
                fontSize = defaultFontSize;
                localStorage.setItem('fontSize', fontSize);
            }
            soalFont(fontSize);

            function soalFont(fontSize) {
                $('div.soal > p > span').css({
                    fontSize: fontSize + 'pt'
                });
                $('span.soal > p > span').css({
                    fontSize: fontSize + 'pt'
                });
                $('.soal').css({
                    fontSize: fontSize + 'pt'
                })
                $('.callout soal').css({
                    fontSize: fontSize + 'pt'
                })
            }

            $(document).ready(function() {
                $('#smaller_font').on('click', function() {
                    fontSize = localStorage.getItem('fontSize')
                    fontSize--;
                    localStorage.setItem('fontSize', fontSize)
                    soalFont(fontSize)
                });

                $('#bigger_font').on('click', function() {
                    fontSize = localStorage.getItem('fontSize')
                    fontSize++;
                    localStorage.setItem('fontSize', fontSize)
                    soalFont(fontSize)
                });

                $('#reset_font').on('click', function() {
                    fontSize = defaultFontSize
                    localStorage.setItem('fontSize', fontSize)
                    soalFont(fontSize)
                });
                function selesai() {
                    var idmapel = '<?= $id_mapel  ?>';
                    var idsiswa = '<?= $id_siswa  ?>';
                    $.ajax({
                        type: 'POST',
                        url: homeurl + '/selesai.php',
                        data: {
                            
                            id_mapel: idmapel,
                            id_siswa: idsiswa,
                            id_ujian: <?= $ac ?>
                        },
                        beforeSend: function() {
                            $('.loader').css('display', 'block');
                        },
                        success: function(response) {
                           
                            $('.loader').css('display', 'none');
                            location.href=homeurl;
                           
                           
                        }
                    });
                }
                $(document).on('click', '.done-btn', function() {
                    var idmapel = '<?= $id_mapel  ?>';
                    var idsiswa = '<?= $id_siswa  ?>';
                    $.ajax({
                        type: 'POST',
                        url: homeurl + '/cekselesai.php',
                        data: {
                            id_mapel: idmapel,
                            id_siswa: idsiswa,
                            id_ujian: <?= $ac ?>
                        },
                        success: function(response) {
                            if (response == 'ok') {
                                swal({
                                    title: 'Apa kamu yakin telah selesai?',
                                    html: 'Pastikan telah menyelesaikan semua dengan benar!',
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Iya'
                                }).then((result) => {
                                    if (result.value) {
                                        //window.onbeforeunload = null;
                                       selesai();
                                    }
                                })
                            } else if (response == 'ragu') {
                                swal({
                                    type: 'warning',
                                    title: 'Oops...',
                                    html: 'Masih ada soal yang masih ragu!!',
                                })
                            } else {
                                swal({
                                    type: 'warning',
                                    title: 'Oops...',
                                    html: 'Masih ada soal yang belum dikerjakan!!',
                                })
                            }

                        }
                    });

                });
                
                var result = '';
                $('.jawabesai').change(function() {
                    result = $(this).val();
                    $('#result').html(result);
                });

                var jam = $('#htmljam').html();
                var menit = $('#htmlmnt').html();
                var detik = $('#htmldtk').html();

                function hitung() {
                    setTimeout(hitung, 1000);
                    $('#countdown').html(jam + ':' + menit + ':' + detik);
                    detik--;
                    if (detik < 0) {
                        detik = 59;
                        menit--;
                        if (menit < 0) {
                            menit = 59;
                            jam--;
                            if (jam < 0) {
                                jam = 0;
                                menit = 0;
                                detik = 0;
                                selesai();
                            }
                        }
                    }
                }
                hitung();

            });

            function waktuhabis() {
                swal({
                    title: 'Oooo Oooww!',
                    text: 'Waktu Ujian Telah Habis',
                    timer: 1000,
                    onOpen: () => {
                        swal.showLoading()
                    }
                }).then((result) => {
                    selesai();
                });
            }

            function loadsoal(idmapel, idsiswa, nosoal) {

                if (nosoal >= 0 && nosoal<<?= $jumsoal ?>) {
                    curnum = $('#displaynum').html();
                    if (nosoal == curnum) {
                        $('#spin-next').show();
                    }
                    if (nosoal > curnum) {
                        $('#spin-next').show();
                    }
                    if (nosoal < curnum) {
                        $('#spin-prev').show();
                    }
                    var ujianya = JSON.parse(localStorage.getItem('ujianya'));
                    var soalsoal = JSON.parse(localStorage.getItem('soallokal'));
                    var pengacak = JSON.parse(localStorage.getItem('pengacakpg'));
                    var pengacakpil = JSON.parse(localStorage.getItem('pengacakpil'));
                    $.ajax({
                        type: 'POST',
                        url: homeurl + '/soal.php',
                        data: {
                            pg: 'soal',
                            id_mapel: idmapel,
                            id_siswa: idsiswa,
                            no_soal: nosoal,
                            soal: soalsoal,
                            pengacak: pengacak,
                            pengacakpil: pengacakpil,
                            ujian: ujianya

                        },
                        success: function(response) {
                            num = nosoal + 1;
                            $('#displaynum').html(num);
                            $('#loadsoal').html(response);
                            $('.fa-spin').hide();
                            $("#modalnosoal").modal('hide');
                            soalFont(fontSize);
                            //iCheckform();
                        }
                    });
                }
            }

            function jawabsoal(idmapel, idsiswa, idsoal, jawab, jawabQ, jenis, idu) {

                //console.log(idmapel + '-' + idsiswa + '-' + idsoal + '-' + jawab + '-' + jawabQ + '-' + jenis + '-' + idu)
                $.ajax({
                    type: 'POST',
                    url: homeurl + '/soal.php',
                    data: {
                        pg: 'jawab',
                        id_mapel: idmapel,
                        id_siswa: idsiswa,
                        id_soal: idsoal,
                        jawaban: jawab,
                        jenis: jenis,
                        idu: idu,
                        jawabx: jawabQ
                    },
                    success: function(response) {
                        //console.log(response);
                        if (response == 'OK') {
                            $('#nomorsoal #badge' + idsoal).removeClass('bg-gray');
                            $('#nomorsoal #badge' + idsoal).removeClass('bg-yellow');
                            $('#nomorsoal #badge' + idsoal).addClass('bg-green');
                            $('#nomorsoal #jawabtemp' + idsoal).html(jawabQ);
                            $('#ketjawab').load(window.location.href + ' #ketjawab');
                        }
                    }
                });
            }

            function jawabesai(idmapel, idsiswa, idsoal, jenis) {
                var jawab = $('#jawabesai').val();
                $.ajax({
                    type: 'POST',
                    url: homeurl + '/soal.php',
                    data: {
                        pg: 'jawab',
                        id_mapel: idmapel,
                        id_siswa: idsiswa,
                        id_soal: idsoal,
                        jawaban: jawab,
                        jenis: jenis,
                        idu: <?= $ac ?>
                    },
                    success: function(response) {
                        if (response == 'OK') {
                            toastr.success("jawaban berhasil disimpan");
                            $('#badge' + idsoal).removeClass('bg-gray');
                            $('#badge' + idsoal).removeClass('bg-yellow');
                            $('#badge' + idsoal).addClass('bg-green');
                            $('#ketjawab').load(window.location.href + ' #ketjawab');
                        }

                    }
                });
            }

            function radaragu(idmapel, idsiswa, idsoal, idu) {
                cekclass = $('#nomorsoal #badge' + idsoal).attr('class');
                if (cekclass != 'btn btn-app bg-gray') {
                    $.ajax({
                        type: 'POST',
                        url: homeurl + '/soal.php',
                        data: {
                            pg: 'ragu',
                            id_mapel: idmapel,
                            id_siswa: idsiswa,
                            id_soal: idsoal,
                            id_ujian: idu
                        },
                        success: function(response) {
                            console.log(response);
                            if (response == 'OK') {
                                if (cekclass == 'btn btn-app bg-green') {
                                    $('#nomorsoal #badge' + idsoal).removeClass('bg-gray');
                                    $('#nomorsoal #badge' + idsoal).removeClass('bg-green');
                                    $('#nomorsoal #badge' + idsoal).addClass('bg-yellow');
                                    console.log('kuning');
                                }
                                if (cekclass == 'btn btn-app bg-yellow') {
                                    $('#nomorsoal #badge' + idsoal).removeClass('bg-gray');
                                    $('#nomorsoal #badge' + idsoal).removeClass('bg-yellow');
                                    $('#nomorsoal #badge' + idsoal).addClass('bg-green');
                                    console.log('hijau');
                                }
                            }
                        }
                    });
                } else {
                    $('#load-ragu input').removeAttr('checked');
                }
            }
        </script>
    <?php endif; ?>
</body>

</html>