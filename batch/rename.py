import os
import hashlib

path = "C:/Users/Ethan/Desktop/test/Texture2D/"

s = hashlib.sha1()
files = os.listdir(path)

# print(files)

for index, value in enumerate(files):
    
    split = os.path.splitext(files[index])
    filename=split[0]
    extension=split[1][1:]

    sha1 = hashlib.sha1(filename.encode('utf-8')).hexdigest()

    renamer = '{filename} [{sha1}-0000000000].{extension}'
    name = renamer.format(filename=filename, extension=extension, sha1=sha1[:10].upper())

    os.rename(path + value, path + name)

    logout='{filename} ======> {name}'
    print(logout.format(filename=filename, name=name))
