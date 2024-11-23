import re
s = 'asss@  aaa@xxx.go  ase2ss.xxx.go'
email = re.findall('[a-zA-Z0-9]+@[a-zA-Z0-9\.]+', s)
print(email)
