-- =====================================================================
-- md_country_group_dup_fix_final.sql
-- แก้ duplicate COUNTRY_ID nodes ใน MD_COUNTRY_GROUP_NODE
-- Schema: Oracle TAT (139.180.208.163:1521 SID=XE schema=TAT)
-- รันทั้งไฟล์ในครั้งเดียว (มี COMMIT ในตัวแล้ว)
--
-- เป้าหมาย: หลังรันสำเร็จ nation_compare วันที่ 08-09-2024 จะแสดง
--   ALL_GOV = ALL_TAT = 72,955 (ปัจจุบัน ALL_GOV เกินอยู่ 79 คน = 73,034)
--
-- ปัญหา (verified live ใน DB):
--   • ALL_GOV: NODE 494 'MAURITIUS' + NODE 530 'MAURITUN' (parent ต่างกัน)
--     ทั้งคู่ใช้ COUNTRY_ID=212 (Mauritius) → over-count Mauritius
--   • ALL_TAT: NODE 822 'MAURITIUS' + NODE 823 'MAURITUN' (parent เดียวกัน)
--     ทั้งคู่ COUNTRY_ID=212 → schema ผิด (ยอด collapse ในเดิม ไม่ over-count)
--   • ALL_TAT: NODE 703 'FAEROE ISLANDS' + NODE 802 'FAROES ISLANDS'
--     ทั้งคู่ COUNTRY_ID=107 → schema ผิด (ไม่ over-count วันที่นี้เพราะ NUM=0)
-- =====================================================================

-- ====== BEFORE: ตรวจ row ที่จะถูกลบ (ต้องได้ 3 rows) ======
SELECT 'BEFORE - target rows' AS phase, NODE_ID, GROUP_ID, NAME_EN, COUNTRY_ID, PARENT_NODE_ID
FROM   MD_COUNTRY_GROUP_NODE
WHERE  NODE_ID IN (530, 802, 823);

-- ====== BACKUP (optional - uncomment ถ้าต้องการ snapshot) ======
-- CREATE TABLE MD_COUNTRY_GROUP_NODE_BAK_20260518 AS
-- SELECT * FROM MD_COUNTRY_GROUP_NODE;

-- ====== DELETE: ลบ 3 duplicate nodes ======
-- เงื่อนไขซ้อน 3 ชั้น (NODE_ID + COUNTRY_ID + NAME_EN) เพื่อ safety
DELETE FROM MD_COUNTRY_GROUP_NODE
WHERE NODE_ID = 530
  AND COUNTRY_ID = 212
  AND NAME_EN = 'MAURITUN';

DELETE FROM MD_COUNTRY_GROUP_NODE
WHERE NODE_ID = 823
  AND COUNTRY_ID = 212
  AND NAME_EN = 'MAURITUN';

DELETE FROM MD_COUNTRY_GROUP_NODE
WHERE NODE_ID = 802
  AND COUNTRY_ID = 107
  AND NAME_EN = 'FAROES ISLANDS';

COMMIT;

-- ====== AFTER 1: row ที่ถูกลบ (ต้องได้ 0 rows) ======
SELECT 'AFTER - deleted rows check' AS phase, NODE_ID, GROUP_ID, NAME_EN, COUNTRY_ID
FROM   MD_COUNTRY_GROUP_NODE
WHERE  NODE_ID IN (530, 802, 823);

-- ====== AFTER 2: duplicate COUNTRY_ID ที่เหลือ (ต้องได้ 0 rows) ======
SELECT 'AFTER - remaining duplicates' AS phase,
       g.GROUP_CODE, n.COUNTRY_ID, COUNT(*) AS CNT
FROM   MD_COUNTRY_GROUP g
       JOIN MD_COUNTRY_GROUP_NODE n ON n.GROUP_ID = g.GROUP_ID
WHERE  n.NODE_TYPE = 'COUNTRY' AND n.COUNTRY_ID IS NOT NULL
GROUP BY g.GROUP_CODE, n.COUNTRY_ID
HAVING COUNT(*) > 1;

-- ====== AFTER 3: ยืนยัน Mauritius/Faroes เหลือ node เดียวต่อ group ======
SELECT 'AFTER - Mauritius+Faroes nodes' AS phase,
       g.GROUP_CODE, n.NODE_ID, n.NAME_EN, n.COUNTRY_ID
FROM   MD_COUNTRY_GROUP g
       JOIN MD_COUNTRY_GROUP_NODE n ON n.GROUP_ID = g.GROUP_ID
WHERE  g.GROUP_CODE IN ('ALL_GOV','ALL_TAT')
  AND  n.NODE_TYPE = 'COUNTRY'
  AND  n.COUNTRY_ID IN (107, 212)
ORDER BY g.GROUP_CODE, n.COUNTRY_ID, n.NODE_ID;
