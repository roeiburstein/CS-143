import json
import os
from pathlib import Path
import pprint
import pandas as pd

# load data
data_folder = Path("/home/cs143/data/")
file = data_folder / "nobel-laureates.json"
data = json.load(open(file, "r"))

laureates = data["laureates"]
pp = pprint.PrettyPrinter(indent=2)

People = pd.DataFrame(columns=['id','givenName','familyName','gender','birthDate','birthPlaceId'])
Organizations = pd.DataFrame(columns=['id','orgName','dateFounded','placeId'])
LaureatePrizes = pd.DataFrame(columns=['laurId','prizeId','sortOrder','portion','prizeStatus'])
Places = pd.DataFrame(columns=['id','city','country'])
NobelPrizes = pd.DataFrame(columns=['id','awardYear','category','dateAwarded','motivation','prizeAmount'])
PrizeAffiliation = pd.DataFrame(columns=['prizeId','affilId'])
Affiliations = pd.DataFrame(columns=['id','name','placeId'])

for index, laureate in enumerate(laureates):
    people_list = [None] * 6
    org_list = [None] * 4
    lp_list = [[None] * 5] * len(laureate['nobelPrizes'])
    place_list = [None] * 3
    np_list = [[None] * 6] * len(laureate['nobelPrizes'])
    pa_list = [None] * 2
    aff_list = [None] * 3

    curr_id = -1
    print(index)
    if 'orgName' in laureate:
        if laureate['id'] not in Organizations.id.values:
            org_list[0] = laureate['id']
            org_list[1] = laureate['orgName']['en']
            if 'founded' in laureate:
                org_list[2] = laureate['founded']['date']
                
                if 'city' in laureate['founded']['place']:
                    index_list = Places[(Places['city'] == laureate['founded']['place']['city']['en'])&(Places['country'] == laureate['founded']['place']['country']['en'])].index.tolist()
                    if not index_list:
                        place_list[0] = len(Places) + 1
                        place_list[1] = laureate['founded']['place']['city']['en']
                        place_list[2] = laureate['founded']['place']['country']['en']
                        org_list[3] = place_list[0]
                    else:
                        org_list[3] = index_list[0]
        else:
            pass
        
    else:
        if laureate['id'] not in People.id.values:
            people_list[0] = laureate['id']
            people_list[1] = laureate['givenName']['en']
            if 'familyName' in laureate:
                people_list[2] = laureate['familyName']['en']
            people_list[3] = laureate['gender']
            if 'birth' in laureate:
                people_list[4] = laureate['birth']['date']
                if 'city' in laureate['birth']['place']:
                    index_list = Places[(Places['city'] == laureate['birth']['place']['city']['en'])&(Places['country'] == laureate['birth']['place']['country']['en'])].index.tolist()
                    if not index_list:
                        place_list[0] = len(Places) + 1
                        place_list[1] = laureate['birth']['place']['city']['en']
                        place_list[2] = laureate['birth']['place']['country']['en']
                        people_list[5] = place_list[0]

                    else:
                        people_list[5] = index_list[0]
        else:
            pass
    for index, prize in enumerate(laureate['nobelPrizes']):
        index_list = NobelPrizes[(NobelPrizes['awardYear'] == prize['awardYear'])&(NobelPrizes['category'] == prize['category']['en'])].index.tolist()
        if not index_list:
            np_list[index][0] = len(NobelPrizes) + index + 1
            np_list[index][1] = prize['awardYear']
            np_list[index][2] = prize['category']['en']
            if 'dateAwarded' in prize:
                np_list[index][3] = prize['dateAwarded']
            np_list[index][4] = prize['motivation']['en']   
            np_list[index][5] = prize['prizeAmount']
            lp_list[index][1] = np_list[index][0]

        else:
            lp_list[index][1] = index_list[0]
        lp_list[index][0] = laureate['id']
        lp_list[index][2] = prize['sortOrder']
        lp_list[index][3] = prize['portion']
        lp_list[index][4] = prize['prizeStatus']

    if people_list[0] is not None:
        People.loc[len(People)] = people_list
    elif org_list[0] is not None:
        Organizations.loc[len(Organizations)] = org_list
    if place_list[0] is not None:
        Places.loc[len(Places)] = place_list
    for index in range(len(np_list)):
        if np_list[index][0] is not None:
            NobelPrizes.loc[len(NobelPrizes)] = np_list[index]
        if lp_list[index][0] is not None:
            LaureatePrizes.loc[len(LaureatePrizes)] = lp_list[index]
    if index >= 500:
        break
People.to_excel("People.xlsx")
Organizations.to_excel("Organizations.xlsx")
Places.to_excel("Places.xlsx")
NobelPrizes.to_excel("NobelPrizes.xlsx")
LaureatePrizes.to_excel("LaureatePrizes.xlsx")

