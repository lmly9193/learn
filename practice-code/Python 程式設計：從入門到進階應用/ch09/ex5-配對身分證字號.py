import re
s = 'B342232223 Z123456789 Z1234543'
id = re.findall('[A-Z][12][0-9]{8}', s)
print(id)
