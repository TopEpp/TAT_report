<?php

/**
 * Excel export helper (HTML → .xlsx)
 *
 * ใช้กลไกเดียวกับ Report::export_excel: gen xlsx ผ่าน CLI subprocess (php ที่ไม่โหลด OCI8)
 * เพื่อหลบ segfault จาก libxml2 ที่ชนกันระหว่าง PHP กับ OCI8 ในโปรเซส Apache
 * ถ้า subprocess ทำไม่ได้ค่อย fallback เขียนในโปรเซสนี้โดยตรง
 *
 * ใช้ไฟล์ worker เดิม: scripts/html2xlsx.php
 */

use PhpOffice\PhpSpreadsheet\IOFactory;

if (!function_exists('tat_stream_xlsx_from_html')) {

	/**
	 * ส่งไฟล์ .xlsx ให้ client ดาวน์โหลดจาก HTML table ที่ render มาแล้ว
	 * (ฟังก์ชันนี้ echo binary + exit — เหมือน Report::export_excel)
	 *
	 * @param string $file       ชื่อไฟล์ที่ผู้ใช้จะได้ เช่น 'log_info.xlsx'
	 * @param string $htmlString HTML ของตารางที่จะแปลง
	 */
	function tat_stream_xlsx_from_html($file, $htmlString)
	{
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=$file");
		header('Cache-Control: max-age=0');

		// วิธีหลัก: CLI subprocess
		$xlsx = tat_render_xlsx_via_cli($htmlString);
		if ($xlsx !== null) {
			echo $xlsx;
			exit;
		}

		// fallback: เขียนในโปรเซสนี้ (environment ที่ไม่มีปัญหา libxml ชน)
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
		$spreadsheet = $reader->loadFromString($htmlString);
		IOFactory::createWriter($spreadsheet, 'Xlsx')->save('php://output');
		exit;
	}

	/**
	 * gen ไฟล์ xlsx จาก HTML ผ่าน CLI subprocess
	 * คืน binary ของ xlsx ถ้าสำเร็จ, คืน null ถ้าทำไม่ได้ (ให้ caller fallback)
	 */
	function tat_render_xlsx_via_cli($htmlString)
	{
		if (!function_exists('exec')) {
			return null;
		}
		$worker = ROOTPATH . 'scripts/html2xlsx.php';
		$php = tat_php_cli_binary();
		if (!$php || !is_file($worker)) {
			return null;
		}

		$tmpDir  = rtrim(sys_get_temp_dir(), '/');
		$htmlTmp = tempnam($tmpDir, 'loghtml');
		$xlsxTmp = tempnam($tmpDir, 'logxlsx');
		if ($htmlTmp === false || $xlsxTmp === false) {
			return null;
		}
		file_put_contents($htmlTmp, $htmlString);

		// dateFlag = 0 (log ไม่มีหัวคอลัมน์วันที่แบบ ISO ที่ต้องแปลง)
		$cmd = escapeshellarg($php) . ' ' . escapeshellarg($worker) . ' '
			 . escapeshellarg($htmlTmp) . ' ' . escapeshellarg($xlsxTmp) . ' 0 2>/dev/null';

		$out = [];
		$rc  = 1;
		exec($cmd, $out, $rc);

		$bin = null;
		if ($rc === 0 && is_file($xlsxTmp) && filesize($xlsxTmp) > 100) {
			$bin = file_get_contents($xlsxTmp);
		}
		@unlink($htmlTmp);
		@unlink($xlsxTmp);
		return $bin;
	}

	/**
	 * หา path ของ php CLI binary แบบ portable (override ได้ด้วย env PHP_CLI_BIN)
	 */
	function tat_php_cli_binary()
	{
		$candidates = [];
		if ($e = getenv('PHP_CLI_BIN')) {
			$candidates[] = $e;
		}
		if (defined('PHP_BINDIR')) {
			$candidates[] = PHP_BINDIR . '/php';
		}
		$candidates[] = '/usr/bin/php';
		$candidates[] = '/usr/local/bin/php';
		foreach ($candidates as $c) {
			if ($c && @is_executable($c)) {
				return $c;
			}
		}
		$w = @shell_exec('command -v php 2>/dev/null');
		return $w ? trim($w) : null;
	}
}
