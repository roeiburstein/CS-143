import json
import os
from pathlib import Path

data_folder = Path("/home/cs143/data/")
data_file = data_folder / "nobel-laureates.json"
data = json.load(open(data_file, "r"))

if os.path.exists("laureates.import"):
    os.remove("laureates.import")

loads = open("laureates.import","a") 
laureates = data["laureates"]

for index, laureate in enumerate(laureates):
    loads.write(json.dumps(laureate) + "\n")