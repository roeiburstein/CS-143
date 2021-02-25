db.laureates.aggregate([
    { $unwind : "$nobelPrizes" },
    { $unwind : "$nobelPrizes.affiliations" },
    { $match : {"nobelPrizes.affiliations.name.en" : "University of California"}},
    { $group : {_id : "$nobelPrizes.affiliations.locationString.en"}},
    { $count : "locations"}
]).pretty();