<?php

class Bruker {
    private $brukerID;
    private $epost;
    private $brukerType;
    private $fornavn;
    private $etternavn;
    
    private $tlf;
    private $adresse;
    private $fødselsNr;
    private $stilling;
    private $postNr;

    function __construct($brukerID,$epost,$brukerType,$fornavn,$etternavn,
    $tlf, $adresse, $fødselsNr, $stilling, $postNr) {
        $this->brukerID = $brukerID;
        $this->epost = $epost;
        $this->brukerType = $brukerType;
        $this->fornavn = $fornavn;
        $this->etternavn = $etternavn;

        $this->tlf = $tlf;
        $this->adresse = $adresse;
        $this->fødselsNr = $fødselsNr;
        $this->stilling = $stilling;
        $this->postNr = $postNr;
    }

    function getBrukerID() {
        return $this->brukerID;
    }

    function getEpost() {
        return $this->epost;
    }

    function getBrukerType() {
        return $this->brukerType;
    }

    function getFornavn() {
        return $this->fornavn;
    }

    function getEtternavn() {
        return $this->etternavn;
    }

    function getTlf() {
        return $this->tlf;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function getFødselsNr() {
        return $this->fødselsNr;
    }

    function getStilling() {
        return $this->stilling;
    }

    function getPostNr() {
        return $this->postNr;
    }

    function toString() {
        return $this->brukerID . ", " . $this->epost . ", " . $this->brukerType. ", " . 
        $this->fornavn . ", " . $this->etternavn. ", " .
        $this->tlf . ", " . $this->adresse . ", " . $this->fødselsNr. ", " . 
        $this->stilling . ", " . $this->postNr;
    }
}
?>