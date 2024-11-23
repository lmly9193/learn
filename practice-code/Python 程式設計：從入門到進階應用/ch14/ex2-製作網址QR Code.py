import pyqrcode
url = pyqrcode.QRCode('https://www.google.com.tw',error='H')
url.png('google.png',scale=3)