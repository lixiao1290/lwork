<?php
include_once dirname(__FILE__) . '/PHPExcel.php';

class ExelHelper
{

    public static function convertUTF8($str)
    {
        return mb_convert_encoding($str, "UTF-8", mb_detect_encoding($str));
    }

    /**
     * +----------------------------------------------------------
     * 导出excel | 2013.08.23
     * Author:HongPing <209201763@qq.com>
     * +----------------------------------------------------------
     *
     * @param $expTitle string
     *            File name
     *            +----------------------------------------------------------
     * @param $expCellName array
     *            Column name
     *            +----------------------------------------------------------
     * @param $expTableData array
     *            Table data
     */
    public static function export($expTitle, $expCellName, $expTableData, $formates = null, $protected = NULL, $types)
    {
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle); // 文件名称
        $fileName = @$_SESSION['loginAccount'] . date('Y-m-d h:i:s', $_SERVER['REQUEST_TIME']); // or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        
        $objPHPExcel = new PHPExcel();
        $cellName = array(
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z',
            'AA',
            'AB',
            'AC',
            'AD',
            'AE',
            'AF',
            'AG',
            'AH',
            'AI',
            'AJ',
            'AK',
            'AL',
            'AM',
            'AN',
            'AO',
            'AP',
            'AQ',
            'AR',
            'AS',
            'AT',
            'AU',
            'AV',
            'AW',
            'AX',
            'AY',
            'AZ'
        );
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1'); // 合并单元格
        $objPHPExcel->getActiveSheet(0)
            ->getDefaultColumnDimension()
            ->setWidth(25);
        // $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setAutoSize();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . '  导出时间:' . date('Y-m-d H:i:s'));
        for ($i = 0; $i < $cellNum; $i ++) {
            // $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension()->setWidth(25);
            $objPHPExcel->getActiveSheet(0)
                ->getStyle($cellName[$i] . '2')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for ($i = 0; $i < $dataNum; $i ++) {
            for ($j = 0; $j < $cellNum; $j ++) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $expTableData[$i][$expCellName[$j][0]]);
                
                if ($formates && array_key_exists($expCellName[$j][0], $formates)) {
                    $objPHPExcel->getActiveSheet(0)
                        ->getStyle($cellName[$j] . ($i + 3))
                        ->getNumberFormat()
                        ->setFormatCode($formates[$expCellName[$j][0]]);
                }
                if ($types && array_key_exists($expCellName[$j][0], $types)) {
                    $objPHPExcel->getActiveSheet()->getCell($cellName[$j] . ($i + 3))->getDataValidation()
                    -> setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                    -> setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                    -> setAllowBlank(false)
                    -> setShowInputMessage(true)
                    -> setShowErrorMessage(true)
                    -> setShowDropDown(true)
                    -> setErrorTitle('输入的值有误')
                    -> setError('您输入的值不在下拉框列表内.')
                    -> setPromptTitle('处理')
                    -> setFormula1($types[$expCellName[$j][0]]['options']);
                    $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $expTableData[$i][$expCellName[$j][0]]);
                } else {
                    $objPHPExcel->getActiveSheet(0)
                        ->getStyle($cellName[$j] . ($i + 3))
                        ->getNumberFormat()
                        ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                }
                /*
                 * if ($protected && in_array($expCellName[$j][0], $protected)) {
                 * // var_dump($cellName[$j].($i+3));exit;
                 * // echo $cellName[$j] . ($i + 3).':'.$cellName[$j+3] . ($i + 3); exit;
                 * // $objPHPExcel->getActiveSheet(0)->getProtection()->setSheet(true);
                 * // $objPHPExcel->getActiveSheet(0)->getProtection()->setSelectLockedCells($cellName[$j] . ($i + 3).':'.$cellName[$j] . ($i + 3));
                 * $objPHPExcel->getActiveSheet(0)->getProtection()->setSheet(true)->setSelectLockedCells($cellName[$j] . ($i + 3).':'.$cellName[$j] . ($i + 3))->setPassword('555');
                 * } else {
                 * $objPHPExcel->getActiveSheet(0)->getProtection()->setSheet(true)->setSelectUnlockedCells($cellName[$j] . ($i + 3).':'.$cellName[$j] . ($i + 3));
                 * // echo $cellName[$j] . ($i + 3).':'.$cellName[$j] . ($i + 3); exit;
                 * // $objPHPExcel->getActiveSheet(0)->getProtection()->setSheet(false);
                 * //$objPHPExcel->getActiveSheet(0)->getProtection()->setSelectUnlockedCells($cellName[$j] . ($i + 3).':'.$cellName[$j] . ($i + 3));
                 *
                 * // $objPHPExcel->getActiveSheet ( 0 )->getStyle ( $cellName [$j] . ($i + 3) )->getNumberFormat ()->setFormatCode ( PHPExcel_Style_NumberFormat::FORMAT_NUMBER );
                 * }
                 */
                $objPHPExcel->getActiveSheet(0)
                    ->getStyle($cellName[$j] . ($i + 3))
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }
         
        $encoded_filename = urlencode($fileName);
        
       
        
        header("Content-Transfer-Encoding:binary");
         
        
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
       // header("Content-Disposition:attachment;filename=$fileName.xls"); // attachment新窗口打印inline本窗口打印
        $ua = $_SERVER["HTTP_USER_AGENT"];
        if (preg_match("/MSIE/", $ua)) {
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '.xls"');
        } else if (preg_match("/Firefox/", $ua)) {
            header('Content-Disposition: attachment; filename*="utf8\'\'' . $fileName . '.xls"');
        } else {
            header('Content-Disposition: attachment; filename="' . $fileName . '.xls"');
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit();
    }

    /*
     * 导入excel
     *
     */
    public static function import($filePath = '', $sheet = 0, $skip = FALSE)
    {
        if (empty($filePath) or ! file_exists($filePath)) {
            die('file not exists');
        }
        $PHPReader = new PHPExcel_Reader_Excel2007(); // 建立reader对象
        if (! $PHPReader->canRead($filePath)) {
            $PHPReader = new PHPExcel_Reader_Excel5();
            if (! $PHPReader->canRead($filePath)) {
                echo 'no Excel';
                return;
            }
        }
        $PHPExcel = $PHPReader->load($filePath); // 建立excel对象
        $currentSheet = $PHPExcel->getSheet($sheet); // **读取excel文件中的指定工作表*/
        $allColumn = $currentSheet->getHighestColumn(); // **取得最大的列号*/
        $allRow = $currentSheet->getHighestRow(); // **取得一共有多少行*/
        $data = array();
        for ($rowIndex = 1; $rowIndex <= $allRow; $rowIndex ++) { // 循环读取每个单元格的内容。注意行从1开始，列从A开始
            for ($colIndex = 'A'; $colIndex <= $allColumn; $colIndex ++) {
                $addr = $colIndex . $rowIndex;
                $cell = $currentSheet->getCell($addr)->getValue();
                if ($cell instanceof PHPExcel_RichText) { // 富文本转换字符串
                    $cell = $cell->__toString();
                }
                /*
                 * if($skip) {
                 * if(!empty($data[$rowIndex][$colIndex])) {
                 * $data[$rowIndex][$colIndex] = $cell;
                 * }
                 * } else
                 */
                $data[$rowIndex][$colIndex] = $cell;
            }
        }
        return $data;
    }

    public static function importExecl($file)
    {
        if (! file_exists($file)) {
            return array(
                "error" => 0,
                'message' => 'file not found!'
            );
        }
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        try {
            $PHPReader = $objReader->load($file);
        } catch (Exception $e) {}
        if (! isset($PHPReader))
            return array(
                "error" => 0,
                'message' => 'read error!'
            );
        $allWorksheets = $PHPReader->getAllSheets();
        $i = 0;
        foreach ($allWorksheets as $objWorksheet) {
            $sheetname = $objWorksheet->getTitle();
            $allRow = $objWorksheet->getHighestRow(); // how many rows
            $highestColumn = $objWorksheet->getHighestColumn(); // how many columns
            $allColumn = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $array[$i]["Title"] = $sheetname;
            $array[$i]["Cols"] = $allColumn;
            $array[$i]["Rows"] = $allRow;
            $arr = array();
            $isMergeCell = array();
            foreach ($objWorksheet->getMergeCells() as $cells) { // merge cells
                foreach (PHPExcel_Cell::extractAllCellReferencesInRange($cells) as $cellReference) {
                    $isMergeCell[$cellReference] = true;
                }
            }
            for ($currentRow = 1; $currentRow <= $allRow; $currentRow ++) {
                $row = array();
                for ($currentColumn = 0; $currentColumn < $allColumn; $currentColumn ++) {
                    ;
                    $cell = $objWorksheet->getCellByColumnAndRow($currentColumn, $currentRow);
                    $afCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn + 1);
                    $bfCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn - 1);
                    $col = PHPExcel_Cell::stringFromColumnIndex($currentColumn);
                    $address = $col . $currentRow;
                    $value = $objWorksheet->getCell($address)->getValue();
                    if (substr($value, 0, 1) == '=') {
                        return array(
                            "error" => 0,
                            'message' => 'can not use the formula!'
                        );
                        exit();
                    }
                    if ($cell->getDataType() == PHPExcel_Cell_DataType::TYPE_NUMERIC) {
                        $cellstyleformat = $cell->getParent()
                            ->getStyle($cell->getCoordinate())
                            ->getNumberFormat();
                        $formatcode = $cellstyleformat->getFormatCode();
                        if (preg_match('/^([$[A-Z]*-[0-9A-F]*])*[hmsdy]/i', $formatcode)) {
                            $value = gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value));
                        } else {
                            $value = PHPExcel_Style_NumberFormat::toFormattedString($value, $formatcode);
                        }
                    }
                    if ($isMergeCell[$col . $currentRow] && $isMergeCell[$afCol . $currentRow] && ! empty($value)) {
                        $temp = $value;
                    } elseif ($isMergeCell[$col . $currentRow] && $isMergeCell[$col . ($currentRow - 1)] && empty($value)) {
                        $value = $arr[$currentRow - 1][$currentColumn];
                    } elseif ($isMergeCell[$col . $currentRow] && $isMergeCell[$bfCol . $currentRow] && empty($value)) {
                        $value = $temp;
                    }
                    $row[$currentColumn] = $value;
                }
                $arr[$currentRow] = $row;
            }
            $array[$i]["Content"] = $arr;
            $i ++;
        }
        unset($objWorksheet);
        unset($PHPReader);
        unset($PHPExcel);
        unlink($file);
        return array(
            "error" => 1,
            "data" => $array
        );
    }
}
 
 