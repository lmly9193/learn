from datetime import datetime,timedelta
now = datetime.now()
for i in range(0,7):
    di = timedelta(days=i)
    nextday = now + di
    fmt = "%Y-%m-%d(%a)"
    print(nextday.strftime(fmt))