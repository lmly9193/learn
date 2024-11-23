def fac(n):
    result = 1
    for i in range(1,n+1):
        result *= i
        yield result
n = int(input('請輸入N值？'))
for i in fac(n):
    print(i)
