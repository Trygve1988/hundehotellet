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
  	vaksniert 		boolean,
  	løpeMedAndre	boolean,
  	løsPåTur		boolean,
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
  	PRIMARY KEY (oppholdID),
  	FOREIGN KEY (hundID) 	REFERENCES hund (hundID),
  	FOREIGN KEY (burID) 	REFERENCES bur (burID)
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
  	prisID 			smallInt,
  	PRIMARY KEY (prisHistorikkID)
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
  	tekst 			varchar (500),
  	brukerID		smallint,
    PRIMARY KEY (innleggID),
    FOREIGN KEY (brukerID) 	REFERENCES bruker (brukerID)
);

CREATE TABLE anmeldelse (
  	anmeldelseID 	smallint AUTO_INCREMENT,
  	tekst 			varchar (500),
  	brukerID		smallint,
    PRIMARY KEY (anmeldelseID),
    FOREIGN KEY (brukerID) 	REFERENCES bruker (brukerID)
);

INSERT INTO hundefor(forID, fortype)
VALUES
(1, "Normal-for"),
(2, "Allergi-for");

INSERT INTO bur(burID, lengdeCm, breddeCm, hoydeCm)
VALUES
(1, 124, 76 ,  84),
(2, 124, 76 ,  84),
(3, 124, 76 ,  84),
(4, 124, 76 ,  84),
(5, 124, 76 ,  84);

INSERT INTO pris(prisID, beskrivelse, beløp)
VALUES
(1, "dagPris", 400),  
(2, "bading", 200);

INSERT INTO rabatt(rabattID, beskrivelse, prosent)
VALUES
(1, "toHunder", 0.2),  
(2, "treHunder", 0.3),
(3, "ansatt", 0.2);