def c(m, n):
    if n == 0 or m == n:
        return 1
    else:
        return c(m-1, n) + c(m-1, n-1)
m = int(input('請輸入m值？'))
n = int(input('請輸入n值？'))
ans = c(m, n)
print('從', m, '取',n,'個的組合結果為',ans,sep='')
