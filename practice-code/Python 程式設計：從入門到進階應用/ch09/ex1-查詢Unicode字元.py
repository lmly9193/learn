import unicodedata
ch = '\u7a0b'
def unicode_name(value):
    name = unicodedata.name(value)
    return name
print(ch)
print(unicode_name(ch))
print(ch.encode(encoding='utf-8'))

