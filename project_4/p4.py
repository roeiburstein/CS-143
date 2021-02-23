import json
import os
from pathlib import Path
import pprint

# load data
data_folder = Path("/home/cs143/data/")
data_file = data_folder / "nobel-laureates.json"
data = json.load(open(data_file, "r"))
pp = pprint.PrettyPrinter(indent=2)

loads = open("laureates.import","a") 

laureates = data["laureates"]


for index, laureate in enumerate(laureates):
    if 'orgName' in laureate:
        print("\n\nOrganization")
    else:
        print("\n\nPerson")
    pp.pprint(laureate)

    if index >= 3:
        break

