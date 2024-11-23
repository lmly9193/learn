import re
s = 'The best fish swim near the bottom.'
words = re.findall('[A-Za-z]+', s)
print(words)
