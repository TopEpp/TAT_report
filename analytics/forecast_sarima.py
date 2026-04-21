#!/usr/bin/env python3
"""
TAT_tourist — Tier 2 Analytics (Pre-computed)
===============================================
รัน script นี้บนเครื่อง dev (มี Python) เพื่อสร้างไฟล์ JSON
ที่ PHP frontend อ่านไปแสดง — server prod ไม่ต้องมี Python

Output: ../public/data/forecast_tier2.json

ใช้งาน:
  $ source venv/bin/activate
  $ python forecast_sarima.py

Features:
  1) SARIMAX forecast 6 เดือน (exogenous: CCI, GT, OR, Oil)
  2) Holt-Winters trend forecast (univariate fallback)
  3) Anomaly detection (IQR + z-score ของ MoM change)
  4) Seasonal-like decomposition (moving average trend + residual)
"""
from __future__ import annotations

import json
import os
import sys
import warnings
from datetime import datetime
from pathlib import Path

import numpy as np
import pandas as pd
from statsmodels.tsa.holtwinters import ExponentialSmoothing
from statsmodels.tsa.statespace.sarimax import SARIMAX

warnings.filterwarnings("ignore")

# ====================================================================
# Historical data (mirror จาก PHP realtime2/forecast — 14 เดือน)
# ====================================================================
MONTH_LABELS = [
    "ก.พ.68", "มี.ค.68", "เม.ย.68", "พ.ค.68", "มิ.ย.68", "ก.ค.68",
    "ส.ค.68", "ก.ย.68", "ต.ค.68", "พ.ย.68", "ธ.ค.68",
    "ม.ค.69", "ก.พ.69", "มี.ค.69",
]
# Valid rows = 13 (index 0..12) · Last month มี.ค.69 มี null + outlier จึงใช้ไม่ได้
VISITORS = [
    25633814, 26527872, 26604374, 27066883, 25319078, 25802437,
    24434297, 24795743, 25884768, 25118127, 26682688, 29713504, 27447304,
]  # คน
OCC = [77.62, 74.99, 74.69, 68.30, 66.09, 68.16, 68.69, 66.73, 70.94, 72.78, 78.09, 77.52, 77.24]  # %
OIL = [36.12, 36.50, 37.20, 36.95, 36.40, 36.75, 37.10, 36.80, 36.50, 36.20, 35.90, 35.75, 36.10]  # ฿
CCI = [52.0, 50.8, 48.8, 48.9, 46.7, 48.4, 47.9, 49.4, 50.9, 51.8, 51.8, 52.6, 53.0]
GT = [23.45, 24.32, 30.75, 23.60, 22.28, 26.35, 24.48, 22.60, 30.40, 28.20, 33.10, 24.00, 21.90]

FUTURE_LABELS = ["เม.ย.69", "พ.ค.69", "มิ.ย.69", "ก.ค.69", "ส.ค.69", "ก.ย.69"]
N_FORECAST = len(FUTURE_LABELS)

# ====================================================================
# 1) Data prep
# ====================================================================
y = pd.Series(
    [v / 1_000_000 for v in VISITORS],
    index=pd.RangeIndex(len(VISITORS)),
    name="visitors_m",
)
X = pd.DataFrame(
    {"cci": CCI, "gt": GT, "or_": OCC, "oil": OIL},
    index=y.index,
)


def linear_trend(series):
    """Fit y = a + b*t and return (a, b)."""
    n = len(series)
    t = np.arange(1, n + 1)
    b, a = np.polyfit(t, series, 1)
    return a, b


def project_series(series, n_ahead):
    """Project univariate series n_ahead steps via linear trend."""
    a, b = linear_trend(series)
    n = len(series)
    return [float(a + b * (n + 1 + i)) for i in range(n_ahead)]


# ====================================================================
# 2) Univariate forecast — Holt-Winters (trend only, damped)
# ====================================================================
def holt_forecast(y, n_ahead):
    try:
        model = ExponentialSmoothing(
            y.values,
            trend="add",
            damped_trend=True,
            seasonal=None,
        )
        fit = model.fit(optimized=True)
        fcst = fit.forecast(n_ahead)
        resid_std = float(np.std(fit.resid, ddof=1))
        # CI ±1.96 × residual σ (approximation)
        lower = (fcst - 1.96 * resid_std).tolist()
        upper = (fcst + 1.96 * resid_std).tolist()
        return {
            "method": "Holt-Winters (damped trend, additive)",
            "fitted": [round(float(v), 3) for v in fit.fittedvalues],
            "forecast": [round(float(v), 3) for v in fcst],
            "lower": [round(float(v), 3) for v in lower],
            "upper": [round(float(v), 3) for v in upper],
            "resid_std": round(resid_std, 4),
            "sse": round(float(np.sum(fit.resid ** 2)), 3),
        }
    except Exception as e:
        return {"method": "Holt-Winters FAILED", "error": str(e)}


# ====================================================================
# 3) Multivariate forecast — SARIMAX with exog (CCI, GT, OR, Oil)
# ====================================================================
def sarimax_forecast(y, X, n_ahead):
    try:
        # Project features forward via linear trend
        exog_future = np.column_stack([
            project_series(X["cci"].values, n_ahead),
            project_series(X["gt"].values, n_ahead),
            project_series(X["or_"].values, n_ahead),
            project_series(X["oil"].values, n_ahead),
        ])

        # ARIMA(1,1,1) non-seasonal + exog (13 obs ไม่พอสำหรับ seasonal(12))
        model = SARIMAX(
            y.values,
            exog=X.values,
            order=(1, 1, 1),
            enforce_stationarity=False,
            enforce_invertibility=False,
        )
        fit = model.fit(disp=False, maxiter=200)
        fcst = fit.get_forecast(steps=n_ahead, exog=exog_future)
        mean = fcst.predicted_mean
        ci = fcst.conf_int(alpha=0.05)  # 95% CI

        return {
            "method": "SARIMAX(1,1,1) + exog",
            "exog_future": {
                "cci": [round(v, 2) for v in exog_future[:, 0].tolist()],
                "gt":  [round(v, 2) for v in exog_future[:, 1].tolist()],
                "or":  [round(v, 2) for v in exog_future[:, 2].tolist()],
                "oil": [round(v, 2) for v in exog_future[:, 3].tolist()],
            },
            "fitted": [round(float(v), 3) for v in fit.fittedvalues],
            "forecast": [round(float(v), 3) for v in mean.tolist()],
            "lower": [round(float(v), 3) for v in ci[:, 0].tolist()],
            "upper": [round(float(v), 3) for v in ci[:, 1].tolist()],
            "aic": round(float(fit.aic), 2),
            "bic": round(float(fit.bic), 2),
            "llf": round(float(fit.llf), 2),
        }
    except Exception as e:
        return {"method": "SARIMAX FAILED", "error": str(e)}


# ====================================================================
# 4) Anomaly detection (IQR + z-score)
# ====================================================================
def detect_anomalies(y, labels):
    values = np.array(y.values, dtype=float)
    # MoM change
    mom = np.diff(values) / values[:-1] * 100  # %

    # IQR method
    q1, q3 = np.percentile(values, [25, 75])
    iqr = q3 - q1
    low_thr = q1 - 1.5 * iqr
    high_thr = q3 + 1.5 * iqr

    # Z-score on MoM
    mom_mean = float(np.mean(mom))
    mom_std = float(np.std(mom, ddof=1))

    anomalies = []
    for i, v in enumerate(values):
        flags = []
        if v > high_thr:
            flags.append("high_level")
        if v < low_thr:
            flags.append("low_level")
        if i > 0 and mom_std > 0:
            z = (mom[i - 1] - mom_mean) / mom_std
            if abs(z) > 2.0:
                flags.append("spike_up" if z > 0 else "spike_down")
        if flags:
            anomalies.append({
                "index": i,
                "month": labels[i],
                "value": round(float(v), 3),
                "mom_pct": round(float(mom[i - 1]), 2) if i > 0 else None,
                "flags": flags,
            })

    return {
        "iqr_low": round(float(low_thr), 3),
        "iqr_high": round(float(high_thr), 3),
        "q1": round(float(q1), 3),
        "q3": round(float(q3), 3),
        "median": round(float(np.median(values)), 3),
        "mean": round(float(np.mean(values)), 3),
        "std": round(float(np.std(values, ddof=1)), 3),
        "mom_mean": round(mom_mean, 3),
        "mom_std": round(mom_std, 3),
        "anomalies": anomalies,
    }


# ====================================================================
# 5) Trend decomposition (moving average)
# ====================================================================
def decompose(y, labels, window=3):
    values = np.array(y.values, dtype=float)
    n = len(values)
    # Centered moving average trend
    trend = np.full(n, np.nan)
    half = window // 2
    for i in range(half, n - half):
        trend[i] = float(np.mean(values[i - half:i + half + 1]))
    # Fill edges by nearest
    for i in range(half):
        trend[i] = trend[half]
    for i in range(n - half, n):
        trend[i] = trend[n - half - 1]
    # Residual = observed - trend
    residual = values - trend
    # YoY growth (assume 13 months not enough for proper yoY, skip)
    return {
        "observed": [round(float(v), 3) for v in values.tolist()],
        "trend":    [round(float(v), 3) for v in trend.tolist()],
        "residual": [round(float(v), 3) for v in residual.tolist()],
        "window":   window,
        "labels":   list(labels),
    }


# ====================================================================
# Main
# ====================================================================
def main():
    print(f"[{datetime.now().isoformat(timespec='seconds')}] Tier 2 analytics pipeline")
    print(f"  Data: {len(y)} months (visitors range {y.min():.2f}–{y.max():.2f} M)")

    result = {
        "generated_at": datetime.now().isoformat(timespec="seconds"),
        "generator": "forecast_sarima.py (statsmodels)",
        "data_meta": {
            "n_obs": int(len(y)),
            "labels": MONTH_LABELS[:len(y)],
            "future_labels": FUTURE_LABELS,
            "visitors_m": [round(float(v), 3) for v in y.values.tolist()],
        },
        "holt": holt_forecast(y, N_FORECAST),
        "sarimax": sarimax_forecast(y, X, N_FORECAST),
        "anomaly": detect_anomalies(y, MONTH_LABELS[:len(y)]),
        "decomposition": decompose(y, MONTH_LABELS[:len(y)], window=3),
    }

    # Output
    out_dir = Path(__file__).resolve().parent.parent / "public" / "data"
    out_dir.mkdir(parents=True, exist_ok=True)
    out_path = out_dir / "forecast_tier2.json"
    with open(out_path, "w", encoding="utf-8") as f:
        json.dump(result, f, ensure_ascii=False, indent=2)

    # Print summary
    print(f"\n=== Summary ===")
    print(f"  Holt forecast:    {result['holt'].get('forecast', 'FAIL')}")
    print(f"  SARIMAX forecast: {result['sarimax'].get('forecast', 'FAIL')}")
    if 'aic' in result['sarimax']:
        print(f"  SARIMAX AIC:      {result['sarimax']['aic']}")
    print(f"  Anomalies:        {len(result['anomaly']['anomalies'])} points flagged")
    print(f"\nOutput → {out_path}")
    return 0


if __name__ == "__main__":
    sys.exit(main())
