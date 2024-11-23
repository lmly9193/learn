import requests
import xml.etree.ElementTree as xmltree
url="http://cloud.culture.tw/frontsite/trans/emapOpenDataAction.do?\
method=exportEmapXML&typeId=A&classifyId=1.1"
result=requests.get(url)
element=xmltree.fromstring(result.text)
print(xmltree.dump(element))
for item in element.findall('./emapItem/emap/Info'):
    print(item.attrib['name'], item.attrib['level'], item.attrib['cityName'], item.attrib['address'])
