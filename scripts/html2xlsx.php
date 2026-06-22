<?php
/**
 * CLI worker: แปลงไฟล์ HTML (ตารางรายงาน) → ไฟล์ .xlsx
 *
 * รันเป็น subprocess แยกจาก Apache เพื่อหลบ segfault จาก libxml2 ที่ชนกันระหว่าง
 * libxml ของ PHP กับ libxml ที่ OCI8 (Oracle client) โหลดมาในโปรเซส Apache
 * — process นี้ไม่มี OCI8 จึงมี libxml ตัวเดียว เขียน xlsx ได้ปลอดภัย
 *
 * usage: php html2xlsx.php <input.html> <output.xlsx> <dateFlag:0|1>
 *   dateFlag=1 → แปลงหัวคอลัมน์วันที่ ISO เป็น Excel date (รายงาน daily)
 *
 * exit: 0 = สำเร็จ, อื่นๆ = ผิดพลาด (controller จะ fallback)
 */

$in  = $argv[1] ?? '';
$out = $argv[2] ?? '';
$dateFlag = ($argv[3] ?? '0') === '1';

if ($in === '' || $out === '' || !is_file($in)) {
    fwrite(STDERR, "bad args or missing input\n");
    exit(2);
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/xlsx_date_helper.php';

try {
    $html = file_get_contents($in);
    $spreadsheet = (new \PhpOffice\PhpSpreadsheet\Reader\Html())->loadFromString($html);

    if ($dateFlag) {
        tat_apply_iso_date_cells($spreadsheet);
    }

    \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx')->save($out);
} catch (\Throwable $e) {
    fwrite(STDERR, 'conv error: ' . $e->getMessage() . "\n");
    exit(3);
}

if (!is_file($out) || filesize($out) < 100) {
    fwrite(STDERR, "output not written\n");
    exit(4);
}
echo "OK";
exit(0);
