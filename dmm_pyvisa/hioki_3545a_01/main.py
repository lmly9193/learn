# -*- coding: utf-8 -*-

import pyvisa
import time

def benchmark_3545a_sampling_rate():
    # ================= 配置區域 =================
    # 請修改為您 3545a 的 IP
    INSTRUMENT_IP = "192.168.30.1"
    # Keysight 儀器 Socket Port 通常為 5025
    PORT = 23
    TEST_DURATION = 30.0             # 測試秒數
    # ===========================================

    # 資源字串格式
    resource_str = f"TCPIP0::{INSTRUMENT_IP}::{PORT}::SOCKET"
    rm = pyvisa.ResourceManager()

    try:
        print(f"正在連線至 Hioki 3545A ({resource_str})...")
        inst = rm.open_resource(resource_str)

        # RM3545A 的 LAN 通訊強制要求 CR+LF (\r\n)
        inst.read_termination = '\r\n'
        inst.write_termination = '\r\n'
        inst.timeout = 5000

        # 1. 初始化與優化速度設定
        print("初始化設定中...")
        inst.write("*RST")            # 重置儀器 [cite: 537]
        time.sleep(0.1)               # 注意: *RST 後需要一點時間恢復，建議 sleep
        inst.write("*CLS")            # 清除錯誤暫存器 [cite: 589]

        # 查詢型號
        print(f"儀器 ID: {inst.query('*IDN?').strip()}")

        # 設定為最快速度 FAST
        inst.write(":SAMPIe:RATE SLOW2")

        # 設定檔位 (Range)
        # 這裡設定為 100 mOhm (100E-3)
        # 關閉 Auto Range 以提升速度 [cite: 1739]
        inst.write(":SENSE:RESistance:RANGe 10.00000E+0")
        inst.write(":SENSE:RESistance:RANGe:AUTO OFF")

        # 觸發設定
        # 設定為內部觸發 (Internal Trigger) [cite: 2050]
        inst.write(":TRIGger:SOURce IMMediate")

        # RM3545A 必須開啟 Continuous，讓儀器自己在背景一直跑 (Free-Run)
        # 這樣我們才能用 FETCH? 快速抓值 [cite: 2020]
        inst.write(":INITiate:CONTinuous ON")

        # 2. 開始連續讀取測試
        print(f"\n開始測試採樣率 (持續 {TEST_DURATION} 秒)...")

        count = 0
        start_time = time.perf_counter()
        end_time = start_time + TEST_DURATION

        # 34461A 用 READ? (Trigger & Read)
        # RM3545A 建議用 FETCH? (Read Last Value)
        # 因為 RM3545A 的 :READ? 指令會強制把 Continuous 關掉 (:INIT:CONT OFF)
        # 所以在高速迴圈中，我們要用 :FETCH? 抓取 Free-Run 的最新值

        while time.perf_counter() < end_time:
            # 讀取數值
            # 預設 FETCH? 回傳格式可能包含狀態 (如 +1.0000E-03,OK)，視設定而定
            # 如果只回傳數值，直接 float 轉換即可
            val_str = inst.query(":FETCH?")

            # 簡單的防呆處理，如果回傳包含逗號(例如有多個值或狀態)，只取第一個
            if ',' in val_str:
                val_str = val_str.split(',')[0]

            count += 1
            # 若為了極限速度測試，可以註解掉 print
            print(f"讀取 {count}: {val_str}")

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
            # 測試結束，停止連續量測
            inst.write(":INITiate:CONTinuous OFF")
            # 回到本地操作面板 [cite: 2235]
            try:
                inst.write(":SYSTem:LOCal")
                print("已關閉遠端模式")
            except:
                pass
            inst.close()
        rm.close()

if __name__ == "__main__":
    benchmark_3545a_sampling_rate()
