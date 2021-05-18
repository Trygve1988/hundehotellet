<?php

class FerdigBestilling {
    private $bestillingID;
    private $startDato;
    private $sluttDato;
    private $bestiltDato;
    private $totalPris;
    private $burID;
    private $hundTab = array();

    function __construct($bestillingID) {
        $this->bestillingID = $bestillingID;
    }

    function setStartDato($startDato) {
        $this->startDato = $startDato;
    }

    function setSluttDato($sluttDato) {
        $this->sluttDato = $sluttDato;
    }

    function setBestiltDato($bestiltDato) {
        $this->bestiltDato = $bestiltDato;
    }

    function setTotalPris($totalPris) {
        $this->totalPris = $totalPris;
    }

    function setBurID($burID) {
        $this->burID = $burID;
    }

    function addHund($hund) {
        array_push($this->hundTab, $hund);
    }

    function setHundTab($hundTab) {
        $this->hundTab = $hundTab;
    }

    function getBestillingID() {
        return $this->bestillingID;
    }

    function getStartDato() {
        return $this->startDato;
    }

    function getSluttDato() {
        return $this->sluttDato;
    }

    function getBestiltDato() {
        return $this->bestiltDato;
    }

    function getTotalPris() {
        return $this->totalPris;
    }

    function getBurID() {
        return $this->burID;
    }

    function getHundTab() {
        return $this->hundTab;
    }

    function toString() {
        return $this->bestillingID . ", " . $this->startDato . ", " . $this->sluttDato . ", " . 
        $this->bestiltDato . ", " . $this->totalPris . ", " . $this->burID . ", " . implode(",",$this->hundTab);
    }
}
?>