#!/usr/bin/env python3
"""
TAT_tourist — Tier 2 International Forecast (SARIMAX + Holt)
=============================================================
อ่าน history จาก PHP dump (forecast_inter_history.json)
สร้าง SARIMAX + Holt forecast 6 เดือน สำหรับ:
  - overall
  - 7 regions
  - top-10 countries

Output: ../public/data/forecast_inter_tier2.json

ใช้งาน:
  1) เปิดหน้า /main/forecast_inter สัก 1 ครั้ง เพื่อ dump history JSON
  2) cd analytics && source venv/bin/activate && python forecast_inter_sarima.py
"""
from __future__ import annotations

import json
import warnings
from datetime import datetime
from pathlib import Path

import numpy as np
import pandas as pd
from statsmodels.tsa.holtwinters import ExponentialSmoothing
from statsmodels.tsa.statespace.sarimax import SARIMAX

warnings.filterwarnings("ignore")

ROOT = Path(__file__).resolve().parent.parent
HISTORY_PATH = ROOT / "public" / "data" / "forecast_inter_history.json"
OUTPUT_PATH = ROOT / "public" / "data" / "forecast_inter_tier2.json"

N_FORECAST = 6  # เดือนข้างหน้า
MONTHS_TH = ["", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
             "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."]


def flatten_monthly_by_year(mb: dict, max_month: int, current_year: int):
    """Flatten {year: {month: value}} → (labels, values) sorted chronologically,
    เอาเฉพาะเดือนที่มี actual (current_year ตัดที่ max_month - 1)."""
    labels = []
    values = []
    years = sorted(int(y) for y in mb.keys())
    for y in years:
        year_data = mb[str(y)]
        for m in range(1, 13):
            if y == current_year and m >= max_month:
                continue
            v = year_data.get(str(m))
            if v is None or v <= 0:
                continue
            labels.append(f"{MONTHS_TH[m]} {(y + 543) - 2500}")
            values.append(float(v) / 1_000_000)  # ล้านคน
    return labels, values


def future_labels_from(max_month: int, current_year: int, n: int):
    out = []
    m, y = max_month, current_year
    for _ in range(n):
        out.append(f"{MONTHS_TH[m]} {(y + 543) - 2500}")
        m += 1
        if m > 12:
            m = 1
            y += 1
    return out


def fit_sarimax(series: pd.Series, n_ahead: int):
    """SARIMAX(1,1,1)(1,1,1,12) univariate — ถ้า data น้อย seasonality ลด"""
    if len(series) < 24:
        # seasonality 12 ต้องการข้อมูล >= 24 เดือน — ถ้าน้อยใช้แค่ non-seasonal
        order = (1, 1, 1)
        seasonal = (0, 0, 0, 0)
    else:
        order = (1, 1, 1)
        seasonal = (1, 1, 1, 12)
    try:
        model = SARIMAX(series, order=order, seasonal_order=seasonal,
                        enforce_stationarity=False, enforce_invertibility=False)
        res = model.fit(disp=False, maxiter=200)
        fitted = res.fittedvalues
        fc_res = res.get_forecast(steps=n_ahead)
        fc_mean = fc_res.predicted_mean
        conf = fc_res.conf_int(alpha=0.2)  # 80% CI
        return {
            "fitted": [float(v) for v in fitted.values],
            "forecast": [float(v) for v in fc_mean.values],
            "lower": [float(v) for v in conf.iloc[:, 0].values],
            "upper": [float(v) for v in conf.iloc[:, 1].values],
            "order": str(order),
            "seasonal": str(seasonal),
        }
    except Exception as e:
        return {"error": str(e)}


def fit_holt(series: pd.Series, n_ahead: int):
    if len(series) < 24:
        try:
            model = ExponentialSmoothing(series, trend="add", seasonal=None).fit()
            fc = model.forecast(n_ahead)
            return {"forecast": [float(v) for v in fc.values]}
        except Exception as e:
            return {"error": str(e)}
    try:
        model = ExponentialSmoothing(series, trend="add", seasonal="add",
                                     seasonal_periods=12).fit()
        fc = model.forecast(n_ahead)
        return {"forecast": [float(v) for v in fc.values]}
    except Exception as e:
        return {"error": str(e)}


def anomaly_detect(values: list):
    arr = np.array(values)
    mom = np.diff(arr) / arr[:-1] * 100
    if len(mom) == 0:
        return []
    q1, q3 = np.percentile(mom, [25, 75])
    iqr = q3 - q1
    lo = q1 - 1.5 * iqr
    hi = q3 + 1.5 * iqr
    out = []
    for i, v in enumerate(mom):
        if v < lo or v > hi:
            out.append({"idx": int(i + 1), "mom_pct": float(v),
                        "type": "low" if v < lo else "high"})
    return out


def process_series(name: str, monthly_by_year: dict, max_month: int, current_year: int):
    labels, values = flatten_monthly_by_year(monthly_by_year, max_month, current_year)
    if len(values) < 6:
        return {"name": name, "error": "insufficient data", "n": len(values)}
    y = pd.Series(values)
    future_labels = future_labels_from(max_month, current_year, N_FORECAST)
    return {
        "name": name,
        "n": len(values),
        "data_meta": {
            "labels": labels,
            "visitors_m": values,
            "future_labels": future_labels,
        },
        "sarimax": fit_sarimax(y, N_FORECAST),
        "holt": fit_holt(y, N_FORECAST),
        "anomaly": anomaly_detect(values),
    }


def main():
    if not HISTORY_PATH.exists():
        print(f"ERROR: ไม่พบ history file: {HISTORY_PATH}")
        print("กรุณาเปิดหน้า /main/forecast_inter อย่างน้อย 1 ครั้งก่อน เพื่อ dump history")
        return 1

    history = json.loads(HISTORY_PATH.read_text(encoding="utf-8"))
    max_month = int(history["max_month"])
    current_year = int(history["current_year"])

    out = {
        "generated_at": datetime.now().isoformat(timespec="seconds"),
        "source_history_at": history.get("generated_at"),
        "n_forecast": N_FORECAST,
        "indicators": history.get("indicators"),
    }

    # Overall
    print("[1/3] Overall SARIMAX...")
    overall_result = process_series(
        "overall", history["overall_monthly_by_year"], max_month, current_year,
    )
    out["overall"] = overall_result
    # Keep top-level aliases for PHP chart to use directly
    if "data_meta" in overall_result:
        out["data_meta"] = overall_result["data_meta"]
        out["sarimax"] = overall_result["sarimax"]
        out["holt"] = overall_result["holt"]
        out["anomaly"] = overall_result["anomaly"]

    # Regions
    print("[2/3] Regions SARIMAX...")
    out["regions"] = {}
    for rname, rdata in history.get("regions", {}).items():
        print(f"   · {rname}")
        out["regions"][rname] = process_series(rname, rdata["monthly_by_year"],
                                               max_month, current_year)

    # Countries
    print("[3/3] Countries SARIMAX...")
    out["countries"] = {}
    for cid, cdata in history.get("countries", {}).items():
        print(f"   · {cdata.get('name', cid)}")
        out["countries"][cid] = process_series(cdata.get("name", cid),
                                               cdata["monthly_by_year"],
                                               max_month, current_year)

    OUTPUT_PATH.parent.mkdir(parents=True, exist_ok=True)
    OUTPUT_PATH.write_text(json.dumps(out, ensure_ascii=False, indent=2),
                           encoding="utf-8")
    print(f"\nDONE → {OUTPUT_PATH}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
