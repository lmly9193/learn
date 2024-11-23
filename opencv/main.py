import os
from time import sleep
import cv2
import subprocess
import numpy

def scan(target):

    # 螢幕截圖(storge)
    # subprocess.check_output('adb exec-out screencap -p > ./cache/screencap.png', shell=True)
    # screenshot = cv2.imread('./cache/screencap.png')

    # 螢幕截圖(memory)
    pipe = subprocess.Popen("adb shell screencap -p", stdin=subprocess.PIPE, stdout=subprocess.PIPE, shell=True)
    image_bytes = pipe.stdout.read().replace(b'\r\n', b'\n')
    screenshot = cv2.imdecode(numpy.frombuffer(image_bytes, numpy.uint8), cv2.IMREAD_COLOR)

    # matchTemplate(image, templ, method[, result])
    #   - image
    #       - 被尋找的圖片，必須為 8-bit or 32-bit
    #   - templ
    #       - 尋找的物品圖片，size 不能大於 image，且格式需一致
    #   - method
    #       - 比對的方法
    #           - TM_SQDIFF         | 平方差，越小越相似
    #           - TM_SQDIFF_NORMED  | 正規化平方差，越小越相似
    #           - TM_CCORR          | 相關係數，越大越相似
    #           - TM_CCORR_NORMED   | 正規化相關係數，越大越相似
    #           - TM_CCOEFF         | 去掉直流成份的相關係數，越大越相似
    #           - TM_CCOEFF_NORMED  | 正規化 去掉直流成份的相關係數
    #   - result
    #       - 比較的結果，格式為 numpy.ndarray (dtype=float32)
    result = cv2.matchTemplate(screenshot, target, cv2.TM_CCORR_NORMED)
    
    # 取得搜尋結果最大值、最小值
    # 計算矩陣 Mat 中最大值、最小值、返回最大最小的索引
    min_val, max_val, min_loc, max_loc = cv2.minMaxLoc(result)
    return {'screenshot': screenshot, 'min_val': min_val, 'max_val': max_val, 'min_loc': min_loc, 'max_loc': max_loc}

# def draw(result):
#     # 取得搜尋結果最大值、最小值
#     # 計算矩陣 Mat 中最大值、最小值、返回最大最小的索引
#     min_val, max_val, min_loc, max_loc = cv2.minMaxLoc(result)

#     # TM_CCORR_NORMED 最大值
#     mat_top, mat_left = max_loc
    
#     # 取得目標取樣的高度及寬度
#     # image.shape = (height, width, channels)
#     prepared_height, prepared_width, prepared_channels = target.shape
    
#     # 取得需要繪製終點的右下位置(左上 + 高, 左上 + 寬)
#     bottom_right = (mat_top + prepared_width, mat_left + prepared_height)
    
#     # 繪製長方形(左上 + 高, 左上 + 寬)
#     # rectangle(繪製物件, 繪製的起始位置(x, y), 繪製的終點位置(x, y), 繪製顏色(RGB), 線條寬度)
#     cv2.rectangle(screenshot, (mat_top, mat_left), bottom_right, (101, 67, 196), 2)

#     # 輸出圖片結果
#     cv2.imwrite('./output.png', screenshot)

def calculated(result, shape):
    mat_top, mat_left = result['max_loc']
    prepared_height, prepared_width, prepared_channels = shape

    x = {
        'left': int(mat_top),
        'center': int((mat_top + mat_top + prepared_width) / 2),
        'right': int(mat_top + prepared_width),
    }

    y = {
        'top': int(mat_left),
        'center': int((mat_left + mat_left + prepared_height) / 2),
        'bottom': int(mat_left + prepared_height),
    }

    return {
        'x': x,
        'y': y,
    }

if __name__ == '__main__':
    while True:
        target = cv2.imread('./button/egg.png')
        result = scan(target)

        # 判斷畫面是否有跟圖片相符
        if result['max_val'] > 0.925:
            points = calculated(result, target.shape)
            print(points)

            x = points['x']['center'];
            y = points['y']['center'];

            subprocess.check_output('adb shell input tap %d %d' % (x, y), shell=True)

