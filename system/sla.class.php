<?php

require '../_app/Config.inc.php';
require './model.class.php';

$slaCli = new model;
$rst = $slaCli->calcSla(74);
var_dump($rst);


