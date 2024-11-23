import os
path = "f:\\"
bigfiles = []
for root, dirs, files in os.walk(path):
    for file in files:
        if os.path.getsize(os.path.join(root, file)) > 100000000:
             bigfiles.append(os.path.join(root, file))
for file in bigfiles:
    print(file)