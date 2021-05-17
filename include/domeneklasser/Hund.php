<?php

class Hund {
    private $hundID;
    private $navn;
    private $rase;
    private $fdato;
    private $kjønn;
    private $sterilisert;
    private $løpeMedAndre;
    private $info;
    private $brukerID;
    private $forID;

    function __construct($hundID,$navn,$rase,$fdato,$kjønn,
        $sterilisert,$løpeMedAndre,$info,$brukerID,$forID) {
        $this->hundID = $hundID;
        $this->navn = $navn;
        $this->rase = $rase;
        $this->fdato = $fdato;
        $this->kjønn = $kjønn;
        $this->sterilisert = $sterilisert;
        $this->løpeMedAndre = $løpeMedAndre;
        $this->info = $info;
        $this->brukerID = $brukerID;
        $this->forID = $forID;
    }

    function getHundID() {
        return $this->hundID;
    }

    function getNavn() {
        return $this->navn;
    }

    function getRase() {
        return $this->rase;
    }

    function getFdato() {
        return $this->fdato;
    }

    function getKjønn() {
        return $this->kjønn;
    }

    function getSterilisert() {
        return $this->sterilisert;
    }

    function getLøpeMedAndre() {
        return $this->løpeMedAndre;
    }

    function getInfo() {
        return $this->info;
    }

    function getBrukerID() {
        return $this->brukerID;
    }

    function getForID() {
        return $this->forID;
    }

    function toString() {
        return $this->hundID . ", " . $this->navn . ", " . $this->rase . ", " . 
        $this->fdato . ", " . $this->kjønn . ", " . 
        $this->sterilisert . ", " . $this->løpeMedAndre. ", " . $this->info. ", " . 
        $this->brukerID. ", " . $this->forID;
    }
}

?>