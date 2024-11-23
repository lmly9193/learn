import re
with open('poem.txt','rt',encoding='utf-8') as fin:
    s = fin.read()
    s = re.findall('\w', s)
    wc = [(w,s.count(w)) for w in set(s)]
    swc = sorted(wc, key=lambda x: x[1], reverse=True)
    print(swc)
    with open('ex2-poem.txt', 'wt', encoding='utf-8') as fout:
        for w, c in swc:
            print(w,c,file=fout)

