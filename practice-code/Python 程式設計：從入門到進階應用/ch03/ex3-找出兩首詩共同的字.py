p1 = '紅豆生南國，春來發幾枝？願君多采擷，此物最相思。'
p2 = '春眠不覺曉，處處聞啼鳥。夜來風雨聲，花落知多少。'
s1 = set(p1)
s1.remove('，')
s1.remove('。')
s1.remove('？')
s2 = set(p2)
s2.remove('，')
s2.remove('。')
print(s1&s2)
