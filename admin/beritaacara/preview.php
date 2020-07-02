<?php if ($pengawas['level'] == 'admin') : ?>
    <?php
    $idberita = $_GET['id'];
    $sqlx = mysqli_query($koneksi, "SELECT * FROM berita a LEFT JOIN mapel b ON a.id_mapel=b.id_mapel LEFT JOIN mata_pelajaran c ON b.nama=c.kode_mapel WHERE a.id_berita='$idberita'");
    $ujian = mysqli_fetch_array($sqlx);
    $kodeujian = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jenis WHERE id_jenis='$ujian[jenis]'"));
    $hari = buat_tanggal('D', $ujian['tgl_ujian']);
    $tanggal = buat_tanggal('d', $ujian['tgl_ujian']);
    // $bulan = buat_tanggal('F', $ujian['tgl_ujian']);
    $bulan = bulan_indo($ujian['tgl_ujian']);
    $tahun = buat_tanggal('Y', $ujian['tgl_ujian']);
    if (date('m') >= 7 and date('m') <= 12) {
        $ajaran = date('Y') . "/" . (date('Y') + 1);
    } elseif (date('m') >= 1 and date('m') <= 6) {
        $ajaran = (date('Y') - 1) . "/" . date('Y');
    }
    ?>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-solid'>
                <div class='box-header'>
                    <h3 class='box-title'>Preview Berita Acara</h3>
                    <div class='box-tools pull-right '>
                        <button onclick="frames['printberita'].print()" class='btn btn-sm btn-flat btn-success'><i class='fa fa-print'></i> Print</button>
                        <iframe name='printberita' src='beritaacara.php?id=<?= $idberita ?>' style='border:none;width:1px;height:1px;'></iframe>
                    </div>
                </div>
                <div class='box-body' style='background:#c3c3c3;  height:1275px;'>
                    <div class='table-responsive'>
                        <div style='background:#fff; width:80%; margin:0 auto; padding:35px; height:90%;'>
                            <!-- <table border='0' width='100%'> -->
                            <table style="width:100%">
                                <tr>
                                    <td rowspan='4' width='120' align='center'>
                                        <img src='../foto/tut.jpg' width='80'>
                                    </td>
                                    <td colspan='2' align='center'>
                                        <font size='+1'>
                                            <b>BERITA ACARA PELAKSANAAN</b>
                                        </font>
                                    </td>
                                    <td rowspan='7' width='120' align='center'><img src='../<?= $setting['logo'] ?>' width='65'></td>
                                </tr>
                                <tr>
                                    <td colspan='2' align='center'>
                                        <font size='+1'><b> <?= strtoupper($kodeujian['nama']) ?></b></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='2' align='center'>
                                        <font size='+1'><b>TAHUN PELAJARAN <?= $ajaran ?></b></font>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table border='0' width='95%' align='center'>
                                <tr height='30'>
                                    <td height='30' colspan='4' style='text-align: justify;'>Pada hari ini <b> <?= $hari ?> </b> tanggal <b><?= $tanggal ?></b> bulan <b><?= $bulan ?></b> tahun <b><?= $tahun ?></b>, di <?= $setting['sekolah'] ?> telah diselenggarakan "<?= ucwords(strtolower($kodeujian['nama'])) ?>" untuk Mata Pelajaran <b><?= $ujian['nama_mapel'] ?></b> dari pukul <b><?= $ujian['mulai'] ?></b> sampai dengan pukul <b><?= $ujian['selesai'] ?></b></td>
                                </tr>
                            </table>
                            <table border='0' width='95%' align='center'>
                                <tr height='30'>
                                    <td height='30' width='5%'>1.</td>
                                    <td height='30' width='30%'>Kode Sekolah</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $setting['kode_sekolah'] ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='10px'></td>
                                    <td height='30'>Sekolah/Madrasah</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $setting['sekolah'] ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='30%'>Sesi</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ujian['sesi'] ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='30%'>Ruang</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ujian['ruang'] ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='10px'></td>
                                    <td height='30'>Jumlah Peserta Seharusnya</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ujian['ikut'] + $ujian['susulan'] ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='30%'>Jumlah Hadir (Ikut Ujian)</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ujian['ikut'] ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='10px'></td>
                                    <td height='30'>Jumlah Tidak Hadir</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ujian['susulan'] ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='10px'></td>
                                    <td height='30'>Nomer Peserta</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'>
                                        <?php
                                        $dataArray = unserialize($ujian['no_susulan']);
                                        if ($dataArray) {
                                            foreach ($dataArray as $key => $value) {
                                                echo "<small class='label label-success'>$value </small>&nbsp;";
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='10px'></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='5%'>2.</td>
                                    <td colspan='2' height='30' width='30%'>
                                        Catatan selama pelaksanaan ujian "<?= ucwords(strtolower($kodeujian['nama'])) ?>"
                                    </td>
                                </tr>
                                <tr height='120px'>
                                    <td height='30' width='5%'></td>
                                    <td colspan='2' style='border:solid 1px black'><?= $ujian['catatan'] ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' colspan='2' width='5%'>Yang membuat berita acara: </td>
                                </tr>
                            </table>
                            <table border='0' width='80%' style='margin-left:50px'>
                                <tr>
                                    <td colspan='4'></td>
                                    <td height='30' width='30%'>TTD</td>
                                <tr>
                                    <td width='10%'>1. </td>
                                    <td width='20%'>Proktor</td>
                                    <td width='30%' style='border-bottom:thin solid #000000'><?= $ujian['nama_proktor'] ?></td>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='35%'></td>
                                </tr>
                                <tr>
                                    <td width='10%'> </td>
                                    <td width='20%'>NIP. </td>
                                    <td width='30%' style='border-bottom:thin solid #000000'><?= $ujian['nip_proktor'] ?></td>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='35%' style='border-bottom:thin solid #000000'> 1. </td>
                                </tr>
                                <tr>
                                    <td colspan='4'></td>
                                </tr>
                                <tr>
                                    <td width='10%'>2. </td>
                                    <td width='20%'>Pengawas</td>
                                    <td width='30%' style='border-bottom:thin solid #000000'><?= $ujian['nama_pengawas'] ?></td>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='35%'></td>
                                </tr>
                                <tr>
                                    <td width='10%'> </td>
                                    <td width='20%'>NIP. </td>
                                    <td width='30%' style='border-bottom:thin solid #000000'><?= $ujian['nip_pengawas'] ?></td>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='35%' style='border-bottom:thin solid #000000'> 2. </td>
                                </tr>
                                <tr>
                                    <td colspan='4'></td>
                                </tr>
                                <tr>
                                    <td width='10%'>3. </td>
                                    <td width='20%'>Kepala Sekolah</td>
                                    <td width='30%' style='border-bottom:thin solid #000000'><?= $setting['kepsek'] ?></td>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='35%'></td>
                                </tr>
                                <tr>
                                    <td width='10%'> </td>
                                    <td width='20%'>NIP. </td>
                                    <td width='30%' style='border-bottom:thin solid #000000'><?= $setting['nip'] ?></td>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='35%' style='border-bottom:thin solid #000000'> 3. </td>
                                </tr>
                            </table>
                            <br><br><br><br><br>
                            <table width='100%' height='30'>
                                <tbody>
                                    <tr>
                                        <td width='25px' style='border:1px solid black'></td>
                                        <td width='5px'>&nbsp;</td>
                                        <td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</td>
                                        <td width='5px'>&nbsp;</td>
                                        <td width='25px' style='border:1px solid black'></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>