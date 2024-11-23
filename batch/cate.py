import os
import shutil
import re

path = '.'
files = os.listdir(path)

for filename in files:
    filepath = os.path.join(path, filename)

    if os.path.isfile(filepath):
        result = re.search(r'\[(.*?)\]', filename)

        if result:
            foldername = result.group(1)

            folderpath = os.path.join(path, f"[{foldername}]")
            print(folderpath)
            if not os.path.exists(folderpath):
                os.makedirs(folderpath)

            new_filepath = os.path.join(folderpath, filename)
            try:
                shutil.move(filepath, new_filepath)
                print(f"{filepath} moved successfully to {new_filepath}.")
            except Exception as e:
                print(f"Error moving {filepath} to {new_filepath}: {e}")

input("Press enter to exit.")
