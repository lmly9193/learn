import fnmatch
import os
from PIL import Image
path = "f:\\python"
matches = []
for root, dirs, files in os.walk(path):
    for file in fnmatch.filter(files, '*.jpg'):
        matches.append((root, file))
for (mdir, mfile) in matches:
    im = Image.open(mdir+'\\'+mfile)
    im2 = im.resize((int(im.size[0]*0.3), int(im.size[1]*0.3)))
    outfile = mdir+'\\'+os.path.splitext(mfile)[0]+'.tif'
    im2.save(outfile, 'TIFF')
