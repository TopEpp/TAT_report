<?php $this->extend('templates/main') ?>

<?php $this->section('content') ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700;800&display=swap');

    .rt-wrapper {
        font-family: 'Sarabun', 'Nunito', sans-serif;
        padding: 10px 0 40px;
    }

    /* --- Header --- */
    .rt-header {
        background: linear-gradient(135deg, #007C84 0%, #3eabae 100%);
        color: #fff;
        border-radius: 14px;
        padding: 22px 30px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 3px 15px rgba(0,124,132,0.2);
    }
    .rt-header h2 {
        margin: 0;
        font-size: 1.5em;
        font-weight: 800;
    }
    .rt-header .subtitle {
        font-size: 0.88em;
        opacity: 0.9;
        margin-top: 2px;
    }
    .rt-live {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.2);
        border-radius: 25px;
        padding: 6px 18px;
        font-size: 0.85em;
        font-weight: 700;
    }
    .rt-live .dot {
        width: 9px; height: 9px;
        background: #fff;
        border-radius: 50%;
        animation: pulse-dot 1.4s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.3; transform: scale(0.75); }
    }

    /* --- Scroll Animations --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    /* ซ่อนไว้ก่อน scroll ถึง */
    .scroll-animate {
        opacity: 0;
    }
    .scroll-animate.is-visible {
        animation: fadeInUp 0.6s ease-out both;
    }
    .scroll-animate-left {
        opacity: 0;
    }
    .scroll-animate-left.is-visible {
        animation: fadeInLeft 0.5s ease-out both;
    }
    /* Stagger delays สำหรับ children */
    .stagger-1.is-visible { animation-delay: 0.05s; }
    .stagger-2.is-visible { animation-delay: 0.15s; }
    .stagger-3.is-visible { animation-delay: 0.25s; }
    .stagger-4.is-visible { animation-delay: 0.1s; }
    .stagger-5.is-visible { animation-delay: 0.2s; }
    .stagger-6.is-visible { animation-delay: 0.3s; }
    .stagger-7.is-visible { animation-delay: 0.4s; }

    /* --- Cards --- */
    .rt-card {
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
    .rt-card:hover {
        box-shadow: 0 6px 24px rgba(0,124,132,0.15);
        transform: translateY(-3px);
    }
    .rt-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 4px; height: 100%;
        border-radius: 14px 0 0 14px;
    }
    .rt-card.accent-teal::before { background: #3eabae; }
    .rt-card.accent-purple::before { background: #8b5cf6; }
    .rt-card.accent-orange::before { background: #f59e0b; }

    .card-icon {
        width: 30px; height: 30px;
        border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 1em;
        vertical-align: middle;
        margin-right: 4px;
    }
    .card-icon.icon-teal { background: #e6f7f7; color: #007C84; }
    .card-icon.icon-purple { background: #f0ecfe; color: #7c3aed; }
    .card-icon.icon-orange { background: #fef3e2; color: #d97706; }

    .card-label {
        font-size: 0.78em;
        color: #6b7c7d;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 6px;
    }
    .card-value {
        font-size: 2em;
        font-weight: 800;
        color: #1a3a3c;
        line-height: 1;
        margin-bottom: 6px;
    }
    .card-sub {
        font-size: 0.82em;
        color: #6b7c7d;
        line-height: 1.6;
    }
    .tag-up { color: #059669; font-weight: 700; }
    .tag-down { color: #dc2626; font-weight: 700; }

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

    /* --- Badges --- */
    .mock-badge {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        background: #fffbeb;
        border: 1px solid #fcd34d;
        color: #92400e;
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
    .api-badge {
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
    .data-badge {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        background: #fdf4ff;
        border: 1px solid #d8b4fe;
        color: #7c3aed;
        border-radius: 6px;
        padding: 1px 8px;
        font-size: 0.7em;
        font-weight: 700;
    }
    /* Source table */
    .source-table {
        width: 100%;
        font-size: 0.82em;
        border-collapse: collapse;
    }
    .source-table th {
        background: #f0fafa;
        color: #1a3a3c;
        font-weight: 700;
        padding: 8px 12px;
        text-align: left;
        border-bottom: 2px solid #3eabae;
    }
    .source-table td {
        padding: 7px 12px;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
    }
    .source-table tr:hover td {
        background: #f8fffe;
    }

    /* --- Factor Cards --- */
    .factor-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #e8f0f0;
        padding: 16px 18px;
        margin-bottom: 14px;
        transition: all 0.3s ease;
    }
    .factor-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .factor-name {
        font-weight: 700;
        font-size: 0.78em;
        color: #6b7c7d;
        text-transform: uppercase;
        letter-spacing: 0.2px;
        margin-bottom: 5px;
    }
    .factor-value {
        font-size: 1.5em;
        font-weight: 800;
        color: #1a3a3c;
    }
    .factor-unit {
        font-size: 0.72em;
        color: #94a3b8;
        margin-left: 2px;
    }
    .factor-bar {
        height: 6px;
        background: #f1f5f9;
        border-radius: 5px;
        margin: 8px 0;
        overflow: hidden;
    }
    .factor-bar-inner {
        height: 100%;
        border-radius: 5px;
        transition: width 0.8s ease;
    }
    .factor-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.78em;
    }
    .factor-corr { color: #6b7c7d; font-weight: 600; }
    .factor-corr b { color: #1a3a3c; }

    /* --- Chart Panel --- */
    .chart-panel {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        border: 1px solid #e8f0f0;
        padding: 22px 24px;
        margin-bottom: 18px;
    }
    .chart-panel .panel-title {
        font-size: 0.92em;
        font-weight: 700;
        color: #1a3a3c;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .chart-panel .panel-title i {
        font-size: 0.95em;
    }

    /* --- Status Bar --- */
    .rt-status-bar {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        border: 1px solid #e8f0f0;
        padding: 14px 22px;
        margin-top: 12px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .corr-tag {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 16px;
        font-size: 0.76em;
        font-weight: 700;
        margin: 2px 2px;
    }
    .corr-tag-pos { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    .corr-tag-neg { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    .rt-timestamp {
        font-size: 0.78em;
        color: #94a3b8;
        font-weight: 600;
    }

    /* --- Responsive --- */
    @media (max-width: 767px) {
        .rt-header { flex-direction: column; text-align: center; gap: 10px; padding: 18px 20px; }
        .rt-header h2 { font-size: 1.2em; }
        .card-value { font-size: 1.5em; }
        .factor-value { font-size: 1.2em; }
        .chart-panel { padding: 14px 16px; }
    }
</style>

<div class="rt-wrapper">

    <!-- Header -->
    <div class="rt-header scroll-animate">
        <div>
            <h2>Thai Domestic Tourism Intelligence</h2>
            <div class="subtitle">วิเคราะห์ปัจจัยที่ส่งผลต่อจำนวนนักท่องเที่ยวชาวไทย</div>
        </div>
    </div>

    <!-- Section 1: Metric Cards -->
    <div class="row">
        <div class="col-lg-4 col-md-6 scroll-animate stagger-1">
            <div class="rt-card accent-teal">
                <div class="card-label"><span class="card-icon icon-teal"><i class="fas fa-users"></i></span> นักท่องเที่ยว (เดือนล่าสุด) <span class="data-badge">Data</span></div>
                <div class="card-value"><?= number_format($tourist_current) ?></div>
                <div class="card-sub">
                    ข้อมูล ณ <?= $data_date ?? 'N/A' ?>
                    &nbsp;&middot;&nbsp;
                    <?php if ($tourist_change >= 0): ?>
                        <span class="tag-up">&#9650; +<?= number_format($tourist_change, 1) ?>%</span> MoM
                    <?php else: ?>
                        <span class="tag-down">&#9660; <?= number_format($tourist_change, 1) ?>%</span> MoM
                    <?php endif; ?>
                    <?php if (isset($tourist_yoy_change)): ?>
                        &nbsp;&middot;&nbsp;
                        <?php if ($tourist_yoy_change >= 0): ?>
                            <span class="tag-up">&#9650; +<?= number_format($tourist_yoy_change, 1) ?>%</span> YoY
                        <?php else: ?>
                            <span class="tag-down">&#9660; <?= number_format($tourist_yoy_change, 1) ?>%</span> YoY
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 scroll-animate stagger-2">
            <div class="rt-card accent-purple">
                <div class="card-label"><span class="card-icon icon-purple"><i class="fas fa-chart-line"></i></span> ค่าพยากรณ์เดือนหน้า <span class="mock-badge">&#10060; Mock</span></div>
                <div class="card-value"><?= number_format($tourist_forecast / 1000000, 2) ?>M</div>
                <div class="card-sub">ความเชื่อมั่น <strong style="color:#7c3aed;"><?= number_format($forecast_confidence, 0) ?>%</strong></div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 scroll-animate stagger-3">
            <div class="rt-card accent-orange">
                <div class="card-label"><span class="card-icon icon-orange"><i class="fas fa-heartbeat"></i></span> ดัชนีสุขภาพการท่องเที่ยว <span class="mock-badge">&#10060; Mock</span></div>
                <div class="card-value"><?= number_format($health_index, 0) ?></div>
                <div class="card-sub">ระดับ: <strong style="color:#059669;"><?= esc($health_level) ?></strong></div>
            </div>
        </div>
    </div>

    <!-- Section 2: Factor Cards -->
    <div class="section-title scroll-animate-left">
        <i class="fas fa-sliders-h" style="color:#3eabae;"></i>
        ปัจจัย 5 ตัว Real-Time
        <span class="data-badge">Data</span>
    </div>
    <div class="row">
        <?php
            $factor_colors = ['#0891b2','#dc2626','#d97706','#2563eb','#7c3aed'];
            $factor_icons = ['fa-route','fa-gas-pump','fa-smile','fa-bed','fa-money-bill-wave'];
            foreach ($factors as $fi => $f):
                $is_neg = ($f['r'] < 0);
                $bar_bg = $factor_colors[$fi] ?? '#3eabae';
                $change_cls = $is_neg
                    ? ($f['change'] > 0 ? 'tag-down' : 'tag-up')
                    : ($f['change'] >= 0 ? 'tag-up' : 'tag-down');
                $arrow = $f['change'] >= 0 ? '&#9650;' : '&#9660;';
        ?>
        <div class="col-lg col-md-4 col-6">
            <div class="factor-card">
                <div class="factor-name">
                    <i class="fas <?= $factor_icons[$fi] ?? 'fa-chart-bar' ?>" style="color:<?= $bar_bg ?>; margin-right:3px;"></i>
                    <?= esc($f['name']) ?>
                    <?php if (($f['source'] ?? 'mock') === 'api'): ?>
                        <span class="api-badge">API</span>
                    <?php elseif (($f['source'] ?? 'mock') === 'db'): ?>
                        <span class="db-badge">DB</span>
                    <?php elseif (($f['source'] ?? 'mock') === 'data'): ?>
                        <span class="data-badge">Data</span>
                    <?php else: ?>
                        <span class="mock-badge">Mock</span>
                    <?php endif; ?>
                </div>
                <div>
                    <span class="factor-value" style="color:<?= $bar_bg ?>;"><?= esc($f['value']) ?></span>
                    <span class="factor-unit"><?= esc($f['unit']) ?></span>
                </div>
                <div class="factor-bar">
                    <div class="factor-bar-inner" style="width:<?= esc($f['bar_percent']) ?>%; background:<?= $bar_bg ?>;"></div>
                </div>
                <div class="factor-meta">
                    <span class="factor-corr">r = <b><?= number_format($f['r'], 2, '.', '') ?></b></span>
                    <span class="<?= $change_cls ?>"><?= $arrow ?> <?= number_format(abs($f['change']), 1) ?>%</span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Section 3: Trend Chart -->
    <div class="chart-panel scroll-animate">
        <div class="panel-title">
            <i class="fas fa-chart-area" style="color:#3eabae;"></i>
            แนวโน้มจำนวนการเดินทาง vs นักท่องเที่ยว (ก.พ.68 - มี.ค.69)
            <span class="data-badge">Data</span>
        </div>
        <div id="chart_trend" style="height: 360px;"></div>
    </div>

    <!-- Section 4: Correlation Bar -->
    <div class="chart-panel scroll-animate">
        <div class="panel-title">
            <i class="fas fa-exchange-alt" style="color:#7c3aed;"></i>
            ค่าสหสัมพันธ์ (Correlation) vs นักท่องเที่ยว
            <span class="data-badge">คำนวณจากข้อมูลจริง</span>
        </div>
        <div id="chart_correlation" style="height: 280px;"></div>
    </div>

    <!-- Section 5: Dual Axis Charts -->
    <div class="row scroll-animate">
        <div class="col-lg-6">
            <div class="chart-panel">
                <div class="panel-title">
                    <i class="fas fa-chart-line" style="color:#d97706;"></i>
                    ราคาน้ำมัน 95 vs อัตราเข้าพัก (ก.พ.68 - มี.ค.69) <span class="data-badge">Data</span>
                </div>
                <div id="chart_scatter" style="height: 310px;"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-panel">
                <div class="panel-title">
                    <i class="fas fa-wave-square" style="color:#059669;"></i>
                    Sentiment &amp; CPI Index (ก.พ.68 - มี.ค.69) <span class="data-badge">Data</span>
                </div>
                <div id="chart_dual_axis" style="height: 310px;"></div>
            </div>
        </div>
    </div>

    <!-- Section 6: Heatmap (ซ่อนไว้ก่อน รอข้อมูลจริง) -->
    <div class="chart-panel" style="display:none;">
        <div class="panel-title">
            <i class="fas fa-th" style="color:#dc2626;"></i>
            Correlation Matrix Heatmap
            <span class="mock-badge">&#10060; Mock</span>
        </div>
        <div id="chart_heatmap" style="height: 400px;"></div>
    </div>

    <!-- Section 7: แหล่งข้อมูล (ซ่อนไว้ก่อน) -->
    <?php if (!empty($data_sources)): ?>
    <div class="chart-panel" style="display:none;">
        <div class="panel-title">
            <i class="fas fa-database" style="color:#3eabae;"></i>
            แหล่งที่มาข้อมูล (Data Sources)
        </div>
        <table class="source-table">
            <thead>
                <tr>
                    <th style="width:25%;">ข้อมูล</th>
                    <th style="width:35%;">แหล่งที่มา</th>
                    <th style="width:15%;">ข้อมูลล่าสุด</th>
                    <th style="width:15%;">API</th>
                    <th style="width:10%;">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_sources as $src): ?>
                <tr>
                    <td><strong><?= esc($src['name']) ?></strong></td>
                    <td><?= esc($src['source']) ?></td>
                    <td style="font-size:0.85em; color:#475569;"><?= $src['detail'] ?? '' ?></td>
                    <td>
                        <?php if (!empty($src['api_url'])): ?>
                            <a href="<?= esc($src['api_url']) ?>" target="_blank" style="color:#0891b2; font-size:0.85em;">
                                <i class="fas fa-external-link-alt"></i> Link
                            </a>
                        <?php else: ?>
                            <span style="color:#cbd5e1;">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($src['type'] === 'db'): ?>
                            <span class="db-badge">DB</span>
                        <?php elseif ($src['type'] === 'api'): ?>
                            <span class="api-badge">API</span>
                        <?php elseif ($src['type'] === 'data'): ?>
                            <span class="data-badge">Data</span>
                        <?php else: ?>
                            <span class="mock-badge">Mock</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Bottom Status Bar -->
    <div class="rt-status-bar scroll-animate">
        <div>
            <strong style="color:#1a3a3c;">ปัจจัยหลักที่ส่งผล</strong>
            <span class="data-badge" style="margin-right:4px;">Pearson r</span>
            <?php foreach ($correlations as $c): ?>
                <span class="corr-tag <?= $c['r'] >= 0 ? 'corr-tag-pos' : 'corr-tag-neg' ?>">
                    <?= esc($c['name']) ?> r=<?= ($c['r'] >= 0 ? '+' : '') . number_format($c['r'], 2) ?>
                </span>
            <?php endforeach; ?>
        </div>
        <div class="rt-timestamp">
            อัปเดตล่าสุด: <span id="rt-update-time"></span>
        </div>
    </div>

</div>

<script>
(function(){
    var now = new Date();
    document.getElementById('rt-update-time').textContent =
        String(now.getHours()).padStart(2,'0') + ':' +
        String(now.getMinutes()).padStart(2,'0') + ':' +
        String(now.getSeconds()).padStart(2,'0');

    // === Intersection Observer: trigger animation เมื่อ scroll ถึง ===
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target); // ทำครั้งเดียว

                // ถ้าเป็น card-value ให้ counter animation
                entry.target.querySelectorAll('.card-value').forEach(function(el) {
                    animateNumber(el);
                });

                // ถ้ามี factor-bar ให้ sweep
                entry.target.querySelectorAll('.factor-bar-inner').forEach(function(bar) {
                    var targetWidth = bar.getAttribute('data-width') || bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(function() { bar.style.width = targetWidth; }, 200);
                });
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.scroll-animate, .scroll-animate-left').forEach(function(el) {
        observer.observe(el);
    });

    // เก็บ target width ของ progress bar ไว้ก่อน reset
    document.querySelectorAll('.factor-bar-inner').forEach(function(bar) {
        bar.setAttribute('data-width', bar.style.width);
        bar.style.width = '0%';
    });

    // Number counter function
    function animateNumber(el) {
        if (el.dataset.animated) return;
        el.dataset.animated = '1';
        var text = el.textContent.trim();
        var num = parseFloat(text.replace(/,/g, ''));
        if (isNaN(num) || num === 0) return;
        var isDecimal = text.indexOf('.') > -1;
        var hasM = text.indexOf('M') > -1;
        var duration = 1200;
        var start = performance.now();
        var originalText = text;

        el.textContent = '0';
        function step(ts) {
            var progress = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            var current = num * eased;
            if (hasM) {
                el.textContent = current.toFixed(2) + 'M';
            } else if (isDecimal) {
                el.textContent = current.toFixed(1);
            } else {
                el.textContent = Math.floor(current).toLocaleString();
            }
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = originalText;
        }
        requestAnimationFrame(step);
    }
})();
</script>

<?= $this->endSection() ?>

<?php $this->section('scripts') ?>

<script src="<?= base_url('public/js/highcharts/highcharts.js') ?>"></script>
<script src="<?= base_url('public/js/highcharts/highcharts-more.js') ?>"></script>
<script src="<?= base_url('public/js/highcharts/modules/heatmap.js') ?>"></script>
<script src="<?= base_url('public/js/highcharts/modules/exporting.js') ?>"></script>

<script>
var months = <?= json_encode($months) ?>;
var touristMonthly = <?= json_encode($tourist_monthly) ?>;
var touristMonthlyPast = <?= json_encode($tourist_monthly_past ?? []) ?>;
var chartYear = <?= json_encode($chart_year ?? date('Y')) ?>;
var chartYearPast = <?= json_encode($chart_year_past ?? (date('Y') - 1)) ?>;
var travelMonthly = <?= json_encode($travel_monthly) ?>;
var occMonthly = <?= json_encode($occ_monthly) ?>;
var oilMonthly = <?= json_encode($oil_monthly) ?>;
var cpiMonthly = <?= json_encode($cpi_monthly) ?>;
var sentimentMonthly = <?= json_encode($sentiment_monthly) ?>;
var corrMatrix = <?= json_encode($corr_matrix) ?>;
var corrLabels = <?= json_encode($corr_labels) ?>;
var scatterOil = <?= json_encode($scatter_oil ?? []) ?>;
var scatterOcc = <?= json_encode($scatter_occ ?? []) ?>;
var scatterLabels = <?= json_encode($scatter_labels ?? []) ?>;

// Light theme
Highcharts.setOptions({
    chart: {
        style: { fontFamily: "'Sarabun', 'Nunito', sans-serif" },
        backgroundColor: 'transparent'
    },
    colors: ['#3eabae', '#007C84', '#0891b2', '#2563eb', '#7c3aed', '#d97706', '#dc2626'],
    credits: { enabled: false }
});

// Chart 1: Trend - จำนวนการเดินทาง vs นักท่องเที่ยว
Highcharts.chart('chart_trend', {
    chart: { type: 'areaspline' },
    title: { text: null },
    xAxis: { categories: months, labels: { style: { fontSize: '11px', color: '#64748b' } } },
    yAxis: { title: { text: 'ล้านคน', style: { color: '#64748b' } }, gridLineColor: '#f1f5f9' },
    tooltip: { shared: true, backgroundColor: '#fff', borderColor: '#e2e8f0', style: { color: '#1a3a3c' } },
    plotOptions: {
        areaspline: { fillOpacity: 0.06, marker: { radius: 4, lineWidth: 2 }, lineWidth: 2.5, connectNulls: false }
    },
    series: [
        {
            name: 'จำนวนการเดินทาง (ล้านคน)',
            data: travelMonthly,
            color: '#007C84',
            fillColor: { linearGradient: {x1:0,y1:0,x2:0,y2:1}, stops: [[0,'rgba(0,124,132,0.15)'],[1,'rgba(0,124,132,0)']] },
            marker: { symbol: 'circle', fillColor: '#007C84', lineColor: '#005f66' },
            tooltip: { valueSuffix: ' ล้านคน' }
        },
        {
            name: 'นักท่องเที่ยว (ล้านคน)',
            data: touristMonthly,
            color: '#d97706',
            dashStyle: 'ShortDash',
            fillColor: 'transparent',
            lineWidth: 2,
            marker: { symbol: 'diamond', fillColor: '#d97706', radius: 3 },
            tooltip: { valueSuffix: ' ล้านคน' }
        }
    ]
});

// Chart 2: Correlation Bar
(function() {
    var phpCorr = <?= json_encode($correlations) ?>;
    var cats = [], vals = [];
    phpCorr.forEach(function(item) { cats.push(item.name); vals.push(parseFloat(item.r)); });
    var barColors = vals.map(function(v) { return v >= 0 ? '#059669' : '#dc2626'; });

    Highcharts.chart('chart_correlation', {
        chart: { type: 'bar' },
        title: { text: null },
        xAxis: { categories: cats, labels: { style: { fontSize: '12px', fontWeight: '700', color: '#1a3a3c' } } },
        yAxis: { min: -1, max: 1, title: { text: 'ค่า r', style: { color: '#64748b' } }, gridLineColor: '#f1f5f9',
            plotLines: [{ value: 0, color: '#cbd5e1', width: 1 }] },
        tooltip: { formatter: function() { return '<b>' + this.x + '</b><br>r = ' + Highcharts.numberFormat(this.y, 2); }, backgroundColor: '#fff', borderColor: '#e2e8f0' },
        legend: { enabled: false },
        plotOptions: {
            bar: { colorByPoint: true, colors: barColors, borderRadius: 5, borderWidth: 0, pointWidth: 20,
                dataLabels: { enabled: true, format: '{y:.2f}', style: { fontSize: '11px', fontWeight: '700', color: '#1a3a3c', textOutline: 'none' } }
            }
        },
        series: [{ name: 'Correlation', data: vals }]
    });
})();

// Chart 3: ราคาน้ำมัน 95 vs อัตราเข้าพัก (Dual-Axis Line)
Highcharts.chart('chart_scatter', {
    chart: { type: 'spline' },
    title: { text: null },
    xAxis: { categories: scatterLabels, labels: { style: { fontSize: '10px', color: '#64748b' }, rotation: -45 } },
    yAxis: [
        { title: { text: 'ราคาน้ำมัน 95 (บาท/ลิตร)', style: { color: '#dc2626' } }, labels: { style: { color: '#dc2626' } }, gridLineColor: '#f1f5f9' },
        { title: { text: 'อัตราเข้าพัก (%)', style: { color: '#2563eb' } }, labels: { style: { color: '#2563eb' } }, opposite: true, gridLineWidth: 0 }
    ],
    tooltip: { shared: true, backgroundColor: '#fff', borderColor: '#e2e8f0' },
    legend: { align: 'center', verticalAlign: 'bottom' },
    series: [
        {
            name: 'ราคาน้ำมัน 95 (บาท/ลิตร)',
            data: scatterOil,
            color: '#dc2626',
            yAxis: 0,
            lineWidth: 2.5,
            marker: { radius: 4, symbol: 'circle' },
            tooltip: { valueSuffix: ' บาท/ลิตร' }
        },
        {
            name: 'อัตราเข้าพัก (%)',
            data: scatterOcc,
            color: '#2563eb',
            yAxis: 1,
            lineWidth: 2.5,
            dashStyle: 'ShortDash',
            marker: { radius: 4, symbol: 'diamond' },
            tooltip: { valueSuffix: '%' }
        }
    ]
});

// Chart 4: Dual Axis
Highcharts.chart('chart_dual_axis', {
    chart: { type: 'line' },
    title: { text: null },
    xAxis: { categories: months, labels: { style: { fontSize: '11px', color: '#64748b' } } },
    yAxis: [
        { title: { text: 'Sentiment', style:{color:'#059669'} }, min:0, max:100, labels:{style:{color:'#059669'}}, gridLineColor:'#f1f5f9' },
        { title: { text: 'CPI Index', style:{color:'#d97706'} }, opposite:true, labels:{style:{color:'#d97706'}}, gridLineWidth:0 }
    ],
    tooltip: { shared: true, backgroundColor: '#fff', borderColor: '#e2e8f0' },
    series: [
        { name:'Sentiment', data:sentimentMonthly, color:'#059669', type:'areaspline',
          fillColor:{linearGradient:{x1:0,y1:0,x2:0,y2:1},stops:[[0,'rgba(5,150,105,0.12)'],[1,'rgba(5,150,105,0)']]},
          yAxis:0, lineWidth:2.5, marker:{radius:3,symbol:'circle'} },
        { name:'CPI Index', data:cpiMonthly, color:'#d97706', dashStyle:'ShortDash', yAxis:1, lineWidth:2, marker:{radius:3,symbol:'diamond'} }
    ]
});

// Chart 5: Heatmap
(function() {
    var hd = [];
    for (var r=0; r<corrMatrix.length; r++)
        for (var c=0; c<corrMatrix[r].length; c++)
            hd.push([c, r, parseFloat(corrMatrix[r][c])]);

    Highcharts.chart('chart_heatmap', {
        chart: { type: 'heatmap', plotBorderWidth: 1, plotBorderColor: '#e2e8f0' },
        title: { text: null },
        xAxis: { categories: corrLabels, opposite: true, labels: { style: { color: '#1a3a3c', fontSize: '11px' } } },
        yAxis: { categories: corrLabels, title: null, reversed: true, labels: { style: { color: '#1a3a3c', fontSize: '11px' } } },
        colorAxis: {
            min: -1, max: 1,
            stops: [[0,'#dc2626'],[0.3,'#fca5a5'],[0.5,'#ffffff'],[0.7,'#93c5fd'],[1,'#1d4ed8']]
        },
        tooltip: {
            formatter: function(){ return '<b>'+corrLabels[this.point.y]+'</b> vs <b>'+corrLabels[this.point.x]+'</b><br>r = '+Highcharts.numberFormat(this.point.value,2); },
            backgroundColor: '#fff', borderColor: '#e2e8f0'
        },
        legend: { align:'right', layout:'vertical', verticalAlign:'middle', symbolHeight:250 },
        series: [{
            name:'Correlation', borderWidth:2, borderColor:'#fff', data:hd,
            dataLabels: { enabled:true, format:'{point.value:.2f}', style:{fontSize:'12px',fontWeight:'700',color:'#1e293b',textOutline:'none'} }
        }]
    });
})();
</script>

<?= $this->endSection() ?>
