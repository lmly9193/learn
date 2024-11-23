# 實時影像文字識別 (OCR)

## 簡介

這是一個基於 Python 的即時文字識別應用，通過攝影機實時捕捉影像並提取其中的文字內容。專案使用 OpenCV 進行影像處理，並透過 Tesseract-OCR 執行文字識別。


## 功能

- 使用攝影機即時擷取影像。
- 提高影像對比度以提升文字識別效果。
- 支援灰階轉換、二值化及影像去噪處理。
- 使用 Tesseract-OCR 識別影像中的文字。
- 動態標註文字區域並顯示信心分數高於 90 的識別結果。


## 使用技術

- Python: 作為主要開發語言。
- OpenCV: 用於影像處理和顯示。
- Tesseract-OCR: 負責文字識別。
- Numpy: 用於影像數據的矩陣運算。


## 先決條件

1. 安裝 Python 3.7+
2. 安裝 Tesseract-OCR 並設定其路徑：
    - 在系統中安裝 Tesseract-OCR。
    - 將 Tesseract 的安裝路徑加入環境變數，或於 .env 檔案中設置 TESSERACT_PATH 變數，範例如下：
        ```env
        TESSERACT_PATH=C:\Program Files\Tesseract-OCR\tesseract.exe
        ```

3. 安裝必要的 Python 套件：
    ```console
    pip install opencv-python numpy pytesseract python-dotenv
    ```
