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

    /* ========================================================
       [v2] Leading Indicators
       ======================================================== */
    .li-hero {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 60%, #5eead4 100%);
        color: #fff;
        border-radius: 16px;
        padding: 22px 28px;
        margin-bottom: 18px;
        box-shadow: 0 6px 24px rgba(15,118,110,0.25);
        position: relative;
        overflow: hidden;
    }
    .li-hero::after {
        content: '';
        position: absolute; right: -60px; top: -60px;
        width: 220px; height: 220px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .li-hero-row {
        display: flex; align-items: center;
        justify-content: space-between;
        gap: 20px; flex-wrap: wrap;
        position: relative; z-index: 1;
    }
    .li-hero .li-label {
        font-size: 0.82em; opacity: 0.85;
        text-transform: uppercase; letter-spacing: 1px;
        font-weight: 700;
    }
    .li-hero .li-score {
        font-size: 3.4em; font-weight: 800;
        line-height: 1; margin-top: 6px;
    }
    .li-hero .li-score-max {
        font-size: 0.45em; opacity: 0.7; font-weight: 600;
    }
    .li-signal {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(255,255,255,0.22);
        border-radius: 30px; padding: 8px 18px;
        font-weight: 800; font-size: 0.92em;
        margin-top: 10px;
    }
    .li-signal.positive { background: rgba(5,150,105,0.3); }
    .li-signal.neutral  { background: rgba(245,158,11,0.3); }
    .li-signal.negative { background: rgba(220,38,38,0.4); }
    .li-hero .li-desc {
        font-size: 0.88em; opacity: 0.92;
        margin-top: 10px; max-width: 520px; line-height: 1.6;
    }
    .li-norm-breakdown { display: flex; gap: 14px; flex-wrap: wrap; }
    .li-norm-item {
        background: rgba(255,255,255,0.18);
        border-radius: 10px; padding: 10px 16px; min-width: 130px;
    }
    .li-norm-item .n-label {
        font-size: 0.72em; opacity: 0.85;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .li-norm-item .n-val { font-size: 1.5em; font-weight: 800; margin-top: 2px; }

    .li-card {
        background: #fff; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        padding: 18px 20px;
        border: 1px solid #e8f0f0;
        height: 100%;
        display: flex; flex-direction: column;
        transition: all 0.3s;
    }
    .li-card:hover {
        box-shadow: 0 6px 20px rgba(0,124,132,0.12);
        transform: translateY(-3px);
    }
    .li-card .li-head {
        display: flex; justify-content: space-between;
        align-items: flex-start; margin-bottom: 6px;
    }
    .li-card .li-name {
        font-size: 0.82em; color: #64748b;
        font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .li-card .li-src { font-size: 0.7em; color: #94a3b8; font-style: italic; }
    .li-card .li-value {
        font-size: 2.4em; font-weight: 800;
        color: #0f766e; line-height: 1;
    }
    .li-card .li-unit { font-size: 0.5em; color: #94a3b8; font-weight: 600; }
    .li-card .li-period { font-size: 0.78em; color: #64748b; margin-top: 2px; }
    .li-card .li-delta {
        display: inline-block;
        padding: 4px 10px; border-radius: 20px;
        font-size: 0.78em; font-weight: 800; margin-top: 6px;
    }
    .li-card .li-delta.up   { background: #dcfce7; color: #059669; }
    .li-card .li-delta.down { background: #fee2e2; color: #dc2626; }
    .li-card .li-delta.flat { background: #f1f5f9; color: #64748b; }
    .li-card .li-mini-chart { flex: 1; min-height: 90px; margin-top: 10px; }
    .li-card .li-corr {
        font-size: 0.76em; color: #64748b;
        margin-top: 8px; padding-top: 8px;
        border-top: 1px dashed #e2e8f0;
    }
    .li-card .li-corr b { color: #0f766e; }

    /* ========================================================
       [v2] Regional Sentiment Map
       ======================================================== */
    .rs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }
    .rs-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        padding: 16px 18px;
        border: 1px solid #e8f0f0;
        border-top: 4px solid #3eabae;
        transition: all 0.3s;
    }
    .rs-card:hover {
        box-shadow: 0 6px 20px rgba(0,124,132,0.1);
        transform: translateY(-2px);
    }
    .rs-card .rs-region {
        font-weight: 800; color: #1a3a3c;
        font-size: 0.98em; margin-bottom: 6px;
    }
    .rs-card .rs-mention {
        font-size: 0.76em; color: #64748b; margin-bottom: 10px;
    }
    .rs-card .rs-mention b { color: #0f766e; font-size: 1.1em; }
    .rs-card .rs-bar {
        display: flex; height: 14px;
        border-radius: 20px; overflow: hidden;
        margin: 8px 0; background: #f1f5f9;
    }
    .rs-card .rs-bar .rs-pos { background: linear-gradient(90deg,#10b981,#34d399); }
    .rs-card .rs-bar .rs-neg { background: linear-gradient(90deg,#ef4444,#dc2626); }
    .rs-card .rs-pct {
        display: flex; justify-content: space-between;
        font-size: 0.78em; font-weight: 700;
    }
    .rs-card .rs-pct .pct-pos { color: #059669; }
    .rs-card .rs-pct .pct-neg { color: #dc2626; }
    .rs-card .rs-theme {
        margin-top: 10px; padding-top: 10px;
        border-top: 1px dashed #e2e8f0;
        font-size: 0.75em; line-height: 1.55;
    }
    .rs-card .rs-theme .t-label { font-weight: 800; margin-right: 4px; }
    .rs-card .rs-theme .pos-theme .t-label { color: #059669; }
    .rs-card .rs-theme .neg-theme .t-label { color: #dc2626; }
    .rs-card .rs-theme .pos-theme { margin-bottom: 6px; color: #334155; }
    .rs-card .rs-theme .neg-theme { color: #334155; }

    .rs-summary {
        display: flex; gap: 16px; align-items: center;
        background: linear-gradient(135deg, #ccfbf1 0%, #f0fdfa 100%);
        border: 1px solid #5eead4;
        border-radius: 12px; padding: 14px 20px;
        margin-bottom: 14px; flex-wrap: wrap;
    }
    .rs-summary .rs-sum-label {
        font-weight: 800; color: #0f766e; font-size: 0.92em;
    }
    .rs-summary .rs-sum-stat {
        display: flex; gap: 22px;
        font-size: 0.88em; color: #115e59; flex-wrap: wrap;
    }
    .rs-summary .rs-sum-stat b {
        display: block; font-size: 1.3em; color: #0f766e;
    }

    /* ========================================================
       [v2-A] Top 10 Provincial Performance
       ======================================================== */
    .pp-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.86em;
    }
    .pp-table thead th {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        color: #fff;
        padding: 11px 12px;
        font-weight: 700;
        text-align: right;
        position: sticky;
        top: 0;
    }
    .pp-table thead th:first-child { text-align: left; border-radius: 8px 0 0 0; }
    .pp-table thead th:last-child  { border-radius: 0 8px 0 0; }
    .pp-table tbody td {
        padding: 9px 12px;
        border-bottom: 1px solid #f1f5f9;
        text-align: right;
        color: #1a3a3c;
    }
    .pp-table tbody td:first-child { text-align: left; font-weight: 700; }
    .pp-table tbody tr:hover td { background: #f0fafa; }
    .pp-table tbody tr.tier-main td:first-child::before {
        content: ''; display: inline-block;
        width: 6px; height: 6px; border-radius: 50%;
        background: #0f766e; margin-right: 8px; vertical-align: middle;
    }
    .pp-table tbody tr.tier-minor td:first-child::before {
        content: ''; display: inline-block;
        width: 6px; height: 6px; border-radius: 50%;
        background: #94a3b8; margin-right: 8px; vertical-align: middle;
    }
    .pp-rank {
        display: inline-block; width: 22px; height: 22px;
        line-height: 22px; text-align: center;
        background: #f0fafa; color: #0f766e;
        border-radius: 50%; font-weight: 800;
        font-size: 0.75em; margin-right: 6px;
    }
    .pp-rank.gold   { background: #fef3c7; color: #92400e; }
    .pp-rank.silver { background: #e5e7eb; color: #374151; }
    .pp-rank.bronze { background: #fde68a; color: #78350f; }
    .pp-tier-badge {
        font-size: 0.7em; padding: 2px 8px;
        border-radius: 10px; margin-left: 4px;
        font-weight: 700;
    }
    .pp-tier-badge.main  { background: #ccfbf1; color: #0f766e; }
    .pp-tier-badge.minor { background: #f1f5f9; color: #475569; }
    .pp-or-mini {
        display: inline-block;
        width: 50px; height: 6px;
        background: #e2e8f0; border-radius: 4px;
        vertical-align: middle; margin-right: 6px;
    }
    .pp-or-mini-fill {
        display: block; height: 100%;
        background: linear-gradient(90deg, #14b8a6, #0f766e);
        border-radius: 4px;
    }
    .pp-yoy { font-weight: 700; }
    .pp-yoy.up   { color: #059669; }
    .pp-yoy.down { color: #dc2626; }

    /* ========================================================
       [v2-B] 6 Region Master Table
       ======================================================== */
    .rm-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 4px;
        font-size: 0.88em;
    }
    .rm-table th {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        color: #fff;
        padding: 12px 14px;
        font-weight: 700;
        text-align: right;
        font-size: 0.92em;
    }
    .rm-table th:first-child { text-align: left; border-radius: 8px 0 0 0; }
    .rm-table th:last-child  { border-radius: 0 8px 0 0; }
    .rm-table td {
        padding: 12px 14px;
        background: #fff;
        text-align: right;
        color: #1a3a3c;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
    }
    .rm-table td:first-child {
        text-align: left; font-weight: 700;
        border-left: 4px solid #3eabae;
    }
    .rm-table tr:hover td { background: #f8fffe; }
    .rm-metric-bar {
        display: block;
        background: #f1f5f9; height: 8px;
        border-radius: 4px; overflow: hidden;
        margin-top: 4px;
    }
    .rm-metric-bar > span {
        display: block; height: 100%;
        border-radius: 4px;
        transition: width 0.8s ease-out;
    }
    .rm-pos-pct.high { color: #059669; }
    .rm-pos-pct.mid  { color: #f59e0b; }
    .rm-pos-pct.low  { color: #dc2626; }
    .rm-cci-pill {
        display: inline-block;
        padding: 4px 10px; border-radius: 14px;
        font-weight: 800; font-size: 0.85em;
    }
    .rm-cci-pill.high { background: #dcfce7; color: #059669; }
    .rm-cci-pill.mid  { background: #fef3c7; color: #92400e; }
    .rm-cci-pill.low  { background: #fee2e2; color: #dc2626; }
    .rm-proxy-note {
        font-size: 0.65em; color: #94a3b8;
        font-style: italic; display: block;
    }

    /* ========================================================
       [v2-C] Long-term Recovery
       ======================================================== */
    .lt-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
        margin-bottom: 16px;
    }
    .lt-stat {
        background: #fff;
        border-radius: 12px;
        padding: 16px 18px;
        border: 1px solid #e8f0f0;
        border-left: 4px solid #0f766e;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }
    .lt-stat .lt-label {
        font-size: 0.78em; color: #64748b;
        text-transform: uppercase; font-weight: 700;
        letter-spacing: 0.5px;
    }
    .lt-stat .lt-value {
        font-size: 1.7em; font-weight: 800;
        color: #0f766e; margin-top: 6px;
        line-height: 1;
    }
    .lt-stat .lt-unit {
        font-size: 0.55em; color: #94a3b8; font-weight: 600;
    }
    .lt-stat .lt-note {
        font-size: 0.78em; color: #64748b; margin-top: 4px;
    }
    .lt-stat.dip      { border-left-color: #dc2626; }
    .lt-stat.dip .lt-value { color: #dc2626; }
    .lt-stat.recover  { border-left-color: #059669; }
    .lt-stat.recover .lt-value { color: #059669; }
    .lt-stat.forecast { border-left-color: #f59e0b; background: linear-gradient(135deg,#fffbeb,#fff); }
    .lt-stat.forecast .lt-value { color: #f59e0b; }
    .lt-milestones {
        display: flex; gap: 8px; flex-wrap: wrap;
        margin-top: 10px;
    }
    .lt-milestone {
        background: #f1f5f9;
        padding: 4px 10px; border-radius: 12px;
        font-size: 0.72em; color: #1e293b;
        border: 1px dashed #cbd5e1;
    }
    .lt-milestone.dip { background: #fee2e2; color: #b91c1c; border-color: #fca5a5; }
    .lt-milestone.recover { background: #dcfce7; color: #047857; border-color: #6ee7b7; }
    .lt-milestone.peak { background: #dbeafe; color: #1d4ed8; border-color: #93c5fd; }

    /* ========================================================
       [v2] Movement & Micro-interactions (Enhanced)
       ======================================================== */

    /* --- Glow pulse สำหรับ Hero Score --- */
    @keyframes glow-pulse {
        0%, 100% { box-shadow: 0 6px 24px rgba(15,118,110,0.25); }
        50%      { box-shadow: 0 6px 36px rgba(15,118,110,0.55), 0 0 0 8px rgba(94,234,212,0.15); }
    }
    .li-hero { animation: glow-pulse 3s ease-in-out infinite; }

    /* --- Hero score: shimmer overlay --- */
    @keyframes shine-sweep {
        0%   { transform: translateX(-100%) skewX(-20deg); }
        60%  { transform: translateX(220%) skewX(-20deg); }
        100% { transform: translateX(220%) skewX(-20deg); }
    }
    .li-hero .li-score {
        position: relative;
        display: inline-block;
        background: linear-gradient(90deg,#fff 30%, #d1fae5 50%, #fff 70%);
        background-size: 200% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        animation: shimmer-text 4s linear infinite;
    }
    @keyframes shimmer-text {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* --- Signal pulse (positive/neutral/negative) --- */
    @keyframes signal-pulse {
        0%, 100% { transform: scale(1); }
        50%      { transform: scale(1.04); }
    }
    .li-signal { animation: signal-pulse 2.4s ease-in-out infinite; }

    /* --- Card lift / hover enhancements --- */
    .li-card, .rs-card, .lt-stat {
        transition: transform 0.35s cubic-bezier(0.4,0,0.2,1),
                    box-shadow 0.35s cubic-bezier(0.4,0,0.2,1);
    }
    .li-card:hover, .lt-stat:hover {
        transform: translateY(-5px) scale(1.015);
    }
    .rs-card:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 10px 28px rgba(0,124,132,0.18) !important;
    }

    /* --- Number count-up pulse --- */
    @keyframes count-pulse {
        0%, 100% { transform: scale(1); }
        50%      { transform: scale(1.08); color: inherit; }
    }
    .is-counting { animation: count-pulse 0.35s ease-out; }

    /* --- Bar fill animation (smooth transition) --- */
    .rm-metric-bar > span,
    .pp-or-mini-fill,
    .rs-card .rs-bar .rs-pos,
    .rs-card .rs-bar .rs-neg,
    .factor-bar-inner {
        transition: width 1.2s cubic-bezier(0.4,0,0.2,1);
    }
    .rm-metric-bar > span.animating-bar,
    .pp-or-mini-fill.animating-bar,
    .rs-bar .rs-pos.animating-bar,
    .rs-bar .rs-neg.animating-bar {
        animation: bar-glow 0.6s ease-out;
    }
    @keyframes bar-glow {
        0%   { box-shadow: 0 0 0 rgba(15,118,110,0); }
        50%  { box-shadow: 0 0 12px rgba(15,118,110,0.45); }
        100% { box-shadow: 0 0 0 rgba(15,118,110,0); }
    }

    /* --- Table row stagger slide-in --- */
    @keyframes row-slide-in {
        from { opacity: 0; transform: translateX(-20px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    .pp-table tbody tr.row-animate,
    .rm-table tr.row-animate {
        opacity: 0;
        animation: row-slide-in 0.5s cubic-bezier(0.25,0.46,0.45,0.94) forwards;
    }

    /* --- Top 1/2/3 medal shine --- */
    @keyframes medal-shine {
        0%, 100% { box-shadow: 0 0 0 rgba(245,158,11,0); }
        50%      { box-shadow: 0 0 12px rgba(245,158,11,0.6); }
    }
    .pp-rank.gold,
    .pp-rank.silver,
    .pp-rank.bronze {
        animation: medal-shine 2.5s ease-in-out infinite;
        position: relative;
        overflow: hidden;
    }
    .pp-rank.gold   { animation-delay: 0s;   }
    .pp-rank.silver { animation-delay: 0.4s; }
    .pp-rank.bronze { animation-delay: 0.8s; }

    /* --- Section title slide & icon spin on view --- */
    @keyframes icon-bounce {
        0%, 100% { transform: translateY(0); }
        25%      { transform: translateY(-3px); }
        75%      { transform: translateY(2px); }
    }
    .section-title.is-visible i { animation: icon-bounce 1.4s ease-in-out 0.4s 1; }

    /* --- Region card row hover-glow --- */
    .rm-table tr {
        transition: transform 0.25s ease;
    }
    .rm-table tr:hover {
        transform: translateX(4px);
    }
    .rm-table tr:hover td {
        background: #f0fafa !important;
    }

    /* --- YoY arrow throb --- */
    @keyframes arrow-throb {
        0%, 100% { transform: translateY(0); opacity: 1; }
        50%      { transform: translateY(-2px); opacity: 0.85; }
    }
    .pp-yoy.up::first-letter,
    .pp-yoy.down::first-letter {
        display: inline-block;
        animation: arrow-throb 1.6s ease-in-out infinite;
    }

    /* --- Hero norm-item count effect --- */
    @keyframes norm-fade-up {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .li-hero.is-visible .li-norm-item {
        animation: norm-fade-up 0.5s ease-out both;
    }
    .li-hero.is-visible .li-norm-item:nth-child(1) { animation-delay: 0.4s; }
    .li-hero.is-visible .li-norm-item:nth-child(2) { animation-delay: 0.55s; }
    .li-hero.is-visible .li-norm-item:nth-child(3) { animation-delay: 0.7s; }

    /* --- Sentiment summary breath --- */
    @keyframes summary-breath {
        0%, 100% { box-shadow: 0 2px 6px rgba(15,118,110,0.08); }
        50%      { box-shadow: 0 4px 18px rgba(15,118,110,0.20); }
    }
    .rs-summary { animation: summary-breath 3.5s ease-in-out infinite; }

    /* --- Forecast card spotlight --- */
    @keyframes forecast-glow {
        0%, 100% { background: linear-gradient(135deg,#fffbeb,#fff); }
        50%      { background: linear-gradient(135deg,#fef3c7,#fffaf0); }
    }
    .lt-stat.forecast { animation: forecast-glow 4s ease-in-out infinite; }

    /* --- Smooth scroll behavior --- */
    html { scroll-behavior: smooth; }

    /* --- Section title underline grow --- */
    .section-title.scroll-animate-left.is-visible::after {
        content: '';
        display: block;
        width: 0;
        height: 3px;
        background: linear-gradient(90deg,#0f766e,#5eead4);
        margin-top: 6px;
        animation: title-underline 0.8s ease-out 0.3s forwards;
        border-radius: 2px;
    }
    @keyframes title-underline {
        to { width: 80px; }
    }

    /* --- Reduced motion --- */
    @media (prefers-reduced-motion: reduce) {
        * { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
    }

    /* ========================================================
       [v2-D] Tier Battle Cards
       ======================================================== */
    .tier-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px;
        margin-bottom: 16px;
    }
    .tier-card {
        background: #fff;
        border-radius: 14px;
        padding: 18px 22px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        border-left: 5px solid #0f766e;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .tier-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(15,118,110,0.18);
    }
    .tier-card.minor { border-left-color: #94a3b8; }
    .tier-card .t-label {
        font-size: 0.78em; color: #64748b;
        text-transform: uppercase; font-weight: 700;
    }
    .tier-card .t-value {
        font-size: 1.9em; font-weight: 800; color: #0f766e;
        line-height: 1; margin-top: 6px;
    }
    .tier-card.minor .t-value { color: #475569; }
    .tier-card .t-share {
        font-size: 0.85em; color: #64748b; margin-top: 4px;
    }
    .tier-card .t-yoy {
        display: inline-block;
        margin-top: 8px;
        padding: 4px 12px;
        border-radius: 14px;
        font-weight: 800; font-size: 0.82em;
    }
    .tier-card .t-yoy.up   { background: #dcfce7; color: #059669; }
    .tier-card .t-yoy.down { background: #fee2e2; color: #dc2626; }

    /* ========================================================
       [v2-E] Google Trends Radar — supplementary cards
       ======================================================== */
    .gt-insight {
        display: flex; gap: 14px; flex-wrap: wrap;
        margin-bottom: 14px;
    }
    .gt-insight-card {
        flex: 1; min-width: 200px;
        background: linear-gradient(135deg,#f0fdfa,#fff);
        border: 1px solid #99f6e4;
        border-radius: 12px;
        padding: 14px 18px;
    }
    .gt-insight-card.price {
        background: linear-gradient(135deg,#fef3c7,#fff);
        border-color: #fcd34d;
    }
    .gt-insight-card .gi-label {
        font-size: 0.78em; color: #64748b;
        font-weight: 700; text-transform: uppercase;
    }
    .gt-insight-card .gi-value {
        font-size: 1.6em; font-weight: 800;
        color: #0f766e; line-height: 1; margin-top: 4px;
    }
    .gt-insight-card.price .gi-value { color: #b45309; }
    .gt-insight-card .gi-note {
        font-size: 0.78em; color: #64748b; margin-top: 4px;
    }

    /* ========================================================
       [v2-F] CCI Regional cards (mini)
       ======================================================== */
    .cci-region-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 12px;
        margin-bottom: 14px;
    }
    .cci-region-card {
        background: #fff;
        border-radius: 12px;
        padding: 14px 16px;
        border: 1px solid #e8f0f0;
        border-top: 4px solid #3eabae;
        position: relative;
        transition: transform 0.3s ease;
    }
    .cci-region-card:hover { transform: translateY(-3px); }
    .cci-region-card .cr-region {
        font-weight: 800;
        color: #1a3a3c;
        font-size: 0.92em;
        margin-bottom: 6px;
    }
    .cci-region-card .cr-value {
        font-size: 1.7em;
        font-weight: 800;
        color: #0f766e;
        line-height: 1;
    }
    .cci-region-card .cr-prev {
        font-size: 0.78em;
        color: #94a3b8;
        margin-top: 2px;
    }
    .cci-region-card .cr-delta {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.78em;
        margin-top: 6px;
    }
    .cci-region-card .cr-delta.up   { background: #dcfce7; color: #059669; }
    .cci-region-card .cr-delta.down { background: #fee2e2; color: #dc2626; }
    .cci-region-card .cr-delta.flat { background: #f1f5f9; color: #64748b; }

    /* ========================================================
       [v2-G/H/J/K] Activity Dashboard (TAT.ACTIVITY)
       ======================================================== */
    .act-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
        margin-bottom: 16px;
    }
    .act-stat {
        background: linear-gradient(135deg,#fff,#f0fdfa);
        border-radius: 12px;
        padding: 16px 18px;
        border: 1px solid #99f6e4;
        border-left: 4px solid #0f766e;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .act-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(15,118,110,0.15);
    }
    .act-stat::after {
        content: '';
        position: absolute;
        right: -20px; top: -20px;
        width: 80px; height: 80px;
        background: radial-gradient(circle, rgba(20,184,166,0.15), transparent 70%);
        border-radius: 50%;
    }
    .act-stat .a-icon {
        width: 38px; height: 38px;
        background: #ccfbf1; color: #0f766e;
        border-radius: 10px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 1.2em;
        margin-bottom: 8px;
    }
    .act-stat.active   { border-left-color: #f59e0b; background: linear-gradient(135deg,#fff,#fffbeb); }
    .act-stat.active .a-icon { background: #fef3c7; color: #d97706; }
    .act-stat.upcoming { border-left-color: #14b8a6; background: linear-gradient(135deg,#fff,#f0fdfa); }
    .act-stat.upcoming .a-icon { background: #ccfbf1; color: #0f766e; }
    .act-stat.yoy      { border-left-color: #059669; background: linear-gradient(135deg,#fff,#f0fdf4); }
    .act-stat.yoy .a-icon { background: #d1fae5; color: #059669; }
    .act-stat .a-label {
        font-size: 0.78em; color: #64748b;
        font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .act-stat .a-value {
        font-size: 2em; font-weight: 800;
        color: #0f766e; line-height: 1;
        margin-top: 4px;
    }
    .act-stat.active .a-value   { color: #d97706; }
    .act-stat.upcoming .a-value { color: #0f766e; }
    .act-stat.yoy .a-value      { color: #059669; }
    .act-stat .a-note {
        font-size: 0.78em; color: #64748b; margin-top: 4px;
    }
    .act-stat .a-yoy {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 10px;
        font-weight: 800; font-size: 0.78em;
        margin-top: 6px;
    }
    .act-stat .a-yoy.up   { background: #dcfce7; color: #059669; }
    .act-stat .a-yoy.down { background: #fee2e2; color: #dc2626; }

    /* Upcoming events list */
    .act-upcoming-list {
        list-style: none;
        padding: 0; margin: 0;
    }
    .act-upcoming-list li {
        background: #fff;
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 8px;
        border: 1px solid #e8f0f0;
        border-left: 4px solid #14b8a6;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.25s, box-shadow 0.25s;
    }
    .act-upcoming-list li:hover {
        transform: translateX(6px);
        box-shadow: 0 4px 14px rgba(15,118,110,0.12);
    }
    .act-upcoming-list .au-date {
        background: linear-gradient(135deg,#0f766e,#14b8a6);
        color: #fff;
        border-radius: 8px;
        padding: 8px 12px;
        text-align: center;
        min-width: 64px;
        font-weight: 800;
    }
    .act-upcoming-list .au-date .au-day {
        font-size: 1.4em; line-height: 1;
    }
    .act-upcoming-list .au-date .au-month {
        font-size: 0.7em; opacity: 0.85;
    }
    .act-upcoming-list .au-info {
        flex: 1;
        min-width: 0;
    }
    .act-upcoming-list .au-name {
        font-weight: 800; color: #1a3a3c;
        font-size: 0.95em;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .act-upcoming-list .au-meta {
        font-size: 0.78em; color: #64748b; margin-top: 2px;
    }
    .act-upcoming-list .au-meta .au-tag {
        display: inline-block;
        padding: 1px 8px;
        background: #f1f5f9; border-radius: 8px;
        margin-right: 4px;
        color: #475569; font-weight: 700;
    }
    .act-upcoming-list .au-countdown {
        background: #ccfbf1;
        color: #0f766e;
        border-radius: 8px;
        padding: 4px 10px;
        font-weight: 800; font-size: 0.85em;
        white-space: nowrap;
    }

    /* Active Now badge (live) */
    .act-live-banner {
        background: linear-gradient(135deg,#fef3c7,#fffbeb);
        border: 1px solid #fcd34d;
        border-left: 4px solid #d97706;
        border-radius: 12px;
        padding: 12px 18px;
        margin-bottom: 14px;
        display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
    }
    .act-live-dot {
        width: 11px; height: 11px;
        background: #d97706;
        border-radius: 50%;
        animation: pulse-dot 1.4s ease-in-out infinite;
    }
    .act-live-banner b { color: #92400e; }
    .act-live-banner .alb-list {
        font-size: 0.85em; color: #78350f;
        flex: 1; min-width: 0;
    }

    /* Type chip */
    .act-type-chip {
        display: inline-block;
        padding: 3px 10px;
        background: #ccfbf1;
        color: #0f766e;
        border-radius: 12px;
        font-size: 0.78em; font-weight: 700;
        margin-right: 4px;
    }

    /* Events column highlight (Top 10 + Region) */
    .pp-events {
        font-weight: 800; color: #0f766e;
    }
    .pp-events.zero { color: #cbd5e1; }
    .pp-events i { margin-right: 3px; }

    /* ========================================================
       [v2-M] Activity Impact Analysis
       ======================================================== */
    .mim-hero {
        background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 60%, #c4b5fd 100%);
        color: #fff;
        border-radius: 16px;
        padding: 22px 28px;
        margin-bottom: 18px;
        box-shadow: 0 6px 24px rgba(109,40,217,0.25);
        position: relative;
        overflow: hidden;
    }
    .mim-hero::after {
        content: '';
        position: absolute;
        right: -50px; top: -50px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .mim-hero-row {
        display: flex; align-items: center;
        justify-content: space-between;
        gap: 24px; flex-wrap: wrap;
        position: relative; z-index: 1;
    }
    .mim-hero .mim-label {
        font-size: 0.82em; opacity: 0.85;
        text-transform: uppercase; font-weight: 700; letter-spacing: 1px;
    }
    .mim-hero .mim-r-value {
        font-size: 3.4em; font-weight: 800;
        line-height: 1; margin-top: 6px;
    }
    .mim-hero .mim-strength {
        display: inline-block;
        background: rgba(255,255,255,0.22);
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 800; font-size: 0.9em;
        margin-top: 8px;
    }
    .mim-hero .mim-desc {
        font-size: 0.88em; opacity: 0.92;
        margin-top: 10px; max-width: 540px; line-height: 1.6;
    }
    .mim-hero .mim-formula {
        background: rgba(255,255,255,0.18);
        border-radius: 12px;
        padding: 14px 20px;
        font-size: 0.92em;
    }
    .mim-hero .mim-formula b {
        font-size: 1.5em; display: block; margin: 4px 0;
    }

    /* KPI cards */
    .mim-kpi {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 14px;
        margin-bottom: 16px;
    }
    .mim-kpi-card {
        background: #fff;
        border-radius: 12px;
        padding: 16px 18px;
        border: 1px solid #e8f0f0;
        border-left: 4px solid #8b5cf6;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .mim-kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(139,92,246,0.15);
    }
    .mim-kpi-card.high { border-left-color: #059669; }
    .mim-kpi-card.low  { border-left-color: #94a3b8; }
    .mim-kpi-card.lift { border-left-color: #d97706; background: linear-gradient(135deg,#fff,#fffbeb); }
    .mim-kpi-card .k-label {
        font-size: 0.78em; color: #64748b;
        font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px;
    }
    .mim-kpi-card .k-value {
        font-size: 1.7em; font-weight: 800;
        color: #6d28d9; line-height: 1; margin-top: 4px;
    }
    .mim-kpi-card.high .k-value { color: #059669; }
    .mim-kpi-card.low  .k-value { color: #475569; }
    .mim-kpi-card.lift .k-value { color: #d97706; }
    .mim-kpi-card .k-unit {
        font-size: 0.5em; color: #94a3b8; font-weight: 600;
    }
    .mim-kpi-card .k-note {
        font-size: 0.78em; color: #64748b; margin-top: 6px;
        line-height: 1.4;
    }
    .mim-kpi-card .k-months {
        margin-top: 6px;
    }
    .mim-kpi-card .k-month-tag {
        display: inline-block;
        background: #f1f5f9;
        color: #475569;
        padding: 2px 8px;
        border-radius: 8px;
        font-size: 0.72em; font-weight: 700;
        margin: 2px 2px 0 0;
    }
    .mim-kpi-card.high .k-month-tag { background: #dcfce7; color: #047857; }
    .mim-kpi-card.low  .k-month-tag { background: #f1f5f9; color: #64748b; }

    /* Insight callout */
    .mim-insight {
        background: linear-gradient(135deg, #ede9fe 0%, #fef3c7 100%);
        border: 1px solid #c4b5fd;
        border-left: 5px solid #8b5cf6;
        border-radius: 12px;
        padding: 14px 20px;
        margin-bottom: 16px;
        font-size: 0.92em; color: #4c1d95;
        line-height: 1.6;
    }
    .mim-insight i { color: #8b5cf6; margin-right: 6px; }
    .mim-insight b { color: #5b21b6; }

    /* MIM filter dropdown */
    .mim-filter-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #fff;
        border: 1px solid #e8f0f0;
        border-left: 4px solid #8b5cf6;
        border-radius: 12px;
        padding: 12px 18px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }
    .mim-filter-bar label {
        font-weight: 800; color: #1a3a3c;
        font-size: 0.92em; margin: 0;
    }
    .mim-filter-bar label i { color: #8b5cf6; margin-right: 6px; }
    .mim-filter-bar select {
        flex: 1; min-width: 200px;
        padding: 8px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-family: inherit;
        font-size: 0.95em;
        font-weight: 600;
        color: #1a3a3c;
        background: #f8fafc;
        transition: all 0.2s;
        cursor: pointer;
    }
    .mim-filter-bar select:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139,92,246,0.15);
        background: #fff;
    }
    .mim-filter-bar .mim-current-tag {
        background: linear-gradient(135deg,#ede9fe,#fdf4ff);
        color: #6d28d9;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 0.85em;
        border: 1px solid #c4b5fd;
    }
</style>

<div class="rt-wrapper">

    <!-- Header -->
    <div class="rt-header scroll-animate">
        <div>
            <h2>
                Thai Domestic Tourism Intelligence
                <span style="font-size:0.55em; background:rgba(255,255,255,0.25); padding:3px 10px; border-radius:12px; margin-left:8px; vertical-align:middle;">v2 · Leading Indicators</span>
            </h2>
            <div class="subtitle">วิเคราะห์ปัจจัยที่ส่งผลต่อจำนวนนักท่องเที่ยวชาวไทย </div>
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
        <i class="fas fa-sliders-h" style="color:#0f766e;"></i>
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
            <i class="fas fa-chart-area" style="color:#0f766e;"></i>
            แนวโน้มจำนวนการเดินทาง vs นักท่องเที่ยว (ก.พ.68 - มี.ค.69)
            <span class="data-badge">Data</span>
        </div>
        <div id="chart_trend" style="height: 360px;"></div>
    </div>

    <!-- Section 4: Correlation Bar -->
    <div class="chart-panel scroll-animate">
        <div class="panel-title">
            <i class="fas fa-exchange-alt" style="color:#0f766e;"></i>
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
                    <i class="fas fa-chart-line" style="color:#0f766e;"></i>
                    ราคาน้ำมัน 95 vs อัตราเข้าพัก (ก.พ.68 - มี.ค.69) <span class="data-badge">Data</span>
                </div>
                <div id="chart_scatter" style="height: 310px;"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-panel">
                <div class="panel-title">
                    <i class="fas fa-wave-square" style="color:#0f766e;"></i>
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

    <!-- =============================================================
         [v2-C] Long-term Recovery Trend (2562-2568P)
         ============================================================= -->
    <div class="section-title scroll-animate-left" style="margin-top: 28px;">
        <i class="fas fa-chart-line" style="color:#0f766e;"></i>
        Long-term Recovery &mdash; ผู้เยี่ยมเยือนชาวไทย 7 ปี (2562-2568P)
        <span class="data-badge">Data</span>
    </div>

    <div class="lt-summary scroll-animate">
        <div class="lt-stat">
            <div class="lt-label">2568P · ทั้งประเทศ</div>
            <div class="lt-value"><?= number_format(end($lt_total) / 1000000, 1) ?><span class="lt-unit"> M คน</span></div>
            <div class="lt-note">สูงสุดในรอบ 7 ปี · YoY +<?= end($lt_yoy) ?>%</div>
        </div>
        <div class="lt-stat dip">
            <div class="lt-label">2564 · จุดต่ำสุด (COVID)</div>
            <div class="lt-value"><?= number_format($lt_total[2] / 1000000, 1) ?><span class="lt-unit"> M คน</span></div>
            <div class="lt-note">ตกจากปี 2562 -<?= round(($lt_total[0]-$lt_total[2])/$lt_total[0]*100, 1) ?>%</div>
        </div>
        <div class="lt-stat recover">
            <div class="lt-label">Recovery Index</div>
            <div class="lt-value"><?= round(end($lt_total) / $lt_total[0] * 100, 1) ?><span class="lt-unit"> %</span></div>
            <div class="lt-note">เทียบ Pre-COVID (2562 = 100%)</div>
        </div>
        <div class="lt-stat forecast">
            <div class="lt-label">Forecast 2569 (Linear)</div>
            <div class="lt-value"><?= number_format($lt_forecast_2569 / 1000000, 1) ?><span class="lt-unit"> M คน</span></div>
            <div class="lt-note">YoY <?= $lt_forecast_yoy >= 0 ? '+' : '' ?><?= $lt_forecast_yoy ?>% · ประมาณการเชิงเส้น 4 ปีหลัง</div>
        </div>
    </div>

    <div class="chart-panel scroll-animate">
        <div class="panel-title">
            <i class="fas fa-mountain" style="color:#0f766e;"></i>
            COVID Dip → Recovery Curve (ทั้งประเทศ vs 22 เมืองหลัก vs 55 เมืองรอง)
            <span class="data-badge">Data</span>
        </div>
        <div id="chartLongTerm" style="height: 380px;"></div>
        <div class="lt-milestones">
            <?php foreach ($lt_milestones as $ms):
                $cls = '';
                if (strpos($ms['label'],'COVID')!==false || strpos($ms['label'],'Peak')!==false) $cls = 'dip';
                elseif (strpos($ms['label'],'Reopening')!==false) $cls = 'recover';
                elseif (strpos($ms['label'],'Pre-COVID')!==false) $cls = 'peak';
            ?>
            <span class="lt-milestone <?= $cls ?>"><b><?= $lt_years[$ms['year_idx']] ?></b> · <?= $ms['label'] ?> · <?= $ms['note'] ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- =============================================================
         [v2-B] 6 Region Master Table
         ============================================================= -->
    <div class="section-title scroll-animate-left" style="margin-top: 28px;">
        <i class="fas fa-table-cells-large" style="color:#0f766e;"></i>
        6 Region Master &mdash; ภาพรวมรายภาค (Cross-Indicator)
        <span class="data-badge">Data · <?= $region_master_period ?></span>
    </div>

    <div class="chart-panel scroll-animate" style="overflow-x:auto;">
        <table class="rm-table">
            <thead>
                <tr>
                    <th>ภาค</th>
                    <th>ผู้เยี่ยมเยือน 2568P</th>
                    <th>YoY</th>
                    <th>OR (เฉลี่ย)</th>
                    <th>CCI ก.พ.69</th>
                    <th>Sentiment ธ.ค.68</th>
                    <th>Active Events <?= $act_year_thai ?? '' ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $maxVisitors = max(array_column($region_master, 'visitors'));
                    $maxOr       = 100;
                    foreach ($region_master as $rm):
                        $vis_pct = round($rm['visitors'] / $maxVisitors * 100, 1);
                        $or_pct  = round($rm['or'] / $maxOr * 100, 1);
                        $cci_cls = $rm['cci'] >= 53 ? 'high' : ($rm['cci'] >= 51 ? 'mid' : 'low');
                        $pos_cls = $rm['pos_pct'] >= 95 ? 'high' : ($rm['pos_pct'] >= 90 ? 'mid' : 'low');
                ?>
                <tr style="border-left-color: <?= $rm['color'] ?>;">
                    <td style="border-left: 4px solid <?= $rm['color'] ?>;"><?= $rm['name'] ?></td>
                    <td>
                        <strong><?= number_format($rm['visitors'] / 1000000, 1) ?>M</strong>
                        <span class="rm-metric-bar"><span style="width:<?= $vis_pct ?>%; background:<?= $rm['color'] ?>;"></span></span>
                    </td>
                    <td>
                        <span class="pp-yoy <?= $rm['yoy'] >= 0 ? 'up' : 'down' ?>">
                            <?= $rm['yoy'] >= 0 ? '▲ +' : '▼ ' ?><?= number_format($rm['yoy'], 2) ?>%
                        </span>
                    </td>
                    <td>
                        <strong><?= number_format($rm['or'], 2) ?>%</strong>
                        <span class="rm-metric-bar"><span style="width:<?= $or_pct ?>%; background: linear-gradient(90deg,#14b8a6,#0f766e);"></span></span>
                    </td>
                    <td>
                        <span class="rm-cci-pill <?= $cci_cls ?>"><?= number_format($rm['cci'], 1) ?></span>
                        <?php if ($rm['cci_note']): ?><span class="rm-proxy-note"><?= $rm['cci_note'] ?></span><?php endif; ?>
                    </td>
                    <td>
                        <strong class="rm-pos-pct <?= $pos_cls ?>"><?= number_format($rm['pos_pct'], 2) ?>%</strong>
                        <?php if ($rm['mentions']): ?>
                            <div style="font-size:0.78em;color:#94a3b8;"><?= number_format($rm['mentions']/1000000, 1) ?>M mentions</div>
                        <?php endif; ?>
                        <?php if ($rm['sentiment_note']): ?><span class="rm-proxy-note"><?= $rm['sentiment_note'] ?></span><?php endif; ?>
                    </td>
                    <td>
                        <?php $evt = $rm['events'] ?? 0; ?>
                        <span class="pp-events <?= $evt == 0 ? 'zero' : '' ?>">
                            <i class="fas fa-calendar-check"></i><?= number_format($evt) ?>
                        </span>
                        <?php if ($evt > 0 && !empty($rm['events_per_mil'])): ?>
                            <div style="font-size:0.72em;color:#94a3b8;margin-top:2px;"><?= $rm['events_per_mil'] ?> /M visitors</div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- =============================================================
         [v2-A] Top 10 Provincial Performance
         ============================================================= -->
    <div class="section-title scroll-animate-left" style="margin-top: 28px;">
        <i class="fas fa-trophy" style="color:#0f766e;"></i>
        Top 10 จังหวัด ผู้เยี่ยมเยือนสูงสุด
        <span class="data-badge">Data · <?= $top_provinces_period ?></span>
    </div>

    <div class="chart-panel scroll-animate" style="overflow-x:auto;">
        <table class="pp-table">
            <thead>
                <tr>
                    <th>จังหวัด</th>
                    <th>เมือง</th>
                    <th>ผู้เยี่ยมเยือน 2568P</th>
                    <th>YoY</th>
                    <th>Occupancy Rate</th>
                    <th>Events <?= $act_year_thai ?? '' ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($top_provinces as $idx => $p):
                    $tier_cls = $p['tier'] === '22 เมืองหลัก' ? 'tier-main' : 'tier-minor';
                    $rank = $idx + 1;
                    $rank_cls = $rank == 1 ? 'gold' : ($rank == 2 ? 'silver' : ($rank == 3 ? 'bronze' : ''));
                    $tier_badge = $p['tier'] === '22 เมืองหลัก' ? 'main' : 'minor';
                    $tier_label = $p['tier'] === '22 เมืองหลัก' ? 'หลัก' : 'รอง';
                ?>
                <tr class="<?= $tier_cls ?>">
                    <td>
                        <span class="pp-rank <?= $rank_cls ?>"><?= $rank ?></span>
                        <?= $p['name'] ?>
                        <span class="pp-tier-badge <?= $tier_badge ?>"><?= $tier_label ?></span>
                    </td>
                    <td><?= $p['region'] ?></td>
                    <td><strong><?= number_format($p['visitors']) ?></strong></td>
                    <td>
                        <span class="pp-yoy <?= $p['yoy'] >= 0 ? 'up' : 'down' ?>">
                            <?= $p['yoy'] >= 0 ? '▲ +' : '▼ ' ?><?= number_format($p['yoy'], 2) ?>%
                        </span>
                    </td>
                    <td>
                        <span class="pp-or-mini">
                            <span class="pp-or-mini-fill" style="width:<?= $p['or'] ?? 0 ?>%;"></span>
                        </span>
                        <strong><?= $p['or'] !== null ? number_format($p['or'], 2).'%' : '-' ?></strong>
                    </td>
                    <td>
                        <?php $evt = $p['events'] ?? 0; ?>
                        <span class="pp-events <?= $evt == 0 ? 'zero' : '' ?>">
                            <i class="fas fa-calendar-check"></i><?= number_format($evt) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (!empty($act_corr_visitors)): ?>
        <div style="margin-top:10px;font-size:0.85em;color:#64748b;">
            <i class="fas fa-link" style="color:#0f766e;"></i>
            Pearson r (Events vs Visitors): <strong style="color:#0f766e;"><?= number_format($act_corr_visitors, 2) ?></strong>
            &mdash; <?php if (abs($act_corr_visitors) >= 0.7) echo 'ความสัมพันธ์สูง';
                       elseif (abs($act_corr_visitors) >= 0.4) echo 'ความสัมพันธ์ปานกลาง';
                       else echo 'ความสัมพันธ์ต่ำ'; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- =============================================================
         [v2-D] Tier Battle — 22 เมืองหลัก vs 55 เมืองรอง
         ============================================================= -->
    <div class="section-title scroll-animate-left" style="margin-top: 28px;">
        <i class="fas fa-shield-halved" style="color:#0f766e;"></i>
        Tier Battle &mdash; 22 เมืองหลัก vs 55 เมืองรอง (รายเดือน 2568P)
        <span class="data-badge">Data</span>
    </div>

    <div class="tier-cards scroll-animate">
        <div class="tier-card">
            <div class="t-label">22 เมืองหลัก · 2568P</div>
            <div class="t-value"><?= number_format($tier_main_total/1000000, 1) ?>M<span style="font-size:0.45em;color:#94a3b8;font-weight:600;"> คน</span></div>
            <div class="t-share">ส่วนแบ่ง <strong><?= $tier_main_share ?>%</strong> ของตลาดในประเทศ</div>
            <span class="t-yoy <?= $tier_main_yoy >= 0 ? 'up' : 'down' ?>">
                <?= $tier_main_yoy >= 0 ? '▲ +' : '▼ ' ?><?= $tier_main_yoy ?>% YoY
            </span>
        </div>
        <div class="tier-card minor">
            <div class="t-label">55 เมืองรอง · 2568P</div>
            <div class="t-value"><?= number_format($tier_minor_total/1000000, 1) ?>M<span style="font-size:0.45em;color:#94a3b8;font-weight:600;"> คน</span></div>
            <div class="t-share">ส่วนแบ่ง <strong><?= $tier_minor_share ?>%</strong> ของตลาดในประเทศ</div>
            <span class="t-yoy <?= $tier_minor_yoy >= 0 ? 'up' : 'down' ?>">
                <?= $tier_minor_yoy >= 0 ? '▲ +' : '▼ ' ?><?= $tier_minor_yoy ?>% YoY
            </span>
        </div>
        <div class="tier-card" style="border-left-color:#14b8a6;">
            <div class="t-label">Growth Gap</div>
            <div class="t-value" style="color:#14b8a6;"><?= ($tier_minor_yoy - $tier_main_yoy) >= 0 ? '+' : '' ?><?= number_format($tier_minor_yoy - $tier_main_yoy, 2) ?>%</div>
            <div class="t-share">เมืองรองโต<?= $tier_minor_yoy > $tier_main_yoy ? 'เร็วกว่า' : 'ช้ากว่า' ?>เมืองหลัก</div>
            <div style="font-size:0.78em;color:#94a3b8;margin-top:4px;">YoY 2568 vs 2567</div>
        </div>
    </div>

    <div class="chart-panel scroll-animate">
        <div class="panel-title">
            <i class="fas fa-layer-group" style="color:#0f766e;"></i>
            สัดส่วนรายเดือน (Stacked) + Ratio % เมืองหลัก
            <span class="data-badge">Data</span>
        </div>
        <div id="chartTier" style="height: 360px;"></div>
    </div>

    <!-- =============================================================
         [v2-E] Google Trends Radar — 5 keywords
         ============================================================= -->
    <div class="section-title scroll-animate-left" style="margin-top: 28px;">
        <i class="fas fa-magnifying-glass-chart" style="color:#0f766e;"></i>
        Google Trends &mdash; Search Intent (5 keywords ท่องเที่ยว)
        <span class="data-badge">Data · <?= $gt_kw_period ?></span>
    </div>

    <div class="gt-insight scroll-animate">
        <div class="gt-insight-card">
            <div class="gi-label"><i class="fas fa-mountain-sun"></i> Leisure Search Avg</div>
            <div class="gi-value"><?= $gt_leisure_avg ?></div>
            <div class="gi-note">ที่เที่ยว · ที่พัก · คาเฟ่ (เฉลี่ย)</div>
        </div>
        <div class="gt-insight-card price">
            <div class="gi-label"><i class="fas fa-tags"></i> Price-sensitive Search Avg</div>
            <div class="gi-value"><?= $gt_price_avg ?></div>
            <div class="gi-note">ตั๋วราคาถูก · ที่พักราคาถูก (เฉลี่ย)</div>
        </div>
        <div class="gt-insight-card" style="background: linear-gradient(135deg,#ccfbf1,#fff);border-color:#5eead4;">
            <div class="gi-label" style="color:#0f766e;"><i class="fas fa-arrows-down-to-line"></i> Total Avg (ล่าสุด)</div>
            <div class="gi-value" style="color:#0f766e;"><?= $gt_latest ?></div>
            <div class="gi-note"><?= $gt_latest_month ?> · YoY <?= $gt_delta >= 0 ? '+' : '' ?><?= $gt_delta ?> MoM</div>
        </div>
    </div>

    <!-- Filter: เลือกเดือนสำหรับ Radar -->
    <div class="mim-filter-bar scroll-animate" style="border-left-color:#0f766e;">
        <label for="gt-month-select"><i class="fas fa-filter" style="color:#0f766e;"></i> เลือกเดือน:</label>
        <select id="gt-month-select">
            <?php foreach ($gt_radar_options as $opt): ?>
                <option value="<?= $opt['key'] ?>" <?= $opt['key'] === $gt_radar_default ? 'selected' : '' ?>>
                    <?= $opt['label'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="mim-current-tag" id="gt-current-tag" style="background:linear-gradient(135deg,#ccfbf1,#f0fdfa);color:#0f766e;border-color:#5eead4;">
            <i class="fas fa-eye"></i> <span id="gt-current-label">—</span>
        </span>
    </div>

    <div class="row scroll-animate">
        <div class="col-lg-7 mb-3">
            <div class="chart-panel" style="height:100%;">
                <div class="panel-title">
                    <i class="fas fa-chart-pie" style="color:#0f766e;"></i>
                    Radar Chart &mdash; <span id="gt-radar-title">ปัจจุบัน vs ปีก่อน vs 2 ปีก่อน</span>
                </div>
                <div id="chartGtRadar" style="height: 400px;"></div>
            </div>
        </div>
        <div class="col-lg-5 mb-3">
            <div class="chart-panel" style="height:100%;">
                <div class="panel-title">
                    <i class="fas fa-table-list" style="color:#0f766e;"></i>
                    YoY Change รายคำค้น &mdash; <span id="gt-table-title">—</span>
                </div>
                <table class="rm-table" style="margin-top:8px;">
                    <thead>
                        <tr>
                            <th>Keyword</th>
                            <th id="gt-th-current">—</th>
                            <th>YoY</th>
                        </tr>
                    </thead>
                    <tbody id="gt-yoy-tbody">
                        <!-- JS populates -->
                    </tbody>
                </table>
                <div id="gt-no-data" style="display:none;text-align:center;color:#94a3b8;padding:40px 0;">
                    <i class="fas fa-circle-info" style="font-size:1.6em;color:#cbd5e1;"></i>
                    <div style="margin-top:6px;">ไม่มีข้อมูลย้อนหลังสำหรับเดือนที่เลือก</div>
                </div>
            </div>
        </div>
    </div>

    <!-- =============================================================
         [v2-F] CCI Regional Heat — 5 ภาค
         ============================================================= -->
    <div class="section-title scroll-animate-left" style="margin-top: 28px;">
        <i class="fas fa-map" style="color:#0f766e;"></i>
        CCI Regional &mdash; ดัชนีความเชื่อมั่นผู้บริโภค รายภาค
        <span class="data-badge">Data · <?= $cci_regions_period ?></span>
    </div>

    <div class="cci-region-grid scroll-animate">
        <?php foreach ($cci_regions as $cr):
            $cls = $cr['delta'] > 0 ? 'up' : ($cr['delta'] < 0 ? 'down' : 'flat');
            $sym = $cr['delta'] > 0 ? '▲ +' : ($cr['delta'] < 0 ? '▼ ' : '');
        ?>
        <div class="cci-region-card" style="border-top-color: <?= $cr['color'] ?>;">
            <div class="cr-region"><?= $cr['region'] ?></div>
            <div class="cr-value"><?= $cr['feb'] ?></div>
            <div class="cr-prev">ม.ค. <?= $cr['jan'] ?> → ก.พ. <?= $cr['feb'] ?></div>
            <span class="cr-delta <?= $cls ?>"><?= $sym . number_format(abs($cr['delta']), 1) ?> MoM</span>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="chart-panel scroll-animate">
        <div class="panel-title">
            <i class="fas fa-chart-bar" style="color:#0f766e;"></i>
            CCI 5 ภาค &mdash; เปรียบเทียบ ม.ค. vs ก.พ. 2569 (เส้นรวมประเทศ = <?= $cci_national_feb ?>)
            <span class="data-badge">Data</span>
        </div>
        <div id="chartCciRegion" style="height: 360px;"></div>
    </div>

    <!-- =============================================================
         [v2-G/H/J/K] Activity Dashboard (TAT.ACTIVITY)
         ============================================================= -->
    <div class="section-title scroll-animate-left" style="margin-top: 28px;">
        <i class="fas fa-calendar-days" style="color:#0f766e;"></i>
        Tourism Activity &mdash; กิจกรรมการท่องเที่ยวรายจังหวัด
        <span class="data-badge">DB · TAT.ACTIVITY (<?= $act_year_thai ?>)</span>
    </div>

    <?php if (!empty($act_active_now['count']) && $act_active_now['count'] > 0): ?>
    <div class="act-live-banner scroll-animate">
        <span class="act-live-dot"></span>
        <b>LIVE NOW · <?= number_format($act_active_now['count']) ?> กิจกรรม</b>
        <span class="alb-list">
            <?php
                $names = array_map(function($a){
                    return htmlspecialchars($a['ACT_NAME_TH'] ?? '') . ' (' . htmlspecialchars($a['PROVINCE'] ?? '-') . ')';
                }, $act_active_now['list'] ?? []);
                echo implode(' · ', array_slice($names, 0, 3));
                if (count($names) > 3) echo ' · +' . (count($names) - 3) . ' more';
            ?>
        </span>
    </div>
    <?php endif; ?>

    <!-- Summary cards -->
    <div class="act-summary scroll-animate">
        <div class="act-stat">
            <div class="a-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="a-label">Total Events <?= $act_year_thai ?></div>
            <div class="a-value"><?= number_format($act_summary['total'] ?? 0) ?></div>
            <div class="a-note">รวมกิจกรรมทั่วประเทศ</div>
        </div>
        <div class="act-stat yoy">
            <div class="a-icon"><i class="fas fa-arrow-trend-up"></i></div>
            <div class="a-label">YoY vs <?= $act_year_thai_prev ?></div>
            <div class="a-value"><?= ($act_summary['yoy'] ?? 0) >= 0 ? '+' : '' ?><?= number_format($act_summary['yoy'] ?? 0, 1) ?>%</div>
            <div class="a-note">ปีก่อน <?= number_format($act_summary['total_prev'] ?? 0) ?> events</div>
        </div>
        <div class="act-stat active">
            <div class="a-icon"><i class="fas fa-bolt"></i></div>
            <div class="a-label">Active Now</div>
            <div class="a-value"><?= number_format($act_active_now['count'] ?? 0) ?></div>
            <div class="a-note">กิจกรรมที่กำลังจัดอยู่</div>
        </div>
        <div class="act-stat upcoming">
            <div class="a-icon"><i class="fas fa-clock"></i></div>
            <div class="a-label">Upcoming Soon</div>
            <div class="a-value"><?= count($act_upcoming) ?></div>
            <div class="a-note">8 รายการถัดไป</div>
        </div>
    </div>

    <!-- H: Calendar Timeline (12 เดือน YoY) -->
    <div class="chart-panel scroll-animate">
        <div class="panel-title">
            <i class="fas fa-chart-column" style="color:#0f766e;"></i>
            Event Calendar Timeline &mdash; รายเดือน <?= $act_year_thai ?> vs <?= $act_year_thai_prev ?>
            <span class="data-badge">DB</span>
        </div>
        <div id="chartActMonth" style="height: 340px;"></div>
    </div>

    <!-- J + K: Type Mix + Upcoming -->
    <div class="row scroll-animate">
        <div class="col-lg-6 mb-3">
            <div class="chart-panel" style="height:100%;">
                <div class="panel-title">
                    <i class="fas fa-chart-pie" style="color:#0f766e;"></i>
                    ประเภทกิจกรรม (Top 10) &mdash; <?= $act_year_thai ?>
                </div>
                <?php if (!empty($act_by_type)): ?>
                    <div id="chartActType" style="height: 340px;"></div>
                <?php else: ?>
                    <div style="text-align:center;color:#94a3b8;padding:60px 0;">
                        <i class="fas fa-database" style="font-size:2em;"></i>
                        <div style="margin-top:8px;">ยังไม่มีข้อมูล (DB อาจเชื่อมต่อไม่ได้)</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="chart-panel" style="height:100%;">
                <div class="panel-title">
                    <i class="fas fa-calendar-plus" style="color:#0f766e;"></i>
                    Upcoming Events &mdash; กิจกรรมใกล้เข้ามา
                </div>
                <?php if (!empty($act_upcoming)): ?>
                <ul class="act-upcoming-list">
                    <?php
                    $months_th = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
                    $today = strtotime(date('Y-m-d'));
                    foreach ($act_upcoming as $u):
                        $start = strtotime($u['START_DATE']);
                        $days_left = max(0, round(($start - $today) / 86400));
                        $d = (int)date('j', $start);
                        $m = (int)date('n', $start);
                    ?>
                    <li>
                        <div class="au-date">
                            <div class="au-day"><?= $d ?></div>
                            <div class="au-month"><?= $months_th[$m] ?></div>
                        </div>
                        <div class="au-info">
                            <div class="au-name"><?= htmlspecialchars($u['ACT_NAME_TH'] ?? '-') ?></div>
                            <div class="au-meta">
                                <span class="au-tag"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($u['PROVINCE'] ?? '-') ?></span>
                                <?php if (!empty($u['TYPE_NAME'])): ?>
                                    <span class="au-tag"><?= htmlspecialchars($u['TYPE_NAME']) ?></span>
                                <?php endif; ?>
                                <?php if (!empty($u['LEVEL_NAME'])): ?>
                                    <span class="au-tag"><?= htmlspecialchars($u['LEVEL_NAME']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="au-countdown">
                            <?php if ($days_left == 0): ?>
                                วันนี้
                            <?php elseif ($days_left == 1): ?>
                                พรุ่งนี้
                            <?php else: ?>
                                อีก <?= $days_left ?> วัน
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <div style="text-align:center;color:#94a3b8;padding:60px 0;">
                    <i class="fas fa-calendar-xmark" style="font-size:2em;"></i>
                    <div style="margin-top:8px;">ไม่มีกิจกรรมที่กำลังจะมาในขณะนี้</div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- =============================================================
         [v2-M] Activity Impact Analysis (Events vs Visitors)
         ============================================================= -->
    <div class="section-title scroll-animate-left" style="margin-top: 28px;">
        <i class="fas fa-flask" style="color:#6d28d9;"></i>
        Activity Impact Analysis &mdash; กิจกรรม ส่งผลต่อจำนวนนักท่องเที่ยวอย่างไร?
        <span class="data-badge">Events 2568 × Visitors 2568P (12 เดือน)</span>
    </div>

    <!-- Filter Bar -->
    <div class="mim-filter-bar scroll-animate">
        <label for="mim-province-select"><i class="fas fa-filter"></i> เลือกข้อมูล:</label>
        <select id="mim-province-select">
            <option value="__ALL__">📊 ภาพรวมประเทศ (77 จังหวัด)</option>
            <option disabled>──── เลือกรายจังหวัด (เรียง ก-ฮ) ────</option>
            <?php
                $province_keys = array_keys($mim_dataset);
                $province_keys = array_filter($province_keys, function($k){ return $k !== '__ALL__'; });
                // เรียงตามตัวอักษรไทย
                usort($province_keys, 'strcoll');
                foreach ($province_keys as $key):
            ?>
                <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($key) ?></option>
            <?php endforeach; ?>
        </select>
        <span class="mim-current-tag" id="mim-current-tag"><i class="fas fa-eye"></i> ภาพรวมประเทศ</span>
    </div>

    <!-- Hero: Pearson r + slope (ข้อความจะถูก JS update) -->
    <div class="mim-hero scroll-animate">
        <div class="mim-hero-row">
            <div>
                <div class="mim-label"><i class="fas fa-link"></i> Pearson Correlation (r)</div>
                <div class="mim-r-value" id="mim-r-value">—</div>
                <div class="mim-strength" id="mim-strength">—</div>
                <div class="mim-desc" id="mim-desc">—</div>
            </div>
            <div class="mim-formula">
                <div style="opacity:0.85;font-size:0.85em;">Linear Regression</div>
                <div style="font-size:0.85em;margin-top:2px;" id="mim-formula-eq">visitors = — + — × events</div>
                <b id="mim-formula-slope">— คน / 1 event</b>
                <div style="opacity:0.85;font-size:0.78em;">marginal impact</div>
            </div>
        </div>
    </div>

    <!-- KPI cards -->
    <div class="mim-kpi scroll-animate">
        <div class="mim-kpi-card">
            <div class="k-label"><i class="fas fa-calendar-check" style="color:#8b5cf6;"></i> Total Events 2568</div>
            <div class="k-value" id="mim-total-events">—</div>
            <div class="k-note" id="mim-total-events-note">—</div>
        </div>
        <div class="mim-kpi-card high">
            <div class="k-label"><i class="fas fa-arrow-up" style="color:#059669;"></i> เดือนที่ Event เยอะ</div>
            <div class="k-value" id="mim-high-avg">—<span class="k-unit"> M visitors</span></div>
            <div class="k-note" id="mim-high-note">—</div>
            <div class="k-months" id="mim-high-months"></div>
        </div>
        <div class="mim-kpi-card low">
            <div class="k-label"><i class="fas fa-arrow-down" style="color:#94a3b8;"></i> เดือนที่ Event น้อย</div>
            <div class="k-value" id="mim-low-avg">—<span class="k-unit"> M visitors</span></div>
            <div class="k-note">ค่าเฉลี่ย visitors/เดือน (events &lt; median)</div>
            <div class="k-months" id="mim-low-months"></div>
        </div>
        <div class="mim-kpi-card lift">
            <div class="k-label"><i class="fas fa-bolt" style="color:#d97706;"></i> Event Lift</div>
            <div class="k-value" id="mim-lift">—</div>
            <div class="k-note" id="mim-lift-note">—</div>
        </div>
    </div>

    <!-- Insight -->
    <div class="mim-insight scroll-animate">
        <i class="fas fa-lightbulb"></i>
        <b>Insight:</b> <span id="mim-insight-text">—</span>
    </div>

    <!-- Combo chart: events bar + visitors line -->
    <div class="row scroll-animate">
        <div class="col-lg-6 mb-3">
            <div class="chart-panel" style="height:100%;">
                <div class="panel-title">
                    <i class="fas fa-chart-line" style="color:#6d28d9;"></i>
                    รายเดือน 2568 &mdash; Events (column) vs Visitors (line)
                </div>
                <div id="chartMimCombo" style="height: 380px;"></div>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="chart-panel" style="height:100%;">
                <div class="panel-title">
                    <i class="fas fa-braille" style="color:#6d28d9;"></i>
                    Scatter &mdash; ทุกเดือนเป็น 1 จุด (X=Events, Y=Visitors)
                </div>
                <div id="chartMimScatter" style="height: 380px;"></div>
            </div>
        </div>
    </div>

    <!-- =============================================================
         [v2] Leading Indicators (Domestic) — CCI · Google Trends · OR
         ============================================================= -->
    <div class="section-title scroll-animate-left" style="margin-top: 28px;">
        <i class="fas fa-bolt" style="color:#0f766e;"></i>
        Leading Indicators &mdash; สัญญาณเตือนล่วงหน้า
        <span class="data-badge">Data</span>
    </div>

    <div class="li-hero scroll-animate">
        <div class="li-hero-row">
            <div>
                <div class="li-label"><i class="fas fa-bolt"></i> Leading Score (Composite)</div>
                <div class="li-score">
                    <?= number_format($leading_score, 1) ?><span class="li-score-max"> / 100</span>
                </div>
                <div class="li-signal <?= $leading_signal ?>">
                    <?php if ($leading_signal === 'positive'): ?>
                        <i class="fas fa-arrow-trend-up"></i>
                    <?php elseif ($leading_signal === 'negative'): ?>
                        <i class="fas fa-arrow-trend-down"></i>
                    <?php else: ?>
                        <i class="fas fa-minus"></i>
                    <?php endif; ?>
                    <?= $leading_signal_text ?>
                </div>
                <div class="li-desc"><?= $leading_signal_desc ?></div>
            </div>
            <div class="li-norm-breakdown">
                <div class="li-norm-item">
                    <div class="n-label">CCI Normalized · 40%</div>
                    <div class="n-val"><?= number_format($leading_norm_cci, 1) ?></div>
                </div>
                <div class="li-norm-item">
                    <div class="n-label">Google Trends · 30%</div>
                    <div class="n-val"><?= number_format($leading_norm_gt, 1) ?></div>
                </div>
                <div class="li-norm-item">
                    <div class="n-label">Occupancy · 30%</div>
                    <div class="n-val"><?= number_format($leading_norm_or, 1) ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- CCI -->
        <div class="col-lg-4 col-md-6 mb-3 scroll-animate stagger-1">
            <div class="li-card">
                <div class="li-head">
                    <div><div class="li-name"><i class="fas fa-user-check" style="color:#0f766e;"></i> CCI · ดัชนีความเชื่อมั่นผู้บริโภค</div></div>
                    <span class="li-src">สนค.</span>
                </div>
                <div class="li-value"><?= number_format($cci_latest, 1) ?><span class="li-unit"> pts</span></div>
                <div class="li-period"><?= $cci_latest_month ?> · ปัจจุบัน <?= number_format($cci_latest_current, 1) ?> · อนาคต <?= number_format($cci_latest_future, 1) ?></div>
                <?php
                    $cciDeltaClass = $cci_delta > 0 ? 'up' : ($cci_delta < 0 ? 'down' : 'flat');
                    $cciSymbol = $cci_delta > 0 ? '+' : '';
                ?>
                <span class="li-delta <?= $cciDeltaClass ?>"><?= $cciSymbol . number_format($cci_delta, 1) ?> MoM</span>
                <div id="liChartCci" class="li-mini-chart"></div>
                <div class="li-corr">Pearson r vs นักท่องเที่ยว: <b><?= number_format($cci_corr, 2) ?></b></div>
            </div>
        </div>

        <!-- Google Trends -->
        <div class="col-lg-4 col-md-6 mb-3 scroll-animate stagger-2">
            <div class="li-card">
                <div class="li-head">
                    <div><div class="li-name"><i class="fas fa-magnifying-glass" style="color:#0f766e;"></i> Google Trends · คำค้นท่องเที่ยว</div></div>
                    <span class="li-src">Google</span>
                </div>
                <div class="li-value"><?= number_format($gt_latest, 1) ?><span class="li-unit"> idx</span></div>
                <div class="li-period"><?= $gt_latest_month ?> · เฉลี่ย 5 keywords (ที่เที่ยว·ที่พัก·คาเฟ่·ตั๋ว·ที่พักราคาถูก)</div>
                <?php
                    $gtDeltaClass = $gt_delta > 0 ? 'up' : ($gt_delta < 0 ? 'down' : 'flat');
                    $gtSymbol = $gt_delta > 0 ? '+' : '';
                ?>
                <span class="li-delta <?= $gtDeltaClass ?>"><?= $gtSymbol . number_format($gt_delta, 1) ?> MoM</span>
                <div id="liChartGt" class="li-mini-chart"></div>
                <div class="li-corr">Pearson r vs นักท่องเที่ยว: <b><?= number_format($gt_corr, 2) ?></b></div>
            </div>
        </div>

        <!-- Occupancy -->
        <div class="col-lg-4 col-md-6 mb-3 scroll-animate stagger-3">
            <div class="li-card">
                <div class="li-head">
                    <div><div class="li-name"><i class="fas fa-hotel" style="color:#0f766e;"></i> OR · อัตราเข้าพักเฉลี่ย</div></div>
                    <span class="li-src">กก.</span>
                </div>
                <div class="li-value"><?= number_format($factors[3]['value'], 1) ?><span class="li-unit"> %</span></div>
                <div class="li-period"><?= $data_date ?> · ทั้งประเทศ</div>
                <?php
                    $orDelta = round($occ_monthly[12] - $occ_monthly[11], 2);
                    $orDeltaClass = $orDelta > 0 ? 'up' : ($orDelta < 0 ? 'down' : 'flat');
                    $orSymbol = $orDelta > 0 ? '+' : '';
                ?>
                <span class="li-delta <?= $orDeltaClass ?>"><?= $orSymbol . number_format($orDelta, 1) ?> MoM</span>
                <div id="liChartOr" class="li-mini-chart"></div>
                <div class="li-corr">Pearson r vs นักท่องเที่ยว: <b><?= number_format($or_corr, 2) ?></b></div>
            </div>
        </div>
    </div>

    <!-- =============================================================
         [v2] Regional Sentiment Map (5 ภาค)
         ============================================================= -->
    <div class="section-title scroll-animate-left" style="margin-top: 28px;">
        <i class="fas fa-map-location-dot" style="color:#0f766e;"></i>
        Regional Sentiment Map &mdash; สัญญาณจากโซเชียลไทย 5 ภาค
        <span class="data-badge">Data · <?= $regional_sentiment_period ?></span>
    </div>

    <div class="rs-summary scroll-animate">
        <div class="rs-sum-label"><i class="fas fa-comments"></i> ทั้งประเทศ (<?= $regional_sentiment_period ?>)</div>
        <div class="rs-sum-stat">
            <div>Mentions <b><?= number_format($regional_sentiment_total['mentions']) ?></b></div>
            <div>Engagements <b><?= number_format($regional_sentiment_total['engagements']) ?></b></div>
            <div>Positive <b style="color:#059669;"><?= number_format($regional_sentiment_total['pos_pct'], 2) ?>%</b></div>
            <div>Negative <b style="color:#dc2626;"><?= number_format($regional_sentiment_total['neg_pct'], 2) ?>%</b></div>
        </div>
    </div>

    <div class="rs-grid scroll-animate">
        <?php foreach ($regional_sentiment as $rs): ?>
        <div class="rs-card" style="border-top-color: <?= $rs['color'] ?>;">
            <div class="rs-region"><?= $rs['region'] ?></div>
            <div class="rs-mention">Mentions <b><?= number_format($rs['mentions']) ?></b> · Eng. <?= number_format($rs['engagements']) ?></div>
            <div class="rs-bar">
                <div class="rs-pos" style="width:<?= $rs['pos_pct'] ?>%;"></div>
                <div class="rs-neg" style="width:<?= $rs['neg_pct'] ?>%;"></div>
            </div>
            <div class="rs-pct">
                <span class="pct-pos"><i class="fas fa-thumbs-up"></i> <?= number_format($rs['pos_pct'], 2) ?>%</span>
                <span class="pct-neg"><i class="fas fa-thumbs-down"></i> <?= number_format($rs['neg_pct'], 2) ?>%</span>
            </div>
            <div class="rs-theme">
                <div class="pos-theme"><span class="t-label">+ Top:</span><?= $rs['pos_theme'] ?></div>
                <div class="neg-theme"><span class="t-label">− Risk:</span><?= $rs['neg_theme'] ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="chart-panel scroll-animate">
        <div class="panel-title">
            <i class="fas fa-chart-area" style="color:#0f766e;"></i>
            Sentiment Trend 14 เดือน &mdash; ทั้งประเทศ
            <span class="data-badge">Data</span>
        </div>
        <div id="chartRsTrend" style="height: 320px;"></div>
    </div>

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

    // === เก็บ width เดิมของ bars ทั้งหมดก่อน reset ===
    function captureAndResetBars(selector) {
        document.querySelectorAll(selector).forEach(function(bar) {
            var w = bar.style.width || (bar.getAttribute('data-width') || '0%');
            bar.setAttribute('data-width', w);
            bar.style.width = '0%';
        });
    }
    captureAndResetBars('.factor-bar-inner');
    captureAndResetBars('.rm-metric-bar > span');
    captureAndResetBars('.pp-or-mini-fill');
    captureAndResetBars('.rs-card .rs-bar .rs-pos');
    captureAndResetBars('.rs-card .rs-bar .rs-neg');

    // === Intersection Observer: trigger animation เมื่อ scroll ถึง ===
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);

                triggerAnimations(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.scroll-animate, .scroll-animate-left').forEach(function(el) {
        observer.observe(el);
    });

    function triggerAnimations(target) {
        // === Number counter (ทุก type) ===
        var numberSelectors = [
            '.card-value', '.li-value', '.li-score', '.lt-value',
            '.n-val', '.rm-cci-pill', '.rm-pos-pct',
            '.pp-table strong', '.rm-table strong'
        ];
        target.querySelectorAll(numberSelectors.join(',')).forEach(function(el) {
            animateNumber(el);
        });

        // === Bar fill animation ===
        var barSelectors = [
            '.factor-bar-inner',
            '.rm-metric-bar > span',
            '.pp-or-mini-fill',
            '.rs-card .rs-bar .rs-pos',
            '.rs-card .rs-bar .rs-neg'
        ];
        target.querySelectorAll(barSelectors.join(',')).forEach(function(bar) {
            var w = bar.getAttribute('data-width');
            if (!w) return;
            setTimeout(function() {
                bar.style.width = w;
                bar.classList.add('animating-bar');
                setTimeout(function(){ bar.classList.remove('animating-bar'); }, 1300);
            }, 180);
        });

        // === Stagger row animation (tables) ===
        var rows = target.querySelectorAll('.pp-table tbody tr, .rm-table tbody tr');
        rows.forEach(function(tr, idx) {
            tr.classList.add('row-animate');
            tr.style.animationDelay = (idx * 60) + 'ms';
        });
    }

    // === Number counter ===
    function animateNumber(el) {
        if (el.dataset.animated) return;
        el.dataset.animated = '1';
        var text = el.textContent.trim();
        // ถ้าไม่มีตัวเลขเลย ข้ามไป
        var match = text.match(/-?[\d,]+(\.\d+)?/);
        if (!match) return;
        var num = parseFloat(match[0].replace(/,/g, ''));
        if (isNaN(num) || num === 0) return;

        var isDecimal = text.indexOf('.') > -1;
        var hasM    = text.indexOf('M') > -1;
        var hasPct  = text.indexOf('%') > -1;
        var prefix  = text.substring(0, match.index);
        var suffix  = text.substring(match.index + match[0].length);
        var duration = 1300;
        var start = performance.now();
        var originalText = text;

        function format(v) {
            if (hasM)         return prefix + v.toFixed(2) + suffix;
            if (hasPct)       return prefix + v.toFixed(1) + suffix;
            if (isDecimal)    return prefix + v.toFixed(1) + suffix;
            return prefix + Math.floor(v).toLocaleString() + suffix;
        }

        el.textContent = format(0);
        function step(ts) {
            var progress = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = format(num * eased);
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = originalText;
                el.classList.add('is-counting');
                setTimeout(function(){ el.classList.remove('is-counting'); }, 350);
            }
        }
        requestAnimationFrame(step);
    }

    // === Live clock ใน status bar (อัปเดตทุกวินาที) ===
    function tickClock() {
        var now = new Date();
        var t = String(now.getHours()).padStart(2,'0') + ':' +
                String(now.getMinutes()).padStart(2,'0') + ':' +
                String(now.getSeconds()).padStart(2,'0');
        var el = document.getElementById('rt-update-time');
        if (el) el.textContent = t;
    }
    setInterval(tickClock, 1000);
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
    colors: ['#0f766e', '#14b8a6', '#3eabae', '#0891b2', '#2563eb', '#f59e0b', '#dc2626'],
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

// ============================================================
// [v2-C] Long-term Recovery Chart — 7 ปี + Forecast 2569
// ============================================================
if (document.getElementById('chartLongTerm')) {
    var ltYears = <?= json_encode($lt_years) ?>;
    var ltTotal = <?= json_encode($lt_total) ?>.map(function(v){ return v ? v/1000000 : null; });
    var ltMain  = <?= json_encode($lt_main_cities) ?>.map(function(v){ return v ? v/1000000 : null; });
    var ltMinor = <?= json_encode($lt_minor_cities) ?>.map(function(v){ return v ? v/1000000 : null; });
    var ltForecast = <?= $lt_forecast_2569 / 1000000 ?>;

    // forecast series: null สำหรับปีก่อนหน้า + เริ่มต่อจากปีล่าสุด
    var fcSeries = [];
    for (var i=0; i<ltTotal.length; i++) fcSeries.push(null);
    fcSeries[ltTotal.length - 1] = ltTotal[ltTotal.length - 1]; // จุดเชื่อม
    fcSeries.push(ltForecast);
    var ltYearsExt = ltYears.slice();
    ltYearsExt.push('2569F');

    var totalExt = ltTotal.slice(); totalExt.push(null);
    var mainExt  = ltMain.slice();  mainExt.push(null);
    var minorExt = ltMinor.slice(); minorExt.push(null);

    Highcharts.chart('chartLongTerm', {
        chart: { },
        title: { text: null },
        xAxis: {
            categories: ltYearsExt,
            crosshair: true,
            labels: { style: { fontSize: '12px', fontWeight: '600', color: '#1a3a3c' } },
            plotBands: [
                { from: 0.5, to: 2.5, color: 'rgba(220,38,38,0.06)', label: { text: 'COVID Era', style: { color: '#dc2626', fontWeight: '700' }, y: 16 } }
            ]
        },
        yAxis: {
            title: { text: 'จำนวน (ล้านคน)', style: { color: '#64748b' } },
            gridLineColor: '#f1f5f9'
        },
        tooltip: {
            shared: true, useHTML: true,
            formatter: function() {
                var s = '<b>' + this.x + '</b><br/>';
                this.points.forEach(function(p) {
                    if (p.y !== null) {
                        s += '<span style="color:' + p.series.color + '">\u25cf</span> ' + p.series.name + ': <b>' + Highcharts.numberFormat(p.y, 1) + 'M</b><br/>';
                    }
                });
                return s;
            }
        },
        plotOptions: {
            areaspline: { fillOpacity: 0.12, marker: { radius: 5, lineWidth: 2, lineColor: '#fff' }, lineWidth: 3 },
            spline: { marker: { radius: 5, lineWidth: 2, lineColor: '#fff' }, lineWidth: 2.5 }
        },
        series: [
            { name: 'ทั้งประเทศ',     type: 'areaspline', data: totalExt, color: '#0f766e',
              fillColor: { linearGradient: {x1:0,y1:0,x2:0,y2:1}, stops: [[0,'rgba(15,118,110,0.25)'],[1,'rgba(15,118,110,0)']] } },
            { name: '22 เมืองหลัก',    type: 'spline', data: mainExt,  color: '#14b8a6', dashStyle: 'ShortDash' },
            { name: '55 เมืองรอง',     type: 'spline', data: minorExt, color: '#94a3b8', dashStyle: 'ShortDash' },
            { name: 'Forecast 2569',   type: 'spline', data: fcSeries, color: '#f59e0b', dashStyle: 'Dot', lineWidth: 3,
              marker: { symbol: 'triangle', radius: 7, fillColor: '#f59e0b' } }
        ],
        legend: { itemStyle: { fontWeight: '600' } }
    });
}

// ============================================================
// [v2-M] Activity Impact — Province filter + dynamic re-render
// ============================================================
var mimDataset  = <?= json_encode($mim_dataset) ?>;
var mimMonths   = <?= json_encode($mim_thai_short) ?>;
var mimComboChart = null, mimScatterChart = null;

function mimMedian(arr) {
    var s = arr.slice().sort(function(a,b){ return a-b; });
    var n = s.length;
    return n % 2 ? s[(n-1)/2] : (s[n/2-1] + s[n/2]) / 2;
}
function mimPearson(x, y) {
    var n = Math.min(x.length, y.length);
    if (n < 3) return 0;
    var mx = x.reduce(function(a,b){return a+b;},0)/n;
    var my = y.reduce(function(a,b){return a+b;},0)/n;
    var num = 0, dx = 0, dy = 0;
    for (var i=0; i<n; i++) {
        num += (x[i]-mx) * (y[i]-my);
        dx  += Math.pow(x[i]-mx, 2);
        dy  += Math.pow(y[i]-my, 2);
    }
    var den = Math.sqrt(dx * dy);
    return den === 0 ? 0 : num / den;
}
function mimRegression(x, y) {
    var n = x.length;
    var mx = x.reduce(function(a,b){return a+b;},0)/n;
    var my = y.reduce(function(a,b){return a+b;},0)/n;
    var num = 0, den = 0;
    for (var i=0; i<n; i++) {
        num += (x[i]-mx) * (y[i]-my);
        den += Math.pow(x[i]-mx, 2);
    }
    var slope = den !== 0 ? num/den : 0;
    return { slope: slope, intercept: my - slope * mx };
}
function mimFmt(n, dec) { return Highcharts.numberFormat(n, dec || 0, '.', ','); }

function mimRender(provinceKey) {
    var ds = mimDataset[provinceKey];
    if (!ds) return;
    var events = ds.events;            // [12]
    var visitors = ds.visitors;        // [12] หน่วย: ล้านคน
    var visitorsRaw = visitors.map(function(v){ return v * 1000000; });

    // === คำนวณตัวเลขทั้งหมด ===
    var corr = mimPearson(events, visitors);
    var reg  = mimRegression(events, visitorsRaw);
    var totalEvents = events.reduce(function(a,b){return a+b;},0);
    var totalVis    = visitorsRaw.reduce(function(a,b){return a+b;},0);

    // Median split
    var evtMedian = mimMedian(events);
    var highVis = [], lowVis = [], highMon = [], lowMon = [];
    for (var i=0; i<12; i++) {
        if (events[i] >= evtMedian) { highVis.push(visitorsRaw[i]); highMon.push(mimMonths[i]); }
        else                         { lowVis.push(visitorsRaw[i]);  lowMon.push(mimMonths[i]); }
    }
    var highAvg = highVis.length ? highVis.reduce(function(a,b){return a+b;},0)/highVis.length : 0;
    var lowAvg  = lowVis.length  ? lowVis.reduce(function(a,b){return a+b;},0)/lowVis.length  : 0;
    var lift = lowAvg > 0 ? (highAvg - lowAvg) / lowAvg * 100 : 0;

    // === Update DOM ===
    var corrSign = corr >= 0 ? '+' : '';
    document.getElementById('mim-r-value').textContent = corrSign + corr.toFixed(3);
    document.getElementById('mim-current-tag').innerHTML = '<i class="fas fa-eye"></i> ' + ds.name;

    // strength + desc
    var strength, strengthIcon, descTxt;
    if (corr >= 0.7)        { strength = 'ความสัมพันธ์เชิงบวกแรง';      strengthIcon = 'fa-arrow-trend-up'; }
    else if (corr >= 0.4)   { strength = 'ความสัมพันธ์เชิงบวกปานกลาง';  strengthIcon = 'fa-arrow-trend-up'; }
    else if (corr >= 0.2)   { strength = 'ความสัมพันธ์เชิงบวกต่ำ';       strengthIcon = 'fa-arrow-right'; }
    else if (corr >= -0.2)  { strength = 'ไม่มีความสัมพันธ์ชัดเจน';      strengthIcon = 'fa-minus'; }
    else                    { strength = 'ความสัมพันธ์เชิงลบ';           strengthIcon = 'fa-arrow-trend-down'; }
    document.getElementById('mim-strength').innerHTML =
        '<i class="fas ' + strengthIcon + '"></i> ' + strength;

    if (corr >= 0.4)
        descTxt = 'เดือนที่จัดกิจกรรมมาก มีจำนวนนักท่องเที่ยวสูงตามไปด้วย — กิจกรรมเป็นปัจจัยขับเคลื่อนสำคัญ';
    else if (corr >= 0.2)
        descTxt = 'มีแนวโน้มกิจกรรมส่งผลต่อนักท่องเที่ยว แต่ยังต้องดูปัจจัยอื่นร่วม (seasonality, holidays)';
    else if (corr >= -0.2)
        descTxt = 'กิจกรรมและจำนวนนักท่องเที่ยวเคลื่อนไหวอิสระจากกัน — อาจเป็น seasonality หรือ supply ที่จัดเต็มทุกเดือน';
    else
        descTxt = 'กิจกรรมมาก แต่นักท่องเที่ยวกลับลดลง — ตรวจสอบปัจจัยภายนอก (เศรษฐกิจ, สภาพอากาศ)';
    document.getElementById('mim-desc').textContent = descTxt;

    // Formula
    document.getElementById('mim-formula-eq').textContent =
        'visitors = ' + (reg.intercept/1000000).toFixed(2) + 'M + ' + Math.round(reg.slope) + ' × events';
    document.getElementById('mim-formula-slope').textContent =
        '≈ ' + mimFmt(Math.round(reg.slope)) + ' คน / 1 event';

    // KPI cards
    document.getElementById('mim-total-events').innerHTML =
        mimFmt(totalEvents) + '<span class="k-unit"> events</span>';
    document.getElementById('mim-total-events-note').textContent =
        'รวม 12 เดือน · เฉลี่ย ' + (totalEvents/12).toFixed(1) + '/เดือน';

    document.getElementById('mim-high-avg').innerHTML =
        (highAvg/1000000).toFixed(2) + '<span class="k-unit"> M visitors</span>';
    document.getElementById('mim-high-note').textContent =
        'ค่าเฉลี่ย visitors/เดือน (events ≥ median ' + evtMedian.toFixed(1) + ')';
    document.getElementById('mim-high-months').innerHTML =
        highMon.map(function(m){ return '<span class="k-month-tag">' + m + '</span>'; }).join('');

    document.getElementById('mim-low-avg').innerHTML =
        (lowAvg/1000000).toFixed(2) + '<span class="k-unit"> M visitors</span>';
    document.getElementById('mim-low-months').innerHTML =
        lowMon.map(function(m){ return '<span class="k-month-tag">' + m + '</span>'; }).join('');

    var liftSign = lift >= 0 ? '+' : '';
    document.getElementById('mim-lift').textContent = liftSign + lift.toFixed(1) + '%';
    document.getElementById('mim-lift-note').textContent =
        'visitors ' + (lift >= 0 ? 'เพิ่มขึ้น' : 'ลดลง') + 'ในเดือนที่กิจกรรมเยอะ';

    // Insight
    var insight;
    if (corr >= 0.4 && lift > 5) {
        insight = 'พื้นที่นี้พบว่า เดือนที่จัดกิจกรรมเยอะ มีจำนวนนักท่องเที่ยวสูงกว่าเดือนที่กิจกรรมน้อย <b>' + lift.toFixed(1) + '%</b> ' +
            'เฉลี่ยกิจกรรม 1 event เพิ่มผู้เยี่ยมเยือนได้ <b>~' + mimFmt(Math.round(reg.slope)) + ' คน</b> — กิจกรรมเป็น <b>growth driver</b> สำคัญ';
    } else if (Math.abs(corr) < 0.2) {
        insight = 'ความสัมพันธ์ระหว่างกิจกรรมและจำนวนนักท่องเที่ยวค่อนข้างอ่อน (r = ' + corr.toFixed(2) + ') ' +
            'อาจเพราะนักท่องเที่ยวเดินทางตาม <b>seasonality</b> (วันหยุดยาว) มากกว่าการจัดกิจกรรม';
    } else {
        insight = 'ความสัมพันธ์อยู่ในระดับที่กล่าวข้างต้น (r = ' + corr.toFixed(2) + ') ' +
            'ในเดือนที่กิจกรรมเยอะมี visitors เฉลี่ย <b>' + (highAvg/1000000).toFixed(2) + 'M</b> ' +
            'เทียบกับเดือนที่น้อย <b>' + (lowAvg/1000000).toFixed(2) + 'M</b> ' +
            '(lift ' + liftSign + lift.toFixed(1) + '%) — พิจารณาร่วมกับ CCI/Google Trends ด้านบน';
    }
    document.getElementById('mim-insight-text').innerHTML = insight;

    // === Re-render Combo Chart ===
    if (mimComboChart) mimComboChart.destroy();
    mimComboChart = Highcharts.chart('chartMimCombo', {
        chart: { },
        title: { text: null },
        xAxis: {
            categories: mimMonths, crosshair: true,
            labels: { style: { fontSize: '12px', fontWeight: '600', color: '#1a3a3c' } }
        },
        yAxis: [
            { title: { text: 'Events', style: { color: '#8b5cf6' } },
              labels: { style: { color: '#8b5cf6' } },
              gridLineColor: '#f1f5f9', allowDecimals: false, min: 0 },
            { title: { text: 'Visitors (M)', style: { color: '#0f766e' } },
              labels: { format: '{value} M', style: { color: '#0f766e' } },
              opposite: true, gridLineWidth: 0 }
        ],
        tooltip: {
            shared: true, useHTML: true, backgroundColor: '#fff', borderColor: '#e2e8f0',
            formatter: function() {
                var s = '<b>' + this.x + ' 2568 · ' + ds.name + '</b><br/>';
                this.points.forEach(function(p) {
                    if (p.series.name === 'Events') {
                        s += '<span style="color:' + p.series.color + '">\u25cf</span> Events: <b>' + p.y + '</b><br/>';
                    } else {
                        s += '<span style="color:' + p.series.color + '">\u25cf</span> Visitors: <b>' + Highcharts.numberFormat(p.y, 2) + ' M</b><br/>';
                    }
                });
                return s;
            }
        },
        plotOptions: {
            column: { borderRadius: 4, borderWidth: 0, pointPadding: 0.15 },
            spline: { marker: { radius: 5, lineWidth: 2, lineColor: '#fff' }, lineWidth: 3 }
        },
        series: [
            { name: 'Events',   type: 'column', yAxis: 0, data: events,   color: '#8b5cf6', opacity: 0.85 },
            { name: 'Visitors', type: 'spline', yAxis: 1, data: visitors, color: '#0f766e' }
        ],
        legend: { itemStyle: { fontWeight: '600' } },
        credits: { enabled: false }
    });

    // === Re-render Scatter (Quadrant) ===
    if (mimScatterChart) mimScatterChart.destroy();
    var xs = events.slice(), ys = visitors.slice();
    var xMed = mimMedian(xs), yMed = mimMedian(ys);
    var groupBest = [], groupNatural = [], groupQuiet = [], groupMissed = [];
    for (var k=0; k<12; k++) {
        var pt = { x: events[k], y: visitors[k], name: mimMonths[k] };
        if      (events[k] >= xMed && visitors[k] >= yMed) groupBest.push(pt);
        else if (events[k] <  xMed && visitors[k] >= yMed) groupNatural.push(pt);
        else if (events[k] <  xMed && visitors[k] <  yMed) groupQuiet.push(pt);
        else                                                groupMissed.push(pt);
    }
    var minX = Math.min.apply(null, xs), maxX = Math.max.apply(null, xs);
    var trendLine = [
        [minX, reg.intercept/1000000 + reg.slope/1000000 * minX],
        [maxX, reg.intercept/1000000 + reg.slope/1000000 * maxX]
    ];

    mimScatterChart = Highcharts.chart('chartMimScatter', {
        chart: { type: 'scatter', zoomType: 'xy', height: 380 },
        title: { text: 'แต่ละเดือน อยู่ในกลุ่มไหน? (' + ds.name + ')',
                 style: { fontSize: '14px', fontWeight: '700', color: '#1a3a3c' } },
        subtitle: { text: 'ขีดประ = ค่ากลาง (median) แบ่งเป็น 4 ช่อง · เส้นม่วง = แนวโน้มเฉลี่ย',
                    style: { fontSize: '11px', color: '#94a3b8' } },
        xAxis: {
            title: { text: 'จำนวน Events ในเดือนนั้น (มากขึ้น →)', style: { color: '#64748b', fontSize: '11px' } },
            gridLineColor: '#f8fafc', allowDecimals: false,
            min: Math.max(0, minX - Math.max(2, (maxX-minX)*0.1)),
            plotLines: [{ value: xMed, color: '#cbd5e1', dashStyle: 'Dash', width: 2, zIndex: 3,
                label: { text: 'Median Events = ' + Math.round(xMed), align: 'right', x: -8, y: 14,
                         style: { color: '#64748b', fontSize: '10px', fontWeight: '700' } } }]
        },
        yAxis: {
            title: { text: 'Visitors ในเดือนนั้น (ล้านคน, มากขึ้น ↑)', style: { color: '#64748b', fontSize: '11px' } },
            gridLineColor: '#f8fafc',
            plotLines: [{ value: yMed, color: '#cbd5e1', dashStyle: 'Dash', width: 2, zIndex: 3,
                label: { text: 'Median Visitors = ' + yMed.toFixed(2) + 'M', align: 'right', x: -8, y: -6,
                         style: { color: '#64748b', fontSize: '10px', fontWeight: '700' } } }],
            plotBands: [
                { from: yMed, to: 1e9, color: 'rgba(5,150,105,0.04)' },
                { from: -1e9, to: yMed, color: 'rgba(220,38,38,0.03)' }
            ]
        },
        tooltip: {
            useHTML: true, backgroundColor: '#fff', borderColor: '#e2e8f0',
            formatter: function() {
                var grp;
                if (this.x >= xMed && this.y >= yMed)      grp = '<span style="color:#059669;">🟢 Best — Events เยอะ Visitors เยอะ</span>';
                else if (this.x < xMed && this.y >= yMed)  grp = '<span style="color:#0891b2;">🔵 มาเอง — Visitors เยอะแม้ Events น้อย</span>';
                else if (this.x < xMed && this.y < yMed)   grp = '<span style="color:#94a3b8;">⚪ ช่วงเงียบ — ทั้งคู่น้อย</span>';
                else                                        grp = '<span style="color:#d97706;">🟠 ต้องระวัง — Events เยอะแต่ Visitors น้อย</span>';
                return '<b style="color:#6d28d9;font-size:1.1em;">' + this.point.name + ' 2568 · ' + ds.name + '</b><br/>' +
                       '<i class="fas fa-calendar-check"></i> Events: <b>' + this.x + '</b><br/>' +
                       '<i class="fas fa-users"></i> Visitors: <b>' + Highcharts.numberFormat(this.y, 2) + ' M</b><br/>' +
                       '<hr style="margin:4px 0;border-color:#e2e8f0;">' + grp;
            }
        },
        plotOptions: {
            scatter: {
                marker: { radius: 9, lineColor: '#fff', lineWidth: 2,
                          states: { hover: { radius: 13 } } },
                dataLabels: { enabled: true, format: '{point.name}',
                              style: { fontSize: '11px', fontWeight: '700', color: '#1a3a3c', textOutline: '2px #fff' },
                              align: 'left', x: 9, y: 4, allowOverlap: false }
            },
            line: { marker: { enabled: false }, enableMouseTracking: false }
        },
        series: [
            { name: '🟢 Best (Events↑ · Visitors↑)',     data: groupBest,    color: '#059669' },
            { name: '🔵 มาเอง (Events↓ · Visitors↑)',    data: groupNatural, color: '#0891b2' },
            { name: '🟠 ต้องระวัง (Events↑ · Visitors↓)', data: groupMissed,  color: '#d97706' },
            { name: '⚪ ช่วงเงียบ (Events↓ · Visitors↓)',  data: groupQuiet,   color: '#94a3b8' },
            { name: 'แนวโน้มเฉลี่ย', type: 'line', data: trendLine,
              color: '#8b5cf6', dashStyle: 'ShortDash', lineWidth: 2 }
        ],
        legend: { align: 'center', verticalAlign: 'bottom',
                  itemStyle: { fontSize: '11px', fontWeight: '600' },
                  symbolRadius: 6, itemMarginTop: 2, itemMarginBottom: 2 },
        credits: { enabled: false }
    });
}

// Initial render + bind change event
mimRender('__ALL__');
document.getElementById('mim-province-select').addEventListener('change', function() {
    mimRender(this.value);
});

// (Old static block ของ chartMimCombo / chartMimScatter ถูกแทนที่ด้วย mimRender() ทั้งหมด)
if (false) {
    var scatterData = <?= json_encode($mim_scatter) ?>;

    // คำนวณ median ทั้งสองแกน
    function median(arr) {
        var s = arr.slice().sort(function(a,b){ return a-b; });
        var n = s.length;
        return n % 2 ? s[(n-1)/2] : (s[n/2-1] + s[n/2]) / 2;
    }
    var xs = scatterData.map(function(d){ return d.x; });
    var ys = scatterData.map(function(d){ return d.y; });
    var xMed = median(xs);
    var yMed = median(ys);

    // จัดกลุ่มเป็น 4 ประเภท (ใช้คำที่เข้าใจง่าย)
    var groupBest    = []; // events เยอะ + visitors เยอะ → "🟢 ตามสมการ"
    var groupNatural = []; // events น้อย + visitors เยอะ → "🔵 มาเอง (ไม่ต้องจัด)"
    var groupQuiet   = []; // events น้อย + visitors น้อย → "⚪ ช่วงเงียบ"
    var groupMissed  = []; // events เยอะ + visitors น้อย → "🟠 จัดแล้วไม่ดึง"

    scatterData.forEach(function(p) {
        var pt = { x: p.x, y: p.y, name: p.name };
        if (p.x >= xMed && p.y >= yMed)      groupBest.push(pt);
        else if (p.x < xMed && p.y >= yMed)  groupNatural.push(pt);
        else if (p.x < xMed && p.y < yMed)   groupQuiet.push(pt);
        else                                  groupMissed.push(pt);
    });

    // คำนวณ trend line (linear regression)
    var n = xs.length;
    var meanX = xs.reduce(function(a,b){ return a+b; }, 0) / n;
    var meanY = ys.reduce(function(a,b){ return a+b; }, 0) / n;
    var num = 0, den = 0;
    for (var i = 0; i < n; i++) {
        num += (xs[i] - meanX) * (ys[i] - meanY);
        den += Math.pow(xs[i] - meanX, 2);
    }
    var slope = den !== 0 ? num / den : 0;
    var intercept = meanY - slope * meanX;
    var minX = Math.min.apply(null, xs);
    var maxX = Math.max.apply(null, xs);
    var trendLine = [
        [minX, intercept + slope * minX],
        [maxX, intercept + slope * maxX]
    ];

    Highcharts.chart('chartMimScatter', {
        chart: { type: 'scatter', zoomType: 'xy', height: 380 },
        title: {
            text: 'แต่ละเดือน อยู่ในกลุ่มไหน?',
            style: { fontSize: '14px', fontWeight: '700', color: '#1a3a3c' }
        },
        subtitle: {
            text: 'ขีดประ = ค่ากลาง (median) แบ่งเป็น 4 ช่อง · เส้นม่วง = แนวโน้มเฉลี่ย',
            style: { fontSize: '11px', color: '#94a3b8' }
        },
        xAxis: {
            title: { text: 'จำนวน Events ในเดือนนั้น (มากขึ้น →)', style: { color: '#64748b', fontSize: '11px' } },
            gridLineColor: '#f8fafc',
            allowDecimals: false,
            min: Math.max(0, minX - 20),
            plotLines: [{
                value: xMed,
                color: '#cbd5e1',
                dashStyle: 'Dash',
                width: 2,
                zIndex: 3,
                label: {
                    text: 'Median Events = ' + Math.round(xMed),
                    rotation: 0,
                    align: 'right',
                    x: -8, y: 14,
                    style: { color: '#64748b', fontSize: '10px', fontWeight: '700' }
                }
            }]
        },
        yAxis: {
            title: { text: 'Visitors ในเดือนนั้น (ล้านคน, มากขึ้น ↑)', style: { color: '#64748b', fontSize: '11px' } },
            gridLineColor: '#f8fafc',
            plotLines: [{
                value: yMed,
                color: '#cbd5e1',
                dashStyle: 'Dash',
                width: 2,
                zIndex: 3,
                label: {
                    text: 'Median Visitors = ' + yMed.toFixed(2) + 'M',
                    align: 'right',
                    x: -8, y: -6,
                    style: { color: '#64748b', fontSize: '10px', fontWeight: '700' }
                }
            }],
            // Quadrant tints (ใช้ plotBands)
            plotBands: [
                {
                    from: yMed, to: 1e9,
                    color: 'rgba(5,150,105,0.04)',
                    label: {
                        text: '↑ Visitors สูง',
                        align: 'left', x: 8, y: 14,
                        style: { color: '#94a3b8', fontSize: '10px', fontStyle: 'italic' }
                    }
                },
                {
                    from: -1e9, to: yMed,
                    color: 'rgba(220,38,38,0.03)'
                }
            ]
        },
        tooltip: {
            useHTML: true,
            backgroundColor: '#fff',
            borderColor: '#e2e8f0',
            formatter: function() {
                var grp = '';
                if (this.x >= xMed && this.y >= yMed)      grp = '<span style="color:#059669;">🟢 Best — Events เยอะ Visitors เยอะ</span>';
                else if (this.x < xMed && this.y >= yMed)  grp = '<span style="color:#0891b2;">🔵 มาเอง — Visitors เยอะแม้ Events น้อย</span>';
                else if (this.x < xMed && this.y < yMed)   grp = '<span style="color:#94a3b8;">⚪ ช่วงเงียบ — ทั้งคู่น้อย</span>';
                else                                        grp = '<span style="color:#d97706;">🟠 ต้องระวัง — Events เยอะแต่ Visitors น้อย</span>';
                return '<b style="color:#6d28d9;font-size:1.1em;">' + this.point.name + ' 2568</b><br/>' +
                    '<i class="fas fa-calendar-check"></i> Events: <b>' + this.x + '</b><br/>' +
                    '<i class="fas fa-users"></i> Visitors: <b>' + Highcharts.numberFormat(this.y, 2) + ' M</b><br/>' +
                    '<hr style="margin:4px 0;border-color:#e2e8f0;">' + grp;
            }
        },
        plotOptions: {
            scatter: {
                marker: {
                    radius: 9,
                    lineColor: '#fff',
                    lineWidth: 2,
                    states: { hover: { radius: 13 } }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}',
                    style: { fontSize: '11px', fontWeight: '700', color: '#1a3a3c', textOutline: '2px #fff' },
                    align: 'left', x: 9, y: 4,
                    allowOverlap: false
                }
            },
            line: {
                marker: { enabled: false },
                enableMouseTracking: false,
                states: { hover: { lineWidth: 2 } }
            }
        },
        series: [
            {
                name: '🟢 Best (Events↑ · Visitors↑)',
                data: groupBest,
                color: '#059669'
            },
            {
                name: '🔵 มาเอง (Events↓ · Visitors↑)',
                data: groupNatural,
                color: '#0891b2'
            },
            {
                name: '🟠 ต้องระวัง (Events↑ · Visitors↓)',
                data: groupMissed,
                color: '#d97706'
            },
            {
                name: '⚪ ช่วงเงียบ (Events↓ · Visitors↓)',
                data: groupQuiet,
                color: '#94a3b8'
            },
            {
                name: 'แนวโน้มเฉลี่ย',
                type: 'line',
                data: trendLine,
                color: '#8b5cf6',
                dashStyle: 'ShortDash',
                lineWidth: 2,
                showInLegend: true
            }
        ],
        legend: {
            align: 'center',
            verticalAlign: 'bottom',
            itemStyle: { fontSize: '11px', fontWeight: '600' },
            symbolRadius: 6,
            itemMarginTop: 2,
            itemMarginBottom: 2
        },
        credits: { enabled: false }
    });
}

// ============================================================
// [v2-H] Activity Calendar Timeline — รายเดือน YoY
// ============================================================
if (document.getElementById('chartActMonth')) {
    Highcharts.chart('chartActMonth', {
        chart: { type: 'column' },
        title: { text: null },
        xAxis: {
            categories: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],
            crosshair: true,
            labels: { style: { fontSize: '12px', fontWeight: '600', color: '#1a3a3c' } }
        },
        yAxis: {
            title: { text: 'จำนวนกิจกรรม', style: { color: '#64748b' } },
            gridLineColor: '#f1f5f9',
            min: 0,
            allowDecimals: false
        },
        tooltip: {
            shared: true, useHTML: true,
            formatter: function() {
                var s = '<b>' + this.x + '</b><br/>';
                this.points.forEach(function(p) {
                    s += '<span style="color:' + p.series.color + '">\u25cf</span> ' + p.series.name + ': <b>' + Highcharts.numberFormat(p.y, 0, '.', ',') + ' events</b><br/>';
                });
                return s;
            }
        },
        plotOptions: {
            column: { borderRadius: 4, borderWidth: 0, pointPadding: 0.08, groupPadding: 0.12 }
        },
        series: [
            { name: '<?= $act_year_thai_prev ?>', data: <?= json_encode($act_by_month_prev) ?>, color: '#cbd5e1' },
            { name: '<?= $act_year_thai ?>',      data: <?= json_encode($act_by_month_cur) ?>,  color: '#0f766e' }
        ],
        legend: { itemStyle: { fontWeight: '600' } }
    });
}

// ============================================================
// [v2-J] Activity Type Mix — Donut (เน้นใช้ legend แทน dataLabels)
// ============================================================
if (document.getElementById('chartActType') && <?= !empty($act_by_type) ? 'true' : 'false' ?>) {
    var typeData = <?= json_encode(array_map(function($t){
        return ['name' => $t['name'], 'y' => $t['count']];
    }, $act_by_type)) ?>;
    var typeColors = ['#0f766e','#14b8a6','#0891b2','#6366f1','#8b5cf6','#ec4899','#f59e0b','#dc2626','#84cc16','#06b6d4','#94a3b8'];
    var typeTotal = typeData.reduce(function(s,d){ return s + d.y; }, 0);

    function truncateLabel(s, n) {
        if (!s) return '';
        return s.length > n ? s.substring(0, n - 1) + '…' : s;
    }

    Highcharts.chart('chartActType', {
        chart: {
            type: 'pie',
            height: 380,
            marginTop: 10,
            events: {
                render: function() {
                    // วาด total ตรงกลาง donut
                    var chart = this;
                    var center = chart.series[0].center;
                    var x = center[0] + chart.plotLeft;
                    var y = center[1] + chart.plotTop;

                    if (chart.customCenter) chart.customCenter.destroy();
                    chart.customCenter = chart.renderer.text(
                        '<div style="text-align:center;line-height:1.2;">' +
                            '<div style="font-size:0.72em;color:#64748b;font-weight:700;letter-spacing:0.5px;">TOTAL</div>' +
                            '<div style="font-size:1.6em;font-weight:800;color:#0f766e;">' + Highcharts.numberFormat(typeTotal, 0, '.', ',') + '</div>' +
                            '<div style="font-size:0.72em;color:#94a3b8;">events</div>' +
                        '</div>',
                        x, y, true
                    ).css({
                        fontFamily: 'Sarabun, Nunito, sans-serif'
                    }).attr({
                        align: 'center',
                        zIndex: 5
                    }).add();

                    // ปรับ y ให้อยู่กลาง (renderer.text anchor อยู่ baseline)
                    var bbox = chart.customCenter.getBBox();
                    chart.customCenter.attr({ y: y - bbox.height / 2 + 8 });
                }
            }
        },
        title: { text: null },
        tooltip: {
            useHTML: true,
            backgroundColor: '#fff',
            borderColor: '#e2e8f0',
            style: { fontSize: '12px' },
            formatter: function() {
                return '<b style="color:' + this.point.color + ';">' + this.point.name + '</b><br/>' +
                       '<span style="font-size:1.1em;font-weight:800;color:#1a3a3c;">' +
                       Highcharts.numberFormat(this.y, 0, '.', ',') + ' events</span> ' +
                       '<span style="color:#64748b;">(' + Highcharts.numberFormat(this.percentage, 1) + '%)</span>';
            }
        },
        plotOptions: {
            pie: {
                size: '85%',
                innerSize: '60%',
                borderWidth: 3,
                borderColor: '#fff',
                dataLabels: { enabled: false },
                showInLegend: true,
                colors: typeColors,
                states: {
                    hover: { brightness: 0.05, halo: { size: 8, opacity: 0.25 } }
                }
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemMarginTop: 4,
            itemMarginBottom: 4,
            itemStyle: {
                fontSize: '12px',
                fontWeight: '600',
                color: '#1a3a3c'
            },
            itemHoverStyle: { color: '#0f766e' },
            symbolRadius: 4,
            useHTML: true,
            labelFormatter: function() {
                var nameTrunc = truncateLabel(this.name, 22);
                var pct = (this.y / typeTotal * 100).toFixed(1);
                return '<span title="' + this.name + '" style="display:inline-block;max-width:200px;">' +
                            '<span style="display:inline-block;min-width:140px;">' + nameTrunc + '</span>' +
                            '<b style="color:' + this.color + ';margin-left:6px;">' + this.y + '</b>' +
                            '<span style="color:#94a3b8;font-size:0.85em;margin-left:4px;">(' + pct + '%)</span>' +
                       '</span>';
            }
        },
        responsive: {
            rules: [{
                condition: { maxWidth: 600 },
                chartOptions: {
                    legend: {
                        align: 'center',
                        verticalAlign: 'bottom',
                        layout: 'horizontal'
                    },
                    plotOptions: { pie: { size: '70%' } }
                }
            }]
        },
        series: [{
            name: 'Events',
            data: typeData
        }]
    });
}

// ============================================================
// [v2-D] Tier Battle — Stacked Column + Ratio Line
// ============================================================
if (document.getElementById('chartTier')) {
    Highcharts.chart('chartTier', {
        chart: { },
        title: { text: null },
        xAxis: { categories: <?= json_encode($tier_months) ?>, crosshair: true },
        yAxis: [
            {
                title: { text: 'จำนวน (ล้านคน)', style: { color: '#0f766e' } },
                labels: { formatter: function() { return (this.value/1000000).toFixed(0) + 'M'; }, style: { color: '#0f766e' } },
                gridLineColor: '#f1f5f9',
                stackLabels: {
                    enabled: true,
                    formatter: function() { return Highcharts.numberFormat(this.total/1000000, 1) + 'M'; },
                    style: { fontSize: '10px', color: '#1a3a3c', fontWeight: '700', textOutline: 'none' }
                }
            },
            {
                title: { text: 'Ratio % เมืองหลัก', style: { color: '#f59e0b' } },
                labels: { format: '{value}%', style: { color: '#f59e0b' } },
                opposite: true,
                min: 50, max: 70,
                gridLineWidth: 0
            }
        ],
        tooltip: {
            shared: true, useHTML: true,
            formatter: function() {
                var s = '<b>' + this.x + ' 2568</b><br/>';
                this.points.forEach(function(p) {
                    if (p.series.name === 'Ratio % หลัก') {
                        s += '<span style="color:' + p.series.color + '">\u25cf</span> ' + p.series.name + ': <b>' + p.y + '%</b><br/>';
                    } else {
                        s += '<span style="color:' + p.series.color + '">\u25cf</span> ' + p.series.name + ': <b>' + Highcharts.numberFormat(p.y/1000000, 2) + 'M</b><br/>';
                    }
                });
                return s;
            }
        },
        plotOptions: {
            column: { stacking: 'normal', borderRadius: 3, borderWidth: 0, pointPadding: 0.1 },
            spline: { marker: { radius: 5, lineWidth: 2, lineColor: '#fff' }, lineWidth: 3 }
        },
        series: [
            { name: '22 เมืองหลัก', type: 'column', yAxis: 0, data: <?= json_encode($tier_main_monthly) ?>,  color: '#0f766e' },
            { name: '55 เมืองรอง',  type: 'column', yAxis: 0, data: <?= json_encode($tier_minor_monthly) ?>, color: '#94a3b8' },
            { name: 'Ratio % หลัก', type: 'spline', yAxis: 1, data: <?= json_encode($tier_ratio) ?>, color: '#f59e0b', dashStyle: 'ShortDash' }
        ],
        legend: { itemStyle: { fontWeight: '600' } }
    });
}

// ============================================================
// [v2-E] Google Trends — Radar Chart with month filter
// ============================================================
var gtDataset    = <?= json_encode($gt_radar_dataset) ?>;
var gtKwLabels   = <?= json_encode($gt_kw_keys) ?>;
var gtThaiMonths = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
var gtRadarChart = null;

function gtGetData(year, month) {
    if (gtDataset[year] && gtDataset[year][month]) return gtDataset[year][month];
    return null;
}

function gtRender(key) {
    var parts = key.split('-');
    var year  = parseInt(parts[0]);
    var month = parseInt(parts[1]);
    var monthLabel = gtThaiMonths[month];

    var cur     = gtGetData(year, month);
    var prevYr  = gtGetData(year - 1, month);
    var prev2Yr = gtGetData(year - 2, month);

    // header tags
    document.getElementById('gt-current-label').textContent = monthLabel + ' ' + year;
    document.getElementById('gt-radar-title').textContent =
        monthLabel + ' ' + year + ' vs ' + monthLabel + ' ' + (year-1) + ' vs ' + monthLabel + ' ' + (year-2);
    document.getElementById('gt-table-title').textContent = monthLabel + ' ' + year;
    document.getElementById('gt-th-current').textContent = monthLabel + ' ' + (year-543).toString().slice(-2) + ' (' + year.toString().slice(-2) + ')';
    document.getElementById('gt-th-current').textContent = monthLabel + ' ' + year.toString().slice(-2);

    // Build series (skip null years)
    var series = [];
    if (cur)
        series.push({ name: monthLabel + ' ' + year + ' (ปัจจุบัน)', data: cur, color: '#0f766e', pointPlacement: 'on' });
    if (prevYr)
        series.push({ name: monthLabel + ' ' + (year-1) + ' (ปีก่อน)', data: prevYr, color: '#f59e0b', pointPlacement: 'on' });
    if (prev2Yr)
        series.push({ name: monthLabel + ' ' + (year-2) + ' (2 ปีก่อน)', data: prev2Yr, color: '#94a3b8', pointPlacement: 'on', dashStyle: 'ShortDot' });

    // ปรับ y-axis max ให้สวย
    var allVals = [];
    series.forEach(function(s){ s.data.forEach(function(v){ if (v != null) allVals.push(v); }); });
    var yMax = allVals.length ? Math.ceil(Math.max.apply(null, allVals) * 1.1 / 10) * 10 : 100;

    // Re-render radar
    if (gtRadarChart) gtRadarChart.destroy();
    gtRadarChart = Highcharts.chart('chartGtRadar', {
        chart: { polar: true, type: 'area', height: 400 },
        title: { text: null },
        pane: { size: '82%' },
        xAxis: {
            categories: gtKwLabels,
            tickmarkPlacement: 'on',
            lineWidth: 0,
            labels: { style: { fontSize: '12px', fontWeight: '700', color: '#1a3a3c' } }
        },
        yAxis: {
            gridLineInterpolation: 'polygon',
            lineWidth: 0,
            min: 0, max: yMax,
            labels: { style: { fontSize: '10px', color: '#94a3b8' } }
        },
        tooltip: {
            shared: true,
            backgroundColor: '#fff', borderColor: '#e2e8f0',
            pointFormat: '<span style="color:{series.color}">●</span> {series.name}: <b>{point.y}</b><br/>'
        },
        plotOptions: {
            area: { fillOpacity: 0.25, marker: { radius: 5, lineWidth: 2, lineColor: '#fff' }, lineWidth: 2.5 }
        },
        series: series,
        legend: { align: 'center', verticalAlign: 'bottom', itemStyle: { fontWeight: '600', fontSize: '11px' } },
        credits: { enabled: false }
    });

    // ===== Update YoY table =====
    var tbody = document.getElementById('gt-yoy-tbody');
    var noData = document.getElementById('gt-no-data');
    if (!cur) {
        tbody.innerHTML = '';
        noData.style.display = 'block';
        return;
    }
    noData.style.display = 'none';
    var rows = '';
    for (var i = 0; i < gtKwLabels.length; i++) {
        var c = cur[i];
        var p = prevYr ? prevYr[i] : null;
        var yoy = (p && p > 0) ? ((c - p) / p * 100) : null;
        var yoyText, yoyCls;
        if (yoy === null) {
            yoyText = 'n/a'; yoyCls = '';
        } else {
            yoyCls = yoy >= 0 ? 'up' : 'down';
            yoyText = (yoy >= 0 ? '▲ +' : '▼ ') + yoy.toFixed(1) + '%';
        }
        rows += '<tr>' +
            '<td>' + gtKwLabels[i] + '</td>' +
            '<td><strong>' + c + '</strong></td>' +
            '<td><span class="pp-yoy ' + yoyCls + '">' + yoyText + '</span></td>' +
            '</tr>';
    }
    tbody.innerHTML = rows;
}

// init + bind
gtRender('<?= $gt_radar_default ?>');
document.getElementById('gt-month-select').addEventListener('change', function() {
    gtRender(this.value);
});

// ============================================================
// [v2-F] CCI Regional — Grouped Bar Chart (ม.ค. vs ก.พ. 2569)
// ============================================================
if (document.getElementById('chartCciRegion')) {
    var cciRegions = <?= json_encode($cci_regions) ?>;
    var cats   = cciRegions.map(function(r){ return r.region; });
    var jans   = cciRegions.map(function(r){ return r.jan; });
    var febs   = cciRegions.map(function(r){ return r.feb; });
    var deltas = cciRegions.map(function(r){ return r.delta; });

    Highcharts.chart('chartCciRegion', {
        chart: { type: 'bar' },
        title: { text: null },
        xAxis: {
            categories: cats,
            labels: { style: { fontSize: '12px', fontWeight: '700', color: '#1a3a3c' } }
        },
        yAxis: [
            {
                min: 40, max: 65,
                title: { text: 'CCI Index', style: { color: '#64748b' } },
                gridLineColor: '#f1f5f9',
                plotLines: [{
                    value: <?= $cci_national_feb ?>,
                    color: '#dc2626',
                    width: 2,
                    dashStyle: 'ShortDash',
                    label: { text: 'ระดับชาติ <?= $cci_national_feb ?>', align: 'right', style: { color: '#dc2626', fontWeight: '700' } },
                    zIndex: 5
                }]
            }
        ],
        tooltip: {
            shared: true, useHTML: true,
            formatter: function() {
                var idx = this.points[0].point.index;
                var d = deltas[idx];
                var sym = d > 0 ? '+' : '';
                var color = d > 0 ? '#059669' : (d < 0 ? '#dc2626' : '#64748b');
                return '<b>' + this.x + '</b><br/>' +
                    this.points.map(function(p){
                        return '<span style="color:' + p.series.color + '">\u25cf</span> ' + p.series.name + ': <b>' + p.y + '</b>';
                    }).join('<br/>') +
                    '<br/><span style="color:' + color + ';font-weight:700;">Δ ' + sym + d + '</span>';
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 4, borderWidth: 0, pointPadding: 0.08, groupPadding: 0.12,
                dataLabels: { enabled: true, style: { fontSize: '11px', fontWeight: '700', textOutline: 'none', color: '#1a3a3c' } }
            }
        },
        series: [
            { name: 'ม.ค. 2569', data: jans, color: '#cbd5e1' },
            { name: 'ก.พ. 2569', data: febs, color: '#0f766e' }
        ],
        legend: { itemStyle: { fontWeight: '600' } }
    });
}

// ============================================================
// [v2] Leading Indicators — Mini Sparklines (CCI, GT, OR)
// ============================================================
var liMonths = <?= json_encode($li_month_labels) ?>;
function makeSparkline(containerId, name, data, color) {
    if (!document.getElementById(containerId)) return;
    Highcharts.chart(containerId, {
        chart: { type: 'areaspline', backgroundColor: 'transparent', margin: [6, 4, 20, 4] },
        title: { text: null },
        xAxis: {
            categories: liMonths,
            labels: { style: { fontSize: '9px', color: '#94a3b8' } },
            tickLength: 0, lineColor: '#e2e8f0'
        },
        yAxis: { title: { text: null }, labels: { enabled: false }, gridLineColor: 'transparent' },
        legend: { enabled: false },
        tooltip: { headerFormat: '<b>{point.x}</b><br/>', pointFormat: name + ': <b>{point.y}</b>' },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.15, lineWidth: 2.5,
                marker: { radius: 2, enabled: false, states: { hover: { enabled: true, radius: 5 } } }
            }
        },
        series: [{ data: data, color: color, connectNulls: true }]
    });
}
makeSparkline('liChartCci', 'CCI',           <?= json_encode($cci_overall) ?>, '#0f766e');
makeSparkline('liChartGt',  'Google Trends', <?= json_encode($gt_avg) ?>,      '#14b8a6');
makeSparkline('liChartOr',  'Occupancy %',   <?= json_encode($occ_monthly) ?>, '#059669');

// ============================================================
// [v2] Regional Sentiment Trend — ทั้งประเทศ 14 เดือน
// ============================================================
if (document.getElementById('chartRsTrend')) {
    Highcharts.chart('chartRsTrend', {
        chart: { },
        title: { text: null },
        xAxis: { categories: <?= json_encode($rs_trend_labels) ?>, crosshair: true },
        yAxis: [
            {
                title: { text: 'Mentions (ล้าน)', style: { color: '#0f766e' } },
                labels: { formatter: function() { return (this.value/1000000).toFixed(0) + 'M'; }, style: { color: '#0f766e' } },
                gridLineColor: '#f1f5f9'
            },
            {
                title: { text: 'Sentiment (%)', style: { color: '#dc2626' } },
                labels: { format: '{value}%', style: { color: '#dc2626' } },
                opposite: true, min: 0, max: 100
            }
        ],
        tooltip: {
            shared: true, useHTML: true,
            formatter: function() {
                var s = '<b>' + this.x + '</b><br/>';
                this.points.forEach(function(p) {
                    if (p.series.name === 'Mentions') {
                        s += '<span style="color:' + p.series.color + '">\u25cf</span> ' + p.series.name + ': <b>' + Highcharts.numberFormat(p.y, 0, '.', ',') + '</b><br/>';
                    } else {
                        s += '<span style="color:' + p.series.color + '">\u25cf</span> ' + p.series.name + ': <b>' + p.y + '%</b><br/>';
                    }
                });
                return s;
            }
        },
        plotOptions: {
            column: { borderRadius: 3, borderWidth: 0 },
            spline: { marker: { radius: 4 }, lineWidth: 2.5 }
        },
        series: [
            { name: 'Mentions',   type: 'column', yAxis: 0, data: <?= json_encode($rs_trend_mentions) ?>, color: '#0f766e', opacity: 0.7 },
            { name: 'Positive %', type: 'spline', yAxis: 1, data: <?= json_encode($rs_trend_pos) ?>,      color: '#059669' },
            { name: 'Negative %', type: 'spline', yAxis: 1, data: <?= json_encode($rs_trend_neg) ?>,      color: '#dc2626' }
        ],
        legend: { itemStyle: { fontWeight: '600' } }
    });
}

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
