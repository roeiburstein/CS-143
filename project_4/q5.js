db.laureates.aggregate([
    { $unwind : "$nobelPrizes" },
    { $match : {"orgName" : {$exists : true}}},
    { $group : {_id : "$nobelPrizes.awardYear"}},
    { $count : "years"}
]).pretty();