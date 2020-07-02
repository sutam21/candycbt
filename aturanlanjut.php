<?php

//defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
$idu = dekripsi($ac);

$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$idu'"));
$idmapel = $query['id_mapel'];

$where = array(
    'id_mapel' => $idmapel

);
$wherepg = array(
    'id_mapel' => $idmapel,
    'jenis' => '1'

);
$where2 = array(
    'id_mapel' => $idmapel,
    'jenis' => '2',
);
$wherelanjut = array(
    'id_mapel' => $idmapel,
	'id_ujian' => $idu,
	'id_siswa' => $_SESSION['id_siswa']
    
);
$mapel = fetch($koneksi, 'ujian', array('id_mapel' => $idmapel, 'id_ujian' => $idu));

$id_acak = [];

$soalsoal = select($koneksi, 'soal', $where);
foreach ($soalsoal as $soalnya) :
    $id_acak[] = $soalnya;
endforeach;
$acak = json_encode($id_acak);
$acak = enkripsi($acak);

$ujian = select($koneksi, 'ujian', array('id_mapel' => $idmapel, 'id_ujian' => $idu));
$ujianarray = [];
foreach ($ujian as $ujianya) :
    $ujianarray[] = $ujianya;
endforeach;
$ujianarray = json_encode($ujianarray);
$ujianarray = enkripsi($ujianarray);
$nilai=fetch($koneksi, 'nilai',$wherelanjut);

 ?>
<script>
    var acak = '<?= $acak ?>';
    var acakpg = '<?= $nilai['id_soal'] ?>';
    var ujian = '<?= $ujianarray ?>';
	//if (localStorage.getItem("soallokal") === null) {
		localStorage.setItem("ujianya", JSON.stringify(ujian));
		localStorage.setItem("soallokal", JSON.stringify(acak));
		localStorage.setItem("pengacakpg", JSON.stringify(acakpg));
  
	//}
    
</script>
<?php if ($mapel['ulang'] == 1) { ?>
    <script>
        var acakopsi = '<?= $nilai['id_opsi'] ?>';
		if (localStorage.getItem("pengacakpil") === null) {
        localStorage.setItem("pengacakpil", JSON.stringify(acakopsi));
		}
    </script>
<?php } ?>