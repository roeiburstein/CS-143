import json
import os
from pathlib import Path
import pandas as pd

data_folder = Path("/home/cs143/data/")
file = data_folder / "nobel-laureates.json"
data = json.load(open(file, "r"))

laureates = data["laureates"]

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
    place_list = [[None] * 3] * len(laureate['nobelPrizes']) * 10
    np_list = [[None] * 6] * len(laureate['nobelPrizes'])
    pa_list = []
    aff_list = []

    if 'orgName' in laureate:
        if laureate['id'] not in Organizations.id.values:
            org_list[0] = laureate['id']
            org_list[1] = laureate['orgName']['en']
            if 'founded' in laureate:
                org_list[2] = laureate['founded']['date']
                
                if 'city' in laureate['founded']['place']:
                    index_list = Places[(Places['city'] == laureate['founded']['place']['city']['en'])&(Places['country'] == laureate['founded']['place']['country']['en'])].index.tolist()
                    if not index_list:
                        curr_len = len(place_list) - 1
                        place_list[curr_len][0] = len(Places) + len(place_list) + 1
                        place_list[curr_len][1] = laureate['founded']['place']['city']['en']
                        place_list[curr_len][2] = laureate['founded']['place']['country']['en']
                        org_list[3] = place_list[curr_len][0]
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
                        curr_len = len(place_list) - 1
                        place_list[curr_len][0] = len(Places) + len(place_list) + 1
                        place_list[curr_len][1] = laureate['birth']['place']['city']['en']
                        place_list[curr_len][2] = laureate['birth']['place']['country']['en']
                        people_list[5] = place_list[curr_len][0]

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
        if 'affiliations' in prize:
            temp_pa_list = [[None] * 2] * len(prize['affiliations'])
            temp_aff_list = [[None] * 3] * len(prize['affiliations'])
            for index2, affiliate in enumerate(prize['affiliations']): # For every affiliate
                temp_pa_list[index2][0] = np_list[index][0]
                temp_aff_list[index2][0] = len(Affiliations) + len(aff_list) + len(temp_aff_list) + 1
                temp_aff_list[index2][1] = affiliate['name']['en']
                if 'city' in affiliate and 'country' in affiliate: # Affiliate has city and country fields
                    place_index_list = Places[(Places['city'] == affiliate['city']['en'])&(Places['country'] == affiliate['country']['en'])].index.tolist()
                    if place_index_list: # If the place already exists
                        # Check if affiliation exists
                        #affiliations_index_list = Affiliations.loc[(Affiliations['name'] == affiliate['name']['en'])&(Affiliations['placeId'] == )]
                        
                        #if affiliations_index_list: # If the affiliate already exists
                        #    temp_pa_list[index2][1] = Affiliations.iloc[affiliations_index_list[0]]['id'] 
                        #else: # If the affiliate doesn't exist, but the place exists
                            temp_aff_list[index2][2] = Places.iloc[place_index_list[0]]['id']
                            temp_pa_list[index2][1] = temp_aff_list[index2][0]
                    else: # If the place doesn't exist
                        # Add place
                        curr_len = len(place_list) - 1
                        place_list[curr_len][0] = len(Places) + len(place_list) + 1
                        place_list[curr_len][1] = affiliate['city']['en']
                        place_list[curr_len][2] = affiliate['country']['en']

                        #Add Affiliate and Prize Affiliate
                        temp_aff_list[index2][2] = place_list[curr_len][0]
                        temp_pa_list[index2][1] = temp_aff_list[index2][0]
                else: # Affiliate doesn't have city and country fields
                    temp_aff_list[index2][2] = None
                    temp_pa_list[index2][1] = temp_aff_list[index2][0]
            for my_list in temp_pa_list:
                if my_list[0]:
                    pa_list.append(my_list)
            for my_list in temp_aff_list:
                if my_list[0]:
                    aff_list.append(my_list)


    if people_list[0]:
        People.loc[len(People)] = people_list
    elif org_list[0]:
        Organizations.loc[len(Organizations)] = org_list
    for index in range(len(np_list)):
        if place_list[index][0]:
            Places.loc[len(Places)] = place_list[index]
    for index in range(len(np_list)):
        if np_list[index][0]:
            NobelPrizes.loc[len(NobelPrizes)] = np_list[index]
        if lp_list[index][0]:
            LaureatePrizes.loc[len(LaureatePrizes)] = lp_list[index]
    for a in range(len(pa_list)):
        if pa_list[a][0]:
            PrizeAffiliation.loc[len(PrizeAffiliation)] = pa_list[a]
    for index in range(len(aff_list)):
        if aff_list[index][0]:
            Affiliations.loc[len(Affiliations)] = aff_list[index]
    if index > 200:
        break
PrizeAffiliation = PrizeAffiliation.drop_duplicates()
Affiliations = Affiliations.drop_duplicates()

People.to_csv(index=False, header=False, path_or_buf="People.del")
Organizations.to_csv(index=False, header=False, path_or_buf="Organizations.del")
Places.to_csv(index=False, header=False, path_or_buf="Places.del")
NobelPrizes.to_csv(index=False, header=False, path_or_buf="NobelPrizes.del")
LaureatePrizes.to_csv(index=False, header=False, path_or_buf="LaureatePrizes.del")
PrizeAffiliation.to_csv(index=False, header=False, path_or_buf="PrizeAffiliation.del")
Affiliations.to_csv(index=False, header=False, path_or_buf="Affiliations.del")