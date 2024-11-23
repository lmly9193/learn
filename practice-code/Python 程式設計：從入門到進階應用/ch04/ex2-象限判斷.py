x = float(input('請輸入該點的X座標？'))
y = float(input('請輸入該點的Y座標？'))
if (x > 0 and y > 0):
    print('該點在第一象限')
elif (x < 0 and y > 0):
    print('該點在第二象限')
elif (x < 0 and y < 0):
    print('該點在第三象限')
elif (x > 0 and y < 0):
    print('該點在第四象限')
else:
    print('該點在座標軸上')

