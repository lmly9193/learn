import tkinter as tk
from tkinter import messagebox, ttk
import serial.tools.list_ports
import time

# 自動檢測所有可用的 COM 埠
def list_com_ports():
    ports = serial.tools.list_ports.comports()
    return [port.device for port in ports]

# 初始化 Arduino 串列連接 (選擇的 COM 埠會在 GUI 中設定)
arduino = None

# 主要的 Tkinter 介面
class MotorControlApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Arduino Motor Control")
        self.root.geometry("400x400")

        # COM 埠選擇
        self.com_label = tk.Label(root, text="Select COM Port:")
        self.com_label.pack(pady=5)

        self.com_ports = list_com_ports()
        self.combobox = ttk.Combobox(root, values=self.com_ports)
        self.combobox.pack(pady=5)

        self.connect_button = tk.Button(root, text="Connect", command=self.connect_arduino)
        self.connect_button.pack(pady=5)

        # 啟動馬達按鈕
        self.start_button = tk.Button(root, text="Start Motor", command=self.start_motor, state=tk.DISABLED)
        self.start_button.pack(pady=10)

        # 停止馬達按鈕
        self.stop_button = tk.Button(root, text="Stop Motor", command=self.stop_motor, state=tk.DISABLED)
        self.stop_button.pack(pady=10)

        # 速度設定
        self.speed_label = tk.Label(root, text="Set Motor Speed (3000 - 5800 RPM):")
        self.speed_label.pack(pady=5)

        # 拉桿設定速度
        self.speed_scale = tk.Scale(root, from_=4000, to=5800, orient=tk.HORIZONTAL)
        self.speed_scale.set(4000)  # 設定預設值為 3000 RPM
        self.speed_scale.pack(pady=5)

        # 顯示目前速度
        self.current_speed_label = tk.Label(root, text=f"Current RPM: {self.speed_scale.get()}")
        self.current_speed_label.pack(pady=5)

        # 更新速度顯示並發送速度命令
        self.speed_scale.bind("<Motion>", self.update_current_speed)

    def connect_arduino(self):
        global arduino
        selected_port = self.combobox.get()
        if selected_port:
            try:
                arduino = serial.Serial(selected_port, 9600, timeout=1)
                time.sleep(2)  # 給 Arduino 一些時間來初始化
                messagebox.showinfo("Info", f"Connected to {selected_port}")
                # 啟用控制按鈕
                self.start_button.config(state=tk.NORMAL)
                self.stop_button.config(state=tk.NORMAL)
            except serial.SerialException:
                messagebox.showerror("Error", "Could not open COM port. Please check the connection.")
                arduino = None
        else:
            messagebox.showwarning("Warning", "Please select a COM port.")

    def send_command(self, command):
        if arduino:
            arduino.write((command + '\n').encode())
        else:
            messagebox.showerror("Error", "Arduino not connected.")

    def start_motor(self):
        self.send_command("start")

    def stop_motor(self):
        self.send_command("stop")

    def update_current_speed(self, event):
        speed = self.speed_scale.get()
        self.current_speed_label.config(text=f"Current RPM: {speed}")
        self.send_command(f"speed:{speed}")

# 啟動 GUI 應用程式
if __name__ == "__main__":
    root = tk.Tk()
    app = MotorControlApp(root)
    root.mainloop()

# 關閉串列通訊
if arduino:
    arduino.close()
