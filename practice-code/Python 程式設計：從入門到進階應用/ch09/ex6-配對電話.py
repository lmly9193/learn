import re
s = '1234-567-789 123-4444-555 1234-55-5555'
phone = re.findall('\d{4}-\d{3}-\d{3}', s)
print(phone)
