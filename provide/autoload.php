<?php
/**
 * Copyright (c) 2022 DevRas All rights reserved.
 */

@session_start();

require_once __DIR__ . '/ClassLoader.php';
spl_autoload_register(array("ClassLoaderXProvide", "loadClass"));

