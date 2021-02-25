db.laureates.aggregate([
    { $match: {"familyName.en" : {$exists : true}}},
    { $group : { _id : "$familyName.en", numPrizes : { $sum : 1}}},
    { $match: {"numPrizes": { $gte : 5 }}},
    { $project : { _id : 0, "familyName" : "$_id"}}
]).pretty();