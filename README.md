# TAT Tourist System
**ระบบวิเคราะห์ข้อมูลนักท่องเที่ยว การท่องเที่ยวแห่งประเทศไทย (ททท.)**

## ภาพรวมระบบ

ระบบ TAT Tourist เป็นแอปพลิเคชันเว็บสำหรับวิเคราะห์และรายงานสถิตินักท่องเที่ยวต่างชาติที่เดินทางเข้าประเทศไทย พัฒนาด้วย CodeIgniter 4 และฐานข้อมูล Oracle ใช้งานภายในองค์กรของ ททท.

---

## Tech Stack

| ส่วน | เทคโนโลยี |
|------|-----------|
| Framework | CodeIgniter 4 (HMVC Modules) |
| Database | Oracle (OCI8) |
| PHP | 7.3+ |
| Frontend | Bootstrap 4, SB Admin 2 |
| Charts | HighCharts |
| UI Components | jQuery EasyUI, jsTree, Datepicker |
| Export | PhpSpreadsheet (Excel), mPDF (PDF), PhpPresentation (PowerPoint) |

---

## เอกสารระบบ

| เอกสาร | คำอธิบาย |
|--------|---------|
| [ARCHITECTURE.md](ARCHITECTURE.md) | สถาปัตยกรรมระบบ, โครงสร้าง directory, flow การทำงาน |
| [MODULES.md](MODULES.md) | รายละเอียดแต่ละ module (Controllers, Models, Views) |
| [DATABASE.md](DATABASE.md) | โครงสร้างฐานข้อมูล, ตาราง, ความสัมพันธ์ |
| [INSTALLATION.md](INSTALLATION.md) | ขั้นตอนการติดตั้งและตั้งค่าระบบ |

---

## โครงสร้างโปรเจกต์

```
TAT_tourist/
├── app/                    # Application core
│   ├── Config/             # การตั้งค่าระบบ
│   ├── Controllers/        # BaseController
│   ├── Filters/            # Auth filter
│   ├── Helpers/            # Helper functions
│   ├── Libraries/          # Custom libraries
│   └── Views/              # Layouts, templates
├── modules/                # HMVC Modules
│   ├── Login/              # Authentication
│   ├── Main/               # Dashboard & Daily Reports
│   ├── Report/             # รายงานสถิติ
│   ├── Import/             # นำเข้าข้อมูล
│   ├── Setting/            # ตั้งค่าระบบ
│   └── User/               # จัดการผู้ใช้
├── public/                 # Web root (document root)
│   ├── css/
│   ├── js/
│   └── uploads/
└── writable/               # Cache, Sessions, Logs
```

---

## ฟีเจอร์หลัก

- **Dashboard** — สรุปสถิตินักท่องเที่ยวรายวัน/รายเดือน พร้อม chart
- **Real-Time Dashboard** (`/main/realtime`) — วิเคราะห์ปัจจัย 5 ตัวที่ส่งผลต่อนักท่องเที่ยว เชื่อมต่อ data.go.th API + World Bank API
- **รายงานภูมิภาค** (`/main/region`) — สถิตินักท่องเที่ยวรายภูมิภาค พร้อม chart เปรียบเทียบ YoY
- **รายงาน** — เปรียบเทียบตามสัญชาติ, ท่าเข้าออก, ตลาด, วันที่เดินทาง
- **นำเข้าข้อมูล** — Import ไฟล์ Excel รายวัน/รายเดือน
- **ตั้งค่า** — บริหารข้อมูล country, port, visa, permission, log
- **จัดการผู้ใช้** — เพิ่ม/แก้ไข/ลบผู้ใช้ กำหนดสิทธิ์
- **Export** — ส่งออกรายงานเป็น Excel / PDF / PowerPoint

---

## Authentication

ระบบรองรับ 3 วิธีเข้าสู่ระบบ:
1. **Active Directory (LDAP)** — สำหรับพนักงาน ททท. (domain: tat.or.th)
2. **Database** — username/password เก็บใน Oracle
3. **Microsoft OAuth** — Azure AD (Microsoft Graph API)

---

## Server Requirements

- PHP 7.3 หรือสูงกว่า
- Extension: `oci8`, `intl`, `curl`, `json`, `mbstring`, `xml`
- Oracle Client สำหรับ OCI8
- Web Server: Apache/Nginx

---

*See [INSTALLATION.md](INSTALLATION.md) for setup instructions*
