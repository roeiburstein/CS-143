SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Places;
DROP TABLE IF EXISTS People;
DROP TABLE IF EXISTS Organizations;
DROP TABLE IF EXISTS NobelPrizes;
DROP TABLE IF EXISTS Affiliations;
DROP TABLE IF EXISTS LaureatePrizes;
DROP TABLE IF EXISTS PrizeAffiliation;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE People(id INT, 
                    givenName VARCHAR(100), 
                    familyName VARCHAR(100), 
                    gender VARCHAR(6), 
                    birthDate DATE, 
                    birthPlaceId INT,
                    PRIMARY KEY(id));

CREATE TABLE Organizations(id INT,
                    orgName VARCHAR(100),
                    dateFounded VARCHAR(100),
                    placeId INT,
                    PRIMARY KEY(id));

CREATE TABLE Places(id INT,
                    city VARCHAR(100),
                    country VARCHAR(100),
                    PRIMARY KEY(id));

CREATE TABLE NobelPrizes(id INT,
                    awardYear INT,
                    category VARCHAR(100),
                    dateAwarded DATE,
                    motivation VARCHAR(1000),
                    prizeAmount INT,
                    PRIMARY KEY(id));

CREATE TABLE LaureatePrizes(laurId INT,
                    prizeId INT,
                    sortOrder VARCHAR(1),
                    portion VARCHAR(6),
                    prizeStatus VARCHAR(11),
                    PRIMARY KEY(laurId, prizeId));

CREATE TABLE Affiliations(id INT, 
                    name VARCHAR(100), 
                    placeId INT,
                    PRIMARY KEY(id));

CREATE TABLE PrizeAffiliation(prizeId INT,
                    affilId INT,
                    PRIMARY KEY(prizeId, affilId));

LOAD DATA LOCAL INFILE '/home/cs143/shared/project_3/convert/Places.del' 
INTO TABLE Places
FIELDS TERMINATED BY ',' 
OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE '/home/cs143/shared/project_3/convert/People.del'
INTO TABLE People 
FIELDS TERMINATED BY ',' 
OPTIONALLY ENCLOSED BY '"';


LOAD DATA LOCAL INFILE '/home/cs143/shared/project_3/convert/Organizations.del' 
INTO TABLE Organizations
FIELDS TERMINATED BY ',' 
OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE '/home/cs143/shared/project_3/convert/NobelPrizes.del' 
INTO TABLE NobelPrizes
FIELDS TERMINATED BY ',' 
OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE '/home/cs143/shared/project_3/convert/Affiliations.del' 
INTO TABLE Affiliations
FIELDS TERMINATED BY ',' 
OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE '/home/cs143/shared/project_3/convert/LaureatePrizes.del' 
INTO TABLE LaureatePrizes
FIELDS TERMINATED BY ',' 
OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE '/home/cs143/shared/project_3/convert/PrizeAffiliation.del' 
INTO TABLE PrizeAffiliation
FIELDS TERMINATED BY ',' 
OPTIONALLY ENCLOSED BY '"';