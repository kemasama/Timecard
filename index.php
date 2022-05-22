<?php

ini_set("display_erros", "on");
require_once __DIR__ . '/provide/autoload.php';

$boot = new BootLoader(__DIR__);
$boot->run();

