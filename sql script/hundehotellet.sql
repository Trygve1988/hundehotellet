SET SQL_SAFE_UPDATES = 0;

DROP TABLE IF EXISTS anmeldelse;
DROP TABLE IF EXISTS innlegg;
DROP TABLE IF EXISTS bading;
DROP TABLE IF EXISTS lufting;
DROP TABLE IF EXISTS mating;
DROP TABLE IF EXISTS bestillingHarRabatt;
DROP TABLE IF EXISTS rabatt;
DROP TABLE IF EXISTS delsum;
DROP TABLE IF EXISTS prisHistorikk;
DROP TABLE IF EXISTS pris;
DROP TABLE IF EXISTS opphold;
DROP TABLE IF EXISTS bestilling;
DROP TABLE IF EXISTS bur;
DROP TABLE IF EXISTS hund;
DROP TABLE IF EXISTS hundefor;
DROP TABLE IF EXISTS bruker;
DROP TABLE IF EXISTS postSted;
DROP TABLE IF EXISTS ledigeBurPrDag;

CREATE TABLE postSted (
	postNr 		char(4),
  	postSted 	varchar(70),
	PRIMARY KEY (postNr)
);

CREATE TABLE bruker (
  	brukerID 	smallint AUTO_INCREMENT,
  	epost 		varchar (50),
  	passord 	varchar (90),
  	brukerType 	varchar (30),
  	fornavn 	varchar(30),
  	etternavn 	varchar(30),
  	tlf 		varchar (12),
  	adresse 	varchar (50),
  	fødselsNr 	char(11),
  	stilling 	varchar(30),
    postNr 		char(4),
    PRIMARY KEY (brukerID),
    FOREIGN KEY (postNr) REFERENCES postSted (postNr)
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
  	lengdeCm 		smallInt,
  	breddeCm 		smallInt,
  	hoydeCm 		smallInt,
    PRIMARY KEY (burID)
);

CREATE TABLE bestilling (
  	bestillingID 	smallint AUTO_INCREMENT,
  	startDato		date,
  	sluttDato		date,
  	bestiltDato 	date,
  	betaltDato 		date,
    totalPris      	smallint,
    PRIMARY KEY (bestillingID)
);

CREATE TABLE opphold (
	oppholdID 		smallInt AUTO_INCREMENT,
	skalBade		boolean,
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

CREATE TABLE prisHistorikk (
  	prisHistorikkID smallInt AUTO_INCREMENT,
  	endretDato 		date,
  	nyttbeløp		smallInt,
  	gammeltbeløp	smallInt,
  	brukerID        smallInt,
  	prisID 			smallInt,
  	PRIMARY KEY (prisHistorikkID),
  	FOREIGN KEY (brukerID) 	REFERENCES bruker (brukerID),
  	FOREIGN KEY (prisID) 	REFERENCES pris (prisID)
);

CREATE TABLE delsum (
	delsumID		smallInt AUTO_INCREMENT,
	oppholdID 		smallInt,
  	prisID 			smallInt,
  	PRIMARY KEY (delsumID),
  	FOREIGN KEY (oppholdID) REFERENCES opphold (oppholdID),
  	FOREIGN KEY (prisID) 	REFERENCES pris (prisID)
);

CREATE TABLE rabatt (
  	rabattID 		smallInt AUTO_INCREMENT,
  	beskrivelse 	varchar (30),
  	prosent			double(4,2),
  	PRIMARY KEY (rabattID)
);

CREATE TABLE bestillingHarRabatt (
	bestillingHarRabattID	smallInt AUTO_INCREMENT,
	oppholdID 				smallInt,
  	rabattID 				smallInt,
  	PRIMARY KEY (bestillingHarRabattID),
  	FOREIGN KEY (oppholdID) REFERENCES opphold (oppholdID),
  	FOREIGN KEY (rabattID) 	REFERENCES rabatt (rabattID)
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

CREATE TABLE bading (
  	badingID 		smallint AUTO_INCREMENT,
  	tidspunkt 		datetime,
  	oppholdID 		smallint,
  	brukerID		smallint,
    PRIMARY KEY (badingID),
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
  	godkjent 		boolean,
  	brukerID		smallint,
    PRIMARY KEY (anmeldelseID),
    FOREIGN KEY (brukerID) 	REFERENCES bruker (brukerID)
);

INSERT INTO bruker(brukerID,epost,passord,brukerType)
VALUES
(1,"admin","passord123","admin");

INSERT INTO hundefor(forID, fortype)
VALUES
(1, "Normal-for"),
(2, "Allergi-for");

INSERT INTO bur(burID, lengdeCm, breddeCm, hoydeCm)
VALUES
(1, 124, 76 ,  84),
(2, 124, 76 ,  84),
(3, 124, 76 ,  84);

INSERT INTO pris(prisID, beskrivelse, beløp)
VALUES
(1, "1Hund", 400), /* pris pr hund viss 1 hund på opphold               400   */ 
(2, "2Hund", 300), /* pris pr hund viss 2 hunder på opphold             600   */ 
(3, "3Hund", 250), /* pris pr hund viss 3 hunder eller mer på opphold   750   */   
(4, "bading", 200);

INSERT INTO innlegg(navn, tekst)
VALUES
("kontaktOss", "innlegg Test Tekst");


INSERT INTO anmeldelse (tekst, godkjent, brukerID)	
VALUES
("<p>Veldig bra hundekennel. Engasjerte ansatte som tok godt vare på hunden min og sørget for at den hadde det bra på oppholdet sitt.</p><p>- Espen Sivertsen</p>", 1, 1),
("<p>Takk til alle på Bø Hundekennel for nok et koselig opphold for hunden min. Selv om Pluto var litt redd i starten har han begynt å loggre når han forstår at han skal på hundehotellet'</p><p>- Sofie Pedersen</p>", 1, 1),
("<p>Bra hundehotell. Profesjonelle folk som vet hva de driver med og er optatte av at hundene skal ha det godt.'</p><p>- Ole Monsen</p>", 1, 1);


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

CALL filldates('2021-03-01','2021-12-31');

UPDATE ledigeBurPrDag SET antallLedigeBur = 3;
