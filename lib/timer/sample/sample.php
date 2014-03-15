<?php

require_once "../Timer.class.php";
require_once "../TimerGroup.class.php";

$t = new Timer();
$tg = new TimerGroup();

$tg->start('A');
usleep(1000*100);
$tg->stop('A');

$tg->start('B');
usleep(1000*100);
$tg->stop('B');

print_r($tg->getTotalTime());

$tg->start('B');
usleep(1000*100);
$tg->stop('B');

print_r($tg->getTotalTime());

$tg->reset();

$tg->start('B');
usleep(1000*100);
$tg->stop('B');

print_r($tg->getTotalTime('B'));

?>
