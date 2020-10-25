<?php

require_once("classes/Transporte.php");

$transporte = new Transporte;

$mercadorias = array();

//Apenas para agilizar
$mercadoriaX = new stdClass();
$mercadoriaX->nome = "Sapatos";
$mercadoriaX->distancia = 15;
$mercadoriaX->peso = 4;

$mercadoriaY = new stdClass();
$mercadoriaY->nome = "PC Gamer";
$mercadoriaY->distancia = 1000;
$mercadoriaY->peso = 35;

$mercadorias[0] = $mercadoriaX;
$mercadorias[1] = $mercadoriaY;

$result = $transporte->calcularTransporte($mercadorias);

print "<pre>";
print_r($result);
print "</pre>";


?>