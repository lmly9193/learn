import requests
from bs4 import BeautifulSoup as soup
url='https://pypi.python.org/pypi'
def getnews(url):
    page = requests.get(url).text
    htm=soup(page,'html.parser')
    items = [elem for elem in htm.find_all('table', class_='list') ]
    tds = [td for td in items[0].find_all('td')]
    print(tds)
    for i in range(0, len(tds)-1, 3):
        time = tds[i].string
        link = tds[i+1].a['href']
        pj = tds[i+1].a.string
        des = tds[i+2].string
        print(time, pj, des, 'https://pypi.python.org'+link)
getnews(url)