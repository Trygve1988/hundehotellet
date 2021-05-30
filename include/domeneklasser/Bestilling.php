<?php

class Bestilling {
    private $startDato;
    private $sluttDato;
    private $totalPris;

    function __construct($startDato,$sluttDato,$totalPris,$burID) {
        $this->startDato = $startDato;
        $this->sluttDato = $sluttDato;
        $this->totalPris = $totalPris;
        $this->burID = $burID;
    }

    function getStartDato() {
        return $this->startDato;
    }

    function getSluttDato() {
        return $this->sluttDato;
    }

    function getTotalPris() {
        return $this->totalPris;
    }

    function getBurID() {
        return $this->burID;
    }

    function toString() {
        return $this->startDato . ", " . $this->sluttDato . ", ".$this->totalPris.", ".$this->burID;
    }
}
?>