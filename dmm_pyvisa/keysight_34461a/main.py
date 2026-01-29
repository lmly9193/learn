# -*- coding: utf-8 -*-

import pyvisa
import time

def benchmark_34461a_sampling_rate():
    # ================= 配置區域 =================
    # 請修改為您 34461A 的 IP
    INSTRUMENT_IP = "192.168.50.10"
    # Keysight 儀器 Socket Port 通常為 5025
    PORT = 5025
    TEST_DURATION = 30.0             # 測試秒數
    # ===========================================

    # 資源字串格式
    resource_str = f"TCPIP0::{INSTRUMENT_IP}::{PORT}::SOCKET"
    rm = pyvisa.ResourceManager()

    try:
        print(f"正在連線至 Keysight 34461A ({resource_str})...")
        inst = rm.open_resource(resource_str)

        # Keysight 儀器通常以 \n 作為結尾
        inst.read_termination = '\n'
        inst.write_termination = '\n'
        inst.timeout = 5000

        # 1. 初始化與優化速度設定
        print("初始化設定中...")
        inst.write("*RST")            # 重置儀器
        inst.write("*CLS")            # 清除錯誤暫存器

        # 查詢型號
        print(f"儀器 ID: {inst.query('*IDN?').strip()}")

        # 設定為兩線式電阻模式 (RES)
        inst.write("CONF:RES")

        # 【關鍵速度設定】設定積分時間 (NPLC)
        # 0.02 NPLC 是最快積分時間，適合衝高採樣率
        # 1 NPLC = 16.6ms (60Hz) 或 20ms (50Hz)
        inst.write("RES:NPLC 0.02")

        # 關閉 Auto Zero (可倍增速度，但稍微犧牲精準度)
        inst.write("RES:ZERO:AUTO OFF")

        # 關閉自動換檔 (Auto Range)，固定在 100 Ohm 檔位
        # 可用範圍: 100, 1E3, 10E3, 100E3, 1E6, 10E6, 100E6
        inst.write("RES:RANG 100")

        # 設定觸發延遲為 0
        inst.write("TRIG:DEL 0")

        # 設定觸發來源為立即 (Immediate)
        inst.write("TRIG:SOUR IMM")

        # 2. 開始連續讀取測試
        print(f"\n開始測試採樣率 (持續 {TEST_DURATION} 秒)...")

        count = 0
        start_time = time.perf_counter()
        end_time = start_time + TEST_DURATION

        # 34461A 建議使用 READ? 進行連續觸發讀取
        # 或者使用 INIT + FETCH? (類似 Hioki)
        # 這裡為了簡單直接用 READ? 測試迴圈速度

        while time.perf_counter() < end_time:
            # 讀取數值
            val = inst.query("READ?")
            count += 1
            # 將科學記號轉換為一般數值格式
            resistance = float(val.strip())
            print(f"讀取 {count}: {resistance:.6f} Ω")

        actual_duration = time.perf_counter() - start_time
        sps = count / actual_duration

        print("-" * 30)
        print(f"測試完成!")
        print(f"總讀取次數: {count}")
        print(f"實際耗時: {actual_duration:.4f} 秒")
        print(f"平均採樣率 (SPS): {sps:.2f} samples/sec")
        print("-" * 30)

    except Exception as e:
        print(f"發生錯誤: {e}")
    finally:
        if 'inst' in locals():
            # 關閉遠端模式，讓儀器回到本地操作
            try:
                inst.write("SYST:LOC")
                print("已關閉遠端模式")
            except:
                pass
            inst.close()
        rm.close()

if __name__ == "__main__":
    benchmark_34461a_sampling_rate()
