def check(pwd):
    if pwd.isdigit():
        if len(pwd) < 6:
            return '不安全的密碼'
        else:
            return '可能是安全的密碼'
    elif pwd.isalpha():
        if len(pwd) < 6:
            return '不安全的密碼'
        else:
            return '可能是安全的密碼'
    elif len(pwd) < 6:
        return '不安全的密碼'
    elif len(pwd) < 10:
        return '安全的密碼'
    else:
        return '非常安全的密碼'
pwd = input('請輸入密碼？')
sec = check(pwd)
print(pwd, '為', sec)
