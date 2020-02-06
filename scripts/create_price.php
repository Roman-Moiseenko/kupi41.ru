<?php
const TIME_LIMIT = 1000;

define('ROOT','kupi41.ru/public_html/');
define('ROOT_LOAD', ROOT . 'data/price/');

spl_autoload_register(function ($class_name) {
    $array_path = array('models/', 'controllers/', 'classes/');
    foreach ($array_path as $path)    {
        $path = ROOT . $path . $class_name . '.php';

        if (is_file($path)) {
            include_once ($path);
        }
    }
});

$priceXLS = new PHPExcel();
$priceXLS->setActiveSheetIndex(0);
$sheet = $priceXLS->getActiveSheet();
$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$sheet->getPageSetup()->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$sheet->getPageMargins()->setTop(1);
$sheet->getPageMargins()->setRight(0.75);
$sheet->getPageMargins()->setLeft(0.75);
$sheet->getPageMargins()->setBottom(1);
$sheet->getPageSetup()->setFitToWidth(1);
$sheet->getPageSetup()->setFitToHeight(0);

$priceXLS->getDefaultStyle()->getFont()->setName('Arial');
$priceXLS->getDefaultStyle()->getFont()->setSize(8);

//1
$sheet->getColumnDimension('A')->setWidth(1);
$sheet->getColumnDimension('B')->setWidth(98);
$sheet->getColumnDimension('C')->setWidth(12);
$sheet->getColumnDimension('D')->setWidth(6);

$sheet->mergeCells('B1:D1');
$sheet->getRowDimension('1')->setRowHeight(32);

$style_info = array('alignment' => array('horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
                                         'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER),
    'font' => array('size' => 14, 'bold' => true)
);
$style_caption = array(
    'font' => array('size' => 12, 'bold' => true)
);
$style_border = array('borders'=>array('allborders' => array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb'=>'000000'))));
$style_catalog = array(
    'font' => array('size' => 10, 'bold' => true),
    'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'cecece'))
);


$sheet->getStyle('B1')->applyFromArray($style_info);
App::gI()->info->load();
$sheet->setCellValue('B1',App::gI()->info->name);

$sheet->setCellValue('B2','Дата прайс-листа:' . date('d - m - Y'));
$sheet->setCellValue('B4', 'Наименования');
$sheet->setCellValue('C4', 'Цена');
$sheet->setCellValue('D4', 'Ед.');

$sheet->getStyle('B4:D4')->applyFromArray($style_caption);
$row = 4;

$catalog = Catalog::loadFromDB();
$price_array = Catalog::getPrice($catalog);

foreach ($price_array as $item) {
    $row++;

    if (isset($item['flag'])) {
        $_l = '';
        $sheet->getStyle('B'.$row.':D'.$row)->applyFromArray($style_catalog);

        for ($i=0;$i<(int)($item['flag']);$i++) $_l .= ' ';

    }
    $sheet->setCellValue('B'.$row, $_l . $item['name']);

    $sheet->getStyle('C'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1. "[\$ ₽-419]");
    $sheet->setCellValue('C'.$row, $item['price']);
    $sheet->setCellValue('D'.$row, $item['unit']);

}
$sheet->getStyle('B4:D'.$row)->applyFromArray($style_border);

unlink(ROOT_LOAD .'price.xlsx');
$objWriter = new PHPExcel_Writer_Excel2007($priceXLS);
$objWriter->save(ROOT_LOAD .'price.xlsx');

