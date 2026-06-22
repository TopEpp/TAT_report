<?php
/**
 * Shared helper: แปลง cell ที่เป็นข้อความวันที่ ISO (yyyy-mm-dd) ให้เป็น Excel date จริง
 * (number format dd/mm/yyyy, ปฏิทิน ค.ศ.) — ใช้ร่วมกันระหว่าง CLI worker (html2xlsx.php)
 * และ fallback ใน Report::export_excel()
 *
 * ใช้กับ HTML Reader ของ PhpSpreadsheet ที่อ่านทุก cell เป็น text เสมอ
 */

use PhpOffice\PhpSpreadsheet\Shared\Date as XlsDate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

if (!function_exists('tat_apply_iso_date_cells')) {
    function tat_apply_iso_date_cells($spreadsheet)
    {
        foreach ($spreadsheet->getWorksheetIterator() as $sheet) {
            $dateCols = [];
            foreach ($sheet->getRowIterator() as $row) {
                $it = $row->getCellIterator();
                $it->setIterateOnlyExistingCells(true);
                foreach ($it as $cell) {
                    $v = $cell->getValue();
                    if (is_string($v) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) {
                        $dt = \DateTime::createFromFormat('Y-m-d', $v);
                        if ($dt) {
                            $dt->setTime(0, 0, 0);
                            $cell->setValueExplicit(XlsDate::PHPToExcel($dt), DataType::TYPE_NUMERIC);
                            $cell->getStyle()->getNumberFormat()->setFormatCode('dd/mm/yyyy');
                            $dateCols[$cell->getColumn()] = true;
                        }
                    }
                }
            }
            // ขยายความกว้างคอลัมน์ที่มีวันที่ ไม่งั้น Excel แสดง "########" (date ไม่พอความกว้าง)
            foreach (array_keys($dateCols) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(false);
                $sheet->getColumnDimension($col)->setWidth(12);
            }
        }
    }
}
