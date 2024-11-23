import re
s = '英文諺語「The best fish swim near the bottom.」，中文意思為「好酒沉甕底」。'
words = re.findall('\w+', s)
print(words)
