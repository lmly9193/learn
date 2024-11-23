s = int(input('請輸入加總開始值？'))
e = int(input('請輸入加總終止值？'))
inc = int(input('請輸入遞增減值？'))
sum = 0
i = s
while(i < e):
    sum = sum + i
    i = i + inc
print(sum)