<?php

namespace App\Libraries;

/**
 * DataGovApi - ดึงข้อมูลจาก data.go.th, Bangchak, MOC, World Bank
 * แหล่งข้อมูล:
 * - ราคาน้ำมัน: Bangchak API (real-time) + EPPO via data.go.th (fallback)
 * - CPI: MOC กระทรวงพาณิชย์ (รายเดือน) + data.go.th + World Bank (fallback)
 * - RSI: FPO via data.go.th
 * - อัตราเข้าพัก: กระทรวงท่องเที่ยวฯ via data.go.th
 */
class DataGovApi
{
    private $apiKey = '0UE4fssokAk0Uv3o3WyFBBh7nQdv2eWs';
    private $baseUrl = 'https://data.go.th/api/3/action/datastore_search';

    // Resource IDs
    private $oilResourceId = '7d56918d-adbf-42b7-bd36-e4b33d425027';
    private $cpiResourceId = '6eb23973-01db-49c8-b783-d9d614a7e03e';

    private $monthMap = [
        'January' => 1, 'February' => 2, 'March' => 3, 'April' => 4,
        'May' => 5, 'June' => 6, 'July' => 7, 'August' => 8,
        'September' => 9, 'October' => 10, 'November' => 11, 'December' => 12
    ];

    /**
     * เรียก data.go.th API
     */
    private function fetch($resourceId, $filters = [], $sort = '_id desc', $limit = 100)
    {
        $params = [
            'resource_id' => $resourceId,
            'limit' => $limit,
            'sort' => $sort,
        ];
        if (!empty($filters)) {
            $params['filters'] = json_encode($filters);
        }

        $url = $this->baseUrl . '?' . http_build_query($params);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $this->apiKey,
                'Accept: application/json'
            ],
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || !$response) {
            return null;
        }

        $data = json_decode($response, true);
        if (!$data || !$data['success']) {
            return null;
        }

        return $data['result']['records'] ?? [];
    }

    /**
     * Generic curl GET (ไม่ต้อง API key)
     */
    private function curlGet($url, $timeout = 10)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || !$response) return null;

        $data = json_decode($response, true);
        return $data;
    }

    // ==========================================================
    // Bangchak Oil Price API (real-time, ฟรี ไม่ต้อง key)
    // ==========================================================

    /**
     * ดึงราคาน้ำมันวันนี้จาก Bangchak API (real-time)
     * @return array|null ['diesel'=>price, 'gasohol95'=>price, 'date'=>'...', ...]
     */
    public function getBangchakOilPrice()
    {
        $data = $this->curlGet('https://oil-price.bangchak.co.th/ApiOilPrice2/en');
        if (!$data) return null;

        // API return เป็น array [{ ... }] ต้องเอา element แรก
        if (isset($data[0])) $data = $data[0];

        // OilList อาจเป็น string (JSON ซ้อน JSON) หรือ array
        $oilList = $data['OilList'] ?? null;
        if (is_string($oilList)) {
            $oilList = json_decode($oilList, true);
        }
        if (empty($oilList)) return null;

        $result = [
            'date' => $data['OilDateNow'] ?? date('d/m/Y'),
            'source' => 'Bangchak Oil Price API (real-time)',
            'api_url' => 'https://oil-price.bangchak.co.th/ApiOilPrice2/en',
            'prices' => [],
        ];

        foreach ($oilList as $oil) {
            $name = trim($oil['OilName'] ?? '');
            $result['prices'][$name] = [
                'today' => (float) ($oil['PriceToday'] ?? 0),
                'yesterday' => (float) ($oil['PriceYesterday'] ?? 0),
                'tomorrow' => (float) ($oil['PriceTomorrow'] ?? 0),
            ];

            // map ชื่อหลัก
            if (strpos($name, 'Hi Diesel S') !== false && strpos($name, 'Premium') === false) {
                $result['diesel'] = (float) ($oil['PriceToday'] ?? 0);
            }
            if (strpos($name, 'Gasohol 95') !== false || strpos($name, 'Gasohol S 95') !== false) {
                $result['gasohol95'] = (float) ($oil['PriceToday'] ?? 0);
            }
            if (strpos($name, 'Gasohol 91') !== false || strpos($name, 'Gasohol S 91') !== false) {
                $result['gasohol91'] = (float) ($oil['PriceToday'] ?? 0);
            }
        }

        // fallback ถ้าไม่เจอ diesel จาก keyword
        if (empty($result['diesel']) && !empty($data['OilList'][1])) {
            $result['diesel'] = (float) ($data['OilList'][1]['PriceToday'] ?? 0);
        }

        return $result;
    }

    // ==========================================================
    // MOC CPI API (กระทรวงพาณิชย์ รายเดือน)
    // ==========================================================

    /**
     * ดึง CPI รายเดือนจาก MOC (กระทรวงพาณิชย์)
     * region_id=5 (ทั่วประเทศ), index_id=0000000000000000 (รวมทุกรายการ)
     * @return array ['months'=>[1=>val,...], 'source'=>'...', ...]
     */
    public function getCpiMoc($year = null)
    {
        if (!$year) $year = (int) date('Y');

        $url = 'https://dataapi.moc.go.th/cpig-indexes?region_id=5&index_id=0000000000000000&from_year=' . $year . '&to_year=' . $year;
        $data = $this->curlGet($url);

        $result = [
            'months' => [],
            'source' => 'สำนักงานนโยบายและยุทธศาสตร์การค้า กระทรวงพาณิชย์ (MOC)',
            'api_url' => $url,
            'year' => $year,
            'base_year' => '2019',
        ];

        // ถ้าไม่มีข้อมูลปีปัจจุบัน ลองปีก่อน
        if (empty($data) || !is_array($data)) {
            $year--;
            $url = 'https://dataapi.moc.go.th/cpig-indexes?region_id=5&index_id=0000000000000000&from_year=' . $year . '&to_year=' . $year;
            $data = $this->curlGet($url);
            $result['year'] = $year;
            $result['api_url'] = $url;
        }

        if (empty($data) || !is_array($data)) return $result;

        foreach ($data as $rec) {
            $m = (int) ($rec['month'] ?? 0);
            $val = $rec['price_index'] ?? null;
            if ($m > 0 && $val !== null) {
                $result['months'][$m] = (float) $val;
            }
        }

        ksort($result['months']);
        return $result;
    }

    /**
     * ดึงราคาน้ำมันดีเซล B7 ประเทศไทย รายเดือน
     * แหล่งข้อมูล: EPPO (สำนักงานนโยบายและแผนพลังงาน)
     * @return array ['months' => [1=>price, 2=>price...], 'source' => '...', 'latest_date' => '...']
     */
    public function getOilPriceMonthly($year = null)
    {
        if (!$year) $year = (int) date('Y');

        $records = $this->fetch($this->oilResourceId, [
            'Country' => 'TH-THAILAND',
            'Item' => '1052-HSD (B7)',
            'Year' => $year
        ], 'Month asc', 100);

        $result = [
            'months' => [],
            'source' => 'สำนักงานนโยบายและแผนพลังงาน (EPPO) via data.go.th',
            'latest_date' => null,
            'year' => $year,
        ];

        if (empty($records)) {
            // ลองปีก่อน
            $records = $this->fetch($this->oilResourceId, [
                'Country' => 'TH-THAILAND',
                'Item' => '1052-HSD (B7)',
                'Year' => $year - 1
            ], 'Month asc', 100);
            $result['year'] = $year - 1;
        }

        if (empty($records)) return $result;

        // Group by month (เอาค่าล่าสุดของแต่ละเดือน)
        foreach ($records as $rec) {
            $monthName = trim($rec['Month'] ?? '');
            $monthNum = $this->monthMap[$monthName] ?? null;
            if ($monthNum && isset($rec['Price(Baht)'])) {
                $result['months'][$monthNum] = (float) $rec['Price(Baht)'];
                $result['latest_date'] = $rec['Year'] . '-' . str_pad($monthNum, 2, '0', STR_PAD_LEFT);
            }
        }

        ksort($result['months']);
        return $result;
    }

    /**
     * ดึง CPI ไทย รายเดือน (Total CPI, base year 2019)
     * แหล่งข้อมูล: TPSO กระทรวงพาณิชย์
     * @return array ['months' => [1=>value, 2=>value...], 'source' => '...', 'latest_date' => '...']
     */
    public function getCpiMonthly($year = null)
    {
        if (!$year) $year = (int) date('Y');

        $records = $this->fetch($this->cpiResourceId, [
            'INDICATOR_CODE' => 'ASI.C.CPI.SEC.0',
            'YEAR' => $year
        ], 'MONTH asc', 20);

        $result = [
            'months' => [],
            'source' => 'สำนักงานนโยบายและยุทธศาสตร์การค้า กระทรวงพาณิชย์ (TPSO) via data.go.th',
            'latest_date' => null,
            'year' => $year,
            'base_year' => '2019',
        ];

        if (empty($records)) {
            // ลองปีก่อนๆ
            for ($tryYear = $year - 1; $tryYear >= $year - 3; $tryYear--) {
                $records = $this->fetch($this->cpiResourceId, [
                    'INDICATOR_CODE' => 'ASI.C.CPI.SEC.0',
                    'YEAR' => $tryYear
                ], 'MONTH asc', 20);
                if (!empty($records)) {
                    $result['year'] = $tryYear;
                    break;
                }
            }
        }

        if (empty($records)) return $result;

        foreach ($records as $rec) {
            $monthName = trim($rec['MONTH'] ?? '');
            $monthNum = $this->monthMap[$monthName] ?? null;
            if ($monthNum && isset($rec['VALUE']) && $rec['VALUE'] !== null) {
                $result['months'][$monthNum] = (float) $rec['VALUE'];
                $result['latest_date'] = $rec['YEAR'] . '-' . str_pad($monthNum, 2, '0', STR_PAD_LEFT);
            }
        }

        ksort($result['months']);
        return $result;
    }

    /**
     * ดึงราคาน้ำมันล่าสุด (เดือนล่าสุด)
     */
    public function getLatestOilPrice()
    {
        $records = $this->fetch($this->oilResourceId, [
            'Country' => 'TH-THAILAND',
            'Item' => '1052-HSD (B7)',
        ], '_id desc', 1);

        if (empty($records)) return null;

        $rec = $records[0];
        $monthNum = $this->monthMap[trim($rec['Month'] ?? '')] ?? 0;
        return [
            'price' => (float) $rec['Price(Baht)'],
            'year' => (int) $rec['Year'],
            'month' => $monthNum,
            'date' => $rec['Year'] . '-' . str_pad($monthNum, 2, '0', STR_PAD_LEFT),
            'source' => 'EPPO via data.go.th',
        ];
    }

    /**
     * ดึง CPI จาก World Bank API (ฟรี ไม่ต้อง key, ข้อมูลรายปี ใหม่กว่า data.go.th)
     * แหล่ง: World Bank Open Data - FP.CPI.TOTL (2010=100)
     */
    public function getCpiWorldBank()
    {
        $year = (int) date('Y');
        $url = "https://api.worldbank.org/v2/country/TH/indicator/FP.CPI.TOTL?format=json&date=" . ($year - 3) . ":" . $year . "&per_page=10";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) return null;

        $data = json_decode($response, true);
        if (empty($data[1])) return null;

        // หาปีล่าสุดที่มีข้อมูล
        foreach ($data[1] as $item) {
            if ($item['value'] !== null) {
                return [
                    'value' => round((float) $item['value'], 2),
                    'year' => (int) $item['date'],
                    'base_year' => '2010',
                    'source' => 'World Bank Open Data (FP.CPI.TOTL)',
                    'api_url' => $url,
                ];
            }
        }

        return null;
    }

    /**
     * ดึง CPI ล่าสุด (ลอง data.go.th ก่อน ถ้าเก่าเกินไป ใช้ World Bank)
     */
    public function getLatestCpi()
    {
        $records = $this->fetch($this->cpiResourceId, [
            'INDICATOR_CODE' => 'ASI.C.CPI.SEC.0',
        ], '_id desc', 15);

        if (empty($records)) return null;

        // หาเดือนล่าสุด (ข้าม "Year" aggregate)
        foreach ($records as $rec) {
            $monthName = trim($rec['MONTH'] ?? '');
            if (isset($this->monthMap[$monthName])) {
                $monthNum = $this->monthMap[$monthName];
                return [
                    'value' => (float) $rec['VALUE'],
                    'year' => (int) $rec['YEAR'],
                    'month' => $monthNum,
                    'date' => $rec['YEAR'] . '-' . str_pad($monthNum, 2, '0', STR_PAD_LEFT),
                    'base_year' => '2019',
                    'source' => 'TPSO via data.go.th',
                ];
            }
        }

        return null;
    }

    // ==========================================================
    // RSI — ดัชนีความเชื่อมั่นอนาคตเศรษฐกิจภูมิภาค (FPO)
    // ==========================================================
    private $rsiResourceId = '6e839c50-aadd-4be0-83c1-881164117836';

    private $thaiMonthMap = [
        'มกราคม' => 1, 'กุมภาพันธ์' => 2, 'มีนาคม' => 3, 'เมษายน' => 4,
        'พฤษภาคม' => 5, 'มิถุนายน' => 6, 'กรกฎาคม' => 7, 'สิงหาคม' => 8,
        'กันยายน' => 9, 'ตุลาคม' => 10, 'พฤศจิกายน' => 11, 'ธันวาคม' => 12
    ];

    // ภาคหลัก 6 ภาค (ไม่รวม EEC ที่ซ้อนกับภาคตะวันออก)
    private $rsiRegions = [
        'กทม. และปริมณฑล',
        'ภาคกลาง',
        'ภาคเหนือ',
        'ภาคตะวันออกเฉียงเหนือ',
        'ภาคตะวันออก',
        'ภาคใต้',
        'ภาคตะวันตก',
    ];

    /**
     * ดึง RSI รายเดือน เฉลี่ยทุกภาค (เป็นค่า Sentiment ระดับชาติ)
     * แหล่งข้อมูล: สำนักงานเศรษฐกิจการคลัง (FPO)
     * ปี = พ.ศ.
     */
    public function getRsiMonthly($yearBE = null)
    {
        if (!$yearBE) $yearBE = (int) date('Y') + 543;

        // ดึง RSI ทุกภาค ของปีที่ระบุ (ดัชนีหลัก RSI เท่านั้น)
        $records = $this->fetch($this->rsiResourceId, [
            'ปี' => $yearBE,
        ], '_id asc', 500);

        $result = [
            'months' => [],
            'source' => 'สำนักงานเศรษฐกิจการคลัง (FPO) via data.go.th',
            'latest_date' => null,
            'year_be' => $yearBE,
            'year_ce' => $yearBE - 543,
        ];

        if (empty($records)) {
            // ลองปีก่อน
            $yearBE--;
            $records = $this->fetch($this->rsiResourceId, ['ปี' => $yearBE], '_id asc', 500);
            $result['year_be'] = $yearBE;
            $result['year_ce'] = $yearBE - 543;
        }

        if (empty($records)) return $result;

        // Filter เฉพาะ RSI หลัก + เฉลี่ยทุกภาค
        $monthData = []; // [month => [values]]
        $rsiIndexName = 'ดัชนีความเชื่อมั่นอนาคตเศรษฐกิจภูมิภาค';

        foreach ($records as $rec) {
            $indexName = trim($rec['ดัชนี'] ?? '');
            if (strpos($indexName, $rsiIndexName) === false) continue;

            $region = trim($rec['ภาค'] ?? '');
            if (!in_array($region, $this->rsiRegions)) continue;

            $monthName = trim($rec['เดือน'] ?? '');
            $monthNum = $this->thaiMonthMap[$monthName] ?? null;
            if (!$monthNum) continue;

            $val = $rec['ค่าดัชนี'] ?? null;
            if ($val === null || $val === '') continue;

            $monthData[$monthNum][] = (float) $val;
        }

        // คำนวณค่าเฉลี่ยแต่ละเดือน
        foreach ($monthData as $m => $vals) {
            $result['months'][$m] = round(array_sum($vals) / count($vals), 2);
            $result['latest_date'] = $yearBE . '-' . str_pad($m, 2, '0', STR_PAD_LEFT);
        }

        ksort($result['months']);
        return $result;
    }

    /**
     * ดึง RSI ล่าสุด
     */
    public function getLatestRsi()
    {
        $data = $this->getRsiMonthly();
        if (empty($data['months'])) return null;

        $lastMonth = max(array_keys($data['months']));
        return [
            'value' => $data['months'][$lastMonth],
            'year_be' => $data['year_be'],
            'month' => $lastMonth,
            'source' => $data['source'],
        ];
    }

    // ==========================================================
    // อัตราเข้าพัก — ระดับชาติ + รายจังหวัด
    // ==========================================================

    // Dataset หลัก: มีข้อมูล "รวมทั้งหมด" ระดับชาติ + รายภาค + รายจังหวัด (249 records)
    private $occNationalResourceId = 'f8c47ebc-2e9b-4479-9463-5d34b7deca41';

    /**
     * ดึงอัตราเข้าพักระดับชาติ (รายปี พ.ศ.)
     * แหล่งข้อมูล: กองเศรษฐกิจการท่องเที่ยวและกีฬา กระทรวงการท่องเที่ยวและกีฬา via data.go.th
     */
    public function getOccupancyRate($yearBE = null)
    {
        if (!$yearBE) $yearBE = (int) date('Y') + 543;

        // ดึง "รวมทั้งหมด" = ค่าเฉลี่ยระดับชาติ
        $records = $this->fetch($this->occNationalResourceId, [
            'จังหวัด' => 'รวมทั้งหมด',
        ], '_id desc', 10);

        if (empty($records)) return null;

        // หาปีล่าสุด
        $latest = null;
        foreach ($records as $rec) {
            $recYear = (int) ($rec['ปี'] ?? 0);
            $val = $rec['ข้อมูล'] ?? null;
            if ($val !== null && $val !== '' && $recYear > 0) {
                if (!$latest || $recYear > $latest['year_be']) {
                    $latest = [
                        'value' => (float) $val,
                        'year_be' => $recYear,
                        'year_ce' => $recYear - 543,
                    ];
                }
            }
        }

        if (!$latest) return null;

        return [
            'value' => $latest['value'],
            'year_be' => $latest['year_be'],
            'year_ce' => $latest['year_ce'],
            'source' => 'กองเศรษฐกิจการท่องเที่ยวและกีฬา กระทรวงการท่องเที่ยวฯ via data.go.th',
            'api_url' => 'https://data.go.th/api/3/action/datastore_search?resource_id=' . $this->occNationalResourceId,
        ];
    }

    /**
     * ดึงอัตราเข้าพักรายปี (ย้อนหลัง) สำหรับ chart
     */
    public function getOccupancyYearly()
    {
        $records = $this->fetch($this->occNationalResourceId, [
            'จังหวัด' => 'รวมทั้งหมด',
        ], '_id asc', 20);

        if (empty($records)) return [];

        $result = [];
        foreach ($records as $rec) {
            $yr = (int) ($rec['ปี'] ?? 0);
            $val = $rec['ข้อมูล'] ?? null;
            if ($yr > 0 && $val !== null) {
                $result[$yr] = (float) $val;
            }
        }

        ksort($result);
        return $result;
    }
}
