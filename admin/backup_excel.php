<?php

require("../config/config.default.php");
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:login.php') : null;

$mapel_id = @$_GET['mapel_id'];
$pengenal = explode(";", $mapel_id);
$nama_mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT nama_mapel FROM mata_pelajaran WHERE kode_mapel='$pengenal[1]'"));

if (!file_exists('backup_soal')) {
    mkdir('backup_soal', 0777, true);
}

// ekspor ke excel
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$soal_mapel = mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$pengenal[0]'");

$file_excel = $pengenal[0] . "-" . $nama_mapel['nama_mapel'] . ".xlsx";
$file_excel_old = $pengenal[0] . "-" . $nama_mapel['nama_mapel'] . ".xls";
$spreadsheet = new Spreadsheet();

$spreadsheet->getProperties()
    ->setCreator("Candy CBT")
    ->setLastModifiedBy("Candy CBT")
    ->setTitle("Office 2007 XLSX for CandyCBT")
    ->setSubject("Office 2007 XLSX for CandyCBT")
    ->setDescription("Office 2007 XLSX for CandyCBT")
    ->setKeywords("Office 2007 XLSX for CandyCBT")
    ->setCategory("Office 2007 XLSX for CandyCBT");

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(7);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(6);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(5);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20);
$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);


$styleArray = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startColor' => [
            'argb' => 'FFA0A0A0',
        ],
        'endColor' => [
            'argb' => 'FFFFFFFF',
        ],
    ],
];

$spreadsheet->getActiveSheet()->getStyle('A1:P1')->applyFromArray($styleArray);
$sheet = $spreadsheet->getActiveSheet();
// BUAT HEADER SOAL
$sheet->setCellValue('A1', 'No Soal');
$sheet->setCellValue('B1', 'Soal');
$sheet->setCellValue('C1', 'PilA');
$sheet->setCellValue('D1', 'PilB');
$sheet->setCellValue('E1', 'PilC');
$sheet->setCellValue('F1', 'PilD');
$sheet->setCellValue('G1', 'PilE');
$sheet->setCellValue('H1', 'jawab');
$sheet->setCellValue('I1', 'Jenis');
$sheet->setCellValue('J1', 'file1');
$sheet->setCellValue('K1', 'file2');
$sheet->setCellValue('L1', 'fileA');
$sheet->setCellValue('M1', 'fileB');
$sheet->setCellValue('N1', 'fileC');
$sheet->setCellValue('O1', 'fileD');
$sheet->setCellValue('P1', 'fileE');
// insert record
// $data = mysqli_fetch_array($soal_mapel);
// $jr = mysqli_num_rows($soal_mapel) + 1;
$i = 2;
while ($data = mysqli_fetch_array($soal_mapel)) :
    $sheet->setCellValue('A' . $i, $data['nomor']);
    $sheet->setCellValue('B' . $i, $data['soal']);
    $sheet->setCellValue('C' . $i, $data['pilA']);
    $sheet->setCellValue('D' . $i, $data['pilB']);
    $sheet->setCellValue('E' . $i, $data['pilC']);
    $sheet->setCellValue('F' . $i, $data['pilD']);
    $sheet->setCellValue('G' . $i, $data['pilE']);
    $sheet->setCellValue('H' . $i, $data['jawaban']);
    $sheet->setCellValue('I' . $i, $data['jenis']);
    $sheet->setCellValue('J' . $i, $data['file']);
    $sheet->setCellValue('K' . $i, $data['file1']);
    $sheet->setCellValue('L' . $i, $data['fileA']);
    $sheet->setCellValue('M' . $i, $data['fileB']);
    $sheet->setCellValue('N' . $i, $data['fileC']);
    $sheet->setCellValue('O' . $i, $data['fileD']);
    $sheet->setCellValue('P' . $i, $data['fileE']);
    $i++;
endwhile;
$spreadsheet->getActiveSheet()->setTitle('CandyCBT');
$writer = new Xlsx($spreadsheet);
$writer->save($file_excel);

$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
$writer->save($file_excel_old);

if (file_exists($file_excel)) {
    $array[] =  $file_excel;
}
if (file_exists($file_excel_old)) {
    $array[] =  $file_excel_old;
}

// backup zip
$mapel = mysqli_query($koneksi, "SELECT `file`, file1, fileA, fileB, fileC, fileD, fileE FROM soal WHERE id_mapel='$pengenal[0]'");
while ($mapelb = mysqli_fetch_array($mapel)) :
    if ($mapelb['file'] <> "") {
        $file = $mapelb['file'];
        $path = '../files/' . $mapelb['file'];
        if (file_exists($path)) {
            copy($path, $file);
            $array[] =  $file;
        }
    }
    if ($mapelb['file1'] <> "") {
        $file = $mapelb['file1'];
        $path = '../files/' . $mapelb['file1'];
        if (file_exists($path)) {
            copy($path, $file);
            $array[] =  $file;
        }
    }
    if ($mapelb['fileA'] <> "") {
        $file = $mapelb['fileA'];
        $path = '../files/' . $mapelb['fileA'];
        if (file_exists($path)) {
            copy($path, $file);
            $array[] =  $file;
        }
    }
    if ($mapelb['fileB'] <> "") {
        $file = $mapelb['fileB'];
        $path = '../files/' . $mapelb['fileB'];
        if (file_exists($path)) {
            copy($path, $file);
            $array[] =  $file;
        }
    }
    if ($mapelb['fileC'] <> "") {
        $file = $mapelb['fileC'];
        $path = '../files/' . $mapelb['fileC'];
        if (file_exists($path)) {
            copy($path, $file);
            $array[] =  $file;
        }
    }
    if ($mapelb['fileD'] <> "") {
        $file = $mapelb['fileD'];
        $path = '../files/' . $mapelb['fileD'];
        if (file_exists($path)) {
            copy($path, $file);
            $array[] =  $file;
        }
    }
    if ($mapelb['fileE'] <> "") {
        $file = $mapelb['fileE'];
        $path = '../files/' . $mapelb['fileE'];
        if (file_exists($path)) {
            copy($path, $file);
            $array[] =  $file;
        }
    }
endwhile;



if (isset($array)) :
    $backup_file = 'backup_soal/' . $pengenal[0] . "-" . $nama_mapel['nama_mapel'] . '.zip';
    if (file_exists($backup_file)) {
        unlink($backup_file);
    }
    $jumlah_array = count($array);
    $zip = new ZipArchive;
    if ($zip->open($backup_file, ZipArchive::CREATE) === TRUE) {
        for ($i = 0; $i < $jumlah_array; $i++) :
            $zip->addFile($array[$i]);
        endfor;
        $zip->close();
    }
    for ($i = 0; $i < $jumlah_array; $i++) :
        unlink($array[$i]);
    endfor;
?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        Master soal <?= $nama_mapel['nama_mapel']; ?> telah diproses.<br />
        Silahkan mendownload dengan mengklik
        <a href="<?= $backup_file ?>"><button class="btn btn-info"> download file</button></a>
    </div>
<?php else : ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        Master soal <?= $nama_mapel['nama_mapel']; ?> gagal diproses.<br />
    </div>
<?php endif; ?>