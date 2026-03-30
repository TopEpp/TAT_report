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

    /* --- Cards --- */
    .rt-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        padding: 22px 24px;
        margin-bottom: 18px;
        border: 1px solid #e8f0f0;
        transition: box-shadow 0.2s;
        position: relative;
        overflow: hidden;
    }
    .rt-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
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
        width: 42px; height: 42px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2em;
        margin-bottom: 12px;
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
        transition: box-shadow 0.2s;
    }
    .factor-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
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
    <div class="rt-header">
        <div>
            <h2>Thai Domestic Tourism Intelligence</h2>
            <div class="subtitle">วิเคราะห์ปัจจัยที่ส่งผลต่อจำนวนนักท่องเที่ยวชาวไทย</div>
        </div>
    </div>

    <!-- Section 1: Metric Cards -->
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="rt-card accent-teal">
                <div class="card-icon icon-teal"><i class="fas fa-users"></i></div>
                <div class="card-label">นักท่องเที่ยว สะสมเดือนนี้ <span class="db-badge">DB</span></div>
                <div class="card-value"><?= number_format($tourist_current) ?></div>
                <div class="card-sub">
                    ข้อมูล ณ <?= isset($data_date) ? $Mydate->date_eng2thai($data_date, 543, 'S', 'S') : 'N/A' ?>
                    <br>
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
        <div class="col-lg-4 col-md-6">
            <div class="rt-card accent-purple">
                <div class="card-icon icon-purple"><i class="fas fa-chart-line"></i></div>
                <div class="card-label">ค่าพยากรณ์เดือนหน้า <span class="mock-badge">&#10060; Mock</span></div>
                <div class="card-value"><?= number_format($tourist_forecast / 1000000, 2) ?>M</div>
                <div class="card-sub">ความเชื่อมั่น <strong style="color:#7c3aed;"><?= number_format($forecast_confidence, 0) ?>%</strong></div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="rt-card accent-orange">
                <div class="card-icon icon-orange"><i class="fas fa-heartbeat"></i></div>
                <div class="card-label">ดัชนีสุขภาพการท่องเที่ยว <span class="mock-badge">&#10060; Mock</span></div>
                <div class="card-value"><?= number_format($health_index, 0) ?></div>
                <div class="card-sub">ระดับ: <strong style="color:#059669;"><?= esc($health_level) ?></strong></div>
            </div>
        </div>
    </div>

    <!-- Section 2: Factor Cards -->
    <div class="section-title">
        <i class="fas fa-sliders-h" style="color:#3eabae;"></i>
        ปัจจัย 5 ตัว Real-Time
        <span class="mock-badge">&#10060; Mock</span>
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
    <div class="chart-panel">
        <div class="panel-title">
            <i class="fas fa-chart-area" style="color:#3eabae;"></i>
            แนวโน้มนักท่องเที่ยว ปี <?= ($chart_year ?? date('Y')) + 543 ?> vs <?= ($chart_year_past ?? (date('Y') - 1)) + 543 ?>
            <span class="db-badge">DB</span>
        </div>
        <div id="chart_trend" style="height: 360px;"></div>
    </div>

    <!-- Section 4: Correlation Bar -->
    <div class="chart-panel">
        <div class="panel-title">
            <i class="fas fa-exchange-alt" style="color:#7c3aed;"></i>
            ค่าสหสัมพันธ์ (Correlation) vs นักท่องเที่ยว
            <span class="mock-badge">&#10060; Mock</span>
        </div>
        <div id="chart_correlation" style="height: 280px;"></div>
    </div>

    <!-- Section 5: Scatter + Dual Axis -->
    <div class="row">
        <div class="col-lg-6">
            <div class="chart-panel">
                <div class="panel-title">
                    <i class="fas fa-braille" style="color:#d97706;"></i>
                    ราคาน้ำมัน <span class="api-badge">API</span> vs อัตราเข้าพัก <span class="mock-badge">Mock</span>
                </div>
                <div id="chart_scatter" style="height: 310px;"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-panel">
                <div class="panel-title">
                    <i class="fas fa-wave-square" style="color:#059669;"></i>
                    Sentiment (RSI) <span class="api-badge">API</span> &amp; CPI Index <span class="api-badge">API</span>
                </div>
                <div id="chart_dual_axis" style="height: 310px;"></div>
            </div>
        </div>
    </div>

    <!-- Section 6: Heatmap -->
    <div class="chart-panel">
        <div class="panel-title">
            <i class="fas fa-th" style="color:#dc2626;"></i>
            Correlation Matrix Heatmap
            <span class="mock-badge">&#10060; Mock</span>
        </div>
        <div id="chart_heatmap" style="height: 400px;"></div>
    </div>

    <!-- Section 7: แหล่งข้อมูล -->
    <?php if (!empty($data_sources)): ?>
    <div class="chart-panel">
        <div class="panel-title">
            <i class="fas fa-database" style="color:#3eabae;"></i>
            แหล่งที่มาข้อมูล (Data Sources)
        </div>
        <table class="source-table">
            <thead>
                <tr>
                    <th>ข้อมูล</th>
                    <th>แหล่งที่มา</th>
                    <th>API Endpoint</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_sources as $src): ?>
                <tr>
                    <td><strong><?= esc($src['name']) ?></strong></td>
                    <td><?= esc($src['source']) ?></td>
                    <td>
                        <?php if (!empty($src['api_url'])): ?>
                            <a href="<?= esc($src['api_url']) ?>" target="_blank" style="color:#0891b2; font-size:0.85em; word-break:break-all;">
                                <i class="fas fa-external-link-alt"></i> API Link
                            </a>
                        <?php else: ?>
                            <span style="color:#94a3b8;">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($src['type'] === 'db'): ?>
                            <span class="db-badge">DB</span>
                        <?php elseif ($src['type'] === 'api'): ?>
                            <span class="api-badge">API</span>
                        <?php else: ?>
                            <span class="mock-badge">&#10060; Mock</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Bottom Status Bar -->
    <div class="rt-status-bar">
        <div>
            <strong style="color:#1a3a3c;">ปัจจัยหลักที่ส่งผล</strong>
            <span class="mock-badge" style="margin-right:4px;">&#10060; Mock</span>
            <span class="corr-tag corr-tag-pos">การเดินทาง r=+0.91</span>
            <span class="corr-tag corr-tag-pos">อัตราเข้าพัก r=+0.83</span>
            <span class="corr-tag corr-tag-pos">Sentiment r=+0.78</span>
            <span class="corr-tag corr-tag-neg">ราคาน้ำมัน r=-0.67</span>
            <span class="corr-tag corr-tag-neg">CPI r=-0.44</span>
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

// Light theme
Highcharts.setOptions({
    chart: {
        style: { fontFamily: "'Sarabun', 'Nunito', sans-serif" },
        backgroundColor: 'transparent'
    },
    colors: ['#3eabae', '#007C84', '#0891b2', '#2563eb', '#7c3aed', '#d97706', '#dc2626'],
    credits: { enabled: false }
});

// Chart 1: Trend (DB)
Highcharts.chart('chart_trend', {
    chart: { type: 'areaspline' },
    title: { text: null },
    xAxis: { categories: months, labels: { style: { fontSize: '11px', color: '#64748b' } } },
    yAxis: { title: { text: 'ล้านคน', style: { color: '#64748b' } }, gridLineColor: '#f1f5f9' },
    tooltip: { shared: true, valueSuffix: ' ล้านคน', backgroundColor: '#fff', borderColor: '#e2e8f0', style: { color: '#1a3a3c' } },
    plotOptions: {
        areaspline: { fillOpacity: 0.06, marker: { radius: 4, lineWidth: 2 }, lineWidth: 2.5, connectNulls: false }
    },
    series: [
        {
            name: 'ปี ' + (chartYear + 543),
            data: touristMonthly,
            color: '#007C84',
            fillColor: { linearGradient: {x1:0,y1:0,x2:0,y2:1}, stops: [[0,'rgba(0,124,132,0.15)'],[1,'rgba(0,124,132,0)']] },
            marker: { symbol: 'circle', fillColor: '#007C84', lineColor: '#005f66' }
        },
        {
            name: 'ปี ' + (chartYearPast + 543),
            data: touristMonthlyPast,
            color: '#94a3b8',
            dashStyle: 'ShortDash',
            fillColor: 'transparent',
            lineWidth: 2,
            marker: { symbol: 'diamond', fillColor: '#94a3b8', radius: 3 }
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

// Chart 3: Scatter
(function() {
    var sd = [];
    for (var i = 0; i < oilMonthly.length; i++) {
        if (oilMonthly[i] != null && occMonthly[i] != null)
            sd.push({ x: parseFloat(oilMonthly[i]), y: parseFloat(occMonthly[i]), name: months[i] });
    }
    var n=sd.length, sx=0, sy=0, sxy=0, sx2=0;
    sd.forEach(function(p){ sx+=p.x; sy+=p.y; sxy+=p.x*p.y; sx2+=p.x*p.x; });
    var sl=(n*sxy-sx*sy)/(n*sx2-sx*sx), ic=(sy-sl*sx)/n;
    var xMn=Infinity, xMx=-Infinity;
    sd.forEach(function(p){ if(p.x<xMn) xMn=p.x; if(p.x>xMx) xMx=p.x; });

    Highcharts.chart('chart_scatter', {
        chart: { type: 'scatter', zoomType: 'xy' },
        title: { text: null },
        xAxis: { title: { text: 'ราคาน้ำมัน (บาท/ลิตร)', style:{color:'#64748b'} }, gridLineColor: '#f1f5f9' },
        yAxis: { title: { text: 'อัตราเข้าพัก (%)', style:{color:'#64748b'} }, gridLineColor: '#f1f5f9' },
        tooltip: { formatter: function(){ return '<b>'+this.point.name+'</b><br>น้ำมัน: '+Highcharts.numberFormat(this.x,1)+' บาท<br>OCC: '+Highcharts.numberFormat(this.y,1)+'%'; }, backgroundColor: '#fff', borderColor: '#e2e8f0' },
        legend: { enabled: false },
        series: [
            { name:'ข้อมูลรายเดือน', data:sd, color:'#d97706', marker:{radius:7,symbol:'circle',fillColor:'#d97706',lineWidth:2,lineColor:'#b45309'} },
            { type:'line', name:'Trend', data:[[xMn,sl*xMn+ic],[xMx,sl*xMx+ic]], color:'#dc2626', dashStyle:'LongDash', lineWidth:2, marker:{enabled:false}, enableMouseTracking:false }
        ]
    });
})();

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
