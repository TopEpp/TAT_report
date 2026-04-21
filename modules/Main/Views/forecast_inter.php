<?php $this->extend('templates/main') ?>

<?php $this->section('content') ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700;800&display=swap');

    .fi-wrapper { font-family: 'Sarabun','Nunito',sans-serif; padding: 10px 0 40px; }

    /* Header */
    .fi-header {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 60%, #5eead4 100%);
        color: #fff; border-radius: 14px; padding: 22px 30px; margin-bottom: 22px;
        box-shadow: 0 6px 24px rgba(15,118,110,0.25);
        position: relative; overflow: hidden;
    }
    .fi-header::after {
        content: ''; position: absolute; right: -60px; top: -60px;
        width: 220px; height: 220px; background: rgba(255,255,255,0.08); border-radius: 50%;
    }
    .fi-header h2 { margin: 0; font-size: 1.5em; font-weight: 800; position: relative; z-index: 1; }
    .fi-header .subtitle { font-size: 0.88em; opacity: 0.92; margin-top: 4px; position: relative; z-index: 1; }
    .fi-header .fi-tag {
        display: inline-block; background: rgba(255,255,255,0.22);
        padding: 3px 12px; border-radius: 14px; font-size: 0.6em;
        vertical-align: middle; margin-left: 8px; font-weight: 700;
    }

    /* Cards */
    .fi-card {
        background: #fff; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        padding: 20px 22px; margin-bottom: 16px;
        border: 1px solid #e8f0f0;
    }
    .fi-section-title {
        font-size: 1em; font-weight: 800; color: #1a3a3c;
        margin: 28px 0 12px; padding-left: 12px;
        border-left: 3px solid #0f766e;
        display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    }
    .fi-section-title i { color: #0f766e; }
    .fi-section-title .fi-badge {
        margin-left: 6px; background: #ccfbf1; color: #0f766e;
        border: 1px solid #5eead4; font-size: 0.7em; font-weight: 700;
        padding: 2px 10px; border-radius: 10px;
    }

    /* Leading score hero */
    .fi-hero {
        display: grid; grid-template-columns: 240px 1fr; gap: 22px;
        align-items: center;
    }
    @media (max-width: 768px) { .fi-hero { grid-template-columns: 1fr; } }
    .fi-score-circle {
        width: 210px; height: 210px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; flex-direction: column;
        margin: 0 auto; color: #fff; position: relative;
        box-shadow: 0 10px 32px rgba(15,118,110,0.25);
    }
    .fi-score-circle.ok       { background: radial-gradient(circle at 30% 30%, #14b8a6, #0f766e); }
    .fi-score-circle.warn     { background: radial-gradient(circle at 30% 30%, #fbbf24, #d97706); }
    .fi-score-circle.critical { background: radial-gradient(circle at 30% 30%, #f87171, #dc2626); }
    .fi-score-circle .sval { font-size: 3.4em; font-weight: 800; line-height: 1; }
    .fi-score-circle .slabel { font-size: 0.8em; opacity: 0.92; margin-top: 4px; letter-spacing: 0.5px; }

    /* Early Warning cards */
    .warn-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 12px;
    }
    .warn-card {
        background: #fff; border-radius: 12px;
        border: 1px solid #e8f0f0; border-left: 5px solid #94a3b8;
        padding: 14px 16px; transition: transform 0.25s, box-shadow 0.25s;
    }
    .warn-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
    .warn-card.ok       { border-left-color: #059669; background: linear-gradient(135deg,#fff,#ecfdf5); }
    .warn-card.warn     { border-left-color: #d97706; background: linear-gradient(135deg,#fff,#fffbeb); }
    .warn-card.critical { border-left-color: #dc2626; background: linear-gradient(135deg,#fff,#fef2f2); }
    .warn-card .w-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; }
    .warn-card .w-name { font-size: 0.78em; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.3px; }
    .warn-card .w-icon { width: 30px; height: 30px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.92em; }
    .warn-card.ok .w-icon       { background: #d1fae5; color: #059669; }
    .warn-card.warn .w-icon     { background: #fef3c7; color: #d97706; }
    .warn-card.critical .w-icon { background: #fee2e2; color: #dc2626; }
    .warn-card.ok .w-value       { color: #059669; }
    .warn-card.warn .w-value     { color: #d97706; }
    .warn-card.critical .w-value { color: #dc2626; }
    .warn-card .w-value { font-size: 1.55em; font-weight: 800; line-height: 1; margin: 4px 0; }
    .warn-card .w-msg   { font-size: 0.8em; color: #475569; line-height: 1.5; margin-top: 4px; }

    /* Indicator grid */
    .ind-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
    }
    .ind-card {
        background: #fff; border: 1px solid #e8f0f0; border-radius: 12px;
        padding: 16px; text-align: center;
    }
    .ind-card .i-lbl { font-size: 0.78em; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; }
    .ind-card .i-val { font-size: 1.9em; font-weight: 800; color: #0f766e; margin: 6px 0; line-height: 1; }
    .ind-card .i-sub { font-size: 0.72em; color: #94a3b8; }
    .ind-card.neg .i-val { color: #dc2626; }
    .ind-card.warn .i-val { color: #d97706; }

    /* Forecast chart container */
    .chart-box { width: 100%; height: 420px; }
    .chart-box-sm { width: 100%; height: 320px; }

    /* Sentiment pill */
    .sent-pill {
        display: inline-block; padding: 2px 10px; border-radius: 10px;
        font-size: 0.78em; font-weight: 700;
    }
    .sent-pill.pos { background: #d1fae5; color: #059669; }
    .sent-pill.neg { background: #fee2e2; color: #dc2626; }
    .sent-pill.neu { background: #e0e7ef; color: #475569; }

    /* Scenario sliders */
    .slider-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 14px;
    }
    .slider-row {
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;
        padding: 12px;
    }
    .slider-row .sl-head {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 6px;
    }
    .slider-row .sl-lbl { font-size: 0.82em; font-weight: 700; color: #334155; }
    .slider-row .sl-val { font-size: 0.96em; font-weight: 800; color: #0f766e; }
    .slider-row input[type=range] { width: 100%; accent-color: #0f766e; }

    /* Preset buttons */
    .preset-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 10px; margin-top: 12px; }
    .preset-btn {
        background: #fff; border: 1px solid #cbd5e1; border-radius: 10px;
        padding: 12px; cursor: pointer; text-align: center;
        transition: all 0.2s;
    }
    .preset-btn:hover { background: #f0fdfa; border-color: #5eead4; transform: translateY(-2px); }
    .preset-btn.active { background: #ccfbf1; border-color: #0f766e; box-shadow: 0 4px 12px rgba(15,118,110,0.2); }
    .preset-btn i { font-size: 1.4em; color: #0f766e; margin-bottom: 6px; display: block; }
    .preset-btn .p-name { font-weight: 800; font-size: 0.88em; color: #1a3a3c; }
    .preset-btn .p-desc { font-size: 0.72em; color: #64748b; margin-top: 3px; }

    /* Tables */
    .fi-tbl { width: 100%; font-size: 0.88em; border-collapse: collapse; }
    .fi-tbl th {
        background: #f0fdfa; color: #0f766e; font-weight: 800;
        padding: 10px 8px; border-bottom: 2px solid #5eead4; text-align: left;
    }
    .fi-tbl td { padding: 9px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .fi-tbl tr:hover td { background: #f0fdfa; }
    .fi-tbl .td-num { text-align: right; font-variant-numeric: tabular-nums; font-weight: 600; }

    /* Tier2 panel */
    .tier2-alert {
        background: #fffbeb; border: 1px solid #fcd34d; border-radius: 10px;
        padding: 12px 16px; color: #92400e; font-size: 0.88em; margin-bottom: 12px;
    }
    .tier2-alert.ok { background: #ecfdf5; border-color: #6ee7b7; color: #065f46; }
    .tier2-alert code { background: rgba(0,0,0,0.05); padding: 2px 6px; border-radius: 4px; font-size: 0.92em; }

    /* Scenario prediction big number */
    .scenario-pred-box {
        background: linear-gradient(135deg, #0f766e, #14b8a6);
        border-radius: 14px; padding: 20px; color: #fff;
        text-align: center; margin-top: 16px;
    }
    .scenario-pred-box .sp-lbl { font-size: 0.82em; opacity: 0.9; font-weight: 700; }
    .scenario-pred-box .sp-val { font-size: 2.4em; font-weight: 800; margin-top: 6px; line-height: 1; }
    .scenario-pred-box .sp-delta { font-size: 0.9em; margin-top: 8px; opacity: 0.92; }

    /* Sensitivity tornado */
    .tornado-row {
        display: grid; grid-template-columns: 140px 1fr 1fr 80px;
        gap: 8px; align-items: center; margin-bottom: 8px; font-size: 0.86em;
    }
    .tornado-bar { height: 22px; border-radius: 4px; position: relative; }
    .tornado-bar.neg { background: linear-gradient(90deg, transparent, #fca5a5 30%, #dc2626); justify-self: end; }
    .tornado-bar.pos { background: linear-gradient(90deg, #14b8a6, #5eead4 70%, transparent); }

    /* Level filter pills */
    .level-tabs { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 12px; }
    .level-tabs button {
        background: #fff; border: 1px solid #cbd5e1; border-radius: 20px;
        padding: 5px 14px; font-size: 0.82em; cursor: pointer; font-weight: 700;
        color: #475569;
    }
    .level-tabs button:hover { background: #f0fdfa; }
    .level-tabs button.active { background: #0f766e; color: #fff; border-color: #0f766e; }

    /* Chart insight / summary panel (ตรงกับ forecast.php) */
    .chart-insight {
        margin-top: 14px; padding: 14px 16px;
        background: linear-gradient(135deg, #f0fdfa, #ecfeff);
        border: 1px solid #99f6e4; border-left: 4px solid #0f766e;
        border-radius: 10px; font-size: 0.88em; color: #1f2937;
        line-height: 1.65;
    }
    .chart-insight .ci-title {
        font-weight: 800; color: #0f766e; font-size: 0.98em;
        margin-bottom: 6px; display: flex; align-items: center; gap: 6px;
    }
    .chart-insight .ci-title i { color: #0f766e; }
    .chart-insight ul { margin: 6px 0 0; padding-left: 22px; }
    .chart-insight li { margin-bottom: 4px; }
    .chart-insight b { color: #0f766e; }
    .chart-insight .pill {
        display: inline-block; padding: 1px 10px; border-radius: 10px;
        font-size: 0.84em; font-weight: 700; margin: 0 2px;
        vertical-align: baseline;
    }
    .chart-insight .pill-good    { background: #dcfce7; color: #047857; }
    .chart-insight .pill-warn    { background: #fef3c7; color: #92400e; }
    .chart-insight .pill-bad     { background: #fee2e2; color: #991b1b; }
    .chart-insight .pill-info    { background: #ccfbf1; color: #0f766e; }
    .chart-insight .pill-neutral { background: #f1f5f9; color: #475569; }

    /* Chart hint (lightbulb one-liner) */
    .chart-hint {
        font-size: 0.82em; color: #64748b; margin-top: 10px; line-height: 1.6;
    }
    .chart-hint i { color: #0f766e; }
    .chart-hint b { color: #0f766e; }
</style>

<div class="fi-wrapper container-fluid">

    <!-- HEADER -->
    <div class="fi-header">
        <h2><i class="fas fa-plane-departure"></i> International Tourism Forecast
            <span class="fi-tag">6 เดือนข้างหน้า</span>
        </h2>
        <div class="subtitle">
            คาดการณ์นักท่องเที่ยวต่างชาติ · รายรวม / ภูมิภาค / ประเทศ · Tier 1 (Seasonal + Trend) + Tier 2 (SARIMAX) + Tier 3 (Scenario & Sensitivity)
            &nbsp;·&nbsp;
            Data max: <?= $max_date ? htmlspecialchars($max_date) : '-' ?>
            &nbsp;·&nbsp; YTD YoY: <strong><?= ($ytd_yoy >= 0 ? '+' : '') . $ytd_yoy ?>%</strong>
        </div>
    </div>

    <!-- 1. HERO: Leading Score + Early Warning -->
    <?php
    $lv = $leading_score >= 60 ? 'ok' : ($leading_score >= 40 ? 'warn' : 'critical');
    ?>
    <div class="fi-section-title"><i class="fas fa-gauge-high"></i> Leading Indicator Composite &amp; Early Warning</div>
    <div class="fi-card">
        <div class="fi-hero">
            <div>
                <div class="fi-score-circle <?= $lv ?>">
                    <div class="sval"><?= $leading_score ?></div>
                    <div class="slabel">/ 100</div>
                </div>
                <div style="text-align:center; font-weight:700; color:#475569; margin-top:10px; font-size:0.9em;">
                    <?= $lv === 'ok' ? '<span style="color:#059669;">สัญญาณบวก</span>' : ($lv === 'warn' ? '<span style="color:#d97706;">สัญญาณกลาง</span>' : '<span style="color:#dc2626;">สัญญาณลบ</span>') ?>
                </div>
            </div>
            <div class="warn-grid">
                <?php foreach ($alerts as $a): ?>
                    <div class="warn-card <?= $a['level'] ?>">
                        <div class="w-head">
                            <span class="w-name"><?= htmlspecialchars($a['name']) ?></span>
                            <span class="w-icon"><i class="fas <?= $a['icon'] ?>"></i></span>
                        </div>
                        <div class="w-value"><?= htmlspecialchars($a['value']) ?></div>
                        <div class="w-msg"><?= htmlspecialchars($a['message']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
            $crit_count = 0; $warn_count = 0; $ok_count = 0;
            foreach ($alerts as $a) {
                if ($a['level'] === 'critical') $crit_count++;
                elseif ($a['level'] === 'warn') $warn_count++;
                else $ok_count++;
            }
            $lead_q = $leading_score >= 60 ? 'สัญญาณบวก — วางแผนปกติได้' : ($leading_score >= 40 ? 'สัญญาณกลาง — เฝ้าระวัง' : 'สัญญาณลบ — ควรจัดมาตรการรองรับ');
            $lead_pill = $leading_score >= 60 ? 'pill-good' : ($leading_score >= 40 ? 'pill-warn' : 'pill-bad');
        ?>
        <div class="chart-insight">
            <div class="ci-title"><i class="fas fa-clipboard-check"></i> ตีความสัญญาณเตือนล่วงหน้า</div>
            <ul>
                <li>Indicator เหล่านี้เป็น <b>สัญญาณนำ (leading)</b> ที่ชี้ทิศ Arrivals 1-3 เดือนข้างหน้า ·
                    Seat/FBI สะท้อนการจองล่วงหน้า · Cancel/Meltwater สะท้อน shock ปัจจุบัน · Office Sentiment จาก สนง.ต่างประเทศ
                </li>
                <li>สถานะรวม 6 ตัว:
                    <?php if ($crit_count > 0): ?><span class="pill pill-bad">วิกฤต <?= $crit_count ?></span><?php endif; ?>
                    <?php if ($warn_count > 0): ?><span class="pill pill-warn">เฝ้าระวัง <?= $warn_count ?></span><?php endif; ?>
                    <?php if ($ok_count > 0): ?><span class="pill pill-good">ปกติ <?= $ok_count ?></span><?php endif; ?>
                </li>
                <li>Composite Leading Score: <span class="pill <?= $lead_pill ?>"><?= $leading_score ?>/100</span> — <?= $lead_q ?>
                    <br><small style="color:#64748b;">น้ำหนัก: FBI 30% · Seat 25% · Cancel/Meltwater/Office 15% ต่อตัว</small>
                </li>
                <li>YTD YoY Arrivals:
                    <span class="pill <?= $ytd_yoy >= 0 ? 'pill-good' : ($ytd_yoy >= -5 ? 'pill-warn' : 'pill-bad') ?>">
                        <?= ($ytd_yoy >= 0 ? '+' : '') . $ytd_yoy ?>%
                    </span>
                    เทียบกับช่วงเดียวกันปีก่อน
                </li>
            </ul>
        </div>
    </div>

    <!-- 2. Overall Forecast (Historical + 6 เดือน) -->
    <div class="fi-section-title"><i class="fas fa-chart-line"></i> Overall Forecast — นักท่องเที่ยวต่างชาติรวม <span class="fi-badge">Tier 1</span></div>
    <div class="fi-card">
        <div style="font-size:0.82em; color:#64748b; margin-bottom:10px;">
            Method: Seasonal-Naive × YoY Growth · CI ±MAPE (<?= $overall_forecast['mape'] ?>%) · Forecast 6 เดือนถัดไป
        </div>
        <div id="chartOverall" class="chart-box"></div>

        <?php
            $fc_vals = array_map(function($f){ return $f['value']/1000000; }, $overall_forecast['forecast']);
            $fc_labels_th = array_map(function($f) use ($month_labels){
                return $month_labels[$f['month']-1] . ' ' . (($f['year']+543) - 2500);
            }, $overall_forecast['forecast']);
            $fc_start = $fc_vals[0] ?? 0;
            $fc_end = end($fc_vals) ?: 0;
            $fc_diff = $fc_end - $fc_start;
            $fc_pct = $fc_start > 0 ? ($fc_diff / $fc_start * 100) : 0;
            $fc_last_hist = !empty($history_values) ? end($history_values) : 0;
            $fc_vs_hist = $fc_start - $fc_last_hist;
            $fc_peak_idx = array_search(max($fc_vals), $fc_vals);
            $fc_low_idx  = array_search(min($fc_vals), $fc_vals);
            $fc_total_6m = array_sum($fc_vals);
            $fc_trend = $fc_pct > 2 ? 'ขาขึ้น' : ($fc_pct < -2 ? 'ขาลง' : 'ทรงตัว');
            $fc_trend_pill = $fc_pct > 2 ? 'pill-good' : ($fc_pct < -2 ? 'pill-bad' : 'pill-neutral');
            $mape_val = (float)$overall_forecast['mape'];
            $mape_q = $mape_val < 8 ? 'ยอดเยี่ยม (<8%)' : ($mape_val < 15 ? 'พอใช้ (8-15%)' : 'ค่อนข้างสูง (>15%)');
            $mape_pill = $mape_val < 8 ? 'pill-good' : ($mape_val < 15 ? 'pill-warn' : 'pill-bad');
            $growth_yoy = round(((float)$overall_forecast['growth'] - 1) * 100, 1);
            $fc_ci_lo = array_sum(array_map(function($f){ return $f['lower']/1000000; }, $overall_forecast['forecast']));
            $fc_ci_hi = array_sum(array_map(function($f){ return $f['upper']/1000000; }, $overall_forecast['forecast']));
        ?>
        <div class="chart-insight">
            <div class="ci-title"><i class="fas fa-clipboard-check"></i> สรุปผลการพยากรณ์ 6 เดือน</div>
            <ul>
                <li>แนวโน้มจาก <b><?= esc($fc_labels_th[0] ?? '-') ?></b> → <b><?= esc(end($fc_labels_th) ?: '-') ?></b>:
                    <span class="pill <?= $fc_trend_pill ?>"><?= $fc_trend ?></span>
                    เปลี่ยน <b><?= ($fc_pct >= 0 ? '+' : '') . number_format($fc_pct, 1) ?>%</b>
                    (<?= number_format($fc_start, 2) ?>M → <?= number_format($fc_end, 2) ?>M)
                </li>
                <li>เทียบเดือนล่าสุดจริง (<?= number_format($fc_last_hist, 2) ?>M) → พยากรณ์
                    <?php if ($fc_vs_hist >= 0): ?>
                        <span class="pill pill-good">สูงขึ้น +<?= number_format($fc_vs_hist, 2) ?>M</span>
                    <?php else: ?>
                        <span class="pill pill-bad">ลดลง <?= number_format($fc_vs_hist, 2) ?>M</span>
                    <?php endif; ?>
                </li>
                <li>เดือนสูงสุด: <b><?= esc($fc_labels_th[$fc_peak_idx] ?? '-') ?></b> (<?= number_format($fc_vals[$fc_peak_idx], 2) ?>M)
                    · เดือนต่ำสุด: <b><?= esc($fc_labels_th[$fc_low_idx] ?? '-') ?></b> (<?= number_format($fc_vals[$fc_low_idx], 2) ?>M)
                </li>
                <li>รวม 6 เดือน: <b><?= number_format($fc_total_6m, 2) ?>M คน</b> · ช่วง CI 95%: <?= number_format($fc_ci_lo, 2) ?>–<?= number_format($fc_ci_hi, 2) ?>M
                    · YoY growth ที่ใช้: <b><?= ($growth_yoy >= 0 ? '+' : '') . $growth_yoy ?>%</b>
                </li>
                <li>ความแม่นโมเดล (MAPE): <span class="pill <?= $mape_pill ?>"><?= $mape_val ?>%</span> — <?= $mape_q ?></li>
            </ul>
        </div>

        <div class="chart-hint">
            <i class="fas fa-lightbulb"></i>
            <b>วิธีอ่านกราฟ:</b> เส้นเขียว = ข้อมูลจริง 3 ปีย้อนหลัง · เส้นส้ม (dot) = forecast 6 เดือน · แถบสีส้มโปร่ง = ช่วง CI ±MAPE ·
            พื้นที่ไฮไลต์เทา-เขียว = โซน forecast
        </div>
    </div>

    <!-- 3. Indicators Panel -->
    <div class="fi-section-title"><i class="fas fa-signal"></i> Leading Indicators (ข้อมูลล่าสุด)</div>
    <div class="ind-grid">
        <div class="ind-card <?= $indicators['seat_capacity_chg'] < 0 ? 'neg' : '' ?>">
            <div class="i-lbl">Seat Capacity</div>
            <div class="i-val"><?= ($indicators['seat_capacity_chg'] >= 0 ? '+' : '') . $indicators['seat_capacity_chg'] ?>%</div>
            <div class="i-sub">W5 vs W1 · OAG</div>
        </div>
        <div class="ind-card <?= $indicators['fbi_chg'] < 0 ? 'neg' : '' ?>">
            <div class="i-lbl">FBI (ForwardKeys)</div>
            <div class="i-val"><?= ($indicators['fbi_chg'] >= 0 ? '+' : '') . $indicators['fbi_chg'] ?>%</div>
            <div class="i-sub">W8 vs W1 baseline</div>
        </div>
        <div class="ind-card <?= $indicators['flight_cancel_pct'] > 15 ? 'neg' : ($indicators['flight_cancel_pct'] > 10 ? 'warn' : '') ?>">
            <div class="i-lbl">Flight Cancel %</div>
            <div class="i-val"><?= $indicators['flight_cancel_pct'] ?>%</div>
            <div class="i-sub">11-31 มี.ค. · 4 สนามบิน</div>
        </div>
        <div class="ind-card <?= $indicators['meltwater_neg'] > 55 ? 'neg' : ($indicators['meltwater_neg'] > 45 ? 'warn' : '') ?>">
            <div class="i-lbl">Meltwater Neg %</div>
            <div class="i-val"><?= $indicators['meltwater_neg'] ?>%</div>
            <div class="i-sub">Social sentiment</div>
        </div>
        <div class="ind-card <?= $indicators['office_sentiment_score'] < 0 ? 'neg' : '' ?>">
            <div class="i-lbl">TAT Office Sentiment</div>
            <div class="i-val"><?= ($indicators['office_sentiment_score'] >= 0 ? '+' : '') . $indicators['office_sentiment_score'] ?></div>
            <div class="i-sub">Net score · INTER_SENTIMENT (<?= $sentiment_source === 'current' ? $current_year_thai : $prev_year_thai ?>)</div>
        </div>
    </div>

    <!-- 4. Region Forecast -->
    <div class="fi-section-title"><i class="fas fa-globe-asia"></i> Region Forecast — 7 ภูมิภาค <span class="fi-badge">Tier 1</span></div>
    <div class="fi-card">
        <div style="font-size:0.82em; color:#64748b; margin-bottom:10px;">
            แต่ละภูมิภาค: seasonal naive forecast + YoY growth · เลือกภูมิภาคที่ต้องการ
        </div>
        <div class="level-tabs" id="regionTabs">
            <?php foreach ($region_names as $i => $rn): ?>
                <button data-region="<?= htmlspecialchars($rn) ?>" class="<?= $i === 0 ? 'active' : '' ?>"><?= htmlspecialchars($rn) ?></button>
            <?php endforeach; ?>
            <button data-region="__ALL__">ดูทุกภูมิภาครวม</button>
        </div>
        <div id="chartRegion" class="chart-box"></div>

        <?php
            $region_summary = [];
            foreach ($region_forecast as $rn => $rfc) {
                $rg = round(((float)$rfc['growth'] - 1) * 100, 1);
                $rtotal = array_sum(array_column($rfc['forecast'], 'value')) / 1000000;
                $region_summary[] = [
                    'name' => $rn,
                    'growth' => $rg,
                    'total' => $rtotal,
                    'mape' => (float)$rfc['mape'],
                ];
            }
            $rs_by_growth = $region_summary;
            usort($rs_by_growth, function($a, $b){ return $b['growth'] <=> $a['growth']; });
            $rs_top = $rs_by_growth[0] ?? null;
            $rs_bot = end($rs_by_growth) ?: null;
            $rs_by_total = $region_summary;
            usort($rs_by_total, function($a, $b){ return $b['total'] <=> $a['total']; });
            $rs_biggest = $rs_by_total[0] ?? null;
            $avg_region_mape = count($region_summary) ? round(array_sum(array_column($region_summary, 'mape')) / count($region_summary), 2) : 0;
        ?>
        <div class="chart-insight">
            <div class="ci-title"><i class="fas fa-clipboard-check"></i> สรุป 7 ภูมิภาค</div>
            <ul>
                <?php if ($rs_biggest): ?>
                <li>ภูมิภาคใหญ่สุด (volume): <b><?= esc($rs_biggest['name']) ?></b> คาด 6 เดือน ~<b><?= number_format($rs_biggest['total'], 2) ?>M คน</b></li>
                <?php endif; ?>
                <?php if ($rs_top && $rs_bot): ?>
                <li>Growth สูงสุด: <b><?= esc($rs_top['name']) ?></b>
                    <span class="pill <?= $rs_top['growth'] > 0 ? 'pill-good' : 'pill-bad' ?>"><?= ($rs_top['growth'] >= 0 ? '+' : '') . $rs_top['growth'] ?>%</span>
                    · ต่ำสุด: <b><?= esc($rs_bot['name']) ?></b>
                    <span class="pill <?= $rs_bot['growth'] > 0 ? 'pill-good' : 'pill-bad' ?>"><?= ($rs_bot['growth'] >= 0 ? '+' : '') . $rs_bot['growth'] ?>%</span>
                </li>
                <?php endif; ?>
                <li>ความแม่นเฉลี่ย (MAPE) ทุกภูมิภาค:
                    <span class="pill <?= $avg_region_mape < 10 ? 'pill-good' : ($avg_region_mape < 20 ? 'pill-warn' : 'pill-bad') ?>"><?= $avg_region_mape ?>%</span>
                </li>
                <li>📌 <b>การใช้งาน:</b> คลิกปุ่มชื่อภูมิภาคเพื่อเปลี่ยนกราฟ · ปุ่ม "ดูทุกภูมิภาครวม" = ยอดรวม 7 ภูมิภาค ·
                    แต่ละภูมิภาคใช้ seasonal naive (ค่าลาก 12 เดือน) × YoY growth ของตัวเอง
                </li>
            </ul>
        </div>
    </div>

    <!-- 5. Top Country Forecast -->
    <div class="fi-section-title"><i class="fas fa-flag"></i> Top 10 Country Forecast <span class="fi-badge">Tier 1</span></div>
    <div class="fi-card">
        <div style="font-size:0.82em; color:#64748b; margin-bottom:10px;">
            10 ตลาดใหญ่ (จัดอันดับตามยอดปี <?= $prev_year_thai ?>)
        </div>
        <div class="level-tabs" id="countryTabs">
            <?php $i = 0; foreach ($country_forecast as $cid => $c): ?>
                <button data-cid="<?= (int)$cid ?>" class="<?= $i === 0 ? 'active' : '' ?>"><?= htmlspecialchars($c['name']) ?></button>
            <?php $i++; endforeach; ?>
        </div>
        <div id="chartCountry" class="chart-box"></div>

        <?php
            $country_summary = [];
            foreach ($country_forecast as $cid => $cfc) {
                $cg = round(((float)$cfc['growth'] - 1) * 100, 1);
                $ctotal = array_sum(array_column($cfc['forecast'], 'value'));
                $country_summary[] = [
                    'name' => $cfc['name'] ?? ('Country ' . $cid),
                    'growth' => $cg,
                    'total' => $ctotal,
                    'mape' => (float)$cfc['mape'],
                ];
            }
            $cs_by_growth = $country_summary;
            usort($cs_by_growth, function($a, $b){ return $b['growth'] <=> $a['growth']; });
            $cs_top_g = $cs_by_growth[0] ?? null;
            $cs_bot_g = end($cs_by_growth) ?: null;
            $cs_by_total = $country_summary;
            usort($cs_by_total, function($a, $b){ return $b['total'] <=> $a['total']; });
            $cs_biggest = $cs_by_total[0] ?? null;
            $cs_pos = count(array_filter($country_summary, function($c){ return $c['growth'] > 0; }));
            $cs_neg = count($country_summary) - $cs_pos;
        ?>
        <div class="chart-insight">
            <div class="ci-title"><i class="fas fa-clipboard-check"></i> สรุป Top 10 ประเทศ</div>
            <ul>
                <?php if ($cs_biggest): ?>
                <li>ตลาดใหญ่สุด (volume): <b><?= esc($cs_biggest['name']) ?></b>
                    คาด 6 เดือน ~<b><?= number_format($cs_biggest['total'] / 1000000, 2) ?>M คน</b>
                </li>
                <?php endif; ?>
                <?php if ($cs_top_g && $cs_bot_g): ?>
                <li>Growth สูงสุด: <b><?= esc($cs_top_g['name']) ?></b>
                    <span class="pill <?= $cs_top_g['growth'] > 0 ? 'pill-good' : 'pill-bad' ?>"><?= ($cs_top_g['growth'] >= 0 ? '+' : '') . $cs_top_g['growth'] ?>%</span>
                    · ต่ำสุด: <b><?= esc($cs_bot_g['name']) ?></b>
                    <span class="pill <?= $cs_bot_g['growth'] > 0 ? 'pill-good' : 'pill-bad' ?>"><?= ($cs_bot_g['growth'] >= 0 ? '+' : '') . $cs_bot_g['growth'] ?>%</span>
                </li>
                <?php endif; ?>
                <li>ประเทศที่ growth เป็นบวก:
                    <span class="pill <?= $cs_pos > $cs_neg ? 'pill-good' : 'pill-warn' ?>"><?= $cs_pos ?>/<?= count($country_summary) ?></span>
                    · เป็นลบ: <span class="pill <?= $cs_neg > $cs_pos ? 'pill-bad' : 'pill-neutral' ?>"><?= $cs_neg ?>/<?= count($country_summary) ?></span>
                </li>
                <li>📌 <b>การใช้งาน:</b> คลิกชื่อประเทศเพื่อเปลี่ยนกราฟ · Top 10 จัดอันดับจากยอด <?= $prev_year_thai ?> ·
                    ประเทศที่ growth ติดลบ ควรดูปัจจัยเฉพาะ (visa, เที่ยวบินตรง, ข่าวสาร) ประกอบ
                </li>
            </ul>
        </div>
    </div>

    <!-- 6. Market Sentiment (INTER_SENTIMENT) -->
    <div class="fi-section-title">
        <i class="fas fa-comment-dots"></i> Market Sentiment — รายงานจาก สนง.ตลาดต่างประเทศ (TAT)
        <span class="fi-badge">INTER_SENTIMENT</span>
        <?php if (empty($sentiment_agg['overall']['total'])): ?>
            <span style="color:#dc2626; font-size:0.78em; margin-left:8px;">(ไม่มีข้อมูลในฐาน)</span>
        <?php else: ?>
            <span style="color:#64748b; font-size:0.78em; margin-left:8px;">
                รวม <?= number_format($sentiment_agg['overall']['total']) ?> รายการ
                · ปี <?= $sentiment_source === 'current' ? $current_year_thai : $prev_year_thai ?>
                · Pos <?= $sentiment_agg['overall']['pos'] ?> / Neg <?= $sentiment_agg['overall']['neg'] ?> / Neu <?= $sentiment_agg['overall']['neu'] ?>
            </span>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="fi-card" style="padding:14px 16px;">
                <?php if (empty($sentiment_markets)): ?>
                    <div style="color:#94a3b8; font-size:0.9em; padding:20px; text-align:center;">
                        ยังไม่มีรายงาน sentiment ในระบบ INTER_SENTIMENT สำหรับปีนี้<br>
                        <small>ดึงข้อมูลจาก: <code>/inter/manage6/{region}/{id}/{year}/{month}/{market_id}</code></small>
                    </div>
                <?php else: ?>
                    <table class="fi-tbl">
                        <thead>
                            <tr>
                                <th>ตลาด/ประเทศ</th>
                                <th style="width:60px;">Pos</th>
                                <th style="width:60px;">Neg</th>
                                <th style="width:60px;">Neu</th>
                                <th style="width:80px;">รวม</th>
                                <th style="width:100px;">Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sentiment_markets as $m): ?>
                                <?php $scv = (float)$m['score']; $sp = $scv > 10 ? 'pos' : ($scv < -10 ? 'neg' : 'neu'); ?>
                                <tr>
                                    <td><?= htmlspecialchars($m['name']) ?></td>
                                    <td class="td-num"><?= $m['pos'] ?></td>
                                    <td class="td-num"><?= $m['neg'] ?></td>
                                    <td class="td-num"><?= $m['neu'] ?></td>
                                    <td class="td-num"><?= $m['total'] ?></td>
                                    <td><span class="sent-pill <?= $sp ?>"><?= ($scv >= 0 ? '+' : '') . $scv ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-5">
            <div class="fi-card" style="padding:14px 16px;">
                <div id="chartSentiment" class="chart-box-sm"></div>
            </div>
        </div>
    </div>

    <?php if (!empty($sentiment_markets) && !empty($sentiment_agg['overall']['total'])):
        $top_pos = null; $top_neg = null;
        foreach ($sentiment_markets as $m) {
            if ($top_pos === null || (float)$m['score'] > (float)$top_pos['score']) $top_pos = $m;
            if ($top_neg === null || (float)$m['score'] < (float)$top_neg['score']) $top_neg = $m;
        }
        $score_overall = (float)$sentiment_agg['overall']['score'];
        $pos_count = (int)$sentiment_agg['overall']['pos'];
        $neg_count = (int)$sentiment_agg['overall']['neg'];
        $neu_count = (int)$sentiment_agg['overall']['neu'];
        $total_rep = (int)$sentiment_agg['overall']['total'];
        $pos_pct = $total_rep > 0 ? round($pos_count / $total_rep * 100, 1) : 0;
        $neg_pct = $total_rep > 0 ? round($neg_count / $total_rep * 100, 1) : 0;
    ?>
    <div class="chart-insight">
        <div class="ci-title"><i class="fas fa-clipboard-check"></i> สรุป Market Sentiment</div>
        <ul>
            <li>Overall Score:
                <span class="pill <?= $score_overall > 10 ? 'pill-good' : ($score_overall < -10 ? 'pill-bad' : 'pill-neutral') ?>">
                    <?= ($score_overall >= 0 ? '+' : '') . $score_overall ?>
                </span>
                จากรายงาน <b><?= number_format($total_rep) ?></b> ชิ้น
                (Pos <?= $pos_pct ?>% · Neg <?= $neg_pct ?>% · Neu <?= round(100 - $pos_pct - $neg_pct, 1) ?>%)
            </li>
            <?php if ($top_pos && $top_neg): ?>
            <li>ตลาดเชิงบวกสุด: <b><?= esc($top_pos['name']) ?></b>
                <span class="pill pill-good">+<?= $top_pos['score'] ?></span>
                · ตลาดเชิงลบสุด: <b><?= esc($top_neg['name']) ?></b>
                <span class="pill pill-bad"><?= $top_neg['score'] ?></span>
            </li>
            <?php endif; ?>
            <li>📌 <b>ที่มา:</b> INTER_SENTIMENT จาก สนง.ตลาดต่างประเทศ TAT (report ผ่าน <code>/inter/manage6/...</code>)
                — เป็นการประเมินจาก <u>เจ้าหน้าที่ในตลาด</u> ไม่ใช่ social listening ทั่วไป
                · ปีที่ใช้: <?= $sentiment_source === 'current' ? $current_year_thai : $prev_year_thai . ' (fallback)' ?>
            </li>
        </ul>
    </div>
    <?php endif; ?>

    <!-- 7. Scenario Simulator -->
    <div class="fi-section-title"><i class="fas fa-sliders"></i> Scenario Simulator <span class="fi-badge">Tier 3</span></div>
    <div class="fi-card">
        <div style="font-size:0.82em; color:#64748b; margin-bottom:12px;">
            ปรับค่า indicators เพื่อดูผลกระทบต่อนักท่องเที่ยว 6 เดือนถัดไป · หรือเลือก Preset
        </div>
        <div class="slider-grid">
            <?php foreach (['seat'=>'seat_capacity_chg','fbi'=>'fbi_chg','cancel'=>'flight_cancel_pct','meltw'=>'meltwater_neg','office'=>'office_sentiment_score'] as $key => $baseKey):
                $r = $slider_ranges[$key];
                $bv = $baseline[$baseKey];
            ?>
            <div class="slider-row">
                <div class="sl-head">
                    <span class="sl-lbl"><?= $r['label'] ?></span>
                    <span class="sl-val" id="slVal_<?= $key ?>"><?= $bv ?></span>
                </div>
                <input type="range" id="slider_<?= $key ?>"
                       min="<?= $r['min'] ?>" max="<?= $r['max'] ?>" step="<?= $r['step'] ?>"
                       value="<?= $bv ?>"
                       data-base="<?= $bv ?>">
                <div style="display:flex; justify-content:space-between; font-size:0.7em; color:#94a3b8; margin-top:2px;">
                    <span><?= $r['min'] ?></span><span>Base: <?= $bv ?></span><span><?= $r['max'] ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="preset-grid">
            <?php foreach ($presets as $p): ?>
                <div class="preset-btn" data-preset="<?= $p['key'] ?>" data-vals='<?= htmlspecialchars(json_encode($p['vals']), ENT_QUOTES) ?>'>
                    <i class="fas <?= $p['icon'] ?>"></i>
                    <div class="p-name"><?= htmlspecialchars($p['name']) ?></div>
                    <div class="p-desc"><?= htmlspecialchars($p['desc']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="scenario-pred-box">
            <div class="sp-lbl">คาดการณ์ 6 เดือนรวม (ล้านคน)</div>
            <div class="sp-val" id="scenarioTotal">—</div>
            <div class="sp-delta" id="scenarioDelta">vs. Baseline: —</div>
        </div>

        <div style="margin-top:16px;">
            <div id="chartScenario" class="chart-box-sm"></div>
        </div>

        <div class="chart-insight">
            <div class="ci-title"><i class="fas fa-clipboard-check"></i> วิธีใช้ Scenario Simulator</div>
            <ul>
                <li>ตัวคูณ (multiplier) = <b>1 + Σ weight × (value − baseline)</b> · weight:
                    Seat <b>+0.006</b>/unit · FBI <b>+0.004</b>/unit · Office <b>+0.0015</b>/unit ·
                    Cancel <b>−0.003</b>/unit · Meltwater <b>−0.001</b>/unit
                    (ค่าพื้น 0.3 — กัน collapse)
                </li>
                <li>Presets 5 แบบ:
                    <b>Normal</b> = ค่าปัจจุบัน ·
                    <b>China Recovery</b> = จีนกลับมา ·
                    <b>Aviation Crisis</b> = ยกเลิกสูง/ที่นั่งลด ·
                    <b>Regional Conflict</b> = สงครามกระทบ ·
                    <b>Peak Season</b> = high season
                </li>
                <li>📌 <b>วิธีอ่าน:</b> กล่องเขียว (Scenario) เทียบแถบเทา (Baseline) · delta <span class="pill pill-good">บวก</span>
                    = scenario ดีกว่า baseline · delta <span class="pill pill-bad">ลบ</span> = ความเสียหายจาก shock —
                    ใช้ทำ <u>stress test</u> วางแผนรับมือ
                </li>
            </ul>
        </div>
    </div>

    <!-- 8. Sensitivity Tornado -->
    <div class="fi-section-title"><i class="fas fa-chart-bar"></i> Sensitivity — ผลกระทบต่อ Arrivals เมื่อ indicator เปลี่ยน ±10 unit <span class="fi-badge">Tier 3</span></div>
    <div class="fi-card">
        <div id="tornadoBox" style="padding: 8px 0;"></div>
        <div style="font-size:0.76em; color:#94a3b8; margin-top:6px;">
            แถบยาวกว่า = indicator ตัวนั้นมีอิทธิพลต่อ arrivals มากกว่า
        </div>

        <?php
            $sw = $scenario_weights;
            $sens_rows = [
                ['name' => 'Seat Capacity',    'w' => abs($sw['seat']) * 10 * 100],
                ['name' => 'FBI',              'w' => abs($sw['fbi']) * 10 * 100],
                ['name' => 'Flight Cancel',    'w' => abs($sw['cancel']) * 10 * 100],
                ['name' => 'Meltwater Neg',    'w' => abs($sw['meltw']) * 10 * 100],
                ['name' => 'Office Sentiment', 'w' => abs($sw['office']) * 10 * 100],
            ];
            usort($sens_rows, function($a, $b){ return $b['w'] <=> $a['w']; });
            $sens_top = $sens_rows[0];
            $sens_bot = end($sens_rows);
        ?>
        <div class="chart-insight">
            <div class="ci-title"><i class="fas fa-clipboard-check"></i> ตีความ Sensitivity Tornado</div>
            <ul>
                <li>Indicator ที่กระทบ arrivals มากสุด: <b><?= esc($sens_top['name']) ?></b>
                    <span class="pill pill-info">±<?= number_format($sens_top['w'], 2) ?>%</span> ต่อการเปลี่ยน 10 unit
                    · น้อยสุด: <b><?= esc($sens_bot['name']) ?></b>
                    <span class="pill pill-neutral">±<?= number_format($sens_bot['w'], 2) ?>%</span>
                </li>
                <li>📌 <b>การใช้งาน:</b> indicator ที่แถบยาวคือจุดที่ควร <u>เฝ้าติดตามก่อน</u> —
                    ถ้าตัวเลขขยับ จะกระทบ arrivals มากที่สุด · ใช้ prioritize การสื่อสาร / นโยบายได้
                </li>
                <li>หมายเหตุ: เป็น <b>linear approximation</b> (ภายใน ±10 unit จาก baseline) — นอกกรอบนี้ผลลัพธ์อาจไม่แม่น ·
                    weight มาจาก <a href="#" onclick="return false;" style="color:#0f766e;">scenario_weights</a> ใน Controller
                </li>
            </ul>
        </div>
    </div>

    <!-- 9. Backtest Panel -->
    <div class="fi-section-title"><i class="fas fa-clock-rotate-left"></i> Backtesting — ผลตรวจย้อนหลัง (Overall) <span class="fi-badge">Tier 3</span></div>
    <div class="fi-card">
        <?php if (empty($overall_forecast['backtest'])): ?>
            <div style="color:#94a3b8; padding:20px;">ไม่มีข้อมูลย้อนหลังเพียงพอใน <?= $current_year_thai ?> (ต้องมี actual อย่างน้อย 1 เดือน)</div>
        <?php else: ?>
            <table class="fi-tbl">
                <thead>
                    <tr><th>เดือน</th><th class="td-num">Actual (M)</th><th class="td-num">Predicted (M)</th><th class="td-num">Error %</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($overall_forecast['backtest'] as $b): ?>
                    <tr>
                        <td><?= $month_labels[$b['month']-1] ?> <?= $current_year_thai ?></td>
                        <td class="td-num"><?= number_format($b['actual']/1000000, 3) ?></td>
                        <td class="td-num"><?= number_format($b['pred']/1000000, 3) ?></td>
                        <td class="td-num" style="color: <?= $b['err_pct'] > 15 ? '#dc2626' : ($b['err_pct'] > 8 ? '#d97706' : '#059669') ?>;">
                            <?= $b['err_pct'] ?>%
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr style="font-weight:800; background:#f0fdfa;">
                        <td colspan="3">Mean Absolute Percentage Error (MAPE)</td>
                        <td class="td-num" style="color:#0f766e;"><?= $overall_forecast['mape'] ?>%</td>
                    </tr>
                </tbody>
            </table>

            <?php
                $bt_list = $overall_forecast['backtest'];
                $bt_errs = array_column($bt_list, 'err_pct');
                $bt_mape_v = (float)$overall_forecast['mape'];
                $bt_best_idx = array_search(min($bt_errs), $bt_errs);
                $bt_worst_idx = array_search(max($bt_errs), $bt_errs);
                $bt_best = $bt_list[$bt_best_idx];
                $bt_worst = $bt_list[$bt_worst_idx];
                $bt_over = 0; $bt_under = 0;
                foreach ($bt_list as $b) {
                    if ($b['pred'] > $b['actual']) $bt_over++;
                    elseif ($b['pred'] < $b['actual']) $bt_under++;
                }
                $bt_bias = $bt_over > $bt_under
                    ? 'พยากรณ์ <b>สูงกว่าจริง</b> (overestimate) ' . $bt_over . '/' . count($bt_list) . ' เดือน'
                    : ($bt_under > $bt_over
                        ? 'พยากรณ์ <b>ต่ำกว่าจริง</b> (underestimate) ' . $bt_under . '/' . count($bt_list) . ' เดือน'
                        : 'สมดุล ไม่เอียง (unbiased)');
                $bt_q = $bt_mape_v < 8 ? 'ยอดเยี่ยม — ใช้พยากรณ์จริงได้' : ($bt_mape_v < 15 ? 'พอใช้ได้ — ควรดูปัจจัยอื่นประกอบ' : 'ความแม่นยังต่ำ — ควรรอข้อมูลเพิ่ม');
                $bt_q_pill = $bt_mape_v < 8 ? 'pill-good' : ($bt_mape_v < 15 ? 'pill-warn' : 'pill-bad');
            ?>
            <div class="chart-insight">
                <div class="ci-title"><i class="fas fa-clipboard-check"></i> สรุปผล Backtesting</div>
                <ul>
                    <li>ความแม่นเฉลี่ย:
                        <span class="pill <?= $bt_q_pill ?>"><?= number_format(100 - $bt_mape_v, 1) ?>%</span>
                        (MAPE <?= $bt_mape_v ?>%) — <?= $bt_q ?>
                    </li>
                    <li>เดือนแม่นสุด: <b><?= $month_labels[$bt_best['month'] - 1] ?></b> (err <?= $bt_best['err_pct'] ?>%)
                        · คลาดสุด: <b><?= $month_labels[$bt_worst['month'] - 1] ?></b> (err <?= $bt_worst['err_pct'] ?>%)
                    </li>
                    <li>Bias ของโมเดล: <?= $bt_bias ?></li>
                    <li>📌 <b>วิธีทดสอบ:</b> นำค่าจริงแต่ละเดือนของปี <?= $current_year_thai ?>
                        เทียบกับค่าพยากรณ์ (ลาก 12 เดือน × YoY growth) — simulate การพยากรณ์อนาคตโดยไม่ให้โมเดลเห็นคำตอบ
                    </li>
                    <li>
                        <?php if ($bt_mape_v < 8): ?>
                            ✅ โมเดลผ่านเกณฑ์ — forecast 6 เดือนข้างหน้ามีความน่าเชื่อถือสูง
                        <?php elseif ($bt_mape_v < 15): ?>
                            🟡 โมเดลใช้ได้ — ควรอ่าน forecast คู่กับ Tier 2 (SARIMAX) หรือ leading indicators
                        <?php else: ?>
                            🔴 ความแม่นยังไม่สูง — ใช้ผลลัพธ์เป็น range (CI) แทน point estimate
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <!-- 10. Tier 2 SARIMAX -->
    <div class="fi-section-title"><i class="fas fa-microchip"></i> Tier 2 — Python SARIMAX Forecast</div>
    <?php if ($tier2_status === 'ok' && !empty($tier2)): ?>
        <div class="tier2-alert ok">
            <i class="fas fa-check-circle"></i> ข้อมูล Tier 2 พร้อมใช้งาน · Generated at: <code><?= htmlspecialchars($tier2_generated_at ?? '-') ?></code>
        </div>
        <div class="fi-card">
            <div id="chartTier2" class="chart-box"></div>

            <div class="chart-hint">
                <i class="fas fa-lightbulb"></i>
                <b>เปรียบเทียบ 2 วิธี:</b>
                <b style="color:#0f766e;">SARIMAX</b> = ARIMA(1,1,1)(1,1,1,12) + exogenous indicators · ใช้ปัจจัยภายนอกช่วยพยากรณ์ ·
                <b style="color:#7c3aed;">Holt-Winters</b> = damped trend univariate · อาศัย pattern visitors เอง
            </div>

            <?php
                $t2_meta = $tier2['data_meta'] ?? [];
                $t2_future = $t2_meta['future_labels'] ?? [];
                $t2_sx = $tier2['sarimax']['forecast'] ?? [];
                $t2_ht = $tier2['holt']['forecast'] ?? [];
                if (!empty($t2_sx) && !empty($t2_ht)):
                    $sx_avg = array_sum($t2_sx) / count($t2_sx);
                    $ht_avg = array_sum($t2_ht) / count($t2_ht);
                    $diff = $sx_avg - $ht_avg;
                    $agree_pct = $ht_avg > 0 ? abs($diff) / $ht_avg * 100 : 0;
                    $sx_trend = end($t2_sx) - $t2_sx[0];
                    $ht_trend = end($t2_ht) - $t2_ht[0];
                    $sx_dir = $sx_trend > 0.05 ? 'ขาขึ้น' : ($sx_trend < -0.05 ? 'ขาลง' : 'ทรงตัว');
                    $ht_dir = $ht_trend > 0.05 ? 'ขาขึ้น' : ($ht_trend < -0.05 ? 'ขาลง' : 'ทรงตัว');
                    $same_dir = ($sx_dir === $ht_dir);
                    $sx_low_i = array_search(min($t2_sx), $t2_sx);
                    $sx_hi_i  = array_search(max($t2_sx), $t2_sx);
                    $sx_aic = $tier2['sarimax']['aic'] ?? null;
            ?>
            <div class="chart-insight">
                <div class="ci-title"><i class="fas fa-clipboard-check"></i> สรุปผล Tier 2 Forecast</div>
                <ul>
                    <li>SARIMAX (ใช้ exogenous): เฉลี่ย <b><?= number_format($sx_avg, 2) ?>M/เดือน</b>
                        · ทิศทาง <span class="pill <?= $sx_trend > 0.05 ? 'pill-good' : ($sx_trend < -0.05 ? 'pill-bad' : 'pill-neutral') ?>"><?= $sx_dir ?></span>
                        <?php if ($sx_aic !== null): ?> · AIC <?= number_format((float)$sx_aic, 1) ?><?php endif; ?>
                    </li>
                    <li>Holt-Winters (univariate): เฉลี่ย <b><?= number_format($ht_avg, 2) ?>M/เดือน</b>
                        · ทิศทาง <span class="pill <?= $ht_trend > 0.05 ? 'pill-good' : ($ht_trend < -0.05 ? 'pill-bad' : 'pill-neutral') ?>"><?= $ht_dir ?></span>
                    </li>
                    <li>ทั้ง 2 วิธี
                        <?php if ($same_dir && $agree_pct < 5): ?>
                            <span class="pill pill-good">✓ เห็นตรงกัน</span> ทั้งทิศและค่า — ความเชื่อมั่นสูง
                        <?php elseif ($same_dir): ?>
                            <span class="pill pill-warn">⚠ ทิศตรงกัน แต่ค่าต่างกัน <?= number_format(abs($diff), 2) ?>M (<?= number_format($agree_pct, 1) ?>%)</span>
                        <?php else: ?>
                            <span class="pill pill-bad">⚠ ทิศไม่ตรงกัน</span> · SARIMAX <?= $sx_dir ?> แต่ Holt <?= $ht_dir ?> — ควรระวัง
                        <?php endif; ?>
                    </li>
                    <?php if (!empty($t2_future)): ?>
                    <li>SARIMAX จุดสูงสุด: <b><?= esc($t2_future[$sx_hi_i] ?? '-') ?></b> (<?= number_format(max($t2_sx), 2) ?>M)
                        · ต่ำสุด: <b><?= esc($t2_future[$sx_low_i] ?? '-') ?></b> (<?= number_format(min($t2_sx), 2) ?>M)
                    </li>
                    <?php endif; ?>
                    <li>📌 <b>คำแนะนำ:</b>
                        <?php if ($same_dir && $agree_pct < 5): ?>
                            ใช้ค่าเฉลี่ยของ 2 วิธีเป็น point estimate ได้
                        <?php elseif ($same_dir): ?>
                            ใช้ช่วง <?= number_format(min($sx_avg, $ht_avg), 2) ?>–<?= number_format(max($sx_avg, $ht_avg), 2) ?>M เป็น range คาดการณ์
                        <?php else: ?>
                            รอข้อมูลเดือนถัดไปก่อนตัดสินใจ · ทิศทางยังไม่ชัดเจน
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="tier2-alert">
            <i class="fas fa-info-circle"></i> ยังไม่มีไฟล์ <code>public/data/forecast_inter_tier2.json</code> ·
            รัน Python pipeline:<br>
            <code>cd analytics && source venv/bin/activate && python forecast_inter_sarima.py</code>
        </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>

<?php $this->section('scripts') ?>
<script src="<?= base_url('public/js/highcharts/highcharts.js') ?>"></script>
<script src="<?= base_url('public/js/highcharts/highcharts-more.js') ?>"></script>
<script>
// ============ Server Data ============
var overallFc   = <?= json_encode($overall_forecast, JSON_UNESCAPED_UNICODE) ?>;
var regionFc    = <?= json_encode($region_forecast, JSON_UNESCAPED_UNICODE) ?>;
var countryFc   = <?= json_encode($country_forecast, JSON_UNESCAPED_UNICODE) ?>;
var histLabels  = <?= json_encode($history_labels, JSON_UNESCAPED_UNICODE) ?>;
var histValues  = <?= json_encode($history_values) ?>;
var baselineVal = <?= json_encode($baseline) ?>;
var weights     = <?= json_encode($scenario_weights) ?>;
var monthLabels = <?= json_encode($month_labels, JSON_UNESCAPED_UNICODE) ?>;
var sentimentMarkets = <?= json_encode($sentiment_markets, JSON_UNESCAPED_UNICODE) ?>;
var tier2Data   = <?= json_encode($tier2, JSON_UNESCAPED_UNICODE) ?>;
var currentYearThai = <?= $current_year_thai ?>;
var prevYearThai    = <?= $prev_year_thai ?>;
var maxMonth        = <?= $max_month ?>;

var baselineKeys = { seat:'seat_capacity_chg', fbi:'fbi_chg', cancel:'flight_cancel_pct', meltw:'meltwater_neg', office:'office_sentiment_score' };

Highcharts.setOptions({
    chart: { style: { fontFamily: "'Sarabun','Nunito',sans-serif" }, backgroundColor: 'transparent' },
    colors: ['#0f766e','#14b8a6','#5eead4','#0891b2','#f59e0b','#dc2626','#7c3aed','#db2777','#059669','#64748b'],
    credits: { enabled: false },
    lang: { thousandsSep: ',' }
});

// ============ Helper: build month labels ค.ศ. → พ.ศ. ============
function monthThai(m, y) {
    var mNames = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
    return mNames[m] + ' ' + ((y + 543) - 2500);
}

// ============ 1. Overall Chart ============
(function() {
    var fcLabels = overallFc.forecast.map(function(f){ return monthThai(f.month, f.year); });
    var allLabels = histLabels.concat(fcLabels);

    var histSeries = histValues.concat(new Array(fcLabels.length).fill(null));
    var fcSeries = new Array(histValues.length - 1).fill(null);
    fcSeries.push(histValues[histValues.length-1]);
    overallFc.forecast.forEach(function(f){ fcSeries.push(+(f.value/1000000).toFixed(3)); });

    var ciBand = new Array(histValues.length).fill([null,null]);
    var last = histValues[histValues.length-1];
    ciBand[histValues.length-1] = [last, last];
    overallFc.forecast.forEach(function(f){
        ciBand.push([+(f.lower/1000000).toFixed(3), +(f.upper/1000000).toFixed(3)]);
    });

    Highcharts.chart('chartOverall', {
        chart: { type: 'line' },
        title: { text: null },
        xAxis: {
            categories: allLabels,
            plotBands: [{
                from: histLabels.length - 0.5,
                to: histLabels.length + fcLabels.length - 0.5,
                color: 'rgba(15,118,110,0.06)',
                label: { text: 'Forecast 6 เดือน', style: { color: '#0f766e', fontWeight: '700' } }
            }]
        },
        yAxis: { title: { text: 'นักท่องเที่ยว (ล้านคน)' }, gridLineColor: '#f1f5f9' },
        tooltip: { shared: true, valueSuffix: ' M', valueDecimals: 2 },
        plotOptions: {
            line: { marker: { radius: 4, lineWidth: 2, lineColor: '#fff' }, lineWidth: 3 },
            arearange: { fillOpacity: 0.18, lineWidth: 0, marker: { enabled: false } }
        },
        series: [
            { name: 'Historical', data: histSeries, color: '#0f766e', zIndex: 3 },
            { name: 'Forecast', data: fcSeries, color: '#f59e0b', dashStyle: 'Dot', marker: { symbol: 'triangle', radius: 7 }, zIndex: 3 },
            { name: 'CI ±MAPE', type: 'arearange', data: ciBand, color: '#f59e0b', zIndex: 1, linkedTo: ':previous' }
        ],
        legend: { itemStyle: { fontWeight: '600' } }
    });
})();

// ============ 2. Region Chart ============
function buildSeriesFromFc(fc) {
    // combine history + forecast
    var labels = [];
    var histVals = [];
    var fcMap = fc.monthly_by_year || {};
    var yearsOrdered = Object.keys(fcMap).sort();
    yearsOrdered.forEach(function(y){
        for (var m = 1; m <= 12; m++) {
            if (fcMap[y][m] !== undefined && fcMap[y][m] > 0) {
                // for current year, only up to maxMonth-1
                var isLast = (+y === Math.max.apply(null, yearsOrdered.map(Number)));
                if (isLast && m >= maxMonth) continue;
                labels.push(monthThai(m, +y));
                histVals.push(+(fcMap[y][m]/1000000).toFixed(3));
            }
        }
    });

    var fcLabels = fc.forecast.map(function(f){ return monthThai(f.month, f.year); });
    var allLabels = labels.concat(fcLabels);
    var histSeries = histVals.concat(new Array(fcLabels.length).fill(null));
    var fcSeries = new Array(histVals.length-1).fill(null);
    if (histVals.length > 0) fcSeries.push(histVals[histVals.length-1]);
    fc.forecast.forEach(function(f){ fcSeries.push(+(f.value/1000000).toFixed(3)); });
    var ciBand = new Array(histVals.length).fill([null,null]);
    if (histVals.length > 0) {
        ciBand[histVals.length-1] = [histVals[histVals.length-1], histVals[histVals.length-1]];
    }
    fc.forecast.forEach(function(f){ ciBand.push([+(f.lower/1000000).toFixed(3), +(f.upper/1000000).toFixed(3)]); });
    return { labels: allLabels, hist: histSeries, fc: fcSeries, ci: ciBand, nHist: histVals.length, nFc: fcLabels.length, mape: fc.mape };
}

var regionChart = null;
function renderRegion(key) {
    var srcFc;
    if (key === '__ALL__') {
        // combined
        srcFc = { monthly_by_year: {}, forecast: [], mape: 0 };
        var mapeList = [];
        Object.keys(regionFc).forEach(function(rn){
            mapeList.push(regionFc[rn].mape);
            var mb = regionFc[rn].monthly_by_year;
            Object.keys(mb).forEach(function(y){
                if (!srcFc.monthly_by_year[y]) srcFc.monthly_by_year[y] = {};
                for (var m = 1; m <= 12; m++) {
                    if (mb[y][m]) srcFc.monthly_by_year[y][m] = (srcFc.monthly_by_year[y][m] || 0) + mb[y][m];
                }
            });
            regionFc[rn].forecast.forEach(function(f, i){
                if (!srcFc.forecast[i]) srcFc.forecast[i] = { year: f.year, month: f.month, value: 0, lower: 0, upper: 0 };
                srcFc.forecast[i].value += f.value;
                srcFc.forecast[i].lower += f.lower;
                srcFc.forecast[i].upper += f.upper;
            });
        });
        srcFc.mape = mapeList.length ? (mapeList.reduce(function(a,b){return a+b;},0)/mapeList.length).toFixed(2) : 0;
    } else {
        srcFc = regionFc[key];
    }
    var s = buildSeriesFromFc(srcFc);
    var title = key === '__ALL__' ? 'ทุกภูมิภาค' : key;
    if (regionChart) regionChart.destroy();
    regionChart = Highcharts.chart('chartRegion', {
        chart: { type: 'line' },
        title: { text: title + ' · MAPE ' + (srcFc.mape || 0) + '%', style: { fontSize: '0.9em', color:'#64748b' } },
        xAxis: { categories: s.labels,
            plotBands: [{ from: s.nHist-0.5, to: s.nHist+s.nFc-0.5, color:'rgba(15,118,110,0.06)',
                label: { text: 'Forecast 6 เดือน', style: { color:'#0f766e', fontWeight:'700' } } }]
        },
        yAxis: { title: { text: 'ล้านคน' }, gridLineColor: '#f1f5f9' },
        tooltip: { shared: true, valueSuffix: ' M', valueDecimals: 2 },
        plotOptions: { line: { marker: { radius: 3, lineWidth: 1.5, lineColor:'#fff' }, lineWidth: 2.5 }, arearange: { fillOpacity: 0.18, lineWidth: 0, marker: { enabled: false } } },
        series: [
            { name: 'Historical', data: s.hist, color: '#0f766e', zIndex: 3 },
            { name: 'Forecast', data: s.fc, color: '#f59e0b', dashStyle: 'Dot', zIndex: 3 },
            { name: 'CI', type: 'arearange', data: s.ci, color: '#f59e0b', zIndex: 1, linkedTo: ':previous' }
        ]
    });
}

document.querySelectorAll('#regionTabs button').forEach(function(btn){
    btn.addEventListener('click', function(){
        document.querySelectorAll('#regionTabs button').forEach(function(b){ b.classList.remove('active'); });
        btn.classList.add('active');
        renderRegion(btn.dataset.region);
    });
});
renderRegion(document.querySelector('#regionTabs button.active').dataset.region);

// ============ 3. Country Chart ============
var countryChart = null;
function renderCountry(cid) {
    var fc = countryFc[cid];
    if (!fc) return;
    var s = buildSeriesFromFc(fc);
    if (countryChart) countryChart.destroy();
    countryChart = Highcharts.chart('chartCountry', {
        chart: { type: 'line' },
        title: { text: fc.name + ' · MAPE ' + fc.mape + '%', style: { fontSize:'0.9em', color:'#64748b' } },
        xAxis: { categories: s.labels,
            plotBands: [{ from: s.nHist-0.5, to: s.nHist+s.nFc-0.5, color:'rgba(15,118,110,0.06)',
                label: { text: 'Forecast 6 เดือน', style: { color:'#0f766e', fontWeight:'700' } } }]
        },
        yAxis: { title: { text: 'คน' } },
        tooltip: { shared: true, valueDecimals: 0 },
        plotOptions: { line: { marker: { radius: 3, lineWidth: 1.5, lineColor:'#fff' }, lineWidth: 2.5 }, arearange: { fillOpacity: 0.18, lineWidth: 0 } },
        series: [
            { name: 'Historical', data: s.hist.map(function(v){return v===null?null:v*1000000;}), color: '#0f766e', zIndex: 3 },
            { name: 'Forecast', data: s.fc.map(function(v){return v===null?null:v*1000000;}), color: '#f59e0b', dashStyle: 'Dot', zIndex: 3 },
            { name: 'CI', type: 'arearange', data: s.ci.map(function(v){ return v[0]===null?[null,null]:[v[0]*1000000,v[1]*1000000]; }), color: '#f59e0b', zIndex: 1, linkedTo: ':previous' }
        ]
    });
}
document.querySelectorAll('#countryTabs button').forEach(function(btn){
    btn.addEventListener('click', function(){
        document.querySelectorAll('#countryTabs button').forEach(function(b){ b.classList.remove('active'); });
        btn.classList.add('active');
        renderCountry(btn.dataset.cid);
    });
});
var firstCountryBtn = document.querySelector('#countryTabs button.active');
if (firstCountryBtn) renderCountry(firstCountryBtn.dataset.cid);

// ============ 4. Sentiment chart (stacked bar by market) ============
(function() {
    if (!sentimentMarkets || !sentimentMarkets.length) {
        document.getElementById('chartSentiment').innerHTML = '<div style="text-align:center; padding:40px; color:#94a3b8; font-size:0.9em;"><i class="fas fa-inbox"></i><br>ไม่มีข้อมูล</div>';
        return;
    }
    var cats = sentimentMarkets.slice(0, 10).map(function(m){ return m.name; });
    var pos = sentimentMarkets.slice(0, 10).map(function(m){ return m.pos; });
    var neg = sentimentMarkets.slice(0, 10).map(function(m){ return m.neg; });
    var neu = sentimentMarkets.slice(0, 10).map(function(m){ return m.neu; });
    Highcharts.chart('chartSentiment', {
        chart: { type: 'bar' },
        title: { text: 'Top 10 ตลาด · รายงาน sentiment', style: { fontSize: '0.9em', color:'#64748b' } },
        xAxis: { categories: cats },
        yAxis: { title: { text: 'จำนวนรายงาน' }, gridLineColor: '#f1f5f9' },
        plotOptions: { series: { stacking: 'normal' } },
        tooltip: { shared: true },
        series: [
            { name: 'Neg', data: neg, color: '#dc2626' },
            { name: 'Neu', data: neu, color: '#94a3b8' },
            { name: 'Pos', data: pos, color: '#059669' }
        ]
    });
})();

// ============ 5. Scenario Simulator ============
function computeScenarioMultiplier(vals) {
    // multiplier = 1 + sum(w_i * (X_i - base_i))
    var m = 1.0;
    Object.keys(weights).forEach(function(k){
        var bk = baselineKeys[k];
        var base = baselineVal[bk];
        m += weights[k] * (vals[k] - base);
    });
    return Math.max(0.3, m); // floor
}

function scenarioForecast(vals) {
    var mult = computeScenarioMultiplier(vals);
    var baseForecast = overallFc.forecast.map(function(f){ return f.value/1000000; });
    var adjusted = baseForecast.map(function(v){ return +(v*mult).toFixed(3); });
    var total = adjusted.reduce(function(a,b){return a+b;},0);
    var baseTotal = baseForecast.reduce(function(a,b){return a+b;},0);
    return { mult: mult, adjusted: adjusted, total: total, baseTotal: baseTotal, base: baseForecast };
}

var scenarioChart = null;
function updateScenario() {
    var vals = {};
    Object.keys(weights).forEach(function(k){
        vals[k] = parseFloat(document.getElementById('slider_'+k).value);
        document.getElementById('slVal_'+k).textContent = vals[k];
    });
    var sc = scenarioForecast(vals);
    document.getElementById('scenarioTotal').textContent = sc.total.toFixed(2) + ' M';
    var delta = sc.total - sc.baseTotal;
    var pct = sc.baseTotal > 0 ? (delta/sc.baseTotal*100) : 0;
    document.getElementById('scenarioDelta').textContent = 'vs. Baseline: ' + (delta>=0?'+':'') + delta.toFixed(2) + ' M (' + (pct>=0?'+':'') + pct.toFixed(1) + '%)';

    var fcLabels = overallFc.forecast.map(function(f){ return monthThai(f.month, f.year); });
    if (scenarioChart) scenarioChart.destroy();
    scenarioChart = Highcharts.chart('chartScenario', {
        chart: { type: 'column' },
        title: { text: null },
        xAxis: { categories: fcLabels },
        yAxis: { title: { text: 'ล้านคน' }, gridLineColor: '#f1f5f9' },
        tooltip: { shared: true, valueDecimals: 2, valueSuffix: ' M' },
        plotOptions: { column: { borderRadius: 3 } },
        series: [
            { name: 'Baseline', data: sc.base.map(function(v){return +v.toFixed(3);}), color: '#94a3b8' },
            { name: 'Scenario', data: sc.adjusted, color: '#0f766e' }
        ]
    });
}

Object.keys(weights).forEach(function(k){
    document.getElementById('slider_'+k).addEventListener('input', updateScenario);
});

document.querySelectorAll('.preset-btn').forEach(function(b){
    b.addEventListener('click', function(){
        document.querySelectorAll('.preset-btn').forEach(function(x){x.classList.remove('active');});
        b.classList.add('active');
        var vals = JSON.parse(b.dataset.vals);
        Object.keys(vals).forEach(function(k){
            document.getElementById('slider_'+k).value = vals[k];
        });
        updateScenario();
    });
});
updateScenario();

// ============ 6. Sensitivity Tornado ============
(function() {
    var features = [
        { key: 'seat',   name: 'Seat Capacity',   w: weights.seat,   baseKey: 'seat_capacity_chg' },
        { key: 'fbi',    name: 'FBI',             w: weights.fbi,    baseKey: 'fbi_chg' },
        { key: 'cancel', name: 'Flight Cancel',   w: weights.cancel, baseKey: 'flight_cancel_pct' },
        { key: 'meltw',  name: 'Meltwater Neg',   w: weights.meltw,  baseKey: 'meltwater_neg' },
        { key: 'office', name: 'Office Sentiment', w: weights.office, baseKey: 'office_sentiment_score' }
    ];
    // Sensitivity: impact on arrivals (%) when feature moves ±10% of its *scale range*
    var scales = { seat: 10, fbi: 10, cancel: 10, meltw: 10, office: 10 }; // 10 unit move
    // impact% = w * 10 * 100
    var rows = features.map(function(f){
        var imp = f.w * 10 * 100; // % impact on arrivals per +10 unit
        return { name: f.name, neg: -Math.abs(imp), pos: Math.abs(imp) };
    }).sort(function(a,b){ return Math.abs(b.pos)-Math.abs(a.pos); });

    var maxAbs = Math.max.apply(null, rows.map(function(r){return Math.abs(r.pos);}));
    var html = '';
    rows.forEach(function(r){
        var nW = Math.abs(r.neg) / maxAbs * 100;
        var pW = Math.abs(r.pos) / maxAbs * 100;
        html += '<div class="tornado-row">'
              + '<div style="font-weight:700; color:#334155;">' + r.name + '</div>'
              + '<div style="display:flex; justify-content:flex-end;"><div class="tornado-bar neg" style="width:' + nW + '%;"></div></div>'
              + '<div><div class="tornado-bar pos" style="width:' + pW + '%;"></div></div>'
              + '<div style="text-align:right; font-variant-numeric:tabular-nums;">±' + r.pos.toFixed(2) + '%</div>'
              + '</div>';
    });
    document.getElementById('tornadoBox').innerHTML = html;
})();

// ============ 7. Tier 2 SARIMAX Chart ============
(function() {
    if (!tier2Data || !tier2Data.sarimax) return;
    var meta = tier2Data.data_meta || {};
    var labels = (meta.labels || []).concat(meta.future_labels || []);
    var nHist = (meta.labels || []).length;
    var nFut = (meta.future_labels || []).length;
    var observed = (meta.visitors_m || []).concat(new Array(nFut).fill(null));
    var sarimaxFit = tier2Data.sarimax.fitted || [];
    var sarimaxFc = new Array(nHist).fill(null).concat(tier2Data.sarimax.forecast || []);
    var holtFc = new Array(nHist).fill(null).concat((tier2Data.holt || {}).forecast || []);

    Highcharts.chart('chartTier2', {
        chart: { type: 'line' },
        title: { text: 'SARIMAX + Holt Forecast', style: { fontSize: '0.9em', color:'#64748b' } },
        xAxis: { categories: labels,
            plotBands: [{ from: nHist-0.5, to: nHist+nFut-0.5, color:'rgba(15,118,110,0.06)',
                label: { text: 'Forecast', style: { color:'#0f766e', fontWeight:'700' } } }]
        },
        yAxis: { title: { text: 'ล้านคน' }, gridLineColor: '#f1f5f9' },
        tooltip: { shared: true, valueDecimals: 2, valueSuffix: ' M' },
        series: [
            { name: 'Observed', data: observed, color: '#0f766e' },
            { name: 'SARIMAX Fit', data: sarimaxFit.concat(new Array(nFut).fill(null)), color: '#14b8a6', dashStyle: 'ShortDash' },
            { name: 'SARIMAX FC', data: sarimaxFc, color: '#f59e0b', dashStyle: 'Dot', marker: { symbol: 'triangle', radius: 6 } },
            { name: 'Holt FC', data: holtFc, color: '#7c3aed', dashStyle: 'Dot' }
        ]
    });
})();
</script>

<?= $this->endSection() ?>
