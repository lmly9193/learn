def sum(num):
    if num == 1:
        return 1
    else:
        return num + sum(num-1)
n = int(input('請輸入n值？'))
ans = sum(n)
print('1+2+...+',n,'為',ans,sep='')
