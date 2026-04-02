<?php $this->extend('templates/main') ?>

<?php $this->section('content') ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700;800&display=swap');

    .rti-wrapper {
        font-family: 'Sarabun', 'Nunito', sans-serif;
        padding: 10px 0 40px;
    }

    /* --- Header --- */
    .rti-header {
        background: linear-gradient(135deg, #007C84 0%, #3eabae 100%);
        color: #fff;
        border-radius: 14px;
        padding: 22px 30px;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 3px 15px rgba(0,124,132,0.2);
    }
    .rti-header h2 {
        margin: 0;
        font-size: 1.5em;
        font-weight: 800;
    }
    .rti-header .subtitle {
        font-size: 0.88em;
        opacity: 0.9;
        margin-top: 2px;
    }
    .rti-live {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.2);
        border-radius: 25px;
        padding: 6px 18px;
        font-size: 0.85em;
        font-weight: 700;
        white-space: nowrap;
    }
    .rti-live .dot {
        width: 9px; height: 9px;
        background: #4ade80;
        border-radius: 50%;
        animation: pulse-dot 1.4s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.3; transform: scale(0.75); }
    }

    /* --- Event Alert --- */
    .rti-event-alert {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(220,38,38,0.85);
        color: #fff;
        border-radius: 20px;
        padding: 4px 16px;
        font-size: 0.8em;
        font-weight: 700;
        margin-left: 12px;
    }

    /* --- Tab Navigation --- */
    .rti-tabs {
        display: flex;
        gap: 0;
        background: #fff;
        border-radius: 0 0 14px 14px;
        border: 1px solid #e8f0f0;
        border-top: none;
        margin-bottom: 18px;
        overflow-x: auto;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .rti-tab {
        padding: 12px 22px;
        font-size: 0.88em;
        font-weight: 600;
        color: #6b7c7d;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        white-space: nowrap;
        transition: all 0.2s;
    }
    .rti-tab:hover {
        color: #007C84;
        background: #f0fafa;
    }
    .rti-tab.active {
        color: #007C84;
        border-bottom-color: #007C84;
        font-weight: 800;
    }

    /* --- Alert Banner --- */
    .rti-alert-banner {
        background: linear-gradient(135deg, #fef3e2 0%, #fff7ed 100%);
        border: 1px solid #fed7aa;
        border-left: 4px solid #f59e0b;
        border-radius: 10px;
        padding: 14px 20px;
        margin-bottom: 18px;
        font-size: 0.88em;
        color: #92400e;
        line-height: 1.7;
    }
    .rti-alert-banner .alert-icon {
        color: #f59e0b;
        font-weight: 800;
        margin-right: 6px;
    }

    /* --- Scroll Animations --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .scroll-animate { opacity: 0; }
    .scroll-animate.is-visible { animation: fadeInUp 0.6s ease-out both; }
    .stagger-1.is-visible { animation-delay: 0.05s; }
    .stagger-2.is-visible { animation-delay: 0.15s; }
    .stagger-3.is-visible { animation-delay: 0.25s; }
    .stagger-4.is-visible { animation-delay: 0.35s; }
    .stagger-5.is-visible { animation-delay: 0.1s; }
    .stagger-6.is-visible { animation-delay: 0.2s; }
    .stagger-7.is-visible { animation-delay: 0.3s; }
    .stagger-8.is-visible { animation-delay: 0.4s; }

    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .scroll-animate-left { opacity: 0; }
    .scroll-animate-left.is-visible { animation: fadeInLeft 0.5s ease-out both; }

    @keyframes countPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .card-value.is-counting { animation: countPulse 0.3s ease; }

    /* --- Cards --- */
    .rti-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        padding: 22px 24px;
        margin-bottom: 18px;
        border: 1px solid #e8f0f0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .rti-card:hover {
        box-shadow: 0 6px 24px rgba(0,124,132,0.15);
        transform: translateY(-3px);
    }
    .rti-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 4px; height: 100%;
        border-radius: 14px 0 0 14px;
    }
    .rti-card.accent-teal::before { background: #3eabae; }
    .rti-card.accent-red::before { background: #dc2626; }
    .rti-card.accent-orange::before { background: #f59e0b; }
    .rti-card.accent-purple::before { background: #8b5cf6; }

    .card-label {
        font-size: 0.78em;
        color: #6b7c7d;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 6px;
    }
    .card-value {
        font-size: 2.2em;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 8px;
    }
    .card-value.positive { color: #059669; }
    .card-value.negative { color: #dc2626; }
    .card-value.neutral { color: #1a3a3c; }
    .card-value.warning { color: #f59e0b; }
    .card-sub {
        font-size: 0.82em;
        color: #6b7c7d;
        line-height: 1.6;
    }

    /* --- YTD Card --- */
    .ytd-table {
        width: 100%;
        font-size: 0.85em;
        border-collapse: collapse;
        margin-top: 10px;
    }
    .ytd-table th {
        font-weight: 700;
        color: #6b7c7d;
        text-align: left;
        padding: 5px 8px;
        border-bottom: 2px solid #e8f0f0;
        font-size: 0.9em;
    }
    .ytd-table td {
        padding: 5px 8px;
        border-bottom: 1px solid #f1f5f9;
        color: #1a3a3c;
        font-weight: 600;
    }
    .ytd-table .yoy-pos { color: #059669; font-weight: 700; }
    .ytd-table .yoy-neg { color: #dc2626; font-weight: 700; }

    /* --- Data Source Badge --- */
    .source-tag {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        background: #eff6ff;
        border: 1px solid #93c5fd;
        color: #1e40af;
        border-radius: 6px;
        padding: 1px 8px;
        font-size: 0.7em;
        font-weight: 700;
    }
    .db-badge {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        background: #ecfdf5;
        border: 1px solid #6ee7b7;
        color: #065f46;
        border-radius: 6px;
        padding: 1px 8px;
        font-size: 0.7em;
        font-weight: 700;
    }

    /* --- Section Title --- */
    .section-title {
        font-size: 1em;
        font-weight: 700;
        color: #1a3a3c;
        margin: 24px 0 12px;
        padding-left: 12px;
        border-left: 3px solid #3eabae;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* --- Impact Badge --- */
    .impact-badge {
        display: inline-block;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #fff;
        border-radius: 6px;
        padding: 3px 12px;
        font-size: 0.75em;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    /* --- War marker --- */
    .war-marker {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #dc2626;
        font-size: 0.82em;
        font-weight: 700;
        margin-top: 10px;
        padding: 8px 16px;
        background: #fef2f2;
        border-radius: 8px;
        border: 1px solid #fecaca;
    }

    /* --- Flight Section --- */
    .flight-section {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        border: 1px solid #e8f0f0;
        padding: 24px 28px;
        margin-bottom: 18px;
    }
    .flight-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 8px;
    }
    .flight-header h4 {
        font-size: 1.15em;
        font-weight: 800;
        color: #1a3a3c;
        margin: 0;
    }
    .flight-header .flight-meta {
        font-size: 0.82em;
        color: #94a3b8;
        font-weight: 600;
        text-align: right;
    }

    .flight-summary-card {
        background: #f8fffe;
        border: 1px solid #e8f0f0;
        border-radius: 10px;
        padding: 16px 18px;
        text-align: center;
        transition: all 0.3s ease;
    }
    .flight-summary-card:hover {
        box-shadow: 0 4px 16px rgba(0,124,132,0.12);
        transform: translateY(-2px);
    }
    .flight-summary-card .fs-label {
        font-size: 0.78em;
        color: #6b7c7d;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .flight-summary-card .fs-value {
        font-size: 1.8em;
        font-weight: 800;
        line-height: 1.1;
    }
    .flight-summary-card .fs-sub {
        font-size: 0.75em;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 2px;
    }

    .airport-card {
        background: #fff;
        border: 1px solid #e8f0f0;
        border-radius: 10px;
        padding: 14px 16px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .airport-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .airport-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 4px; height: 100%;
    }
    .airport-card .ap-code {
        font-size: 1.1em;
        font-weight: 800;
        color: #1a3a3c;
    }
    .airport-card .ap-name {
        font-size: 0.75em;
        color: #94a3b8;
        font-weight: 600;
    }
    .airport-card .ap-value {
        font-size: 1.6em;
        font-weight: 800;
        line-height: 1.1;
        margin-top: 6px;
    }
    .airport-card .ap-sub {
        font-size: 0.72em;
        color: #6b7c7d;
        margin-top: 2px;
    }
    .airport-card .ap-note {
        display: inline-block;
        background: #fef2f2;
        color: #dc2626;
        border-radius: 4px;
        padding: 1px 6px;
        font-size: 0.68em;
        font-weight: 700;
        margin-left: 4px;
    }

    /* Airline / Route bars */
    .bar-list { list-style: none; padding: 0; margin: 0; }
    .bar-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 0;
        font-size: 0.85em;
    }
    .bar-list .bl-name {
        min-width: 140px;
        font-weight: 600;
        color: #1a3a3c;
        text-align: right;
        flex-shrink: 0;
    }
    .bar-list .bl-bar-wrap {
        flex: 1;
        background: #f1f5f9;
        border-radius: 4px;
        height: 18px;
        overflow: hidden;
    }
    .bar-list .bl-bar {
        display: block;
        height: 100%;
        border-radius: 4px;
        transition: width 0.8s ease;
        min-width: 4px;
        width: 0%;
    }
    .bar-list .bl-value {
        min-width: 50px;
        font-weight: 800;
        color: #1a3a3c;
        text-align: right;
    }
    .bar-section-title {
        font-size: 0.9em;
        font-weight: 800;
        color: #f59e0b;
        margin-bottom: 10px;
        padding-bottom: 6px;
        border-bottom: 2px solid #fef3e2;
    }

    /* Region table */
    .region-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88em;
    }
    .region-table th {
        background: #f0fafa;
        color: #1a3a3c;
        font-weight: 700;
        padding: 10px 14px;
        text-align: right;
        border-bottom: 2px solid #3eabae;
    }
    .region-table th:first-child { text-align: left; }
    .region-table td {
        padding: 9px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #1a3a3c;
        text-align: right;
        font-weight: 600;
    }
    .region-table td:first-child {
        text-align: left;
        font-weight: 700;
    }
    .region-table tr:hover td { background: #f8fffe; }
    .region-table tr.total-row td {
        background: #f0fafa;
        font-weight: 800;
        font-size: 1.02em;
        border-bottom: 2px solid #3eabae;
    }
    .diff-pos { color: #059669 !important; }
    .diff-neg { color: #dc2626 !important; }

    /* Chart card */
    .chart-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        padding: 22px 24px;
        border: 1px solid #e8f0f0;
        margin-bottom: 18px;
    }
    .chart-card h5 {
        font-size: 1em;
        font-weight: 800;
        color: #1a3a3c;
        margin-bottom: 4px;
    }
    .chart-card .chart-subtitle {
        font-size: 0.78em;
        color: #94a3b8;
        margin-bottom: 14px;
    }
</style>

<div class="rti-wrapper">

    <!-- ===== HEADER ===== -->
    <div class="rti-header">
        <div>
            <h2>
                <i class="fa fa-globe"></i>
                Tourism Intelligence Dashboard &mdash; Real-time Demand Monitor
            </h2>
            <div class="subtitle">
                กองวิจัยตลาดการท่องเที่ยว &middot; Tourism Authority of Thailand
            </div>
        </div>
        <div class="d-flex align-items-center gap-3 flex-wrap justify-content-end">
            <span class="rti-event-alert">
                <i class="fa fa-exclamation-triangle"></i>
                <?= $event_name ?> &middot; เมื่อ <?= $event_date ?>
            </span>
            <span class="rti-live">
                <span class="dot"></span> REAL-TIME
                <span id="liveTime"></span>
            </span>
        </div>
    </div>

    <!-- TAB NAVIGATION ปิดไว้ก่อน -->
    <!--
    <div class="rti-tabs">
        <div class="rti-tab">Executive Summary</div>
        <div class="rti-tab active">ภาพรวม</div>
        <div class="rti-tab">Seat Capacity</div>
        <div class="rti-tab">Forward Booking &amp; Search</div>
        <div class="rti-tab">Social Listening</div>
        <div class="rti-tab">ปัจจัยภายนอก</div>
        <div class="rti-tab">Impact of War</div>
    </div>
    -->

    <!-- ===== FLIGHT DASHBOARD ===== -->
    <div class="flight-section scroll-animate">
        <div class="flight-header">
            <h4><i class="fa fa-plane"></i> International Flight Dashboard &mdash; Plan (Frequency) vs Actual</h4>
            <div class="flight-meta">
                <?= $flight_period ?> | <?= $flight_airports ?> | ข้อมูลครบ <?= $flight_days ?> วัน
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-3">
            <div class="col-lg-3 col-md-6 mb-2 scroll-animate stagger-1">
                <div class="flight-summary-card">
                    <div class="fs-label">เที่ยวบินนานาชาติทั้งหมด</div>
                    <div class="fs-value" style="color: #1a3a3c;"><?= number_format($flight_total) ?></div>
                    <div class="fs-sub">ทุกสนามบินรวมกัน</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-2 scroll-animate stagger-2">
                <div class="flight-summary-card">
                    <div class="fs-label">บินจริง (Operated)</div>
                    <div class="fs-value" style="color: #059669;"><?= number_format($flight_operated) ?></div>
                    <div class="fs-sub"><?= $flight_operated_pct ?>% ของทั้งหมด</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-2 scroll-animate stagger-3">
                <div class="flight-summary-card">
                    <div class="fs-label">ยกเลิก (Cancelled)</div>
                    <div class="fs-value" style="color: #dc2626;"><?= number_format($flight_cancelled) ?></div>
                    <div class="fs-sub"><?= $flight_cancel_pct ?>% ของทั้งหมด</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-2 scroll-animate stagger-4">
                <div class="flight-summary-card">
                    <div class="fs-label">เฉลี่ยยกเลิก/วัน</div>
                    <div class="fs-value" style="color: #1a3a3c;"><?= $flight_avg_cancel_day ?></div>
                    <div class="fs-sub"><?= $flight_days ?> วัน ทุกสนามบิน</div>
                </div>
            </div>
        </div>

        <!-- Airport Cards -->
        <div class="row mb-3">
            <?php $apIdx = 5; foreach ($airport_cancels as $ap): ?>
            <div class="col-lg-3 col-md-6 mb-2 scroll-animate stagger-<?= $apIdx++ ?>">
                <div class="airport-card" style="border-left: 4px solid <?= $ap['color'] ?>;">
                    <div class="ap-code"><?= $ap['code'] ?></div>
                    <div class="ap-name"><?= $ap['name'] ?></div>
                    <div class="ap-value" style="color: <?= $ap['color'] ?>;"><?= number_format($ap['cancelled']) ?></div>
                    <div class="ap-sub">
                        ยกเลิก จาก <?= number_format($ap['total']) ?> เที่ยว (<?= $ap['pct'] ?>%)
                        <?php if (!empty($ap['note'])): ?>
                            <span class="ap-note"><?= $ap['note'] ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Daily Cancel Chart -->
        <div class="section-title" style="margin-top: 16px;">
            ยกเลิกรายวัน &mdash; แยกตามสนามบิน (<?= $flight_period ?>)
        </div>
        <div id="chartDailyCancel" style="height: 320px;"></div>

        <!-- Airline & Route Charts -->
        <div class="row mt-4 scroll-animate">
            <div class="col-lg-6 mb-3">
                <div class="bar-section-title">% ยกเลิกสูงสุด รายสายการบิน</div>
                <ul class="bar-list">
                    <?php foreach ($airline_cancels as $al): ?>
                    <li>
                        <span class="bl-name"><?= $al['name'] ?></span>
                        <span class="bl-bar-wrap">
                            <span class="bl-bar animate-bar" data-width="<?= $al['pct'] ?>" data-color="<?= $al['color'] ?>"></span>
                        </span>
                        <span class="bl-value"><?= $al['pct'] ?>%</span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="bar-section-title">เส้นทางที่ยกเลิกมากที่สุด</div>
                <ul class="bar-list">
                    <?php
                    $maxRouteCount = $route_cancels[0]['count'];
                    foreach ($route_cancels as $rt): ?>
                    <li>
                        <span class="bl-name"><?= $rt['route'] ?></span>
                        <span class="bl-bar-wrap">
                            <span class="bl-bar animate-bar" data-width="<?= round($rt['count'] / $maxRouteCount * 100) ?>" data-color="#3eabae"></span>
                        </span>
                        <span class="bl-value"><?= $rt['count'] ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Region %Change Table -->
        <div class="section-title scroll-animate" style="margin-top: 16px;">
            TOP %Change Regions &mdash; JAN-<?= strtoupper(date('M')) ?> <?= $prev_year_thai ?> vs JAN-<?= strtoupper(date('M')) ?> <?= $current_year_thai ?>
            <span class="db-badge" style="font-size: 0.7em;">DB</span>
        </div>
        <div class="table-responsive scroll-animate">
            <table class="region-table">
                <thead>
                    <tr>
                        <th>Region</th>
                        <th><?= $prev_year_thai ?></th>
                        <th><?= $current_year_thai ?></th>
                        <th>%Diff</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($region_changes as $rc): ?>
                    <tr<?= $rc['is_total'] ? ' class="total-row"' : '' ?>>
                        <td><?= $rc['region'] ?></td>
                        <td><?= number_format($rc['prev']) ?></td>
                        <td><?= number_format($rc['current']) ?></td>
                        <td class="<?= $rc['diff'] >= 0 ? 'diff-pos' : 'diff-neg' ?>">
                            <?= ($rc['diff'] >= 0 ? '+' : '') . number_format($rc['diff'], 2) ?>%
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== ALERT BANNER ===== -->
    <div class="rti-alert-banner scroll-animate">
        <span class="alert-icon"><i class="fa fa-exclamation-circle"></i></span>
        <strong><?= $event_name ?>:</strong> <?= $event_desc ?>
    </div>

    <!-- ===== METRIC CARDS ===== -->
    <div class="row">
        <!-- Card 1: นักท่องเที่ยวรวมสะสม YTD -->
        <div class="col-lg-3 col-md-6 scroll-animate stagger-1">
            <div class="rti-card accent-teal" style="min-height: 260px;">
                <div class="card-label">
                    <i class="fa fa-plane"></i>
                    นักท่องเที่ยวรวมสะสม ปี <?= $current_year_thai ?> (YTD)
                </div>
                <div class="card-value neutral">
                    <?= number_format($ytd_total, 2) ?>M
                </div>
                <div class="card-sub">
                    <?= $data_period ?> &middot; <span class="db-badge">ข้อมูลจริง</span>
                </div>
                <table class="ytd-table">
                    <thead>
                        <tr>
                            <th>เดือน</th>
                            <th style="text-align:right;"><?= $current_year_thai ?> Actual</th>
                            <th style="text-align:right;">YOY%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ytd_months as $m): ?>
                        <tr>
                            <td><?= $m['month'] ?></td>
                            <td style="text-align:right;"><?= number_format($m['actual'], 2) ?>M</td>
                            <td style="text-align:right;" class="<?= $m['yoy'] >= 0 ? 'yoy-pos' : 'yoy-neg' ?>">
                                <?= ($m['yoy'] >= 0 ? '+' : '') . $m['yoy'] ?>%
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card 2: Seat Capacity -->
        <div class="col-lg-3 col-md-6 scroll-animate stagger-2">
            <div class="rti-card accent-red">
                <div class="card-label">
                    <i class="fa fa-chair"></i>
                    SEAT CAPACITY W5 VS W1 (OAG)
                </div>
                <div class="card-value negative">
                    <?= ($seat_capacity_change >= 0 ? '+' : '') . $seat_capacity_change ?>%
                </div>
                <div class="card-sub">
                    <?= $seat_capacity_desc ?>
                </div>
                <div class="card-sub" style="margin-top: 8px; font-weight: 600;">
                    <?= $seat_capacity_detail ?>
                </div>
                <div style="margin-top: 8px;"><span class="source-tag">OAG · Actual</span></div>
            </div>
        </div>

        <!-- Card 3: Forward Booking Index -->
        <div class="col-lg-3 col-md-6 scroll-animate stagger-3">
            <div class="rti-card accent-orange">
                <div class="card-label">
                    <i class="fa fa-calendar-check"></i>
                    FORWARD BOOKING INDEX &mdash; LATEST VS BASELINE
                </div>
                <div class="card-value negative">
                    <?= ($fbi_change >= 0 ? '+' : '') . $fbi_change ?>%
                </div>
                <div class="card-sub">
                    <?= $fbi_desc ?>
                </div>
                <div class="card-sub" style="margin-top: 8px; font-weight: 600;">
                    <?= $fbi_detail ?>
                </div>
                <div style="margin-top: 8px;"><span class="source-tag">ForwardKeys · Actual</span></div>
            </div>
        </div>

        <!-- Card 4: Sentiment -->
        <div class="col-lg-3 col-md-6 scroll-animate stagger-4">
            <div class="rti-card accent-purple">
                <div class="card-label">
                    <i class="fa fa-comment-dots"></i>
                    SENTIMENT &mdash; NEG MENTIONS (%)
                </div>
                <div class="card-value warning">
                    <?= $sentiment_neg ?>%
                </div>
                <div class="card-sub">
                    <?= $sentiment_detail ?>
                </div>
                <div class="card-sub" style="margin-top: 8px; font-weight: 600;">
                    <?= $sentiment_breakdown ?>
                </div>
                <div style="margin-top: 8px;"><span class="source-tag">Meltwater</span></div>
            </div>
        </div>
    </div>

    <!-- ===== CHARTS ROW ===== -->
    <div class="row">
        <!-- Monthly Arrivals Chart -->
        <div class="col-lg-8 scroll-animate scroll-animate-left">
            <div class="chart-card">
                <h5>Monthly Arrivals &mdash; เปรียบเทียบ <?= $current_year_thai ?> vs <?= $prev_year_thai ?> (ล้านคน)</h5>
                <div class="chart-subtitle">
                    Actual <?= $current_year_thai ?> (จากฐานข้อมูล) &middot; Forecast (Updated) &middot; เทียบ Actual <?= $prev_year_thai ?> ทั้งปี
                </div>
                <div id="chartArrivals" style="height: 400px;"></div>
                <div class="war-marker">
                    <i class="fa fa-exclamation-triangle"></i>
                    28 ก.พ. 2569 &mdash; <?= $event_name ?> &middot; มี.ค. 2569 เริ่มเห็นผลกระทบ
                </div>
            </div>
        </div>

        <!-- Top Markets Chart -->
        <div class="col-lg-4 scroll-animate">
            <div class="chart-card" style="min-height: 500px;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h5>Top Markets &mdash; YoY Change (%)</h5>
                        <div class="chart-subtitle">
                            เปรียบเทียบ <?= $current_year_thai ?> vs <?= $prev_year_thai ?> (YTD) &middot; ข้อมูลจากฐานข้อมูล
                        </div>
                    </div>
                    <span class="db-badge">DB</span>
                </div>
                <div id="chartMarkets" style="height: 380px;"></div>
            </div>
        </div>
    </div>

</div>

<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script src='<?= base_url('public/js/highcharts/highcharts.js') ?>'></script>
<script src='<?= base_url('public/js/highcharts/modules/exporting.js') ?>'></script>
<script>
$(document).ready(function() {

    // Live clock
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        $('#liveTime').text(h + ':' + m + ':' + s);
    }
    updateClock();
    setInterval(updateClock, 1000);

    // === Number Counter Animation ===
    function animateNumber(el) {
        if (el.dataset.animated) return;
        el.dataset.animated = '1';
        var text = el.textContent.trim();
        var num = parseFloat(text.replace(/,/g, ''));
        if (isNaN(num) || num === 0) return;
        var isDecimal = text.indexOf('.') > -1;
        var hasM = text.indexOf('M') > -1;
        var hasPct = text.indexOf('%') > -1;
        var isNeg = num < 0;
        var absNum = Math.abs(num);
        var duration = 1200;
        var start = performance.now();
        var originalText = text;
        el.textContent = '0';
        function step(ts) {
            var progress = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            var current = absNum * eased;
            var prefix = isNeg ? '-' : '';
            if (hasM) {
                el.textContent = prefix + current.toFixed(2) + 'M';
            } else if (hasPct) {
                el.textContent = prefix + current.toFixed(1) + '%';
            } else if (isDecimal) {
                el.textContent = prefix + current.toFixed(1);
            } else {
                el.textContent = prefix + Math.floor(current).toLocaleString();
            }
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = originalText;
        }
        requestAnimationFrame(step);
    }

    // === Scroll Animation Observer ===
    function triggerAnimations(target) {
        // Number counter animation
        target.querySelectorAll('.card-value, .fs-value, .ap-value').forEach(function(el) {
            animateNumber(el);
        });

        // Bar animation
        target.querySelectorAll('.animate-bar').forEach(function(bar) {
            var w = bar.getAttribute('data-width');
            var c = bar.getAttribute('data-color');
            bar.style.backgroundColor = c;
            setTimeout(function() { bar.style.width = w + '%'; }, 200);
        });
    }

    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
                // เรียก animation หลังจาก fadeIn เริ่ม (delay เล็กน้อย)
                setTimeout(function() { triggerAnimations(entry.target); }, 100);
            }
        });
    }, { threshold: 0.05 });

    // Observe ทุก element ที่ต้อง animate
    document.querySelectorAll('.scroll-animate, .scroll-animate-left').forEach(function(el) {
        observer.observe(el);
    });

    // ===== Daily Cancel Stacked Bar Chart =====
    Highcharts.chart('chartDailyCancel', {
        chart: { type: 'column', height: 320, style: { fontFamily: 'Sarabun, Nunito, sans-serif' } },
        title: { text: null },
        xAxis: {
            categories: <?= json_encode($daily_cancel_labels) ?>,
            labels: { rotation: -45, style: { fontSize: '11px' } }
        },
        yAxis: {
            min: 0,
            title: { text: 'เที่ยวบินยกเลิก', style: { color: '#94a3b8' } },
            gridLineColor: '#f1f5f9',
            stackLabels: { enabled: false }
        },
        tooltip: {
            shared: true,
            useHTML: true,
            formatter: function() {
                let s = '<b>' + this.x + '</b><br/>';
                let total = 0;
                this.points.forEach(p => {
                    s += '<span style="color:' + p.series.color + ';font-weight:bold;">\u25cf</span> ' +
                        p.series.name + ': <b>' + p.y + '</b><br/>';
                    total += p.y;
                });
                s += '<b>รวม: ' + total + '</b>';
                return s;
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                borderWidth: 0,
                borderRadius: 2
            }
        },
        series: [
            { name: 'BKK', data: <?= json_encode($daily_cancel_bkk) ?>, color: '#2563eb' },
            { name: 'HKT', data: <?= json_encode($daily_cancel_hkt) ?>, color: '#dc2626' },
            { name: 'DMK', data: <?= json_encode($daily_cancel_dmk) ?>, color: '#f59e0b' },
            { name: 'CNX', data: <?= json_encode($daily_cancel_cnx) ?>, color: '#059669' }
        ],
        legend: {
            align: 'center', verticalAlign: 'top',
            itemStyle: { fontWeight: '600', fontSize: '12px' }
        },
        credits: { enabled: false }
    });

    // ===== Monthly Arrivals Chart =====
    const monthLabels = <?= json_encode($month_labels) ?>;
    const arrivals2568 = <?= json_encode($arrivals_2568) ?>;
    const arrivals2569Actual = <?= json_encode($arrivals_2569_actual) ?>;
    const arrivals2569Forecast = <?= json_encode($arrivals_2569_forecast) ?>;

    Highcharts.chart('chartArrivals', {
        chart: { type: 'column', height: 400, style: { fontFamily: 'Sarabun, Nunito, sans-serif' } },
        title: { text: null },
        xAxis: {
            categories: monthLabels,
            crosshair: true,
            plotBands: [{
                from: 1.5,
                to: 11.5,
                color: 'rgba(220,38,38,0.04)',
                label: {
                    text: '<i class="fa fa-exclamation-triangle"></i> 28 ก.พ.',
                    style: { color: '#dc2626', fontSize: '11px', fontWeight: '700' },
                    align: 'left',
                    x: 5, y: 15,
                    useHTML: true
                }
            }]
        },
        yAxis: {
            title: { text: 'จำนวน (ล้านคน)', style: { color: '#94a3b8' } },
            gridLineColor: '#f1f5f9',
            min: 0
        },
        tooltip: {
            shared: true,
            useHTML: true,
            formatter: function() {
                let s = '<b>' + this.x + '</b><br/>';
                this.points.forEach(p => {
                    if (p.y !== null) {
                        s += '<span style="color:' + p.series.color + ';font-weight:bold;">\u25cf</span> ' +
                            p.series.name + ': <b>' + Highcharts.numberFormat(p.y, 2) + 'M</b><br/>';
                    }
                });
                return s;
            }
        },
        plotOptions: {
            column: { pointPadding: 0.15, borderWidth: 0, borderRadius: 3 },
            line: { marker: { radius: 4 } },
            series: { connectNulls: false }
        },
        series: [
            {
                name: '<?= $prev_year_thai ?> Actual',
                data: arrivals2568,
                color: '#3eabae',
                type: 'column'
            },
            {
                name: '<?= $current_year_thai ?> Actual',
                data: arrivals2569Actual,
                color: '#dc2626',
                type: 'column'
            },
            {
                name: '<?= $current_year_thai ?> Forecast (Updated)',
                data: arrivals2569Forecast,
                color: '#f59e0b',
                type: 'line',
                dashStyle: 'Dash',
                marker: { symbol: 'circle', radius: 5, fillColor: '#f59e0b' },
                lineWidth: 2.5
            }
        ],
        legend: {
            align: 'center',
            verticalAlign: 'top',
            floating: false,
            itemStyle: { fontWeight: '600', fontSize: '12px' }
        },
        credits: { enabled: false }
    });

    // ===== Top Markets Chart =====
    const markets = <?= json_encode($top_markets) ?>;
    const marketNames = markets.map(m => m.name);
    const changeData = markets.map(m => ({
        y: m.change,
        color: m.change >= 0 ? '#3eabae' : '#dc2626'
    }));

    Highcharts.chart('chartMarkets', {
        chart: { type: 'bar', height: 380, style: { fontFamily: 'Sarabun, Nunito, sans-serif' } },
        title: { text: null },
        xAxis: {
            categories: marketNames,
            labels: { style: { fontSize: '12px', fontWeight: '600', color: '#1a3a3c' } }
        },
        yAxis: {
            title: { text: null },
            labels: { format: '{value}%' },
            gridLineColor: '#f1f5f9',
            plotLines: [{ value: 0, color: '#94a3b8', width: 1 }]
        },
        tooltip: {
            useHTML: true,
            formatter: function() {
                const m = markets[this.point.index];
                return '<b>' + this.x + '</b><br/>' +
                    'YoY Change: <b>' + (this.y >= 0 ? '+' : '') + this.y + '%</b><br/>' +
                    '<?= $current_year_thai ?>: ' + Highcharts.numberFormat(m.current, 0) + '<br/>' +
                    '<?= $prev_year_thai ?>: ' + Highcharts.numberFormat(m.past, 0);
            }
        },
        plotOptions: {
            bar: {
                pointPadding: 0.1,
                groupPadding: 0.15,
                borderWidth: 0,
                borderRadius: 3,
                colorByPoint: true
            }
        },
        series: [{
            name: 'YoY Change %',
            data: changeData,
            showInLegend: false
        }],
        credits: { enabled: false }
    });

    // Number animation ใช้ animateNumber ใน observer เท่านั้น (ไม่ซ้ำซ้อน)
});
</script>
<?php $this->endSection() ?>
