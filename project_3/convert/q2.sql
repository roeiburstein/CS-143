SELECT country 
FROM Places, Affiliations
WHERE Affiliations.placeId = Places.id
AND Affiliations.name = 'CERN'
LIMIT 1;