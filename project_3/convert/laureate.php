<?php
// get the id parameter from the request
$id = intval($_GET['id']);

// set the Content-Type header to JSON, so that the client knows that we are returning a JSON data
header('Content-Type: application/json');

$db = new mysqli('localhost', 'cs143', '', 'cs143');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}
$query1 = "SELECT * from People where id = $id";
$query2 = "SELECT * from Organizations where id = $id";

$a = $db->query("$query1");
$b = $db->query("$query2");

if (!$a) {
    $errmsg = $a->error; 
    print "Query 1 failed: $errmsg <br>"; 
    exit(1); 
}

if (!$b) {
    $errmsg = $b->error; 
    print "Query 2 failed: $errmsg <br>"; 
    exit(1); 
}

if($a->num_rows > 0){
    while ($row = $a->fetch_assoc()) {
        $givenName = $row['givenName'];
        $familyName = $row['familyName'];
        $gender = $row['gender'];
        $birthDate = $row['birthDate'];
        $birthPlaceId = $row['birthPlaceId'];
    }
    $place_string = "SELECT * from Places where id = $birthPlaceId";
    $place_query = $db->query("$place_string");
    if (!$place_query) {
        $errmsg = $place_query->error; 
        print "Query 3 failed: $errmsg <br>"; 
        exit(1); 
    }
    while ($row = $place_query->fetch_assoc()) {
        $city = $row['city'];
        $country = $row['country'];
    }
    $prize_string = "SELECT * from NobelPrizes, LaureatePrizes where id = prizeId and laurId = $id";
    $prize_query = $db->query("$prize_string");
    
    if (!$prize_query) {
        $errmsg = $prize_query->error; 
        print "Query 4 failed: $errmsg <br>"; 
        exit(1); 
    }

    while ($row = $prize_query->fetch_assoc()) {
        $prizeId = $row['id'];
        $awardYear = $row['awardYear'];
        $category = $row['category'];
        $dateAwarded = $row['dateAwarded'];
        $motivation = $row['motivation'];
        $prizeAmount = $row['prizeAmount'];
        
        $sortOrder = $row['sortOrder'];
        $portion = $row['portion'];
        $prizeStatus = $row['prizeStatus'];

        $affil_string = "SELECT * from Affiliations left join PrizeAffiliation on affilId = id where prizeId = $prizeId";
        $affil_query = $db->query("$affil_string");
        if (!$affil_query) {
            $errmsg = $affil_query->error; 
            print "Query 5 failed: $errmsg <br>"; 
            exit(1); 
        }
        while ($row = $affil_query->fetch_assoc()) {
            $affilName = $row['name'];
            $placeId = $row['placeId'];
            $affil_place_string = "SELECT * from Places where id = $placeId";
            $affil_place_query = $db->query("$affil_place_string");
            if (!$affil_place_query) {
                $errmsg = $affil_place_query->error; 
                print "Query 6 failed: $errmsg <br>"; 
                exit(1); 
            }
            while ($row = $affil_place_query->fetch_assoc()) {
                $affilCity = $row['city'];
                $affilCountry = $row['country'];
            }
        }
    }

    $output = (object) [
        "id" => strval($id),
        "givenName" => (object) [
            "en" => strval($givenName)
        ],
        "familyName" => (object) [
            "en" => strval($familyName)
        ],
        "gender" => strval($gender)
        ,
        "birth" => (object) [
            "date" => strval($birthDate),
            "place" => (object) [
                "city" => (object) [
                    "en" => strval($city)
                ],
                "country" => (object) [
                    "en" => strval($country)
                ]
            ]
        ]
        ,
        "nobelPrizes" => array( 
            "awardYear" => strval($awardYear),
            "category" => (object) [
                "en" => strval($category)
            ],
            "sortOrder" => strval($sortOrder),
            "portion" => strval($portion),
            "dateAwarded" => strval($dateAwarded),
            "prizeStatus" => strval($prizeStatus),
            "motivation" => (object) [
                "en" => strval($motivation)
            ],
            "prizeAmount" => strval($awardYear),
            "affiliations" => array( 
                "name" => $affilName,
                "city" => (object) [
                    "en" => strval($affilCity)
                ],
                "country" => (object) [
                    "en" => strval($affilCountry)
                ]
            )
        )
    ];
}

elseif($b->num_rows > 0){
    while ($row = $b->fetch_assoc()) {
        $orgName = $row['orgName'];
        $dateFounded = $row['founded'];
        $placeId = $row['placeId'];
    }
    $place_string = "SELECT * from Places where id = $placeId";
    $place_query = $db->query("$place_string");
    if (!$place_query) {
        $errmsg = $place_query->error; 
        print "Query 3 failed: $errmsg <br>"; 
        exit(1); 
    }
    while ($row = $place_query->fetch_assoc()) {
        $city = $row['city'];
        $country = $row['country'];
    }
    $prize_string = "SELECT * from NobelPrizes, LaureatePrizes where id = prizeId and laurId = $id";
    $prize_query = $db->query("$prize_string");
    
    if (!$prize_query) {
        $errmsg = $prize_query->error; 
        print "Query 4 failed: $errmsg <br>"; 
        exit(1); 
    }

    while ($row = $prize_query->fetch_assoc()) {
        $prizeId = $row['id'];
        $awardYear = $row['awardYear'];
        $category = $row['category'];
        $dateAwarded = $row['dateAwarded'];
        $motivation = $row['motivation'];
        $prizeAmount = $row['prizeAmount'];
        
        $sortOrder = $row['sortOrder'];
        $portion = $row['portion'];
        $prizeStatus = $row['prizeStatus'];

        $affil_string = "SELECT * from Affiliations left join PrizeAffiliation on affilId = id where prizeId = $prizeId";
        $affil_query = $db->query("$affil_string");
        if (!$affil_query) {
            $errmsg = $affil_query->error; 
            print "Query 5 failed: $errmsg <br>"; 
            exit(1); 
        }
        while ($row = $affil_query->fetch_assoc()) {
            $affilName = $row['name'];
            $placeId = $row['placeId'];
            $affil_place_string = "SELECT * from Places where id = $placeId";
            $affil_place_query = $db->query("$affil_place_string");
            if (!$affil_place_query) {
                $errmsg = $affil_place_query->error; 
                print "Query 6 failed: $errmsg <br>"; 
                exit(1); 
            }
            while ($row = $affil_place_query->fetch_assoc()) {
                $affilCity = $row['city'];
                $affilCountry = $row['country'];
            }
        }
    }

    $output = (object) [
        "id" => strval($id),
        "orgName" => strval($orgName),
        "founded" => (object) [
            "date" => strval($dateFounded),
            "place" => (object) [
                "city" => (object) [
                    "en" => strval($city)
                ],
                "country" => (object) [
                    "en" => strval($country)
                ]
            ]
        ]
        ,
        "nobelPrizes" => array( 
            "awardYear" => strval($awardYear),
            "category" => (object) [
                "en" => strval($category)
            ],
            "sortOrder" => strval($sortOrder),
            "portion" => strval($portion),
            "dateAwarded" => strval($dateAwarded),
            "prizeStatus" => strval($prizeStatus),
            "motivation" => (object) [
                "en" => strval($motivation)
            ],
            "prizeAmount" => strval($awardYear),
            "affiliations" => array( 
                "name" => $affilName,
                "city" => (object) [
                    "en" => strval($affilCity)
                ],
                "country" => (object) [
                    "en" => strval($affilCountry)
                ]
            )
        )
    ];
}


echo json_encode($output);

?>
