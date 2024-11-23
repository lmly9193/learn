import os
import subprocess

# 指定包含 .ts 檔案的目錄
directory = './ts'
destination = './ffmpeg'

for filename in os.listdir(directory):
    if filename.endswith(".ts"):
        # 獲取檔案名，不包含副檔名
        base_name = os.path.splitext(filename)[0]

        # 指定輸出檔案的名稱
        output_name = os.path.join(destination, f'{base_name}.mp4')

        # 設定源檔案的完整路徑
        input_path = os.path.join(directory, filename)

        # 執行 ffmpeg 命令
        subprocess.run(['ffmpeg', '-i', input_path, '-c', 'copy', output_name])

print("轉換完成")
