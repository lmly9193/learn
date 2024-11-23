s = input('請輸入一行英文句子？')
s.strip(' .')
words = s.split(' ')
print(words[::-1])