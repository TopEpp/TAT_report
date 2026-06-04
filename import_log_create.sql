-- ==============================================================
-- LOG_IMPORT_DAILY: บันทึกประวัติการนำเข้าข้อมูล (ใช้กับปฏิทินหน้า /import)
-- import ซ้ำวันเดิม = log แถวใหม่ (เก็บประวัติ re-import, ปฏิทินโชว์ครั้งล่าสุด)
-- Created: 2026-06-04 · Deploy: dev แล้ว / prod รอรัน
-- ==============================================================

CREATE TABLE LOG_IMPORT_DAILY (
    LOG_ID      NUMBER NOT NULL,
    REPORT_DATE DATE NOT NULL,                       -- วันที่ของข้อมูล
    IMPORT_TYPE VARCHAR2(20) DEFAULT 'DAILY' NOT NULL,
    IMPORTED_AT DATE DEFAULT SYSDATE NOT NULL,       -- เวลากดนำเข้าจริง
    IMPORTED_BY VARCHAR2(100),                       -- username จาก session
    ROW_COUNT   NUMBER,
    FILE_NAME   VARCHAR2(255),
    CONSTRAINT PK_LOG_IMPORT_DAILY PRIMARY KEY (LOG_ID)
);

CREATE SEQUENCE LOG_IMPORT_DAILY_SEQ START WITH 1 INCREMENT BY 1 NOCACHE;

CREATE INDEX IDX_LOG_IMP_DAILY_TYPE_RD ON LOG_IMPORT_DAILY (IMPORT_TYPE, REPORT_DATE);

COMMIT;

-- Verify
SELECT TABLE_NAME FROM USER_TABLES WHERE TABLE_NAME = 'LOG_IMPORT_DAILY';
SELECT SEQUENCE_NAME FROM USER_SEQUENCES WHERE SEQUENCE_NAME = 'LOG_IMPORT_DAILY_SEQ';
