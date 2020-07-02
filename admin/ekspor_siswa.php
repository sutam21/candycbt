<?php
require "../config/config.default.php";
require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'NIS');
$sheet->setCellValue('C1', 'NO_PESERTA');
$sheet->setCellValue('D1', 'NAMA');
$sheet->setCellValue('E1', 'LEVEL');
$sheet->setCellValue('F1', 'KELAS');
$sheet->setCellValue('G1', 'JURUSAN');
$sheet->setCellValue('H1', 'SESI');
$sheet->setCellValue('I1', 'RUANG');
$sheet->setCellValue('J1', 'USERNAME');
$sheet->setCellValue('K1', 'PASSWORD');
$sheet->setCellValue('L1', 'FOTO');
$sheet->getStyle('A1:L1')->applyFromArray(
    array(
        'fill' => array(
            'type' => Fill::FILL_SOLID,
            'color' => array('rgb' => '00FF00')
        ),
        'font'  => array(
            'bold'  =>  true
        )
    )
);
$query = mysqli_query($koneksi, "SELECT * FROM siswa");
$i = 2;
$no = 1;
while ($row = mysqli_fetch_array($query)) {
    $sheet->setCellValue('A' . $i, $row['id_siswa']);
    $sheet->setCellValue('B' . $i, $row['nis']);
    $sheet->setCellValue('C' . $i, $row['no_peserta']);
    $sheet->setCellValue('D' . $i, $row['nama']);
    $sheet->setCellValue('E' . $i, $row['level']);
    $sheet->setCellValue('F' . $i, $row['id_kelas']);
    $sheet->setCellValue('G' . $i, $row['idpk']);
    $sheet->setCellValue('H' . $i, $row['sesi']);
    $sheet->setCellValue('I' . $i, $row['ruang']);
    $sheet->setCellValue('J' . $i, $row['username']);
    $sheet->setCellValue('K' . $i, $row['password']);
    $sheet->setCellValue('L' . $i, $row['foto']);
    $i++;
}
foreach (range('A', 'L') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_MEDIUM,
            'color' => array('argb' => '000000'),
        ],
    ],
];
$i = $i - 1;
$sheet->getStyle('A2:L' . $i)->applyFromArray($styleArray);


$writer = new Xlsx($spreadsheet);
$filename = 'datasiswa';
header('Content-Type: application/vnd.ms-excel'); // generate excel file
header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
