<?php
$useKint = true;

// Valid PHP Version?
$minPHPVersion = '7.3';
if (version_compare(PHP_VERSION, $minPHPVersion, '<')) {
    die("Your PHP version must be {$minPHPVersion} or higher to run CodeIgniter. Current version: " . PHP_VERSION);
}
unset($minPHPVersion);

/*
 *---------------------------------------------------------------
 * FRONT CONTROLLER ใน public/ (DocumentRoot ชี้มาที่โฟลเดอร์นี้)
 *---------------------------------------------------------------
 * FCPATH คงไว้ที่ "โฟลเดอร์โปรเจกต์" (หนึ่งชั้นเหนือ public/) เหมือน index.php เดิม
 * เพื่อให้โค้ดที่อ้าง FCPATH / CWD / path 'public/...' ทำงานเหมือนเดิมทุกอย่าง
 * โดยไม่ต้องแก้โค้ดในแอป — ส่วน URL '/public/...' อาศัย symlink  public/public -> .
 */
define('FCPATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the project folder (เท่ากับ chdir เดิมของ index.php ราก)
chdir(FCPATH);

// Load our paths config file
require realpath(FCPATH . 'app/Config/Paths.php') ?: FCPATH . 'app/Config/Paths.php';

$paths = new Config\Paths();

// Location of the framework bootstrap file.
$bootstrap = rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
$app = require realpath($bootstrap) ?: $bootstrap;

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 */
$app->run();
