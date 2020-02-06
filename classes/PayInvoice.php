<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 20.02.2019
 * Time: 12:53
 */

class PayInvoice extends Pay
{
    public function PayOrder(Order &$order)
    {
        parent::PayOrder($order);
        $order->orderstatus = Order::ORDER_INVOICE;
        $order->save();
        //$paydoc = new Paydoc();
        $order->paydoc->user = App::gI()->user->id;
        $order->paydoc->productorder = $order->id;
        $order->paydoc->datepaydoc = time();
        $order->paydoc->numberpaydoc = 'ИМ-' . $order->id;
        $order->paydoc->typepaydoc = Paydoc::PAY_INVOICE;
        $order->paydoc->save();
        //$paydoc->loadPaydoc();
        $_SESSION['invoice'] = true;
        //return $order->id;

    }

    public function loadPaydoc($params = array()) {
        if (is_object($params)) $params = json_decode((json_encode($params)), true);
        extract($params);
        //TODO
        $invoiceXLS = new PHPExcel();
        $invoiceXLS->setActiveSheetIndex(0);
        $sheet = $invoiceXLS->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet->getPageMargins()->setTop(1);
        $sheet->getPageMargins()->setRight(0.75);
        $sheet->getPageMargins()->setLeft(0.75);
        $sheet->getPageMargins()->setBottom(1);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        /** !!!!!!!!!!!! */
        $sheet->setTitle('Счет N ' . $numberpaydoc);

        $invoiceXLS->getDefaultStyle()->getFont()->setName('Arial');
        $invoiceXLS->getDefaultStyle()->getFont()->setSize(8);

        //1
        $sheet->getColumnDimension('A')->setWidth(1);
        foreach(['B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA', 'AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL'] as $letter) {
            $sheet->getColumnDimension($letter)->setWidth(3.5);
        }
        //Шапка - ИНТРО
        $sheet->mergeCells('B1:AL1');
        $sheet->getRowDimension('1')->setRowHeight(40);
        $sheet->setCellValue('B1','Внимание! Оплата данного счета означает согласие с условиями '
            . ' поставки товара. Уведомление об оплате обязательно, в противном случае не гарантируется '
            . 'наличие товара на складе. Товар отпускается по факту прихода денег на р/с Поставщика, '
            . 'самовывозом, при наличии доверенности и паспорта.');
        $style_tdate = array('alignment' => array('horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER),
            'font' => array('size' => 8)
        );
        $sheet->getStyle('B1')->applyFromArray($style_tdate);
        $sheet->getStyle('B1')->getAlignment()->setWrapText(true);


        //Шапка - Получатель
        $sheet->mergeCells('B2:AL2');
        $sheet->getRowDimension('2')->setRowHeight(32);
        $sheet->setCellValue('B2','Счет действителен в течение семи банковских дней, в случае не '
            . 'оплаты данный счет анулируется, товар снимается с резерва.');
        $style_tdate = array('alignment' => array('horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER),
            'font' => array('size' => 11, 'bold' => true)
        );
        $style_border = array('borders'=>array('outline' => array('style'=>PHPExcel_Style_Border::BORDER_MEDIUM,'color' => array('rgb'=>'000000')))
        );
        $sheet->getStyle('B2')->applyFromArray($style_tdate);
        $sheet->getStyle('B2:AL2')->applyFromArray($style_border);
        $sheet->getStyle('B2')->getAlignment()->setWrapText(true);
        foreach (['B3:S4','B5:S5','B6:C6','B7:S8','B9:S9','D6:J6','K6:L6','M6:S6','T3:V3','T4:V5','T6:V9','W3:AL3','W4:AL5','W6:AL9'] as $letter) {
            $sheet->mergeCells($letter);
        }
        $style_border_thin = array('borders'=>array('outline' => array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb'=>'000000')))
        );

        foreach (['B3:S5','B6:J6','B7:S9','K6:S6','T3:V3','T4:V5','T6:V9','W3:AL5','W6:AL9'] as $letter) {
            $sheet->getStyle($letter)->applyFromArray($style_border_thin);
        }
        $style_tdate = array('alignment' => array('horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
            'font' => array('size' => 10)
        );
        $sheet->getStyle('B3:AL9')->applyFromArray($style_tdate);
        $style_tdate = array('alignment' => array('horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT),
            'font' => array('size' => 8)
        );

        $sheet->getStyle('B5')->applyFromArray($style_tdate);
        $sheet->getStyle('B9')->applyFromArray($style_tdate);
        $sheet->setCellValue('B5','Банк получателя');
        $sheet->setCellValue('B9','Получатель');

        $sheet->setCellValue('B6','ИНН');
        $sheet->setCellValue('K6','КПП');
        $sheet->setCellValue('T3','БИК');
        $sheet->setCellValue('T4','Сч.№');
        $sheet->setCellValue('T6','Сч.№');

        $sheet->setCellValue('B3',App::gI()->info->bank);
        $sheet->setCellValue('W3',App::gI()->info->BIK);
        $sheet->setCellValue('W4',App::gI()->info->accountbank);
        $sheet->setCellValue('W6',App::gI()->info->account);
        $sheet->setCellValue('D6',App::gI()->info->INN);
        $sheet->setCellValue('M6',App::gI()->info->KPP);
        $sheet->setCellValue('B7',App::gI()->info->name);

        //Счет

        $sheet->mergeCells('B11:AL11');
        $sheet->getRowDimension('11')->setRowHeight(40);
        $style_tdate = array('alignment' => array('horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'font' => array('size' => 14, 'bold' => true),
            'borders' => array('bottom' => array('style'=>PHPExcel_Style_Border::BORDER_MEDIUM,'color' => array('rgb'=>'000000')))
        );
        $sheet->getStyle('B11:AL11')->applyFromArray($style_tdate);
        /** !!!!!!!!!!!! */
        $sheet->setCellValue('B11','Счет на оплату № ' . $numberpaydoc . ' от ' . _f::dateToHTML($datepaydoc));

        //Поставщик
        $style_tdate = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'font' => array('size' => 9));
        $sheet->getStyle('B13')->applyFromArray($style_tdate);
        $sheet->mergeCells('B13:G13');
        $sheet->setCellValue('B13','Поставщик:');
        $sheet->mergeCells('H13:AL13');
        $style_tdate = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'font' => array('size' => 9, 'bold' => true));
        $sheet->getStyle('H13')->applyFromArray($style_tdate);
        $sheet->setCellValue('H13',App::gI()->info->name . ', ИНН '.App::gI()->info->INN . ', КПП '.App::gI()->info->KPP . ', ' . App::gI()->info->address);
        $sheet->getRowDimension('13')->setRowHeight(32);
        $sheet->getStyle('H13')->getAlignment()->setWrapText(true);
        //Грузотправитель
        $style_tdate = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'font' => array('size' => 9));
        $sheet->getStyle('B15')->applyFromArray($style_tdate);
        $sheet->mergeCells('B15:G15');
        $sheet->setCellValue('B15','Грузотправитель:');
        $sheet->mergeCells('H15:AL15');
        $style_tdate = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'font' => array('size' => 9, 'bold' => true));
        $sheet->getStyle('H15')->applyFromArray($style_tdate);
        $sheet->setCellValue('H15',App::gI()->info->name . ', ИНН '.App::gI()->info->INN . ', КПП '.App::gI()->info->KPP . ', ' . App::gI()->info->address);
        $sheet->getRowDimension('15')->setRowHeight(32);
        $sheet->getStyle('H15')->getAlignment()->setWrapText(true);

        //Получатель
        $firm = json_decode(App::gI()->user->firm, true);
        $style_tdate = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'font' => array('size' => 9));
        $sheet->getStyle('B17')->applyFromArray($style_tdate);
        $sheet->mergeCells('B17:G17');
        $sheet->setCellValue('B17','Получатель:');
        $sheet->mergeCells('H17:AL17');
        $style_tdate = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'font' => array('size' => 9, 'bold' => true));
        $sheet->getStyle('H17')->applyFromArray($style_tdate);
        $sheet->setCellValue('H17',$firm['namefirm'] . ', ИНН '. $firm['INN'] . ', КПП '. $firm['KPP']. ', ' . App::gI()->user->address);
        $sheet->getRowDimension('17')->setRowHeight(32);
        $sheet->getStyle('H17')->getAlignment()->setWrapText(true);
        //die('error0');
        //Грузополучатель
        $firm = json_decode(App::gI()->user->firm, true);
        $style_tdate = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'font' => array('size' => 9));
        $sheet->getStyle('B19')->applyFromArray($style_tdate);
        $sheet->mergeCells('B19:G19');
        $sheet->setCellValue('B19','Грузополучатель:');
        $sheet->mergeCells('H19:AL19');
        $style_tdate = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'font' => array('size' => 9, 'bold' => true));
        $sheet->getStyle('H19')->applyFromArray($style_tdate);
        $sheet->setCellValue('H19',$firm['namefirm'] . ', ИНН '. $firm['INN'] . ', КПП '. $firm['KPP']. ', ' . App::gI()->user->address);
        $sheet->getRowDimension('19')->setRowHeight(32);
        $sheet->getStyle('H19')->getAlignment()->setWrapText(true);

        //Шапка таблицы

        foreach (['B21:C21','D21:X21','Y21:AA21','AB21:AC21','AD21:AG21','AH21:AL21'] as $letter) {
            $sheet->mergeCells($letter);
        }
        $style_tdate = array('alignment' => array('horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'font' => array('size' => 10, 'bold' => true));
        $sheet->getStyle('B21:AL21')->applyFromArray($style_tdate);
        $sheet->setCellValue('B21','№');
        $sheet->setCellValue('D21','Товары (работы, услуги)');
        $sheet->setCellValue('Y21','Кол-во');
        $sheet->setCellValue('AB21','Ед.');
        $sheet->setCellValue('AD21','Цена');
        $sheet->setCellValue('AH21','Сумма');
        $row = 21; $i = 0;
        /** !!!!!!!!!!!! */
        $order = Order::model($productorder);

        $products = Extproduct::_models(0,$order->products);
        foreach ($products as $id => $product)
        {
            $i++;
            foreach (['B'.(int)($row + $i).':C'.(int)($row + $i),'D'.(int)($row + $i).':X'.(int)($row + $i),
                         'Y'.(int)($row + $i).':AA'.(int)($row + $i),'AB'.(int)($row + $i).':AC'.(int)($row + $i),
                         'AD'.(int)($row + $i).':AG'.(int)($row + $i),'AH'.(int)($row + $i).':AL'.(int)($row + $i)] as $letter) {
                $sheet->mergeCells($letter);
            }

            $sheet->setCellValue('B'.(int)($row + $i), $i );
            $sheet->setCellValue('D'.(int)($row + $i),$product->name);
            $sheet->setCellValue('Y'.(int)($row + $i),$product->count);
            $sheet->setCellValue('AB'.(int)($row + $i),$product->unit);
            $sheet->getStyle('AD'.(int)($row + $i))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $sheet->setCellValue('AD'.(int)($row + $i),$product->price);
            $sheet->getStyle('AH'.(int)($row + $i))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $sheet->setCellValue('AH'.(int)($row + $i), (int)($product->count) * (float)($product->price));
        }
        $style_border = array('borders'=>array('outline'     => array('style'=>PHPExcel_Style_Border::BORDER_MEDIUM,'color' => array('rgb'=>'000000')),
            'inside'  => array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb'=>'000000')))
        );
        $sheet->getStyle('B21:AL' . (int)($row + $i))->applyFromArray($style_border);
        $style_tdate = array('alignment' => array('horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_RIGHT),
            'font' => array('size' => 10, 'bold' => true));
        $row += $i;
        $row++;
        $sheet->getRowDimension($row)->setRowHeight(9);

        //Итого
        $row++;
        $sheet->getStyle('AC'.$row.':AL'.($row + 3))->applyFromArray($style_tdate);
        $sheet->mergeCells('AD'.$row.':AG'.$row);
        $sheet->setCellValue('AD'.$row,'Итого:');
        $sheet->mergeCells('AH'.$row.':AL'.$row);
        $sheet->getStyle('AH'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $sheet->setCellValue('AH'.$row, $order->total);

        $row++;
        $sheet->mergeCells('AD'.$row.':AG'.$row);
        $sheet->setCellValue('AD'.$row,'Сумма НДС:');
        $sheet->mergeCells('AH'.$row.':AL'.$row);
        $sheet->setCellValue('AH'.$row, '-');

        $row++;
        $sheet->mergeCells('AC'.$row.':AG'.$row);
        $sheet->setCellValue('AC'.$row,'Всего к оплате:');
        $sheet->mergeCells('AH'.$row.':AL'.$row);
        $sheet->getStyle('AH'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $sheet->setCellValue('AH'.$row, $order->total);

        $row++;
        $style_tdate = array('font' => array('size' => 10));
        $sheet->getStyle('B'.$row.':AL'.$row)->applyFromArray($style_tdate);
        $sheet->mergeCells('B'.$row.':AL'.$row);
        $sheet->setCellValue('B'.$row,'Всего наименований '. $i .' на сумму '. number_format($order->total, 2, ',' , ' '));

        $row++;
        $style_tdate = array('font' => array('size' => 10, 'bold' => true));
        $sheet->mergeCells('B'.$row.':AL'.$row);
        $sheet->getStyle('B'.$row.':AL'.$row)->applyFromArray($style_tdate);
        $str = _f::num2str($order->total);
        $str = mb_strtoupper(mb_substr($str, 0, 1, "UTF-8"), 'UTF-8').mb_substr($str, 1, mb_strlen($str), "UTF-8" );
        $sheet->setCellValue('B'.$row, $str); //Сумма прописью

        $row++;
        $style_tdate = array('borders' => array('bottom' => array('style'=>PHPExcel_Style_Border::BORDER_MEDIUM,'color' => array('rgb'=>'000000')))
        );
        $sheet->getStyle('B'.$row.':AL'.$row)->applyFromArray($style_tdate);
        $sheet->getRowDimension($row)->setRowHeight(9);

        //Подписи
        $style_title = array('font' => array('size' => 9, 'bold' => true));
        $style_caption = array('font' => array('size' => 8),
            'alignment' => array('horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER));
        $style_person = array('font' => array('size' => 9, 'bold' => true),
            'alignment' => array('horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER));
        $style_border = array('borders' => array('bottom' => array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb'=>'000000'))));
        $row +=2;
        $sheet->mergeCells('B'.$row.':F'.$row);
        $sheet->getStyle('B'.$row.':F'.$row)->applyFromArray($style_title);
        $sheet->setCellValue('B'.$row,'Руководитель');

        $sheet->mergeCells('H'.$row.':P'.$row);
        $sheet->getStyle('H'.$row.':P'.$row)->applyFromArray($style_border);
        $sheet->getStyle('R'.$row.':AA'.$row)->applyFromArray($style_border);
        $sheet->getStyle('AC'.$row.':AL'.$row)->applyFromArray($style_border);
        $sheet->mergeCells('AC'.$row.':AL'.$row);
        $sheet->getStyle('AC'.$row.':AL'.$row)->applyFromArray($style_person);
        $sheet->setCellValue('AC'.$row,App::gI()->info->director);

        $row++;
        $sheet->mergeCells('H'.$row.':P'.$row);
        $sheet->getStyle('H'.$row.':P'.$row)->applyFromArray($style_caption);
        $sheet->setCellValue('H'.$row, 'должность');
        $sheet->mergeCells('R'.$row.':AA'.$row);
        $sheet->getStyle('R'.$row.':AA'.$row)->applyFromArray($style_caption);
        $sheet->setCellValue('R'.$row, 'подпись');
        $sheet->mergeCells('AC'.$row.':AL'.$row);
        $sheet->getStyle('AC'.$row.':AL'.$row)->applyFromArray($style_caption);
        $sheet->setCellValue('AC'.$row, 'расшифровка подписи');
        $sheet->getRowDimension($row)->setRowHeight(14);

        $row += 2;
        $sheet->mergeCells('B'.$row.':J'.$row);
        $sheet->getStyle('B'.$row.':J'.$row)->applyFromArray($style_title);
        $sheet->setCellValue('B'.$row,'Главный (старший) бухгалтер');


        $sheet->getStyle('R'.$row.':AA'.$row)->applyFromArray($style_border);
        $sheet->getStyle('AC'.$row.':AL'.$row)->applyFromArray($style_border);
        $sheet->mergeCells('AC'.$row.':AL'.$row);
        $sheet->getStyle('AC'.$row.':AL'.$row)->applyFromArray($style_person);
        $sheet->setCellValue('AC'.$row,App::gI()->info->accountant);

        $row++;
        $sheet->mergeCells('R'.$row.':AA'.$row);
        $sheet->getStyle('R'.$row.':AA'.$row)->applyFromArray($style_caption);
        $sheet->setCellValue('R'.$row, 'подпись');
        $sheet->mergeCells('AC'.$row.':AL'.$row);
        $sheet->getStyle('AC'.$row.':AL'.$row)->applyFromArray($style_caption);
        $sheet->setCellValue('AC'.$row, 'расшифровка подписи');
        $sheet->getRowDimension($row)->setRowHeight(14);

        $row += 2;
        $sheet->mergeCells('B'.$row.':J'.$row);
        $sheet->getStyle('B'.$row.':J'.$row)->applyFromArray($style_title);
        $sheet->setCellValue('B'.$row,'Ответственный');


        $sheet->getStyle('R'.$row.':AA'.$row)->applyFromArray($style_border);
        $sheet->getStyle('AC'.$row.':AL'.$row)->applyFromArray($style_border);
        $sheet->mergeCells('AC'.$row.':AL'.$row);
        $sheet->getStyle('AC'.$row.':AL'.$row)->applyFromArray($style_person);


        $row++;
        $sheet->mergeCells('R'.$row.':AA'.$row);
        $sheet->getStyle('R'.$row.':AA'.$row)->applyFromArray($style_caption);
        $sheet->setCellValue('R'.$row, 'подпись');
        $sheet->mergeCells('AC'.$row.':AL'.$row);
        $sheet->getStyle('AC'.$row.':AL'.$row)->applyFromArray($style_caption);
        $sheet->setCellValue('AC'.$row, 'расшифровка подписи');
        $sheet->getRowDimension($row)->setRowHeight(14);


        //N
        header('Content-Type:xlsx:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        /** !!!!!!!!!!!! */
        header('Content-Disposition:attachment;filename="Счет на оплату ' . $numberpaydoc . '.xlsx"');

        $objWriter = new PHPExcel_Writer_Excel2007($invoiceXLS);
        $objWriter->save('php://output');

    }

}