<?php
include "src/Dice.php";
session_start();

use WakkenEnIjsberen\Dice;
use WakkenEnIjsberen\Hint;
use WakkenEnIjsberen\Play;

require_once "vendor/autoload.php";




if($_POST["IceHoles"] == $_SESSION["dice"]->getIceholes() && $_POST["Penguins"] == $_SESSION["dice"]->getPenguins()
    && $_POST["PolarBears"] == $_SESSION["dice"]->getPolarbears())
{

    header( 'refresh: 0; url=index.php');
}else{

    header( 'refresh: 0; url=index.php=amount');
}
