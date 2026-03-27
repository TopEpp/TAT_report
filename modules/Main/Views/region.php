<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<style type="text/css">
.card_info {
    border-radius: 10px;
    margin-bottom: 10px;
    border: 1px solid #fff;
    padding: 15px 5px 15px 5px;
}

.font-19 {
    font-size: 18px;
}

.font-21 {
    font-size: 21px;
}

.font-17 {
    font-size: 17px;
}

.region-card {
    background: #FFF;
    border-radius: 15px;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.region-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.region-badge {
    display: inline-block;
    padding: 5px 15px;
    border-radius: 20px;
    color: #fff;
    font-weight: bold;
    font-size: 16px;
}

.change-label {
    font-size: 22px;
    font-weight: bold;
}

.change-positive { color: green; }
.change-negative { color: red; }

.btn_Color {
    background-color: #3eabae;
    color: white;
}

.highcharts-contextmenu {
    z-index: 9999 !important;
}

#export-loading {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 99999;
    justify-content: center;
    align-items: center;
}
#export-loading .loading-box {
    background: #fff;
    padding: 30px 50px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 5px 30px rgba(0,0,0,0.3);
}
#export-loading .spinner-border {
    width: 3rem;
    height: 3rem;
    color: #3eabae;
}
</style>

<!-- Loading Overlay -->
<div id="export-loading">
    <div class="loading-box">
        <div class="spinner-border mb-3" role="status"></div>
        <div style="font-size: 16px; color: #333;"><b>กำลัง Export กรุณารอสักครู่...</b></div>
    </div>
</div>

<?php $shortmonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); ?>

<div class="py-2">
    <div class="row">
        <div class="col-md-2 col-12 my-auto text-center py-2">
            เลือกช่วงวันที่
        </div>
        <div class="col-md-2 col-12 my-auto">
            <input type="text" name="start_date" id="start_date" class="form-control date_picker"
                value="" placeholder="From" />
        </div>
        <div class="col-md-2 col-12 my-auto">
            <input type="text" name="end_date" id="end_date" class="form-control date_picker"
                value="" placeholder="To" />
        </div>
        <div class="col-md-1 my-auto">
            <div class="btn btn_Color" onclick="ChangeFilter()">ตกลง</div>
        </div>
        <div class="col-md-1 my-auto">
            <div class="btn btn_Color" onclick="ClearFilter()">ล้างค่า</div>
        </div>
        <div class="col-md-3 my-auto text-right">
            <button type="button" onclick="exportPage('png')" class="btn btn-success btn-export" style="border-radius: 1em;">
                <i class="fa-solid fa-file-image"></i> PNG
            </button>
            <button type="button" onclick="exportPage('jpg')" class="btn btn-warning btn-export" style="border-radius: 1em;">
                <i class="fa-solid fa-file-image"></i> JPG
            </button>
            <button type="button" onclick="exportPage('pdf')" class="btn btn-danger btn-export" style="border-radius: 1em;">
                <i class="fa-solid fa-file-pdf"></i> PDF
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card" style="background-position: center;background-size: cover;background-image: url(<?php echo base_url('public/img/bg_report_country_2.png') ?>);background-repeat: no-repeat;">
            <div class="card-body" id="region_dashboard_content">

                <!-- Page Title -->
                <div class="text-center mb-4">
                    <h4 style="color: #1a329a;"><b>ภาพรวมนักท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย</b></h4>
                    <p style="color: #666;">
                        ข้อมูลสะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S'); ?> - <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S'); ?>
                        เทียบกับ <?php echo $Mydate->date_eng2thai($start_date_label_past, 543, 'S', 'S'); ?> - <?php echo $Mydate->date_eng2thai($end_date_label_past, 543, 'S', 'S'); ?>
                    </p>
                </div>

                <?php
                // Generate charts for each region
                foreach ($regionMap as $idx => $region):
                    $sumMonth = $region['sumMonth'];
                    $sumMonth_past = $region['sumMonth_past'];
                    if ($sumMonth_past > 0) {
                        $percent = round(($sumMonth - $sumMonth_past) / $sumMonth_past * 100, 1);
                    } else {
                        $percent = 0;
                    }
                    $changeClass = $percent >= 0 ? 'change-positive' : 'change-negative';
                    $changeSign = $percent >= 0 ? '+' : '';
                ?>

                <?php
                    $chartData = @$regionCharts[$idx];
                    $avg_current = 0;
                    $avg_past = 0;
                    if (!empty($chartData['current'])) {
                        $avg_current = round(array_sum($chartData['current']) / count($chartData['current']));
                    }
                    if (!empty($chartData['past'])) {
                        $avg_past = round(array_sum($chartData['past']) / count($chartData['past']));
                    }

                    list($sy, $sm, $sd) = explode('-', $start_date_label_past);
                    list($ey, $em, $ed) = explode('-', $end_date_label_past);
                    $datePastLine1 = $sd . ' ' . $shortmonth[(int)$sm] . ' ' . ($sy + 543);
                    $datePastLine2 = $ed . ' ' . $shortmonth[(int)$em] . ' ' . ($ey + 543);

                    list($sy, $sm, $sd) = explode('-', $start_date_label);
                    list($ey, $em, $ed) = explode('-', $end_date_label);
                    $dateCurrentLine1 = $sd . ' ' . $shortmonth[(int)$sm] . ' ' . ($sy + 543);
                    $dateCurrentLine2 = $ed . ' ' . $shortmonth[(int)$em] . ' ' . ($ey + 543);
                ?>
                <div class="row mb-3 region-row" style="display: flex; align-items: stretch;">
                    <div class="col-md-3 d-flex">
                        <div class="region-card flex-fill">
                            <!-- Row 1: Badge + Change % -->
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                <span class="region-badge" style="background-color: <?php echo $region['titleColor']; ?>;">
                                    <?php echo $region['name']; ?>
                                </span>
                                <span class="change-label <?php echo $changeClass; ?>">
                                    <?php echo $changeSign . number_format($percent, 1); ?>%
                                </span>
                            </div>

                            <!-- Row 2: Date range (past left, current right) -->
                            <div style="display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 3px;">
                                <div style="color: #888; text-align: left;"><?php echo $datePastLine1; ?><br><?php echo $datePastLine2; ?></div>
                                <div style="color: <?php echo $region['titleColor']; ?>; text-align: right;"><?php echo $dateCurrentLine1; ?><br><?php echo $dateCurrentLine2; ?></div>
                            </div>

                            <!-- VS -->
                            <div class="text-center" style="font-size: 11px; color: <?php echo $region['titleColor']; ?>; margin-bottom: 3px;"><b>VS</b></div>

                            <!-- Row 3: Sum (past left gray, current right colored bg) -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <span style="font-size: 14px; color: #666;"><b><?php echo number_format($sumMonth_past); ?></b></span>
                                <span style="font-size: 14px; color: #fff; background-color: <?php echo $region['titleColor']; ?>; padding: 3px 12px; border-radius: 15px;"><b><?php echo number_format($sumMonth); ?></b></span>
                            </div>

                            <!-- Row 4: Average label -->
                            <div class="text-center" style="font-size: 12px; color: <?php echo $region['titleColor']; ?>; margin-bottom: 3px;"><b>Average</b></div>

                            <!-- Row 5: Average (past left gray, current right colored) -->
                            <div style="display: flex; justify-content: space-between; font-size: 12px;">
                                <div style="color: #888; text-align: left;"><b><?php echo number_format($avg_past); ?></b><br><b>person/day</b></div>
                                <div style="color: <?php echo $region['titleColor']; ?>; text-align: right;"><b><?php echo number_format($avg_current); ?></b><br><b>person/day</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 d-flex">
                        <div class="region-card flex-fill" style="position: relative; z-index: 1;">
                            <div id="chart_region_<?php echo $idx; ?>" style="height: 100%; min-height: 280px;"></div>
                        </div>
                    </div>
                </div>

                <?php endforeach; ?>

                <!-- หมายเหตุ -->
                <!-- <div class="row">
                    <div class="col-md-12" style="background-color: #0a1b54;color: white; font-size: 11px; position: relative; z-index: 0; padding: 10px; border-radius: 8px;">
                        หมายเหตุ : <br>1. ข้อมูลจำแนกรายสัญชาติ (Nationality) ที่มีการกำหนดหลักเกณฑ์การคำนวณนักท่องเที่ยวระหว่างประเทศ
                        (สามารถอ่านเพิ่มเติมได้ที่นิยามในระบบฯ) <br>
                        2. ข้อมูลรวมสะสมในระบบมีความแตกต่างจากข้อมูลรวมสะสมของกระทรวงการท่องเที่ยวและกีฬา ประมาณร้อยละ 1-3 เนื่องจากมีการ Cleansing ข้อมูลรายเดือน และยังไม่นับรวมนักท่องเที่ยวที่เดินทางเข้าประเทศไทยโดยใช้ Border Pass
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<?php
// Prepare chart data for each region
function convertRegionChartData($array, $end_date_label) {
    if (empty($array)) return '[]';
    $series = [];
    $min_year = PHP_INT_MAX;
    foreach ($array as $name => $data) {
        foreach ($data as $date => $value) {
            $dateParts = explode("-", $date);
            if ($name === 'current') {
                $year = (int)$dateParts[0];
                if ($year < $min_year) {
                    $min_year = $year;
                }
            }
        }
    }

    list($year, $month, $day) = explode('-', $end_date_label);
    foreach ($array as $name => $data) {
        if ($name == 'current') {
            $name_chart = ($min_year == $year) ? $year : $min_year . ' - ' . $year;
        } else {
            $name_chart = ($min_year == $year) ? $year - 1 : ($min_year - 1) . ' - ' . ($year - 1);
        }

        $seriesObject = [
            "name" => "'" . (string)$name_chart . "'",
            "lineWidth" => 4,
            "marker" => ["radius" => 4],
            "data" => []
        ];

        foreach ($data as $date => $value) {
            $dateParts = explode("-", $date);
            if ($name == 'current') {
                $y = (int)$dateParts[0];
            } else {
                $y = (int)$dateParts[0] + 1;
            }
            $m = (int)$dateParts[1] - 1;
            $d = (int)$dateParts[2];
            $seriesObject["data"][] = "[Date.UTC($y, $m, $d), $value]";
        }
        $series[] = $seriesObject;
    }
    return json_encode($series);
}

$allChartData = [];
foreach ($regionCharts as $idx => $chartData) {
    $allChartData[$idx] = convertRegionChartData($chartData, $end_date_label);
}
?>

<?php $this->endSection() ?>
<?= $this->section("scripts") ?>
<script src="<?= base_url('public/js/script.js') ?>"></script>
<script src="<?php echo base_url('public/vendor/html2canvas/html2canvas.js'); ?>"></script>
<script src="<?php echo base_url('public/js/highcharts/highcharts.js')?>"></script>
<script src="<?php echo base_url('public/js/highcharts/modules/exporting.js')?> "></script>
<script src="<?php echo base_url('public/js/highcharts/modules/export-data.js')?> "></script>
<script src="<?php echo base_url('public/js/highcharts/modules/accessibility.js')?> "></script>

<script type="text/javascript">
$(function() {
    $('.date_picker').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        language: 'th-th',
        endDate: new Date('<?php list($y, $m, $d) = explode('-', $end_date_label); echo $y . '-' . $m . '-' . $d; ?>')
    });

    var regionNames = <?php echo json_encode(array_column($regionMap, 'name')); ?>;
    var regionColors = <?php echo json_encode(array_column($regionMap, 'color')); ?>;

    <?php foreach ($allChartData as $idx => $jsonData): ?>
    Highcharts.chart('chart_region_<?php echo $idx; ?>', {
        chart: {
            scrollablePlotArea: { minWidth: 700 },
            backgroundColor: 'rgba(0,0,0,0)',
            style: { fontFamily: 'TATSana-Chon' }
        },
        credits: { enabled: false },
        title: {
            text: '<?php echo $regionMap[$idx]['name']; ?>',
            align: 'center',
            style: { color: '<?php echo $regionMap[$idx]['titleColor']; ?>', fontSize: '16px', fontWeight: 'bold' }
        },
        xAxis: {
            type: 'datetime',
            tickInterval: 7 * 24 * 3600 * 1000,
            tickWidth: 0,
            gridLineWidth: 1,
            gridLineDashStyle: 'Dash',
            labels: {
                formatter: function() {
                    return Highcharts.dateFormat('%d/%m', this.value);
                }
            }
        },
        yAxis: [{
            title: { text: null },
            showFirstLabel: false
        }],
        legend: { enabled: true },
        tooltip: {
            shared: true,
            crosshairs: true,
            formatter: function () {
                return this.points
                    .map(point => {
                        let date = new Date(point.x);
                        if (point.series.index === 1) {
                            date.setFullYear(date.getFullYear() - 1);
                        }
                        const formattedDate = Highcharts.dateFormat('%d-%m-%Y', date.getTime());
                        const value = Highcharts.numberFormat(point.y, 0, '.', ',');
                        return '<span style="color: ' + point.series.color + '">' + formattedDate + ' : ' + value + '</span>';
                    })
                    .join('<br>');
            }
        },
        series: <?php echo str_replace('"', '', $jsonData); ?>
    });
    <?php endforeach; ?>

});

function ChangeFilter() {
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    if (start_date && end_date) {
        var parts = start_date.split('/');
        start_date = parts[0] + '-' + parts[1] + '-' + (parts[2] - 543);

        parts = end_date.split('/');
        end_date = parts[0] + '-' + parts[1] + '-' + (parts[2] - 543);

        var url = '<?php echo base_url('main/region'); ?>?start_date=' + start_date + '&end_date=' + end_date;
        window.location.href = url;
    }
}

function ClearFilter() {
    window.location.href = '<?php echo base_url('main/region'); ?>';
}

function showLoading() {
    $('#export-loading').css('display', 'flex');
}
function hideLoading() {
    $('#export-loading').css('display', 'none');
}

function exportPage(format) {
    showLoading();

    var container = document.getElementById('region_dashboard_content');
    var exportBtns = document.querySelectorAll('.btn-export');
    var regionCards = document.querySelectorAll('.region-card');
    var hcMenuBtns = document.querySelectorAll('.highcharts-exporting-group');

    // ซ่อนปุ่ม export + เงา + hamburger menu ก่อน capture
    exportBtns.forEach(function(btn) { btn.style.visibility = 'hidden'; });
    regionCards.forEach(function(card) { card.setAttribute('data-shadow', card.style.boxShadow); card.style.boxShadow = 'none'; card.style.border = '1px solid #ddd'; });
    hcMenuBtns.forEach(function(btn) { btn.style.display = 'none'; });

    var scaleVal = (format === 'pdf') ? 1 : 1.5;

    setTimeout(function() {
        html2canvas(container, {
            allowTaint: true,
            useCORS: true,
            scale: scaleVal,
            backgroundColor: '#ffffff',
            scrollY: -window.scrollY
        }).then(function(canvas) {
            // คืนค่าทั้งหมด
            exportBtns.forEach(function(btn) { btn.style.visibility = 'visible'; });
            regionCards.forEach(function(card) { card.style.boxShadow = card.getAttribute('data-shadow') || ''; card.style.border = ''; });
            hcMenuBtns.forEach(function(btn) { btn.style.display = ''; });
            var fileName = 'region_dashboard_<?php echo $end_date_label; ?>';

            if (format === 'png') {
                var link = document.createElement('a');
                link.download = fileName + '.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
                hideLoading();
            } else if (format === 'jpg') {
                var jpgCanvas = document.createElement('canvas');
                jpgCanvas.width = canvas.width;
                jpgCanvas.height = canvas.height;
                var ctx = jpgCanvas.getContext('2d');
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, jpgCanvas.width, jpgCanvas.height);
                ctx.drawImage(canvas, 0, 0);
                var link = document.createElement('a');
                link.download = fileName + '.jpg';
                link.href = jpgCanvas.toDataURL('image/jpeg', 0.85);
                link.click();
                hideLoading();
            } else if (format === 'pdf') {
                // capture ทีละ 2 region rows แยกหน้า
                var titleEl = document.querySelector('#region_dashboard_content > .text-center.mb-4');
                var rows = document.querySelectorAll('.region-row');
                var totalPages = Math.ceil(rows.length / 2);
                var capturedImages = [];
                var capturedCount = 0;

                // capture title ก่อน
                html2canvas(titleEl, { scale: 1.5, backgroundColor: '#ffffff', useCORS: true, allowTaint: true }).then(function(titleCanvas) {
                    var titleImg = titleCanvas.toDataURL('image/jpeg', 0.90);

                    for (var p = 0; p < totalPages; p++) {
                        (function(pageIdx) {
                            // สร้าง wrapper ชั่วคราวใส่ 2 rows
                            var wrapper = document.createElement('div');
                            wrapper.style.cssText = 'position:absolute;left:-9999px;top:0;width:' + container.offsetWidth + 'px;background:#fff;padding:10px;';
                            var start = pageIdx * 2;
                            var end = Math.min(start + 2, rows.length);
                            for (var r = start; r < end; r++) {
                                wrapper.appendChild(rows[r].cloneNode(true));
                            }
                            document.body.appendChild(wrapper);

                            // ซ่อนเงาและ menu ใน clone
                            wrapper.querySelectorAll('.region-card').forEach(function(c) { c.style.boxShadow = 'none'; c.style.border = '1px solid #ddd'; });
                            wrapper.querySelectorAll('.highcharts-exporting-group').forEach(function(b) { b.style.display = 'none'; });

                            html2canvas(wrapper, { scale: 1.5, backgroundColor: '#ffffff', useCORS: true, allowTaint: true }).then(function(pageCanvas) {
                                capturedImages[pageIdx] = pageCanvas.toDataURL('image/jpeg', 0.90);
                                document.body.removeChild(wrapper);
                                capturedCount++;
                                if (capturedCount === totalPages) {
                                    // ทุกหน้า capture เสร็จ → เปิด print window
                                    var printWindow = window.open('', '_blank');
                                    var html = '<html><head><title>ภาพรวมนักท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย</title>' +
                                        '<style>' +
                                        '@page { size: landscape; margin: 8mm; }' +
                                        'body { margin: 0; padding: 0; }' +
                                        '.page { page-break-after: always; text-align: center; }' +
                                        '.page:last-child { page-break-after: auto; }' +
                                        'img { width: 100%; height: auto; }' +
                                        '.title-img { width: 60%; margin-bottom: 10px; }' +
                                        '</style></head><body>';
                                    for (var i = 0; i < capturedImages.length; i++) {
                                        html += '<div class="page">';
                                        if (i === 0) {
                                            html += '<img class="title-img" src="' + titleImg + '"><br>';
                                        }
                                        html += '<img src="' + capturedImages[i] + '">';
                                        html += '</div>';
                                    }
                                    html += '</body></html>';
                                    printWindow.document.write(html);
                                    printWindow.document.close();
                                    printWindow.onload = function() { printWindow.print(); };
                                    hideLoading();
                                }
                            });
                        })(p);
                    }
                });
            }

            $.post('<?php echo base_url('main/saveLog'); ?>', { type: 'Region' });
        }).catch(function(error) {
            exportBtns.forEach(function(btn) { btn.style.visibility = 'visible'; });
            regionCards.forEach(function(card) { card.style.boxShadow = card.getAttribute('data-shadow') || ''; card.style.border = ''; });
            hcMenuBtns.forEach(function(btn) { btn.style.display = ''; });
            hideLoading();
            console.error('Export error:', error);
            alert('เกิดข้อผิดพลาดในการ Export');
        });
    }, 100);
}
</script>
<?php $this->endSection() ?>
