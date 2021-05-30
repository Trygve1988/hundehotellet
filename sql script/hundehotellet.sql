SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
SET SQL_SAFE_UPDATES = 0;

DROP TABLE IF EXISTS slettetBestilling;
DROP TABLE IF EXISTS anmeldelse;
DROP TABLE IF EXISTS innlegg;
DROP TABLE IF EXISTS kommentar;
DROP TABLE IF EXISTS tur;
DROP TABLE IF EXISTS lufting;
DROP TABLE IF EXISTS mating;
DROP TABLE IF EXISTS pris;
DROP TABLE IF EXISTS opphold;
DROP TABLE IF EXISTS bestilling;
DROP TABLE IF EXISTS bur;
DROP TABLE IF EXISTS hund;
DROP TABLE IF EXISTS hundefor;
DROP TABLE IF EXISTS bruker;
DROP TABLE IF EXISTS postSted;
DROP TABLE IF EXISTS ledigeBurPrDag;

CREATE TABLE bruker (
  	brukerID 	smallint AUTO_INCREMENT,
  	epost 		varchar (50),
  	passord 	varchar (90),
  	brukerType 	varchar (30),
  	fornavn 	varchar(30),
  	etternavn 	varchar(30),
  	tlf 		varchar (12),
  	adresse 	varchar (50),
  	postnummer	char(4),
  	poststed 	varchar(50),
  	fødselsNr 	char(11),
  	stilling 	varchar(30),
    slettetDato date,
    PRIMARY KEY (brukerID)
);

CREATE TABLE hundefor (
  	forID 		smallint AUTO_INCREMENT,
  	fortype 	varchar(50),
    PRIMARY KEY (forID)
);

CREATE TABLE hund (
  	hundID 			smallInt AUTO_INCREMENT,
  	navn 			varchar (50),
  	rase 			varchar (50),
  	fdato 			date,
  	kjønn 			varchar (5),
  	sterilisert 	boolean,
  	løpeMedAndre	boolean,
  	info 			varchar (100),
  	brukerID 		smallInt,
  	forID 			smallInt,
    PRIMARY KEY (hundID),
    FOREIGN KEY (brukerID) 	REFERENCES bruker (brukerID),
    FOREIGN KEY (forID) 	REFERENCES hundefor (forId)
);

CREATE TABLE bur (
  	burID 			smallint AUTO_INCREMENT,
    PRIMARY KEY (burID)
);

CREATE TABLE bestilling (
  	bestillingID 	smallint AUTO_INCREMENT,
  	startDato		date,
  	sluttDato		date,
  	bestiltDato 	date,
  	betaltDato 		date,
  	sjekketInn      datetime,
  	sjekketUt      	datetime,
    totalPris      	smallint,
    PRIMARY KEY (bestillingID)
);

CREATE TABLE opphold (
	oppholdID 		smallInt AUTO_INCREMENT,
  	hundID 			smallInt,
  	burID 			smallint,
  	bestillingID 	smallint,
  	PRIMARY KEY (oppholdID),
  	FOREIGN KEY (hundID) 		REFERENCES hund (hundID),
  	FOREIGN KEY (burID) 		REFERENCES bur (burID),
  	FOREIGN KEY (bestillingID) 	REFERENCES bestilling (bestillingID)
);

CREATE TABLE pris (
  	prisID 			smallInt AUTO_INCREMENT,
  	beskrivelse 	varchar (30),
  	beløp			smallInt,
  	PRIMARY KEY (prisID)
);

CREATE TABLE mating (
  	matingID 		smallint AUTO_INCREMENT,
  	tidspunkt 		datetime,
  	oppholdID 		smallint,
  	forId 			smallint,
  	brukerID		smallint,
    PRIMARY KEY (matingID),
	FOREIGN KEY (oppholdID) REFERENCES opphold (oppholdID),
    FOREIGN KEY (forID) 	REFERENCES hundefor (forID),
    FOREIGN KEY (brukerID) 	REFERENCES bruker (brukerID)
);

CREATE TABLE lufting (
  	luftingID 		smallint AUTO_INCREMENT,
  	startTidspunkt 	datetime,
  	sluttTidspunkt 	datetime,
  	oppholdID 		smallint,
  	brukerID 		smallint,
    PRIMARY KEY (luftingID),
    FOREIGN KEY (oppholdID) REFERENCES opphold (oppholdID),
    FOREIGN KEY (brukerID) 	REFERENCES bruker (brukerID)
);

CREATE TABLE tur (
  	turID 			smallint AUTO_INCREMENT,
  	startTidspunkt 	datetime,
  	sluttTidspunkt 	datetime,
  	oppholdID 		smallint,
  	brukerID 		smallint,
    PRIMARY KEY (turID),
    FOREIGN KEY (oppholdID) REFERENCES opphold (oppholdID),
    FOREIGN KEY (brukerID) 	REFERENCES bruker (brukerID)
);

CREATE TABLE kommentar (
  	kommentarID 	smallint AUTO_INCREMENT,
  	tekst 			varchar(500),
  	tidspunkt 		datetime,
  	oppholdID 		smallint,
  	brukerID 		smallint,
    PRIMARY KEY (kommentarID),
    FOREIGN KEY (oppholdID) REFERENCES opphold (oppholdID),
    FOREIGN KEY (brukerID) 	REFERENCES bruker (brukerID)
);

CREATE TABLE innlegg (
  	innleggID 		smallint AUTO_INCREMENT,
  	navn 			varchar (30),
  	tekst 			varchar (2000),
  	brukerID		smallint,
    PRIMARY KEY (innleggID),
    FOREIGN KEY (brukerID) 	REFERENCES bruker (brukerID)
);

CREATE TABLE anmeldelse (
  	anmeldelseID 	smallint AUTO_INCREMENT,
  	tekst 			varchar (2000),
  	dato 			date,
  	godkjent 		boolean,
  	brukerID		smallint,
    PRIMARY KEY (anmeldelseID),
    FOREIGN KEY (brukerID) 	REFERENCES bruker (brukerID)
);

CREATE TABLE slettetBestilling (
  	slettetBestillingID	smallint AUTO_INCREMENT,
  	startDato			date,
  	sluttDato			date,
  	bestiltDato 		date,
    totalPris      		smallint,
    brukerID			smallint,
    PRIMARY KEY (slettetBestillingID),
    FOREIGN KEY (brukerID) 	REFERENCES bruker (brukerID)
);

INSERT INTO hundefor(forID, fortype)
VALUES
(1, "Normal-for"),
(2, "Allergi-for");

INSERT INTO bur(burID)
VALUES
(1),
(2),
(3);

INSERT INTO pris(prisID, beskrivelse, beløp)
VALUES
(1, "1HundPrDøgn", 400), 
(2, "2HundPrDøgn", 600), 
(3, "3HundPrDøgn", 750);

INSERT INTO anmeldelse (tekst, dato, godkjent, brukerID)	
VALUES
("<p>Veldig bra hundekennel. Engasjerte ansatte som tok godt vare på hunden min og sørget for at den hadde det bra på oppholdet sitt.</p><p>- Espen Sivertsen</p>","2020-01-01" ,1, 1),
("<p>Takk til alle på Bø Hundekennel for nok et koselig opphold for hunden min. Selv om Pluto var litt redd i starten har han begynt å loggre når han forstår at han skal på hundehotellet'</p><p>- Sofie Pedersen</p>","2020-02-02" , 1, 1),
("<p>Bra hundehotell. Profesjonelle folk som vet hva de driver med og er optatte av at hundene skal ha det godt.'</p><p>- Ole Monsen</p>","2020-03-03", 1, 1);

-- ledigeBurPrDag
DROP TABLE IF EXISTS ledigeBurPrDag;
CREATE TABLE ledigeBurPrDag (
    dato DATE,
    antallLedigeBur smallint
);

DROP PROCEDURE IF EXISTS filldates;
DELIMITER |
CREATE PROCEDURE filldates(dateStart DATE, dateEnd DATE)
BEGIN
  WHILE dateStart <= dateEnd DO
    INSERT INTO ledigeBurPrDag (dato) VALUES (dateStart);
    SET dateStart = date_add(dateStart, INTERVAL 1 DAY);
  END WHILE;
END;
|
DELIMITER ;

CALL filldates( DATE_SUB(curdate(), INTERVAL 1 MONTH) , DATE_ADD(CURDATE(), INTERVAL 10 YEAR) );

UPDATE ledigeBurPrDag SET antallLedigeBur = 3;


SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;