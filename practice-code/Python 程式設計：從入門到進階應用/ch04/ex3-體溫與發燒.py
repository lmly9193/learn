temp = float(input('請輸入體溫？'))
if (temp < 36):
    print('體溫過低')
elif (temp < 38):
    print('體溫正常')
elif (temp < 39):
    print('體溫有點燒')
else:
    print('體溫很燒')

