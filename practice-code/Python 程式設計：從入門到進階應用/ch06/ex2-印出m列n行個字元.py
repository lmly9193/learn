def prmn(m, n, ch):
    for i in range(m):
        for j in range(n):
            print(ch, sep='', end='')
        print()
m = int(input('請輸入列數(m)？'))
n = int(input('請輸入行數(n)？'))
ch = input('請輸入要顯示的字元？')
prmn(m, n, ch)
