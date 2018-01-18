<?php
namespace Model\Service;


class PriceListService
{
    public function excelPriceList($books)
    {
        $xls = new \PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('PriceList');

        $sheet->setCellValue("A1", 'PriceList');
        $sheet->setCellValue("A2", '#');
        $sheet->setCellValue("B2", 'Title');
        $sheet->setCellValue("C2", 'Category');
        $sheet->setCellValue("D2", 'Price');

        $sheet->getStyle('A2:D2')->getBorders()->getAllBorders()
            ->applyFromArray(array('style' =>\PHPExcel_Style_Border::BORDER_MEDIUM,'color' => array('rgb' => '000000')));

        $sheet->getStyle('A2')->getAlignment()->setHorizontal(
            \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('B2:D2')->getAlignment()->setHorizontal(
            \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A1')->getFill()->setFillType(
            \PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setRGB('EEEEEE');

        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(
            \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B')->getAlignment()->setHorizontal(
            \PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D')->getAlignment()->setHorizontal(
            \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->getColumnDimension('C')->setWidth(10);

        $number=0;
        for($i=3; $i<count($books); $i++) {
            $number++;

            $sheet->setCellValueByColumnAndRow(0, $i, $number);
            $sheet->setCellValueByColumnAndRow(1, $i, $books[$i]->getTitle());
            $sheet->setCellValueByColumnAndRow(2, $i, $books[$i]->getCategory()->getName());
            $sheet->setCellValueByColumnAndRow(3, $i, $books[$i]->getPrice() . " $");

            $sheet->getStyle('D'."{$i}")->getFont()->getColor()->applyFromArray(array('rgb' => 'FF0000'));

        }
        header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
        header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
        header ( "Cache-Control: no-cache, must-revalidate" );
        header ( "Pragma: no-cache" );
        header ( "Content-type: application/vnd.ms-excel" );
        header ( "Content-Disposition: attachment; filename=price.xls" );
        $objWriter = new \PHPExcel_Writer_Excel5($xls);

        $objWriter->save('php://output');

    }

}