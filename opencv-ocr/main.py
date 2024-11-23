import os
from dotenv import load_dotenv
import cv2
import pytesseract
import numpy as np

load_dotenv()
pytesseract.pytesseract.tesseract_cmd = os.getenv('TESSERACT_PATH')

cap = cv2.VideoCapture(0)

if not cap.isOpened():
    print("Cannot open camera")
    exit()

while(True):
    # 擷取影像
    ret, frame = cap.read()
    if not ret:
        print("Can't receive frame (stream end?). Exiting ...")
        break

    pre_processed = frame.copy()

    # 提高對比
    alpha = 1.7
    beta = 0
    pre_processed = cv2.convertScaleAbs(pre_processed, alpha=alpha, beta=beta)

    # 彩色轉灰階
    pre_processed = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

    # 二值化反轉
    pre_processed = cv2.threshold(pre_processed, 250, 255, cv2.THRESH_BINARY_INV + cv2.THRESH_OTSU)[1]

    # 模糊化
    pre_processed = cv2.medianBlur(pre_processed, 1)

    # 開運算
    kernel = np.ones((1, 1), np.uint8)
    pre_processed = cv2.morphologyEx(pre_processed, cv2.MORPH_OPEN, kernel, iterations=2)


    hFrame, wFrame = frame.shape[:2]

    data = pytesseract.image_to_data(pre_processed, lang='eng', config='--psm 6', output_type=pytesseract.Output.DICT)
    for i in range(len(data['text'])):
        # 僅列出信心超過 60 的文字
        if int(data['conf'][i]) > 90:
            # 提取位置和尺寸
            x, y, w, h = data['left'][i], data['top'][i], data['width'][i], data['height'][i]

            # 繪製方框
            cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 1)

            # 繪製文字
            cv2.putText(frame, data['text'][i], (x, y + h + 25), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 0, 255), 1)


    # 顯示圖片
    cv2.imshow('OCR', frame)
    cv2.imshow('Pre-Processed', pre_processed)

    # 按下 q 鍵離開迴圈
    if cv2.waitKey(1) == ord('q'):
        break

# 釋放該攝影機裝置
cap.release()
cv2.destroyAllWindows()
