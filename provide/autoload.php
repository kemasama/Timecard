<?php
/**
 * Copyright (c) 2022 DevRas All rights reserved.
 */

@session_start();

require_once __DIR__ . '/ClassLoader.php';
spl_autoload_register(array("ClassLoaderXProvide", "loadClass"));

$config = require_once __DIR__ . '/../config.php';
$db = new IDB();
if (!$db->Connect($config["mysql"]["hostname"],
    $config["mysql"]["dbname"],
    $config["mysql"]["username"],
    $config["mysql"]["password"])
)
{
    echo 'can not connect to mysql server.';
    exit;
}

$pdo = $db->getDB();
