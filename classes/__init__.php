<?php

require_once(dirname(__FILE__)."/DB.php");
require_once(dirname(__FILE__)."/Personnel.php");
require_once (dirname(__FILE__)."/Refuge.php" );
require_once (dirname(__FILE__)."/Animal.php" );
require_once (dirname(__FILE__)."/fonctions.php" );

// Initialisation de la variable db
$DB = DB::getInstance();
$db = DB::$db;
//
const MAX_LIMIT = 10000;