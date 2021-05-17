<?php

class Bestilling {
    private $startDato;
    private $sluttDato;
    private $totalPris;

    function __construct($startDato,$sluttDato,$totalPris) {
        $this->startDato = $startDato;
        $this->sluttDato = $sluttDato;
        $this->totalPris = $totalPris;
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

    function toString() {
        return $this->startDato . ", " . $this->sluttDato . ", ".$this->totalPris.", ";
    }
}
?>