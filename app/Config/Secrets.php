<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * ศูนย์รวมค่า secret / key ที่อ่านจาก .env
 * เรียกใช้: config('Secrets')->getGoogleMapsApiKey()
 *
 * >>> ตั้งค่าใน .env เท่านั้น <<<
 *     google.mapsApiKey = ...
 *     datagov.apiKey    = ...
 *
 * ห้ามใส่ค่าจริงลงไฟล์นี้ (ไฟล์นี้อยู่ใน git)
 * เพิ่ม key ใหม่ให้เพิ่มเมธอด getXxx() ที่นี่ ไม่ต้องสร้างไฟล์ config ใหม่
 */
class Secrets extends BaseConfig
{
    /**
     * คีย์ Google Maps JavaScript API ที่ส่งให้หน้า view (ตัวแปร Api_Code)
     * คีย์ฝั่ง client ซ่อนจากผู้ใช้ไม่ได้ — ต้องจำกัด HTTP referrer ใน Google Cloud Console ควบคู่กัน
     */
    public function getGoogleMapsApiKey(): string
    {
        return $this->optionalEnv('google.mapsApiKey');
    }

    /**
     * คีย์เรียก data.go.th / Bangchak / MOC (ใช้โดย App\Libraries\DataGovApi)
     */
    public function getDataGovApiKey(): string
    {
        return $this->requireEnv('datagov.apiKey');
    }

    /** ค่าที่ขาดไม่ได้ — ไม่มีแล้วต้องหยุด */
    private function requireEnv(string $key): string
    {
        $value = env($key);

        if (!is_string($value) || $value === '') {
            throw new \RuntimeException("ยังไม่ได้ตั้งค่า $key ใน .env");
        }

        return $value;
    }

    /** ค่าที่ไม่มีก็ยังทำงานต่อได้ (ฟีเจอร์นั้นจะไม่ทำงานเท่านั้น) */
    private function optionalEnv(string $key): string
    {
        $value = env($key);

        return is_string($value) ? $value : '';
    }
}
