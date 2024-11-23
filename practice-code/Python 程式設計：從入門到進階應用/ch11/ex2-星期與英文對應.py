import collections
days = ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六']
eng = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
week = collections.OrderedDict(zip(days,eng))
print(week)
