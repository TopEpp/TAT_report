<?php $this->extend('templates/main') ?>

<?php $this->section('content') ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700;800&display=swap');

    .fc-wrapper { font-family: 'Sarabun', 'Nunito', sans-serif; padding: 10px 0 40px; }

    /* --- Header --- */
    .fc-header {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 60%, #5eead4 100%);
        color: #fff;
        border-radius: 14px;
        padding: 22px 30px;
        margin-bottom: 22px;
        box-shadow: 0 6px 24px rgba(15,118,110,0.25);
        position: relative; overflow: hidden;
    }
    .fc-header::after {
        content: ''; position: absolute; right: -60px; top: -60px;
        width: 220px; height: 220px;
        background: rgba(255,255,255,0.08); border-radius: 50%;
    }
    .fc-header h2 { margin: 0; font-size: 1.5em; font-weight: 800; position: relative; z-index: 1; }
    .fc-header .subtitle { font-size: 0.88em; opacity: 0.92; margin-top: 4px; position: relative; z-index: 1; }
    .fc-header .fc-tag {
        display: inline-block; background: rgba(255,255,255,0.22);
        padding: 3px 12px; border-radius: 14px;
        font-size: 0.6em; vertical-align: middle; margin-left: 8px; font-weight: 700;
    }

    /* --- Cards --- */
    .fc-card {
        background: #fff; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        padding: 20px 22px; margin-bottom: 16px;
        border: 1px solid #e8f0f0;
    }
    .fc-section-title {
        font-size: 1em; font-weight: 800; color: #1a3a3c;
        margin: 28px 0 12px; padding-left: 12px;
        border-left: 3px solid #0f766e;
        display: flex; align-items: center; gap: 8px;
    }
    .fc-section-title i { color: #0f766e; }
    .fc-section-title .fc-badge {
        margin-left: 6px;
        background: #ccfbf1; color: #0f766e;
        border: 1px solid #5eead4;
        font-size: 0.7em; font-weight: 700;
        padding: 2px 10px; border-radius: 10px;
    }

    /* --- Early Warning Cards --- */
    .warn-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 12px; margin-bottom: 12px;
    }
    .warn-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e8f0f0;
        border-left: 5px solid #94a3b8;
        padding: 14px 16px;
        transition: transform 0.25s, box-shadow 0.25s;
    }
    .warn-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
    .warn-card.ok       { border-left-color: #059669; background: linear-gradient(135deg,#fff,#ecfdf5); }
    .warn-card.warn     { border-left-color: #d97706; background: linear-gradient(135deg,#fff,#fffbeb); }
    .warn-card.critical { border-left-color: #dc2626; background: linear-gradient(135deg,#fff,#fef2f2); }
    .warn-card .w-head {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 6px;
    }
    .warn-card .w-name {
        font-size: 0.78em; font-weight: 800; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.3px;
    }
    .warn-card .w-icon {
        width: 30px; height: 30px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.92em;
    }
    .warn-card.ok .w-icon       { background: #d1fae5; color: #059669; }
    .warn-card.warn .w-icon     { background: #fef3c7; color: #d97706; }
    .warn-card.critical .w-icon { background: #fee2e2; color: #dc2626; }
    .warn-card.ok .w-value       { color: #059669; }
    .warn-card.warn .w-value     { color: #d97706; }
    .warn-card.critical .w-value { color: #dc2626; }
    .warn-card .w-value {
        font-size: 1.6em; font-weight: 800;
        line-height: 1; margin: 4px 0;
    }
    .warn-card .w-msg {
        font-size: 0.8em; color: #475569; line-height: 1.5; margin-top: 4px;
    }
    .warn-status-pill {
        display: inline-block;
        padding: 2px 10px; border-radius: 12px;
        font-size: 0.72em; font-weight: 800;
    }
    .warn-card.ok       .warn-status-pill { background: #d1fae5; color: #065f46; }
    .warn-card.warn     .warn-status-pill { background: #fef3c7; color: #92400e; }
    .warn-card.critical .warn-status-pill { background: #fee2e2; color: #991b1b; }

    /* --- Multivariate Forecast --- */
    .fc-stats-row {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px; margin-bottom: 14px;
    }
    .fc-stat {
        background: linear-gradient(135deg,#fff,#f0fdfa);
        border: 1px solid #5eead4;
        border-left: 4px solid #0f766e;
        border-radius: 10px; padding: 12px 14px;
    }
    .fc-stat .s-label { font-size: 0.74em; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; }
    .fc-stat .s-value { font-size: 1.6em; font-weight: 800; color: #0f766e; line-height: 1; margin-top: 4px; }
    .fc-stat .s-note  { font-size: 0.74em; color: #64748b; margin-top: 3px; }

    /* --- Coefficient Table --- */
    .coef-table {
        width: 100%; border-collapse: separate; border-spacing: 0;
        font-size: 0.88em;
    }
    .coef-table th {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        color: #fff; padding: 10px 12px; font-weight: 700;
        text-align: right;
    }
    .coef-table th:first-child { text-align: left; border-radius: 8px 0 0 0; }
    .coef-table th:last-child  { border-radius: 0 8px 0 0; }
    .coef-table td {
        padding: 9px 12px; border-bottom: 1px solid #f1f5f9;
        text-align: right; color: #1a3a3c;
    }
    .coef-table td:first-child { text-align: left; font-weight: 700; }
    .coef-table tr:hover td { background: #f0fafa; }
    .coef-bar {
        display: inline-block; width: 80px; height: 8px;
        background: #f1f5f9; border-radius: 4px; margin-right: 6px;
        vertical-align: middle;
    }
    .coef-bar-fill {
        display: block; height: 100%;
        background: linear-gradient(90deg,#14b8a6,#0f766e);
        border-radius: 4px;
    }
    .coef-bar-fill.neg { background: linear-gradient(90deg,#fca5a5,#dc2626); }
    .impact-pill {
        display: inline-block;
        padding: 2px 10px; border-radius: 10px;
        font-weight: 800; font-size: 0.82em;
    }
    .impact-pill.up   { background: #dcfce7; color: #059669; }
    .impact-pill.down { background: #fee2e2; color: #dc2626; }

    /* --- Forecast chart panel --- */
    .fc-chart-panel {
        background: #fff; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        border: 1px solid #e8f0f0;
        padding: 18px 20px; margin-bottom: 16px;
    }
    .fc-panel-title {
        font-size: 0.92em; font-weight: 800; color: #1a3a3c;
        margin-bottom: 12px;
        display: flex; align-items: center; gap: 8px;
    }
    .fc-panel-title i { color: #0f766e; }

    /* --- Scenario Simulator Sliders --- */
    .sim-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        align-items: stretch;
    }
    @media (max-width: 991px) { .sim-layout { grid-template-columns: 1fr; } }
    .sim-controls {
        background: #fff; border-radius: 14px;
        border: 1px solid #e8f0f0;
        padding: 18px 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }
    .sim-controls h4 {
        font-size: 0.95em; font-weight: 800; color: #0f766e;
        margin: 0 0 14px; padding-bottom: 10px;
        border-bottom: 2px dashed #5eead4;
    }
    .sim-row { margin-bottom: 16px; }
    .sim-row:last-child { margin-bottom: 0; }
    .sim-label {
        display: flex; justify-content: space-between;
        align-items: baseline;
        font-size: 0.85em; font-weight: 700; color: #334155;
        margin-bottom: 4px;
    }
    .sim-label .sim-unit { color: #94a3b8; font-size: 0.85em; font-weight: 600; }
    .sim-label .sim-base { color: #64748b; font-size: 0.78em; font-weight: 600; }
    .sim-slider-row {
        display: flex; align-items: center; gap: 10px;
    }
    .sim-slider {
        flex: 1;
        -webkit-appearance: none; appearance: none;
        height: 6px; border-radius: 5px;
        background: #e2e8f0;
        outline: none;
    }
    .sim-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 20px; height: 20px;
        border-radius: 50%;
        background: #0f766e;
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(15,118,110,0.35);
        transition: transform 0.15s;
    }
    .sim-slider::-webkit-slider-thumb:hover { transform: scale(1.2); }
    .sim-slider::-moz-range-thumb {
        width: 20px; height: 20px; border-radius: 50%;
        background: #0f766e; cursor: pointer; border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(15,118,110,0.35);
    }
    .sim-value {
        min-width: 62px; text-align: right;
        font-weight: 800; color: #0f766e; font-size: 0.95em;
    }
    .sim-reset {
        display: inline-block; margin-top: 6px;
        font-size: 0.8em; color: #0f766e; cursor: pointer;
        text-decoration: underline;
    }
    .sim-reset:hover { color: #115e59; }

    /* --- Scenario Output panel --- */
    .sim-output {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        color: #fff;
        border-radius: 14px;
        padding: 22px 24px;
        box-shadow: 0 6px 22px rgba(15,118,110,0.25);
        position: relative; overflow: hidden;
        display: flex; flex-direction: column;
    }
    .sim-output::after {
        content: ''; position: absolute; right: -50px; top: -50px;
        width: 180px; height: 180px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .sim-output h4 {
        font-size: 0.82em; font-weight: 800; opacity: 0.9;
        text-transform: uppercase; letter-spacing: 1px;
        margin: 0 0 8px; position: relative; z-index: 1;
    }
    .sim-output .sim-pred {
        font-size: 3em; font-weight: 800; line-height: 1;
        position: relative; z-index: 1;
    }
    .sim-output .sim-pred small { font-size: 0.35em; opacity: 0.8; font-weight: 600; }
    .sim-output .sim-delta {
        display: inline-block; padding: 6px 14px;
        border-radius: 20px; margin-top: 10px;
        font-weight: 800; font-size: 0.88em;
        background: rgba(255,255,255,0.22);
        position: relative; z-index: 1;
    }
    .sim-output .sim-delta.up   { background: rgba(5,150,105,0.35); }
    .sim-output .sim-delta.down { background: rgba(220,38,38,0.38); }
    .sim-output .sim-base-note {
        font-size: 0.8em; opacity: 0.85;
        margin-top: 10px; position: relative; z-index: 1;
    }
    .sim-waterfall-title {
        font-size: 0.78em; opacity: 0.85;
        margin-top: 14px; margin-bottom: 6px;
        position: relative; z-index: 1;
    }
    .sim-waterfall {
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.82em;
        position: relative; z-index: 1;
    }
    .sim-contrib-row {
        display: flex; justify-content: space-between;
        padding: 3px 0; align-items: center;
    }
    .sim-contrib-row .sc-name { opacity: 0.85; }
    .sim-contrib-row .sc-val {
        font-weight: 700; min-width: 72px; text-align: right;
    }
    .sim-contrib-row .sc-val.pos { color: #bbf7d0; }
    .sim-contrib-row .sc-val.neg { color: #fecaca; }

    /* --- Event ROI --- */
    .roi-layout {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 16px;
    }
    @media (max-width: 991px) { .roi-layout { grid-template-columns: 1fr; } }
    .roi-controls {
        background: #fff; border-radius: 14px;
        border: 1px solid #e8f0f0;
        padding: 18px 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }
    .roi-input-group {
        display: flex; gap: 10px; align-items: center;
        margin-bottom: 14px;
    }
    .roi-input-group label {
        font-weight: 800; color: #1a3a3c; margin: 0;
        white-space: nowrap; font-size: 0.9em;
    }
    .roi-input {
        flex: 1; max-width: 140px;
        padding: 8px 12px; border: 1px solid #e2e8f0;
        border-radius: 8px; font-family: inherit;
        font-size: 1em; font-weight: 700; color: #0f766e;
        background: #f8fafc;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .roi-input:focus {
        outline: none; border-color: #0f766e; background: #fff;
        box-shadow: 0 0 0 3px rgba(15,118,110,0.15);
    }
    .roi-unit { font-size: 0.85em; color: #64748b; font-weight: 600; }
    .roi-kpi-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 10px;
    }
    .roi-kpi {
        background: linear-gradient(135deg,#fff,#f0fdfa);
        border: 1px solid #5eead4;
        border-left: 4px solid #0f766e;
        border-radius: 10px; padding: 10px 14px;
    }
    .roi-kpi.lift {
        border-left-color: #d97706;
        background: linear-gradient(135deg,#fff,#fffbeb);
    }
    .roi-kpi .rk-label { font-size: 0.72em; color: #64748b; font-weight: 700; text-transform: uppercase; }
    .roi-kpi .rk-value { font-size: 1.4em; font-weight: 800; color: #0f766e; line-height: 1; margin-top: 4px; }
    .roi-kpi.lift .rk-value { color: #d97706; }
    .roi-kpi .rk-note  { font-size: 0.72em; color: #64748b; margin-top: 2px; }

    .roi-formula {
        margin-top: 14px; padding: 12px 16px;
        background: #f0fdfa; border: 1px dashed #5eead4;
        border-radius: 10px;
        font-size: 0.82em; color: #115e59;
    }
    .roi-formula b { color: #0f766e; }

    /* --- Forecast feature table --- */
    .ff-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 10px; margin-bottom: 12px;
    }
    .ff-card {
        background: #fff; border-radius: 10px;
        border: 1px solid #e8f0f0; border-top: 3px solid #0f766e;
        padding: 10px 14px;
    }
    .ff-card .ff-month { font-size: 0.78em; color: #64748b; font-weight: 700; text-transform: uppercase; }
    .ff-card .ff-vis   { font-size: 1.6em; font-weight: 800; color: #0f766e; line-height: 1; margin-top: 4px; }
    .ff-card .ff-vis small { font-size: 0.5em; color: #94a3b8; font-weight: 600; }
    .ff-card .ff-feat  { font-size: 0.76em; color: #475569; margin-top: 6px; line-height: 1.5; }
    .ff-card .ff-feat b { color: #1a3a3c; }

    /* --- Province dropdown (ROI) --- */
    .roi-province-row {
        display: flex; gap: 10px; align-items: center;
        margin-bottom: 14px; flex-wrap: wrap;
        padding: 10px 14px;
        background: #f0fdfa;
        border: 1px solid #5eead4;
        border-radius: 10px;
    }
    .roi-province-row label {
        font-weight: 800; color: #0f766e; margin: 0;
        font-size: 0.9em; white-space: nowrap;
    }
    .roi-province-select {
        flex: 1; min-width: 200px;
        padding: 8px 12px; border: 1px solid #5eead4;
        border-radius: 8px; font-family: inherit;
        font-size: 0.92em; font-weight: 700;
        color: #1a3a3c; background: #fff;
        cursor: pointer;
    }
    .roi-province-select:focus {
        outline: none; border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15,118,110,0.15);
    }
    .roi-tag {
        display: inline-block; padding: 4px 12px;
        background: linear-gradient(135deg, #ccfbf1, #f0fdfa);
        color: #0f766e; border: 1px solid #5eead4;
        border-radius: 16px;
        font-weight: 800; font-size: 0.82em;
    }

    /* --- Preset Scenario Buttons --- */
    .preset-row {
        display: flex; flex-wrap: wrap; gap: 8px;
        margin-bottom: 14px;
    }
    .preset-btn {
        background: #fff; border: 1px solid #e2e8f0;
        border-radius: 10px; padding: 8px 14px;
        cursor: pointer;
        font-family: inherit; font-size: 0.85em; font-weight: 700;
        color: #334155;
        display: inline-flex; align-items: center; gap: 6px;
        transition: all 0.2s;
    }
    .preset-btn:hover {
        border-color: #0f766e; color: #0f766e;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(15,118,110,0.12);
    }
    .preset-btn.active {
        background: linear-gradient(135deg, #0f766e, #14b8a6);
        color: #fff; border-color: #0f766e;
        box-shadow: 0 4px 14px rgba(15,118,110,0.25);
    }
    .preset-btn i { opacity: 0.8; }
    .preset-label {
        font-size: 0.78em; color: #64748b; font-weight: 700;
        margin-right: 6px; text-transform: uppercase; letter-spacing: 0.3px;
        align-self: center;
    }

    /* --- Backtesting Panel --- */
    .bt-header-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 10px; margin-bottom: 12px;
    }
    .bt-stat {
        background: linear-gradient(135deg,#fff,#f0fdfa);
        border: 1px solid #5eead4;
        border-left: 4px solid #0f766e;
        border-radius: 10px; padding: 12px 14px;
    }
    .bt-stat .bs-label { font-size: 0.74em; color: #64748b; font-weight: 700; text-transform: uppercase; }
    .bt-stat .bs-value { font-size: 1.5em; font-weight: 800; color: #0f766e; line-height: 1; margin-top: 4px; }
    .bt-stat .bs-note { font-size: 0.74em; color: #64748b; margin-top: 2px; }
    .bt-stat.good { border-left-color: #059669; }
    .bt-stat.good .bs-value { color: #059669; }
    .bt-stat.warn { border-left-color: #d97706; }
    .bt-stat.warn .bs-value { color: #d97706; }
    .bt-stat.bad  { border-left-color: #dc2626; }
    .bt-stat.bad  .bs-value { color: #dc2626; }

    .bt-table {
        width: 100%; border-collapse: separate; border-spacing: 0;
        font-size: 0.88em;
    }
    .bt-table th {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        color: #fff; padding: 10px 12px; font-weight: 700;
        text-align: right;
    }
    .bt-table th:first-child { text-align: left; border-radius: 8px 0 0 0; }
    .bt-table th:last-child  { border-radius: 0 8px 0 0; }
    .bt-table td {
        padding: 9px 12px; border-bottom: 1px solid #f1f5f9;
        text-align: right; color: #1a3a3c;
    }
    .bt-table td:first-child { text-align: left; font-weight: 700; }
    .bt-err-pill {
        display: inline-block;
        padding: 2px 10px; border-radius: 10px;
        font-size: 0.82em; font-weight: 800;
    }
    .bt-err-pill.good { background: #dcfce7; color: #059669; }
    .bt-err-pill.mid  { background: #fef3c7; color: #92400e; }
    .bt-err-pill.bad  { background: #fee2e2; color: #dc2626; }

    /* --- Tier 2 (SARIMAX) Badge & Banner --- */
    .t2-banner {
        display: flex; gap: 12px; align-items: center;
        background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 100%);
        border: 1px solid #fcd34d; border-left: 5px solid #d97706;
        border-radius: 12px; padding: 12px 18px;
        margin-bottom: 14px;
        font-size: 0.88em; color: #78350f;
    }
    .t2-banner i { color: #d97706; font-size: 1.2em; }
    .t2-banner b { color: #92400e; }
    .t2-banner code {
        background: #fff3c4; padding: 2px 8px;
        border-radius: 4px; color: #78350f;
        font-family: 'Menlo', monospace; font-size: 0.9em;
    }
    .t2-timestamp {
        display: inline-block;
        background: linear-gradient(135deg, #ccfbf1, #f0fdfa);
        color: #0f766e; border: 1px solid #5eead4;
        padding: 2px 10px; border-radius: 12px;
        font-size: 0.75em; font-weight: 700;
        margin-left: 8px;
    }

    .t2-anomaly-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 10px;
    }
    .t2-anomaly-card {
        background: #fff; border: 1px solid #e8f0f0;
        border-left: 4px solid #d97706;
        border-radius: 10px; padding: 12px 14px;
    }
    .t2-anomaly-card.spike_up   { border-left-color: #f59e0b; background: linear-gradient(135deg,#fff,#fffbeb); }
    .t2-anomaly-card.spike_down { border-left-color: #dc2626; background: linear-gradient(135deg,#fff,#fef2f2); }
    .t2-anomaly-card.high_level { border-left-color: #0f766e; background: linear-gradient(135deg,#fff,#f0fdfa); }
    .t2-anomaly-card.low_level  { border-left-color: #475569; background: linear-gradient(135deg,#fff,#f8fafc); }
    .t2-anomaly-card .a-month  { font-size: 0.78em; color: #64748b; font-weight: 700; text-transform: uppercase; }
    .t2-anomaly-card .a-value  { font-size: 1.5em; font-weight: 800; color: #1a3a3c; line-height: 1; margin-top: 4px; }
    .t2-anomaly-card .a-value small { font-size: 0.5em; color: #94a3b8; font-weight: 600; }
    .t2-anomaly-card .a-mom    { font-size: 0.78em; color: #64748b; margin-top: 3px; }
    .t2-anomaly-card .a-flags  { margin-top: 6px; }
    .t2-anomaly-card .a-flag   {
        display: inline-block; padding: 2px 8px;
        border-radius: 8px; font-size: 0.7em; font-weight: 800;
        margin-right: 4px;
    }
    .t2-anomaly-card .a-flag.spike_up   { background: #fef3c7; color: #92400e; }
    .t2-anomaly-card .a-flag.spike_down { background: #fee2e2; color: #991b1b; }
    .t2-anomaly-card .a-flag.high_level { background: #ccfbf1; color: #0f766e; }
    .t2-anomaly-card .a-flag.low_level  { background: #e2e8f0; color: #334155; }

    /* --- Chart Insight Box --- */
    .chart-insight {
        background: linear-gradient(135deg, #f0fdfa 0%, #ecfdf5 100%);
        border: 1px solid #5eead4;
        border-left: 4px solid #0f766e;
        border-radius: 10px;
        padding: 14px 18px;
        margin-top: 14px;
        font-size: 0.88em; line-height: 1.75;
        color: #1a3a3c;
    }
    .chart-insight .ci-title {
        font-weight: 800; color: #0f766e;
        font-size: 0.98em; margin-bottom: 4px;
        display: flex; align-items: center; gap: 6px;
    }
    .chart-insight ul { margin: 6px 0 0; padding-left: 22px; }
    .chart-insight li { margin-bottom: 4px; }
    .chart-insight .pill {
        display: inline-block;
        padding: 1px 9px; border-radius: 10px;
        font-weight: 800;
        margin: 0 1px;
        font-size: 0.92em;
    }
    .chart-insight .pill-good { background: #dcfce7; color: #047857; }
    .chart-insight .pill-warn { background: #fef3c7; color: #92400e; }
    .chart-insight .pill-bad  { background: #fee2e2; color: #991b1b; }
    .chart-insight .pill-info { background: #ccfbf1; color: #0f766e; }
    .chart-insight .pill-neutral { background: #f1f5f9; color: #475569; }
    .chart-insight b { color: #0f766e; }

    /* --- Responsive --- */
    @media (max-width: 767px) {
        .fc-header h2 { font-size: 1.2em; }
        .sim-output .sim-pred { font-size: 2em; }
    }
</style>

<div class="fc-wrapper">

    <!-- Header -->
    <div class="fc-header">
        <h2>
            <i class="fas fa-chart-line"></i>
            Tourism Forecast &amp; Scenario Analytics
            <span class="fc-tag">Tier 1 · Multivariate</span>
        </h2>
        <div class="subtitle">คาดการณ์นักท่องเที่ยวล่วงหน้า 3 เดือน · จำลอง Scenario · Early Warning · Event ROI</div>
    </div>

    <!-- ================================================== -->
    <!-- Section 1: Early Warning System                      -->
    <!-- ================================================== -->
    <div class="fc-section-title">
        <i class="fas fa-triangle-exclamation"></i> Early Warning System
        <span class="fc-badge">Rule-based · 6 indicators</span>
    </div>
    <div class="warn-grid">
        <?php foreach ($alerts as $a):
            $pillText = $a['level'] === 'ok' ? 'ปกติ' : ($a['level'] === 'warn' ? 'เฝ้าระวัง' : 'วิกฤต');
        ?>
        <div class="warn-card <?= esc($a['level']) ?>">
            <div class="w-head">
                <div class="w-name"><?= esc($a['name']) ?></div>
                <div class="w-icon"><i class="fas <?= esc($a['icon']) ?>"></i></div>
            </div>
            <div class="w-value"><?= esc($a['value']) ?></div>
            <span class="warn-status-pill"><?= $pillText ?></span>
            <div class="w-msg"><?= esc($a['message']) ?></div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ================================================== -->
    <!-- Section 2: Multivariate Forecast                     -->
    <!-- ================================================== -->
    <div class="fc-section-title">
        <i class="fas fa-chart-area"></i> Multivariate Forecast — 3 เดือนล่วงหน้า
        <span class="fc-badge">OLS Regression · 4 features</span>
    </div>

    <!-- Model stats -->
    <div class="fc-stats-row">
        <div class="fc-stat">
            <div class="s-label">R² (fit quality)</div>
            <div class="s-value"><?= number_format($model['r2'] * 100, 1) ?>%</div>
            <div class="s-note">ตัวแปรอธิบายความแปรปรวน</div>
        </div>
        <div class="fc-stat">
            <div class="s-label">MAPE (avg error)</div>
            <div class="s-value"><?= number_format($model['mape'], 2) ?>%</div>
            <div class="s-note">Mean Abs % Error</div>
        </div>
        <div class="fc-stat">
            <div class="s-label">RMSE</div>
            <div class="s-value"><?= number_format($model['rmse'], 2) ?><small style="font-size:0.45em;color:#94a3b8;"> M</small></div>
            <div class="s-note">Root Mean Sq Error</div>
        </div>
        <div class="fc-stat">
            <div class="s-label">ข้อมูลที่ใช้ Fit</div>
            <div class="s-value">13<small style="font-size:0.45em;color:#94a3b8;"> เดือน</small></div>
            <div class="s-note">ก.พ.68 - ก.พ.69</div>
        </div>
    </div>

    <!-- Coefficient table -->
    <div class="fc-chart-panel">
        <div class="fc-panel-title"><i class="fas fa-sliders"></i> ค่าสัมประสิทธิ์ (Coefficient) — ปัจจัยไหนขับเคลื่อนนักท่องเที่ยว</div>
        <table class="coef-table">
            <thead>
                <tr>
                    <th style="width:26%;">Feature</th>
                    <th>ค่าเฉลี่ย</th>
                    <th>Coefficient (β)</th>
                    <th>Impact ต่อ 1 unit</th>
                    <th style="width:20%;">ทิศทาง</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $feature_means = [
                    array_sum(array_slice($hist_visitors, 0, 0)) + 0, // placeholder
                ];
                // compute means on-the-fly
                $cci_mean = array_sum(array_slice([52.0,50.8,48.8,48.9,46.7,48.4,47.9,49.4,50.9,51.8,51.8,52.6,53.0], 0, 13)) / 13;
                $gt_mean  = array_sum([23.45,24.32,30.75,23.60,22.28,26.35,24.48,22.60,30.40,28.20,33.10,24.00,21.90]) / 13;
                $or_mean  = array_sum([77.62,74.99,74.69,68.30,66.09,68.16,68.69,66.73,70.94,72.78,78.09,77.52,77.24]) / 13;
                $oil_mean = array_sum([36.12,36.50,37.20,36.95,36.40,36.75,37.10,36.80,36.50,36.20,35.90,35.75,36.10]) / 13;
                $means = [$cci_mean, $gt_mean, $or_mean, $oil_mean];
                $maxAbsCoef = 0;
                foreach ($model['coefs'] as $c) { if (abs($c) > $maxAbsCoef) $maxAbsCoef = abs($c); }
                foreach ($feature_names as $i => $fname):
                    $coef = $model['coefs'][$i];
                    $barPct = $maxAbsCoef > 0 ? abs($coef) / $maxAbsCoef * 100 : 0;
                    $neg = $coef < 0;
            ?>
                <tr>
                    <td><?= esc($fname) ?> <span style="color:#94a3b8;font-size:0.78em;">(<?= esc($feature_units[$i]) ?>)</span></td>
                    <td><?= number_format($means[$i], 2) ?></td>
                    <td style="color:<?= $neg ? '#dc2626' : '#059669' ?>;font-weight:800;">
                        <?= ($neg ? '' : '+') . number_format($coef, 4) ?>
                    </td>
                    <td>
                        <span class="impact-pill <?= $neg ? 'down' : 'up' ?>">
                            <?= ($neg ? '▼ ' : '▲ +') . number_format(abs($coef), 3) ?>M
                        </span>
                        <span style="color:#94a3b8;font-size:0.82em;"> ต่อ +1 <?= esc($feature_units[$i]) ?></span>
                    </td>
                    <td>
                        <span class="coef-bar">
                            <span class="coef-bar-fill <?= $neg ? 'neg' : '' ?>" style="width:<?= $barPct ?>%;"></span>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
                <tr style="background:#f0fdfa;">
                    <td colspan="2" style="font-weight:800;color:#0f766e;">Intercept (β₀)</td>
                    <td colspan="3" style="font-weight:800;color:#0f766e;"><?= number_format($model['intercept'], 3) ?>M</td>
                </tr>
            </tbody>
        </table>
        <div style="font-size:0.82em;color:#64748b;margin-top:10px;line-height:1.6;">
            <i class="fas fa-lightbulb" style="color:#0f766e;"></i>
            <b>วิธีตีความ:</b> ค่า β บวก = ปัจจัยนั้นเพิ่มขึ้น → นักท่องเที่ยวเพิ่ม · β ลบ = ปัจจัยเพิ่ม → นักท่องเที่ยวลด
        </div>
    </div>

    <!-- Forecast Chart + Feature Projections -->
    <div class="fc-chart-panel">
        <div class="fc-panel-title"><i class="fas fa-chart-line"></i> การคาดการณ์ (History + Forecast 3 เดือน + CI 95%)</div>
        <div id="chartForecast" style="height: 360px;"></div>

        <?php
            $fc_start = $forecast_visitors[0];
            $fc_end   = end($forecast_visitors);
            $fc_diff  = $fc_end - $fc_start;
            $fc_pct   = $fc_start > 0 ? ($fc_diff / $fc_start * 100) : 0;
            $fc_last_hist = end($hist_visitors);
            $fc_vs_hist = $fc_start - $fc_last_hist;
            $fc_trend_text = $fc_pct > 1.5 ? 'ขาขึ้น' : ($fc_pct < -1.5 ? 'ขาลง' : 'ทรงตัว');
            $fc_trend_pill = $fc_pct > 1.5 ? 'pill-good' : ($fc_pct < -1.5 ? 'pill-bad' : 'pill-neutral');
            $fc_peak_idx = array_search(max($forecast_visitors), $forecast_visitors);
            $fc_low_idx  = array_search(min($forecast_visitors), $forecast_visitors);
            // หา top driver = feature ที่มี |coef × mean| สูงสุด
            $drivers = [];
            foreach ($model['coefs'] as $i => $coef) {
                $drivers[] = ['name' => $feature_names[$i], 'impact' => abs($coef * $baseline[$feature_keys[$i]]), 'coef' => $coef];
            }
            usort($drivers, function($a,$b){ return $b['impact'] <=> $a['impact']; });
            $top_driver = $drivers[0];
            $avg_ci_width = array_sum(array_map(function($u,$l){ return $u - $l; }, $forecast_upper, $forecast_lower)) / count($forecast_upper);
            $r2_pct = $model['r2'] * 100;
            $r2_quality = $r2_pct >= 70 ? 'ดีมาก' : ($r2_pct >= 50 ? 'พอใช้' : 'ค่อนข้างต่ำ — ข้อมูลมีน้อย');
            $r2_pill = $r2_pct >= 70 ? 'pill-good' : ($r2_pct >= 50 ? 'pill-warn' : 'pill-bad');
        ?>
        <div class="chart-insight">
            <div class="ci-title"><i class="fas fa-clipboard-check"></i> สรุปผลการพยากรณ์ 3 เดือน</div>
            <ul>
                <li>แนวโน้มจาก <?= esc($forecast_labels[0]) ?> ไป <?= esc(end($forecast_labels)) ?>:
                    <span class="pill <?= $fc_trend_pill ?>"><?= $fc_trend_text ?></span>
                    เปลี่ยน <b><?= ($fc_pct >= 0 ? '+' : '') . number_format($fc_pct, 1) ?>%</b>
                    (<?= number_format($fc_start, 2) ?>M → <?= number_format($fc_end, 2) ?>M)
                </li>
                <li>เทียบเดือนล่าสุดจริง (<?= esc(end($hist_labels)) ?> = <?= number_format($fc_last_hist, 2) ?>M) → พยากรณ์
                    <?php if ($fc_vs_hist >= 0): ?>
                        <span class="pill pill-good">สูงขึ้น +<?= number_format($fc_vs_hist, 2) ?>M</span>
                    <?php else: ?>
                        <span class="pill pill-bad">ลดลง <?= number_format($fc_vs_hist, 2) ?>M</span>
                    <?php endif; ?>
                </li>
                <li>เดือนสูงสุด: <b><?= esc($forecast_labels[$fc_peak_idx]) ?></b> (<?= number_format($forecast_visitors[$fc_peak_idx], 2) ?>M)
                    · เดือนต่ำสุด: <b><?= esc($forecast_labels[$fc_low_idx]) ?></b> (<?= number_format($forecast_visitors[$fc_low_idx], 2) ?>M)
                </li>
                <li>ปัจจัยที่ขับเคลื่อนมากสุดตอนนี้: <b><?= esc($top_driver['name']) ?></b>
                    (<?= $top_driver['coef'] > 0 ? 'ผลบวก' : 'ผลลบ' ?>)</li>
                <li>ความเชื่อมั่นโมเดล (R²):
                    <span class="pill <?= $r2_pill ?>"><?= number_format($r2_pct, 1) ?>%</span>
                    — <?= $r2_quality ?>
                    · ช่วงไม่แน่นอน ±<?= number_format($avg_ci_width / 2, 2) ?>M (CI 95%)
                </li>
            </ul>
        </div>
    </div>

    <div class="fc-chart-panel">
        <div class="fc-panel-title"><i class="fas fa-forward"></i> รายละเอียด Forecast — features ที่ใช้พยากรณ์</div>
        <div class="ff-grid">
            <?php foreach ($forecast_labels as $idx => $lbl): $ff = $forecast_features[$idx]; ?>
            <div class="ff-card">
                <div class="ff-month"><?= esc($lbl) ?></div>
                <div class="ff-vis"><?= number_format($forecast_visitors[$idx], 2) ?><small>M คน</small></div>
                <div style="font-size:0.74em;color:#94a3b8;margin-top:2px;">
                    CI 95%: <?= number_format($forecast_lower[$idx], 2) ?>–<?= number_format($forecast_upper[$idx], 2) ?>M
                </div>
                <div class="ff-feat">
                    CCI <b><?= $ff['cci'] ?></b> · GT <b><?= $ff['gt'] ?></b><br>
                    OR <b><?= $ff['or'] ?>%</b> · Oil <b><?= $ff['oil'] ?></b>฿
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="font-size:0.8em;color:#64748b;">
            <i class="fas fa-circle-info" style="color:#0f766e;"></i>
            Features ถูก project ด้วย Linear Trend 13 เดือนย้อนหลัง แล้วนำไปใส่ในสมการ OLS เพื่อพยากรณ์นักท่องเที่ยว
        </div>
    </div>

    <!-- [Tier 3] Backtesting Panel -->
    <div class="fc-section-title">
        <i class="fas fa-check-to-slot"></i> Backtesting — Model แม่นแค่ไหน บน 3 เดือนล่าสุด
        <span class="fc-badge">Rolling-origin validation</span>
    </div>
    <?php
        $bt_mape_cls = $backtest_mape < 5 ? 'good' : ($backtest_mape < 10 ? 'warn' : 'bad');
        $bt_maxe_cls = $backtest_max_err < 5 ? 'good' : ($backtest_max_err < 10 ? 'warn' : 'bad');
    ?>
    <div class="bt-header-row">
        <div class="bt-stat <?= $bt_mape_cls ?>">
            <div class="bs-label">MAPE (เฉลี่ย)</div>
            <div class="bs-value"><?= number_format($backtest_mape, 2) ?>%</div>
            <div class="bs-note"><?= $backtest_mape < 5 ? 'ยอดเยี่ยม (<5%)' : ($backtest_mape < 10 ? 'พอใช้ได้ (5-10%)' : 'ควรปรับโมเดล (>10%)') ?></div>
        </div>
        <div class="bt-stat <?= $bt_maxe_cls ?>">
            <div class="bs-label">Max Error</div>
            <div class="bs-value"><?= number_format($backtest_max_err, 2) ?>%</div>
            <div class="bs-note">ความคลาดเคลื่อนสูงสุด</div>
        </div>
        <div class="bt-stat">
            <div class="bs-label">เดือนที่ทดสอบ</div>
            <div class="bs-value"><?= count($backtest) ?></div>
            <div class="bs-note">เดือนล่าสุด (holdout)</div>
        </div>
        <div class="bt-stat">
            <div class="bs-label">Accuracy</div>
            <div class="bs-value"><?= number_format(100 - $backtest_mape, 1) ?>%</div>
            <div class="bs-note">เฉลี่ย (100 − MAPE)</div>
        </div>
    </div>

    <div class="fc-chart-panel">
        <div class="fc-panel-title"><i class="fas fa-table"></i> ผลการทดสอบรายเดือน — Actual vs Predicted</div>
        <table class="bt-table">
            <thead>
                <tr>
                    <th>เดือน</th>
                    <th>ใช้ train (เดือน)</th>
                    <th>Actual (M)</th>
                    <th>Predicted (M)</th>
                    <th>Error</th>
                    <th style="width:18%;">แม่นแค่ไหน</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($backtest as $bt):
                    $cls = $bt['error_pct'] < 5 ? 'good' : ($bt['error_pct'] < 10 ? 'mid' : 'bad');
                ?>
                <tr>
                    <td><?= esc($bt['month']) ?></td>
                    <td><?= $bt['train_size'] ?></td>
                    <td><strong><?= number_format($bt['actual'], 2) ?></strong></td>
                    <td><?= number_format($bt['predicted'], 2) ?></td>
                    <td>
                        <span class="bt-err-pill <?= $cls ?>"><?= number_format($bt['error_pct'], 2) ?>%</span>
                    </td>
                    <td><?= $bt['error_pct'] < 5 ? '✅ ดี' : ($bt['error_pct'] < 10 ? '🟡 พอใช้' : '🔴 คลาด') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="font-size:0.82em;color:#64748b;margin-top:10px;line-height:1.6;">
            <i class="fas fa-lightbulb" style="color:#0f766e;"></i>
            <b>วิธีทดสอบ:</b> ใช้ข้อมูล n เดือนแรกเทรน แล้วพยากรณ์เดือนที่ n+1 → เปรียบเทียบกับค่าจริง
            (simulate การพยากรณ์อนาคต โดยไม่ให้โมเดลเห็นคำตอบ)
        </div>

        <?php
            $bt_accuracy = 100 - $backtest_mape;
            $bt_quality = $backtest_mape < 5 ? 'ใช้พยากรณ์จริงได้' : ($backtest_mape < 10 ? 'ใช้ได้แต่ควรดูร่วมกับปัจจัยอื่น' : 'ความแม่นต่ำ — ควรปรับโมเดลหรือเพิ่มข้อมูล');
            $bt_quality_pill = $backtest_mape < 5 ? 'pill-good' : ($backtest_mape < 10 ? 'pill-warn' : 'pill-bad');
            $bt_errors = array_column($backtest, 'error_pct');
            $bt_best_idx = array_search(min($bt_errors), $bt_errors);
            $bt_worst_idx = array_search(max($bt_errors), $bt_errors);
            $bt_direction_hint = '';
            // ดูว่า predicted มักสูง/ต่ำกว่า actual
            $over = 0; $under = 0;
            foreach ($backtest as $bt) {
                if ($bt['predicted'] > $bt['actual']) $over++;
                elseif ($bt['predicted'] < $bt['actual']) $under++;
            }
            if ($over > $under) $bt_direction_hint = 'โมเดลมักพยากรณ์ <b>สูงกว่าจริง</b> (overestimate) ~' . $over . '/' . count($backtest) . ' เดือน';
            elseif ($under > $over) $bt_direction_hint = 'โมเดลมักพยากรณ์ <b>ต่ำกว่าจริง</b> (underestimate) ~' . $under . '/' . count($backtest) . ' เดือน';
            else $bt_direction_hint = 'โมเดลสมดุล ไม่เอียง (unbiased)';
        ?>
        <div class="chart-insight">
            <div class="ci-title"><i class="fas fa-clipboard-check"></i> สรุปผล Backtesting</div>
            <ul>
                <li>ความแม่นเฉลี่ย:
                    <span class="pill <?= $bt_quality_pill ?>"><?= number_format($bt_accuracy, 1) ?>%</span>
                    (MAPE <?= number_format($backtest_mape, 2) ?>%) — <?= $bt_quality ?>
                </li>
                <li>เดือนแม่นสุด: <b><?= esc($backtest[$bt_best_idx]['month']) ?></b>
                    (error <?= number_format($backtest[$bt_best_idx]['error_pct'], 2) ?>%)
                    · เดือนคลาดสุด: <b><?= esc($backtest[$bt_worst_idx]['month']) ?></b>
                    (error <?= number_format($backtest[$bt_worst_idx]['error_pct'], 2) ?>%)
                </li>
                <li>Bias ของโมเดล: <?= $bt_direction_hint ?></li>
                <li>
                    <?php if ($backtest_mape < 5): ?>
                        ✅ โมเดลผ่านเกณฑ์ — ใช้พยากรณ์ 3 เดือนข้างหน้าได้อย่างมั่นใจ
                    <?php elseif ($backtest_mape < 10): ?>
                        🟡 โมเดลพอใช้ได้ — ควรอ่าน forecast พร้อมดูปัจจัยภายนอก (CCI/GT/Oil) ประกอบ
                    <?php else: ?>
                        🔴 ความแม่นยังไม่สูง — ควรเพิ่มข้อมูล หรือพิจารณาใช้ Tier 2 (SARIMAX) ประกอบ
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>

    <!-- ================================================== -->
    <!-- [Tier 2] Pre-computed Advanced Forecast (Python)    -->
    <!-- ================================================== -->
    <div class="fc-section-title">
        <i class="fas fa-brain"></i> Advanced Forecast (Tier 2) — SARIMAX + Holt-Winters + Anomaly
        <span class="fc-badge">Python · statsmodels</span>
        <?php if (!empty($tier2_generated_at)): ?>
            <span class="t2-timestamp"><i class="fas fa-clock"></i> generated <?= esc($tier2_generated_at) ?></span>
        <?php endif; ?>
    </div>

    <?php if ($tier2_status !== 'ok' || empty($tier2)): ?>
    <div class="t2-banner">
        <i class="fas fa-triangle-exclamation"></i>
        <div>
            <b>ยังไม่มีข้อมูล Tier 2</b> — ให้รัน Python pipeline ก่อน:<br>
            <code>cd analytics &amp;&amp; source venv/bin/activate &amp;&amp; python forecast_sarima.py</code>
            &nbsp;&nbsp;(output: <code>public/data/forecast_tier2.json</code>)
        </div>
    </div>
    <?php else: ?>

    <!-- Stats row -->
    <div class="fc-stats-row">
        <div class="fc-stat">
            <div class="s-label">SARIMAX AIC</div>
            <div class="s-value"><?= number_format($tier2['sarimax']['aic'] ?? 0, 1) ?></div>
            <div class="s-note">ต่ำ = ดี (ARIMA+exog)</div>
        </div>
        <div class="fc-stat">
            <div class="s-label">Holt Residual σ</div>
            <div class="s-value"><?= number_format($tier2['holt']['resid_std'] ?? 0, 3) ?></div>
            <div class="s-note">SD ของ residuals</div>
        </div>
        <div class="fc-stat">
            <div class="s-label">Forecast Horizon</div>
            <div class="s-value"><?= count($tier2['data_meta']['future_labels']) ?><small style="font-size:0.45em;color:#94a3b8;"> เดือน</small></div>
            <div class="s-note">ล่วงหน้า (vs Tier 1 = 3)</div>
        </div>
        <div class="fc-stat">
            <div class="s-label">Anomalies</div>
            <div class="s-value"><?= count($tier2['anomaly']['anomalies'] ?? []) ?></div>
            <div class="s-note">จุดผิดปกติในอดีต</div>
        </div>
    </div>

    <!-- Tier 2 forecast chart -->
    <div class="fc-chart-panel">
        <div class="fc-panel-title">
            <i class="fas fa-chart-line"></i> Forecast Comparison — SARIMAX vs Holt-Winters (6 เดือนล่วงหน้า)
        </div>
        <div id="chartTier2Forecast" style="height: 380px;"></div>
        <div style="font-size:0.82em;color:#64748b;margin-top:10px;line-height:1.6;">
            <i class="fas fa-lightbulb" style="color:#0f766e;"></i>
            <b>เปรียบเทียบ 2 วิธี:</b>
            <b style="color:#0f766e;">SARIMAX</b> = ARIMA(1,1,1) + exogenous (CCI/GT/OR/Oil) · ใช้ปัจจัยภายนอกช่วยพยากรณ์ ·
            <b style="color:#f59e0b;">Holt-Winters</b> = damped trend univariate · อาศัย pattern ของ visitors เอง
        </div>

        <?php
            $sx_fc = $tier2['sarimax']['forecast'] ?? [];
            $ht_fc = $tier2['holt']['forecast'] ?? [];
            if (!empty($sx_fc) && !empty($ht_fc)):
                $sx_avg = array_sum($sx_fc) / count($sx_fc);
                $ht_avg = array_sum($ht_fc) / count($ht_fc);
                $diff_avg = $sx_avg - $ht_avg;
                $agreement_pct = $ht_avg > 0 ? abs($diff_avg) / $ht_avg * 100 : 0;
                $sx_trend = end($sx_fc) - $sx_fc[0];
                $ht_trend = end($ht_fc) - $ht_fc[0];
                $sx_dir = $sx_trend > 0.1 ? 'ขาขึ้น' : ($sx_trend < -0.1 ? 'ขาลง' : 'ทรงตัว');
                $ht_dir = $ht_trend > 0.1 ? 'ขาขึ้น' : ($ht_trend < -0.1 ? 'ขาลง' : 'ทรงตัว');
                $same_dir = ($sx_dir === $ht_dir);
                $lo = min(array_merge([$sx_avg], [$ht_avg])) - 1;
                $hi = max(array_merge([$sx_avg], [$ht_avg])) + 1;
                $sx_low_month = array_search(min($sx_fc), $sx_fc);
                $sx_high_month = array_search(max($sx_fc), $sx_fc);
                $future_labels = $tier2['data_meta']['future_labels'] ?? [];
        ?>
        <div class="chart-insight">
            <div class="ci-title"><i class="fas fa-clipboard-check"></i> สรุปผล Tier 2 Forecast (6 เดือน)</div>
            <ul>
                <li>SARIMAX (ใช้ปัจจัยภายนอก): เฉลี่ย <b><?= number_format($sx_avg, 2) ?>M</b>/เดือน
                    · ทิศทาง <span class="pill <?= $sx_trend > 0.1 ? 'pill-good' : ($sx_trend < -0.1 ? 'pill-bad' : 'pill-neutral') ?>"><?= $sx_dir ?></span>
                </li>
                <li>Holt-Winters (univariate): เฉลี่ย <b><?= number_format($ht_avg, 2) ?>M</b>/เดือน
                    · ทิศทาง <span class="pill <?= $ht_trend > 0.1 ? 'pill-good' : ($ht_trend < -0.1 ? 'pill-bad' : 'pill-neutral') ?>"><?= $ht_dir ?></span>
                </li>
                <li>ทั้ง 2 วิธี
                    <?php if ($same_dir && $agreement_pct < 5): ?>
                        <span class="pill pill-good">✓ เห็นตรงกัน</span> ทั้งทิศทางและค่า — ความเชื่อมั่นสูง
                    <?php elseif ($same_dir): ?>
                        <span class="pill pill-warn">⚠ ทิศตรงกันแต่ค่าต่างกัน <?= number_format(abs($diff_avg), 2) ?>M (<?= number_format($agreement_pct, 1) ?>%)</span>
                    <?php else: ?>
                        <span class="pill pill-bad">⚠ ทิศไม่ตรงกัน</span> — ควรระวัง · SARIMAX <?= $sx_dir ?> แต่ Holt <?= $ht_dir ?>
                    <?php endif; ?>
                </li>
                <li>ช่วงคาดการณ์รวม: <b><?= number_format(min(array_merge($sx_fc, $ht_fc)), 2) ?>M</b>
                    ถึง <b><?= number_format(max(array_merge($sx_fc, $ht_fc)), 2) ?>M</b>
                </li>
                <?php if (!empty($future_labels)): ?>
                <li>SARIMAX จุดต่ำสุด: <b><?= esc($future_labels[$sx_low_month] ?? '?') ?></b> (<?= number_format(min($sx_fc), 2) ?>M)
                    · สูงสุด: <b><?= esc($future_labels[$sx_high_month] ?? '?') ?></b> (<?= number_format(max($sx_fc), 2) ?>M)
                </li>
                <?php endif; ?>
                <li>📌 <b>คำแนะนำ:</b>
                    <?php if ($same_dir && $agreement_pct < 5): ?>
                        ใช้ค่าเฉลี่ยของ 2 วิธีเป็น point estimate ได้
                    <?php elseif ($same_dir): ?>
                        ใช้ช่วง <?= number_format(min($sx_avg, $ht_avg), 2) ?>–<?= number_format(max($sx_avg, $ht_avg), 2) ?>M เป็น range คาดการณ์
                    <?php else: ?>
                        ควรรอข้อมูลเดือนถัดไปก่อนตัดสินใจ · ทิศทางยังไม่ชัดเจน
                    <?php endif; ?>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </div>

    <!-- Decomposition chart -->
    <div class="fc-chart-panel">
        <div class="fc-panel-title">
            <i class="fas fa-layer-group"></i> Trend Decomposition — แยก pattern ของข้อมูล
        </div>
        <div id="chartTier2Decomp" style="height: 340px;"></div>
        <div style="font-size:0.82em;color:#64748b;margin-top:10px;line-height:1.6;">
            <i class="fas fa-lightbulb" style="color:#0f766e;"></i>
            <b>Trend</b> = แนวโน้มระยะยาว (moving avg) · <b>Residual</b> = ส่วนที่อธิบายไม่ได้ (shocks/anomalies)
        </div>

        <?php
            $dec = $tier2['decomposition'] ?? null;
            if ($dec && !empty($dec['residual'])):
                $decomp_labels = $dec['labels'] ?? [];
                $trend_start = $dec['trend'][0] ?? 0;
                $trend_end = end($dec['trend']) ?: 0;
                $trend_diff = $trend_end - $trend_start;
                $trend_pct = $trend_start > 0 ? $trend_diff / $trend_start * 100 : 0;
                $trend_dir = $trend_pct > 3 ? 'ขาขึ้น' : ($trend_pct < -3 ? 'ขาลง' : 'ทรงตัว');
                $trend_pill = $trend_pct > 3 ? 'pill-good' : ($trend_pct < -3 ? 'pill-bad' : 'pill-neutral');

                $abs_res = array_map('abs', $dec['residual']);
                $max_res_idx = array_search(max($abs_res), $abs_res);
                $max_res_val = $dec['residual'][$max_res_idx];
                $max_res_sign = $max_res_val > 0 ? 'สูงกว่า' : 'ต่ำกว่า';
                $res_std = 0;
                $n_res = count($dec['residual']);
                $res_mean = array_sum($dec['residual']) / max(1, $n_res);
                foreach ($dec['residual'] as $r) $res_std += ($r - $res_mean) ** 2;
                $res_std = sqrt($res_std / max(1, $n_res - 1));
                $res_stability = $res_std < 0.5 ? 'นิ่ง' : ($res_std < 1.2 ? 'ผันผวนกลาง' : 'ผันผวนสูง');
                $res_pill = $res_std < 0.5 ? 'pill-good' : ($res_std < 1.2 ? 'pill-warn' : 'pill-bad');
        ?>
        <div class="chart-insight">
            <div class="ci-title"><i class="fas fa-clipboard-check"></i> สรุปผล Trend Decomposition</div>
            <ul>
                <li>แนวโน้ม 13 เดือน:
                    <span class="pill <?= $trend_pill ?>"><?= $trend_dir ?></span>
                    เปลี่ยน <b><?= ($trend_pct >= 0 ? '+' : '') . number_format($trend_pct, 1) ?>%</b>
                    (<?= number_format($trend_start, 2) ?>M → <?= number_format($trend_end, 2) ?>M)
                </li>
                <li>Shock ที่ใหญ่ที่สุด: <b><?= esc($decomp_labels[$max_res_idx] ?? '?') ?></b>
                    — <?= $max_res_sign ?> trend <b><?= number_format(abs($max_res_val), 2) ?>M</b>
                    <?= $max_res_val > 0 ? '(มี boost ผิดปกติ)' : '(ลดลงผิดปกติ)' ?>
                </li>
                <li>ความผันผวน (residual σ):
                    <span class="pill <?= $res_pill ?>"><?= number_format($res_std, 2) ?>M</span>
                    — <?= $res_stability ?>
                </li>
                <li>📌 <b>การตีความ:</b>
                    <?php if ($trend_pct > 3 && $res_std < 1): ?>
                        ข้อมูลกำลังเติบโตต่อเนื่อง · shocks น้อย → พยากรณ์ได้แม่นยำ
                    <?php elseif ($trend_pct > 3): ?>
                        เติบโตแต่มี shocks บ่อย · ควรจับตาปัจจัยภายนอก
                    <?php elseif (abs($trend_pct) <= 3 && $res_std < 1): ?>
                        ข้อมูลนิ่ง เสถียร · เหมาะกับการวางแผนระยะกลาง
                    <?php else: ?>
                        ผันผวนสูง · ควรใช้ช่วงคาดการณ์ (range) แทน point estimate
                    <?php endif; ?>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </div>

    <!-- Anomaly cards -->
    <?php if (!empty($tier2['anomaly']['anomalies'])): ?>
    <div class="fc-chart-panel">
        <div class="fc-panel-title">
            <i class="fas fa-magnifying-glass-chart"></i> Anomaly Detection — เดือนที่ผิดปกติ (IQR + z-score)
        </div>
        <div class="t2-anomaly-grid">
            <?php foreach ($tier2['anomaly']['anomalies'] as $anom):
                $primary_flag = $anom['flags'][0] ?? 'neutral';
                $flag_label = [
                    'spike_up'   => '📈 พุ่งผิดปกติ',
                    'spike_down' => '📉 ดิ่งผิดปกติ',
                    'high_level' => '🔝 สูงกว่าปกติ',
                    'low_level'  => '⬇ ต่ำกว่าปกติ',
                ];
            ?>
            <div class="t2-anomaly-card <?= esc($primary_flag) ?>">
                <div class="a-month"><?= esc($anom['month']) ?></div>
                <div class="a-value"><?= number_format($anom['value'], 2) ?><small> M</small></div>
                <?php if ($anom['mom_pct'] !== null): ?>
                    <div class="a-mom">MoM: <?= ($anom['mom_pct'] >= 0 ? '+' : '') . number_format($anom['mom_pct'], 1) ?>%</div>
                <?php endif; ?>
                <div class="a-flags">
                    <?php foreach ($anom['flags'] as $f): ?>
                        <span class="a-flag <?= esc($f) ?>"><?= esc($flag_label[$f] ?? $f) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="font-size:0.82em;color:#64748b;margin-top:12px;line-height:1.6;">
            <i class="fas fa-info-circle" style="color:#0f766e;"></i>
            <b>เกณฑ์:</b> IQR (สูงกว่า Q3+1.5·IQR หรือต่ำกว่า Q1−1.5·IQR) + z-score ของ MoM (|z| > 2) ·
            Median: <b><?= $tier2['anomaly']['median'] ?>M</b> · σ: <b><?= $tier2['anomaly']['std'] ?>M</b>
        </div>
    </div>
    <?php endif; ?>

    <?php endif; // end tier2 ok ?>

    <!-- ================================================== -->
    <!-- Section 3: Scenario Simulator                        -->
    <!-- ================================================== -->
    <div class="fc-section-title">
        <i class="fas fa-flask-vial"></i> Scenario Simulator — จำลอง "ถ้า…จะเป็นยังไง"
        <span class="fc-badge">Interactive · Real-time</span>
    </div>

    <div class="sim-layout">
        <div class="sim-controls">
            <h4><i class="fas fa-sliders"></i> ปรับค่าปัจจัยเพื่อจำลอง</h4>

            <!-- [Tier 3] Preset Scenario Buttons -->
            <div class="preset-row">
                <span class="preset-label">Preset:</span>
                <?php foreach ($presets as $p): ?>
                <button type="button" class="preset-btn <?= $p['key'] === 'normal' ? 'active' : '' ?>"
                        data-preset="<?= esc($p['key']) ?>"
                        title="<?= esc($p['desc']) ?>">
                    <i class="fas <?= esc($p['icon']) ?>"></i> <?= esc($p['name']) ?>
                </button>
                <?php endforeach; ?>
            </div>

            <?php foreach ($feature_keys as $i => $fk):
                $range = $slider_ranges[$fk];
                $base = $baseline[$fk];
            ?>
            <div class="sim-row">
                <div class="sim-label">
                    <span><?= esc($feature_names[$i]) ?> <span class="sim-unit">(<?= esc($feature_units[$i]) ?>)</span></span>
                    <span class="sim-base">baseline: <?= number_format($base, 2) ?></span>
                </div>
                <div class="sim-slider-row">
                    <input type="range" class="sim-slider" id="slider_<?= $fk ?>"
                           min="<?= $range['min'] ?>" max="<?= $range['max'] ?>"
                           step="<?= $range['step'] ?>" value="<?= $base ?>"
                           data-key="<?= $fk ?>" data-base="<?= $base ?>">
                    <div class="sim-value" id="val_<?= $fk ?>"><?= number_format($base, 2) ?></div>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="sim-reset" onclick="resetSimulator()"><i class="fas fa-rotate-left"></i> รีเซ็ตค่าเป็น baseline</div>
        </div>

        <div class="sim-output">
            <h4><i class="fas fa-bullseye"></i> ผลการคาดการณ์</h4>
            <div class="sim-pred"><span id="sim-pred-val"><?= number_format($baseline_pred, 2) ?></span><small> M คน</small></div>
            <span class="sim-delta" id="sim-delta">± 0.00 M vs baseline</span>
            <div class="sim-base-note">
                Baseline (<?= $baseline_month ?>): <b><?= number_format($baseline_pred, 2) ?>M</b>
            </div>

            <div class="sim-waterfall-title"><i class="fas fa-layer-group"></i> การมีส่วนร่วมของแต่ละปัจจัย (Δ vs baseline):</div>
            <div class="sim-waterfall" id="sim-waterfall">
                <?php foreach ($feature_keys as $i => $fk): ?>
                <div class="sim-contrib-row" data-key="<?= $fk ?>">
                    <span class="sc-name"><?= esc($feature_names[$i]) ?></span>
                    <span class="sc-val" id="contrib_<?= $fk ?>">0.000 M</span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- ================================================== -->
    <!-- Section 4: Event ROI Calculator (ภาพรวม + 77 จว.)   -->
    <!-- ================================================== -->
    <div class="fc-section-title">
        <i class="fas fa-calculator"></i> Event ROI Calculator — คำนวณผลตอบแทนจากการจัดกิจกรรม
        <span class="fc-badge">77 จังหวัด · 2568</span>
    </div>

    <!-- Province dropdown -->
    <div class="roi-province-row">
        <label for="roi-province"><i class="fas fa-map-marker-alt"></i> เลือกพื้นที่:</label>
        <select id="roi-province" class="roi-province-select">
            <option value="__ALL__">📊 ภาพรวมประเทศ (77 จังหวัด)</option>
            <option disabled>──── รายจังหวัด (ก-ฮ) ────</option>
            <?php
                $prov_keys = array_keys($prov_roi_dataset);
                $prov_keys = array_filter($prov_keys, function($k){ return $k !== '__ALL__'; });
                usort($prov_keys, 'strcoll');
                foreach ($prov_keys as $pk):
            ?>
                <option value="<?= esc($pk) ?>"><?= esc($pk) ?></option>
            <?php endforeach; ?>
        </select>
        <span class="roi-tag" id="roi-prov-tag"><i class="fas fa-eye"></i> ภาพรวมประเทศ</span>
    </div>

    <div class="roi-layout">
        <div class="roi-controls">
            <div class="roi-input-group">
                <label for="roi-events"><i class="fas fa-calendar-check" style="color:#0f766e;"></i> จำนวนกิจกรรม / เดือน:</label>
                <input type="number" class="roi-input" id="roi-events" value="0" min="0" max="500" step="1">
                <span class="roi-unit">events</span>
                <span class="roi-unit" id="roi-avg-hint" style="margin-left:auto;">avg: — ev/เดือน</span>
            </div>

            <div class="roi-kpi-grid">
                <div class="roi-kpi">
                    <div class="rk-label">คาดการณ์นักท่องเที่ยว</div>
                    <div class="rk-value" id="roi-pred-vis">—</div>
                    <div class="rk-note">M คน / เดือน</div>
                </div>
                <div class="roi-kpi lift">
                    <div class="rk-label">Marginal Lift</div>
                    <div class="rk-value" id="roi-delta">—</div>
                    <div class="rk-note">vs ค่าเฉลี่ยพื้นที่</div>
                </div>
                <div class="roi-kpi">
                    <div class="rk-label">ต่อ 1 event</div>
                    <div class="rk-value" id="roi-per-event">—</div>
                    <div class="rk-note">พันคน (marginal)</div>
                </div>
                <div class="roi-kpi">
                    <div class="rk-label">Pearson r</div>
                    <div class="rk-value" id="roi-r-value">—</div>
                    <div class="rk-note" id="roi-r-note">—</div>
                </div>
            </div>

            <div class="roi-formula">
                <i class="fas fa-square-root-variable" style="color:#0f766e;"></i>
                <b>สูตร:</b> <span id="roi-formula">visitors (M) = — + — × events</span>
            </div>
        </div>

        <div class="fc-chart-panel" style="margin-bottom:0;">
            <div class="fc-panel-title">
                <i class="fas fa-chart-simple"></i>
                ตำแหน่งของแผนคุณเทียบกับอดีต 12 เดือน
                <span id="roi-chart-sub" style="font-weight:600;color:#64748b;">(ภาพรวมประเทศ)</span>
            </div>
            <!-- Quadrant legend -->
            <div style="display:flex;gap:8px;flex-wrap:wrap;font-size:0.78em;margin-bottom:10px;">
                <span style="background:#dcfce7;color:#047857;padding:3px 10px;border-radius:10px;font-weight:700;"><span style="color:#059669;">●</span> Best · events↑ visitors↑</span>
                <span style="background:#cffafe;color:#0e7490;padding:3px 10px;border-radius:10px;font-weight:700;"><span style="color:#0891b2;">●</span> มาเอง · events↓ visitors↑</span>
                <span style="background:#fef3c7;color:#92400e;padding:3px 10px;border-radius:10px;font-weight:700;"><span style="color:#d97706;">●</span> ต้องระวัง · events↑ visitors↓</span>
                <span style="background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:10px;font-weight:700;"><span style="color:#94a3b8;">●</span> ช่วงเงียบ · events↓ visitors↓</span>
                <span style="background:#fee2e2;color:#991b1b;padding:3px 10px;border-radius:10px;font-weight:700;">🎯 แผนของคุณ (จุดแดง)</span>
            </div>
            <div id="chartRoi" style="height: 340px;"></div>
            <div style="font-size:0.82em;color:#64748b;margin-top:10px;line-height:1.6;background:#f8fffe;border-radius:8px;padding:8px 12px;">
                <i class="fas fa-lightbulb" style="color:#0f766e;"></i>
                <b>อ่านกราฟยังไง?</b> เส้นประแบ่งครึ่งตามค่ากลาง (median) · จุดแผนคุณอยู่โซนไหน = แผนคุณน่าจะได้ผลแบบนั้น
            </div>
            <div class="chart-insight" id="roi-insight">
                <div class="ci-title"><i class="fas fa-clipboard-check"></i> สรุปผล — <span id="roi-insight-area">ภาพรวมประเทศ</span></div>
                <ul id="roi-insight-list">
                    <li>กำลังคำนวณ…</li>
                </ul>
            </div>
        </div>
    </div>

    <div style="font-size:0.85em;color:#64748b;margin-top:12px;line-height:1.6;background:#f0fdfa;border:1px dashed #5eead4;border-radius:10px;padding:12px 16px;">
        <i class="fas fa-lightbulb" style="color:#0f766e;"></i>
        <b>วิธีใช้:</b> เลือกจังหวัด → ใส่จำนวน events ที่วางแผนจัดต่อเดือน → ระบบจะคำนวณว่าได้ visitors กี่ M และเพิ่มจากค่าเฉลี่ยเท่าไหร่
        (ใช้ per-province regression — slope แตกต่างกันทุกจังหวัด)
    </div>

</div>

<?= $this->endSection() ?>

<?php $this->section('scripts') ?>

<script src="<?= base_url('public/js/highcharts/highcharts.js') ?>"></script>
<script src="<?= base_url('public/js/highcharts/highcharts-more.js') ?>"></script>

<script>
// ============ Server-side data ============
var histLabels   = <?= json_encode($hist_labels) ?>;
var histVisitors = <?= json_encode($hist_visitors) ?>;
var histPreds    = <?= json_encode($hist_preds) ?>;
var fcLabels     = <?= json_encode($forecast_labels) ?>;
var fcVisitors   = <?= json_encode($forecast_visitors) ?>;
var fcLower      = <?= json_encode($forecast_lower) ?>;
var fcUpper      = <?= json_encode($forecast_upper) ?>;

var modelIntercept = <?= $model['intercept'] ?>;
var modelCoefs     = <?= json_encode($model['coefs']) ?>; // [b_cci, b_gt, b_or, b_oil]
var baseline       = <?= json_encode($baseline) ?>;
var baselinePred   = <?= $baseline_pred ?>;
var featureKeys    = <?= json_encode($feature_keys) ?>;
var featureNames   = <?= json_encode($feature_names) ?>;

var provRoiDataset = <?= json_encode($prov_roi_dataset, JSON_UNESCAPED_UNICODE) ?>;
var presetsData    = <?= json_encode($presets, JSON_UNESCAPED_UNICODE) ?>;
var tier2Data      = <?= json_encode($tier2 ?? null, JSON_UNESCAPED_UNICODE) ?>;

// ============ Highcharts defaults ============
Highcharts.setOptions({
    chart: { style: { fontFamily: "'Sarabun', 'Nunito', sans-serif" }, backgroundColor: 'transparent' },
    colors: ['#0f766e', '#14b8a6', '#3eabae', '#0891b2', '#f59e0b', '#dc2626'],
    credits: { enabled: false }
});

// ============ Chart 1: Forecast with CI bands ============
(function() {
    var allLabels = histLabels.concat(fcLabels);
    var histSeries = histVisitors.concat([null, null, null]);
    var fcSeries   = [].concat(new Array(histVisitors.length - 1).fill(null));
    fcSeries.push(histVisitors[histVisitors.length - 1]); // bridge point
    fcSeries = fcSeries.concat(fcVisitors);
    var ciBand = new Array(histVisitors.length).fill([null, null]);
    // bridge (last historical = [actual, actual])
    var lastH = histVisitors[histVisitors.length - 1];
    ciBand[histVisitors.length - 1] = [lastH, lastH];
    for (var i = 0; i < fcLower.length; i++) ciBand.push([fcLower[i], fcUpper[i]]);
    var predSeries = histPreds.concat([null, null, null]);

    Highcharts.chart('chartForecast', {
        chart: { type: 'line', spacing: [10, 10, 10, 10] },
        title: { text: null },
        xAxis: {
            categories: allLabels,
            plotBands: [{
                from: histLabels.length - 0.5,
                to:   histLabels.length + fcLabels.length - 0.5,
                color: 'rgba(15,118,110,0.06)',
                label: { text: 'Forecast 3 เดือน', style: { color: '#0f766e', fontWeight: '700' }, align: 'center' }
            }]
        },
        yAxis: {
            title: { text: 'นักท่องเที่ยว (ล้านคน)', style: { color: '#64748b' } },
            gridLineColor: '#f1f5f9'
        },
        tooltip: { shared: true, valueSuffix: ' M', valueDecimals: 2 },
        plotOptions: {
            line: { marker: { radius: 5, lineWidth: 2, lineColor: '#fff' }, lineWidth: 3 },
            arearange: { fillOpacity: 0.18, lineWidth: 0, marker: { enabled: false } }
        },
        series: [
            { name: 'นักท่องเที่ยวจริง', data: histSeries, color: '#0f766e', zIndex: 3 },
            { name: 'Model Fit', data: predSeries, color: '#14b8a6', dashStyle: 'ShortDash', lineWidth: 2, marker: { radius: 3 }, zIndex: 2 },
            { name: 'Forecast', data: fcSeries, color: '#f59e0b', dashStyle: 'Dot', marker: { symbol: 'triangle', radius: 7 }, zIndex: 3 },
            { name: 'CI 95%', type: 'arearange', data: ciBand, color: '#f59e0b', zIndex: 1, linkedTo: ':previous' }
        ],
        legend: { itemStyle: { fontWeight: '600' } }
    });
})();

// ============ Tier 2 Charts (SARIMAX + Decomposition) ============
(function() {
    if (!tier2Data || !tier2Data.sarimax || !tier2Data.holt) return;

    var meta   = tier2Data.data_meta;
    var labels = meta.labels.concat(meta.future_labels);
    var nHist  = meta.labels.length;
    var nFut   = meta.future_labels.length;

    // ---- Chart A: Forecast comparison ----
    var sarimax = tier2Data.sarimax;
    var holt    = tier2Data.holt;

    // Historical observed
    var observedSeries = meta.visitors_m.concat(new Array(nFut).fill(null));

    // SARIMAX fitted (in-sample) + forecast (out-of-sample)
    var sarimaxFit = (sarimax.fitted || []).concat(new Array(nFut).fill(null));
    var sarimaxFc  = new Array(nHist - 1).fill(null);
    sarimaxFc.push(meta.visitors_m[nHist - 1]); // bridge
    sarimaxFc = sarimaxFc.concat(sarimax.forecast);
    var sarimaxBand = new Array(nHist).fill([null, null]);
    var lastV = meta.visitors_m[nHist - 1];
    sarimaxBand[nHist - 1] = [lastV, lastV];
    for (var i = 0; i < sarimax.lower.length; i++) sarimaxBand.push([sarimax.lower[i], sarimax.upper[i]]);

    // Holt forecast only (skip fitted to avoid chart clutter)
    var holtFc = new Array(nHist - 1).fill(null);
    holtFc.push(meta.visitors_m[nHist - 1]);
    holtFc = holtFc.concat(holt.forecast);

    Highcharts.chart('chartTier2Forecast', {
        chart: { type: 'line', spacing: [10, 10, 10, 10] },
        title: { text: null },
        xAxis: {
            categories: labels,
            plotBands: [{
                from: nHist - 0.5,
                to:   nHist + nFut - 0.5,
                color: 'rgba(15,118,110,0.06)',
                label: { text: 'Forecast ' + nFut + ' เดือน', style: { color: '#0f766e', fontWeight: '700' }, align: 'center' }
            }]
        },
        yAxis: {
            title: { text: 'นักท่องเที่ยว (ล้านคน)', style: { color: '#64748b' } },
            gridLineColor: '#f1f5f9'
        },
        tooltip: { shared: true, valueSuffix: ' M', valueDecimals: 2 },
        plotOptions: {
            line: { marker: { radius: 5, lineWidth: 2, lineColor: '#fff' }, lineWidth: 3 },
            arearange: { fillOpacity: 0.18, lineWidth: 0, marker: { enabled: false } }
        },
        series: [
            { name: 'Observed', data: observedSeries, color: '#0f766e', zIndex: 4 },
            { name: 'SARIMAX fit', data: sarimaxFit, color: '#14b8a6', dashStyle: 'ShortDash', lineWidth: 2, marker: { radius: 3 }, zIndex: 2 },
            { name: 'SARIMAX forecast', data: sarimaxFc, color: '#0891b2', dashStyle: 'Dot', marker: { symbol: 'triangle', radius: 7 }, zIndex: 3 },
            { name: 'SARIMAX CI 95%', type: 'arearange', data: sarimaxBand, color: '#0891b2', zIndex: 1, linkedTo: ':previous' },
            { name: 'Holt-Winters forecast', data: holtFc, color: '#f59e0b', dashStyle: 'Dash', marker: { symbol: 'diamond', radius: 6 }, lineWidth: 2, zIndex: 3 }
        ],
        legend: { itemStyle: { fontWeight: '600' } }
    });

    // ---- Chart B: Trend Decomposition ----
    var dec = tier2Data.decomposition;
    if (dec) {
        Highcharts.chart('chartTier2Decomp', {
            chart: { zoomType: 'x' },
            title: { text: null },
            xAxis: { categories: dec.labels },
            yAxis: [
                { title: { text: 'Visitors (ล้านคน)', style: { color: '#0f766e' } }, gridLineColor: '#f1f5f9' },
                { title: { text: 'Residual', style: { color: '#dc2626' } }, gridLineColor: 'transparent', opposite: true }
            ],
            tooltip: { shared: true, valueDecimals: 2 },
            plotOptions: {
                line: { marker: { radius: 4, lineWidth: 2, lineColor: '#fff' }, lineWidth: 2.5 },
                column: { opacity: 0.7 }
            },
            series: [
                { name: 'Observed', data: dec.observed, type: 'line', color: '#0f766e' },
                { name: 'Trend (MA-' + dec.window + ')', data: dec.trend, type: 'line', color: '#f59e0b', dashStyle: 'ShortDash', lineWidth: 2 },
                { name: 'Residual', data: dec.residual, type: 'column', yAxis: 1, color: '#dc2626' }
            ],
            legend: { itemStyle: { fontWeight: '600' } }
        });
    }
})();

// ============ Chart 2: Event ROI Scatter (4-quadrant + your-plan marker) ============
var roiChart = null;
var roiMonthLabels = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];

function median(arr) {
    var s = arr.slice().sort(function(a,b){ return a-b; });
    var n = s.length;
    return n % 2 ? s[(n-1)/2] : (s[n/2-1] + s[n/2]) / 2;
}

function roiRenderChart(provKey, userEvents) {
    var d = provRoiDataset[provKey];
    if (!d) return;
    var events = d.events;
    var visitors = d.visitors;
    var n = events.length;

    var medE = median(events);
    var medV = median(visitors);

    // 4 groups by quadrant
    var grp = { best: [], natural: [], worry: [], quiet: [] };
    var groupMap = { best: '🟢 Best', natural: '🔵 มาเอง', worry: '🟠 ต้องระวัง', quiet: '⚪ ช่วงเงียบ' };
    for (var i = 0; i < n; i++) {
        var key;
        if (events[i] >= medE && visitors[i] >= medV)      key = 'best';
        else if (events[i] <  medE && visitors[i] >= medV) key = 'natural';
        else if (events[i] >= medE && visitors[i] <  medV) key = 'worry';
        else                                                key = 'quiet';
        grp[key].push({
            name: roiMonthLabels[i] + ' 2568',
            x: events[i],
            y: visitors[i],
            monthLabel: roiMonthLabels[i],
            group: groupMap[key]
        });
    }

    // Trend line endpoints
    var range = Math.max.apply(null, events) - Math.min.apply(null, events);
    var pad = Math.max(1, range * 0.08);
    var minE = Math.max(0, Math.min.apply(null, events) - pad);
    var maxE = Math.max.apply(null, events) + pad;
    // ถ้า user ใส่ค่านอก range ให้ขยาย axis
    if (typeof userEvents === 'number' && !isNaN(userEvents)) {
        if (userEvents < minE) minE = Math.max(0, userEvents - 2);
        if (userEvents > maxE) maxE = userEvents + 2;
    }
    var trend = [
        [minE, d.intercept + d.slope * minE],
        [maxE, d.intercept + d.slope * maxE]
    ];

    // "แผนของคุณ" จุดแดงขยับตาม input
    var planSeries = null;
    if (typeof userEvents === 'number' && !isNaN(userEvents) && userEvents >= 0) {
        var predY = Math.max(0, d.intercept + d.slope * userEvents);
        planSeries = {
            type: 'scatter',
            name: '🎯 แผนของคุณ',
            color: '#dc2626',
            data: [{ name: '🎯 แผนของคุณ', x: userEvents, y: predY, monthLabel: 'YOU', group: '🎯 แผน' }],
            marker: { symbol: 'diamond', radius: 14, lineColor: '#fff', lineWidth: 3 },
            dataLabels: {
                enabled: true,
                useHTML: true,
                format: '<span style="background:#dc2626;color:#fff;padding:2px 8px;border-radius:10px;font-weight:800;">🎯 คุณ</span>',
                y: -14,
                style: { textOutline: 'none' }
            },
            zIndex: 10
        };
    }

    // Helper to build series from group
    function mkSeries(key, color, name) {
        return {
            type: 'scatter',
            name: name,
            color: color,
            data: grp[key],
            marker: { radius: 8, lineColor: '#fff', lineWidth: 2 },
            dataLabels: {
                enabled: true,
                format: '{point.monthLabel}',
                style: { fontSize: '10px', fontWeight: '700', color: '#334155', textOutline: '2px #fff' },
                y: -12
            }
        };
    }

    if (roiChart) { roiChart.destroy(); roiChart = null; }
    roiChart = Highcharts.chart('chartRoi', {
        chart: { zoomType: 'xy' },
        title: { text: null },
        xAxis: {
            title: { text: 'Events / เดือน', style: { color: '#64748b' } },
            gridLineColor: '#f1f5f9', gridLineWidth: 1,
            min: minE, max: maxE,
            plotLines: [{
                value: medE,
                color: '#94a3b8',
                dashStyle: 'Dash',
                width: 1.5,
                label: { text: 'Events กลาง = ' + medE.toFixed(0), style: { color: '#64748b', fontSize: '10px', fontWeight: '700' }, y: 14, x: 4 },
                zIndex: 1
            }]
        },
        yAxis: {
            title: { text: 'Visitors (ล้านคน)', style: { color: '#64748b' } },
            gridLineColor: '#f1f5f9',
            plotLines: [{
                value: medV,
                color: '#94a3b8',
                dashStyle: 'Dash',
                width: 1.5,
                label: { text: 'Visitors กลาง = ' + medV.toFixed(2) + 'M', style: { color: '#64748b', fontSize: '10px', fontWeight: '700' }, align: 'right', x: -6, y: -4 },
                zIndex: 1
            }]
        },
        tooltip: {
            useHTML: true,
            formatter: function() {
                var p = this.point;
                if (p.monthLabel === 'YOU') {
                    return '<b style="color:#dc2626;">🎯 แผนของคุณ</b><br/>' +
                           'Events: <b>' + p.x + '</b>/เดือน<br/>' +
                           'คาดว่าได้ Visitors: <b>' + p.y.toFixed(3) + 'M</b>';
                }
                return '<b>' + p.name + '</b> · ' + p.group + '<br/>' +
                       'Events: <b>' + p.x + '</b><br/>' +
                       'Visitors: <b>' + p.y.toFixed(3) + 'M</b>';
            }
        },
        plotOptions: {
            scatter: { states: { hover: { marker: { enabled: true, lineColor: '#0f766e' } } } },
            line:    { marker: { enabled: false }, enableMouseTracking: false }
        },
        series: [
            mkSeries('best',    '#059669', '🟢 Best'),
            mkSeries('natural', '#0891b2', '🔵 มาเอง'),
            mkSeries('worry',   '#d97706', '🟠 ต้องระวัง'),
            mkSeries('quiet',   '#94a3b8', '⚪ ช่วงเงียบ'),
            { type: 'line', name: 'Trend line', data: trend, color: '#f59e0b', dashStyle: 'ShortDash', lineWidth: 2, enableMouseTracking: false, showInLegend: true, marker: { enabled: false } },
            planSeries
        ].filter(function(s){ return s !== null; }),
        legend: { itemStyle: { fontWeight: '600', fontSize: '11px' } }
    });
}

// ============ Scenario Simulator ============
function predictFromInputs() {
    var vals = {};
    featureKeys.forEach(function(k) {
        vals[k] = parseFloat(document.getElementById('slider_' + k).value);
    });
    var pred = modelIntercept
             + modelCoefs[0] * vals.cci
             + modelCoefs[1] * vals.gt
             + modelCoefs[2] * vals.or
             + modelCoefs[3] * vals.oil;

    document.getElementById('sim-pred-val').textContent = pred.toFixed(2);

    var delta = pred - baselinePred;
    var deltaEl = document.getElementById('sim-delta');
    var sign = delta >= 0 ? '+' : '';
    deltaEl.textContent = sign + delta.toFixed(2) + ' M vs baseline';
    deltaEl.className = 'sim-delta ' + (delta > 0.01 ? 'up' : (delta < -0.01 ? 'down' : ''));

    // Update contribution rows
    featureKeys.forEach(function(k, i) {
        var contrib = modelCoefs[i] * (vals[k] - baseline[k]);
        var el = document.getElementById('contrib_' + k);
        var s = contrib >= 0 ? '+' : '';
        el.textContent = s + contrib.toFixed(3) + ' M';
        el.className = 'sc-val ' + (contrib > 0.001 ? 'pos' : (contrib < -0.001 ? 'neg' : ''));
    });
}

featureKeys.forEach(function(k) {
    var slider = document.getElementById('slider_' + k);
    var valEl  = document.getElementById('val_' + k);
    slider.addEventListener('input', function() {
        valEl.textContent = parseFloat(this.value).toFixed(2);
        predictFromInputs();
    });
});

function resetSimulator() {
    featureKeys.forEach(function(k) {
        var slider = document.getElementById('slider_' + k);
        slider.value = baseline[k];
        document.getElementById('val_' + k).textContent = parseFloat(baseline[k]).toFixed(2);
    });
    predictFromInputs();
}

// initial
predictFromInputs();

// ============ Event ROI — Province-aware live calculator ============
(function() {
    var provSel    = document.getElementById('roi-province');
    var eventInput = document.getElementById('roi-events');
    var predEl     = document.getElementById('roi-pred-vis');
    var deltaEl    = document.getElementById('roi-delta');
    var perEvtEl   = document.getElementById('roi-per-event');
    var rEl        = document.getElementById('roi-r-value');
    var rNoteEl    = document.getElementById('roi-r-note');
    var formulaEl  = document.getElementById('roi-formula');
    var tagEl      = document.getElementById('roi-prov-tag');
    var hintEl     = document.getElementById('roi-avg-hint');
    var chartSubEl = document.getElementById('roi-chart-sub');

    function currentDataset() {
        var key = provSel.value;
        return { key: key, data: provRoiDataset[key] };
    }

    function roiUpdate() {
        var c = currentDataset();
        if (!c.data) return;
        var d = c.data;
        var ev = parseFloat(eventInput.value) || 0;
        var pred = d.intercept + d.slope * ev;
        if (pred < 0) pred = 0;

        predEl.textContent = pred.toFixed(3);

        var delta = pred - d.avg_visitors;
        var s = delta >= 0 ? '+' : '';
        deltaEl.textContent = s + delta.toFixed(3) + 'M';
        deltaEl.style.color = delta >= 0 ? '#d97706' : '#dc2626';

        // per 1 event (in thousand people)
        perEvtEl.textContent = (d.slope * 1000).toFixed(1);

        // Pearson r with interpretation
        rEl.textContent = d.r.toFixed(2);
        var absR = Math.abs(d.r);
        var rText;
        if (absR >= 0.7)      rText = 'ความสัมพันธ์สูง';
        else if (absR >= 0.4) rText = 'ปานกลาง';
        else if (absR >= 0.2) rText = 'ต่ำ';
        else                  rText = 'แทบไม่มี';
        rNoteEl.textContent = rText + ' · Events × Visitors';
        rEl.style.color = absR >= 0.4 ? '#059669' : (absR >= 0.2 ? '#d97706' : '#64748b');

        // Formula display
        formulaEl.innerHTML = 'visitors (M) = <b>' + d.intercept.toFixed(3) + '</b> + <b>' +
                              d.slope.toFixed(4) + '</b> × events &nbsp; | &nbsp; ค่าเฉลี่ย <b>' +
                              d.avg_events + '</b> ev → <b>' + d.avg_visitors.toFixed(3) + 'M</b>';

        // Hint + tag
        hintEl.textContent = 'avg: ' + d.avg_events + ' ev/เดือน';
        var isAll = (c.key === '__ALL__');
        tagEl.innerHTML = '<i class="fas fa-eye"></i> ' + (isAll ? 'ภาพรวมประเทศ' : c.key);
        chartSubEl.textContent = '(' + (isAll ? 'ภาพรวมประเทศ' : c.key) + ')';

        // ===== Dynamic Insight =====
        roiUpdateInsight(c.key, d, ev, pred);
    }

    function roiUpdateInsight(provKey, d, userEv, userPred) {
        var areaEl = document.getElementById('roi-insight-area');
        var listEl = document.getElementById('roi-insight-list');
        var isAllP = (provKey === '__ALL__');
        areaEl.textContent = isAllP ? 'ภาพรวมประเทศ (77 จังหวัด)' : provKey;

        // Quadrant counts
        var medE = median(d.events);
        var medV = median(d.visitors);
        var counts = { best: 0, natural: 0, worry: 0, quiet: 0 };
        var monthsBest = [];
        for (var i = 0; i < d.events.length; i++) {
            var e = d.events[i], v = d.visitors[i];
            if (e >= medE && v >= medV)      { counts.best++; monthsBest.push(roiMonthLabels[i]); }
            else if (e <  medE && v >= medV) counts.natural++;
            else if (e >= medE && v <  medV) counts.worry++;
            else                              counts.quiet++;
        }

        // User plan zone
        var yourZone, yourZoneColor, yourZoneEmoji;
        if (userEv >= medE && userPred >= medV)      { yourZone = 'Best — events ช่วยดึงนักท่องเที่ยว'; yourZoneColor = 'pill-good'; yourZoneEmoji = '🟢'; }
        else if (userEv <  medE && userPred >= medV) { yourZone = 'มาเอง — ไม่ต้องจัดงานก็มีคน';        yourZoneColor = 'pill-info'; yourZoneEmoji = '🔵'; }
        else if (userEv >= medE && userPred <  medV) { yourZone = 'ต้องระวัง — จัดงานเยอะแต่คนไม่มา';   yourZoneColor = 'pill-warn'; yourZoneEmoji = '🟠'; }
        else                                          { yourZone = 'ช่วงเงียบ — low season';            yourZoneColor = 'pill-neutral'; yourZoneEmoji = '⚪'; }

        // Correlation strength
        var absR = Math.abs(d.r);
        var rStrength, rPill;
        if (absR >= 0.7)      { rStrength = 'สูง';  rPill = 'pill-good'; }
        else if (absR >= 0.4) { rStrength = 'ปานกลาง'; rPill = 'pill-warn'; }
        else if (absR >= 0.2) { rStrength = 'ต่ำ';   rPill = 'pill-bad'; }
        else                  { rStrength = 'แทบไม่มี'; rPill = 'pill-bad'; }
        var rDir = d.r >= 0 ? 'บวก (events↑ → visitors↑)' : 'ลบ (events↑ → visitors↓)';

        // Lift
        var lift = userPred - d.avg_visitors;
        var liftPct = d.avg_visitors > 0 ? (lift / d.avg_visitors * 100) : 0;
        var liftPill, liftText;
        if (lift > 0.05)  { liftPill = 'pill-good'; liftText = '✓ เพิ่มจากค่าเฉลี่ย'; }
        else if (lift < -0.05) { liftPill = 'pill-bad'; liftText = '✗ ต่ำกว่าค่าเฉลี่ย'; }
        else               { liftPill = 'pill-neutral'; liftText = '≈ ใกล้ค่าเฉลี่ย'; }

        // Recommendation
        var rec;
        if (absR < 0.3) {
            rec = 'ℹ <b>Events กับ Visitors ในพื้นที่นี้สัมพันธ์กันน้อย</b> — การจัดงานเพิ่มอาจไม่เพิ่มนักท่องเที่ยวชัด ควรใช้กลยุทธ์อื่นประกอบ (marketing, ที่พัก)';
        } else if (d.slope > 0 && userEv > d.avg_events * 1.3) {
            rec = '✅ <b>แผนคุณ (' + userEv + ' events) สูงกว่าค่าเฉลี่ย</b> · ถ้าสัมพันธ์เป็นบวก (r=' + d.r.toFixed(2) + ') คาดว่าได้ผลตอบแทนดี';
        } else if (d.slope > 0 && userEv < d.avg_events * 0.7) {
            rec = '⚠ <b>แผน events ต่ำกว่าค่าเฉลี่ย</b> — อาจพลาดโอกาส · ลองเพิ่ม events ให้เท่า ' + Math.round(d.avg_events) + ' หรือมากกว่า';
        } else if (d.slope < 0) {
            rec = '⚠ <b>ค่า r ติดลบ</b> — ในพื้นที่นี้ events เยอะแต่ visitors ลด · อาจเกิดจาก events ไปเบียดทรัพยากร (ที่พักเต็ม/ราคาแพง)';
        } else {
            rec = '💡 แผนอยู่ในช่วงปกติ · ถ้าอยาก lift มากขึ้น เพิ่ม events + ปัจจัยอื่นประกอบ (OR/CCI)';
        }

        var html = '';
        html += '<li>สถานะแผนของคุณ: ' + yourZoneEmoji + ' <span class="pill ' + yourZoneColor + '">' + yourZone + '</span></li>';
        html += '<li>คาดว่าได้ <b>' + userPred.toFixed(3) + 'M</b> คน จาก <b>' + userEv + '</b> events · '
             + '<span class="pill ' + liftPill + '">' + liftText + ' ' + (lift >= 0 ? '+' : '') + lift.toFixed(3) + 'M (' + (liftPct >= 0 ? '+' : '') + liftPct.toFixed(1) + '%)</span></li>';
        html += '<li>ความสัมพันธ์ Events × Visitors: <span class="pill ' + rPill + '">r = ' + d.r.toFixed(2) + ' · ' + rStrength + '</span> · ทิศทาง ' + rDir + '</li>';
        html += '<li>ใน 12 เดือนที่ผ่านมา: '
             + '<span class="pill pill-good">🟢 Best ' + counts.best + '</span> '
             + '<span class="pill pill-info">🔵 มาเอง ' + counts.natural + '</span> '
             + '<span class="pill pill-warn">🟠 ระวัง ' + counts.worry + '</span> '
             + '<span class="pill pill-neutral">⚪ เงียบ ' + counts.quiet + '</span></li>';
        html += '<li>📌 <b>คำแนะนำ:</b> ' + rec + '</li>';
        listEl.innerHTML = html;
    }

    provSel.addEventListener('change', function() {
        var d = currentDataset().data;
        if (!d) return;
        eventInput.value = Math.round(d.avg_events);
        roiUpdate();
    });
    eventInput.addEventListener('input', roiUpdate);

    // ขยับ chart เฉพาะตอนจำเป็น (เปลี่ยนจังหวัดหรือ input) — debounce input
    var renderTimer = null;
    function scheduleRender() {
        clearTimeout(renderTimer);
        renderTimer = setTimeout(function() {
            var ev = parseFloat(eventInput.value);
            roiRenderChart(provSel.value, ev);
        }, 120);
    }
    provSel.addEventListener('change', scheduleRender);
    eventInput.addEventListener('input', scheduleRender);

    // init — default: __ALL__
    var init = currentDataset().data;
    eventInput.value = Math.round(init.avg_events);
    roiRenderChart('__ALL__', Math.round(init.avg_events));
    roiUpdate();
})();

// ============ Preset Scenario Buttons ============
(function() {
    var btns = document.querySelectorAll('.preset-btn');
    btns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var key = this.getAttribute('data-preset');
            var preset = presetsData.find(function(p) { return p.key === key; });
            if (!preset) return;

            // Apply deltas to baseline → set sliders
            featureKeys.forEach(function(fk) {
                var slider = document.getElementById('slider_' + fk);
                var newVal = baseline[fk] + (preset.deltas[fk] || 0);
                // Clamp to slider range
                var minVal = parseFloat(slider.min);
                var maxVal = parseFloat(slider.max);
                newVal = Math.max(minVal, Math.min(maxVal, newVal));
                slider.value = newVal;
                document.getElementById('val_' + fk).textContent = newVal.toFixed(2);
            });
            // Update active state
            btns.forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            predictFromInputs();
        });
    });

    // When user manually moves a slider → unset "active" on presets
    featureKeys.forEach(function(fk) {
        document.getElementById('slider_' + fk).addEventListener('input', function() {
            btns.forEach(function(b) { b.classList.remove('active'); });
        });
    });
})();
</script>

<?= $this->endSection() ?>
