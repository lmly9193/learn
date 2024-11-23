import re
s = '123  ab 123.456 1d2.df -456'
nums = re.findall('-?\d+\.?\d+', s)
print(nums)
