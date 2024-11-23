import re
import csv
with open('poem.txt', 'rt', encoding='utf-8') as fin:
    s = fin.read()
    s = re.findall('\w', s)
    wc = [(w, s.count(w)) for w in set(s)]
    swc = sorted(wc, key=lambda x: x[1], reverse=True)
    print(swc)
    with open('ex3-poem.csv', 'wt', newline='') as fout:
        writer = csv.writer(fout)
        for w, c in swc:
            writer.writerow([str(w), str(c)])

