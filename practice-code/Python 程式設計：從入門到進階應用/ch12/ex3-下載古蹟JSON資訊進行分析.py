import requests
import json
url="http://cloud.culture.tw/frontsite/trans/emapOpenDataAction.do?\
method=exportEmapJson&typeId=A&classifyId=1.1"
result=requests.get(url)
data=json.loads(result.text)
print(data)
for i in data:
    print(i['name'], i['level'], i['cityName'], i['address'])