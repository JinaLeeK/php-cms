<?php

ob_start();
session_start();


defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS . "templates" . DS . "front");
defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS . "templates" . DS . "back");

defined("DB_HOST") ? null : define("DB_HOST", "localhost:3307");
defined("DB_USER") ? null : define("DB_USER", "root");
defined("DB_PASS") ? null : define("DB_PASS","");
defined("DB_NAME") ? null : define("DB_NAME","baby_db");
defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__.DS."uploads");
defined("UPLOAD_ADMIN_DIRECTORY") ? null : define("UPLOAD_ADMIN_DIRECTORY", __DIR__.DS."uploads".DS."admin");
defined("SLIDES_DIRECTORY") ? null : define("SLIDES_DIRECTORY", __DIR__.DS."slides");
defined("MAX_FILE_SIZE") ? null : define("MAX_FILE_SIZE", 3);
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// defined("SLIDES_DIRECTORY") ? null : define("SLIDES_DIRECTORY" , __DIR__ . DS . "slides");
// defined("DB_HOST") ? null : define("DB_HOST", "localhost");
// defined("DB_USER") ? null : define("DB_USER", "root");
// defined("DB_PASS") ? null : define("DB_PASS","");
// defined("DB_NAME") ? null : define("DB_NAME","babyblog_db");
defined("PER_PAGE") ? null : define("PER_PAGE", 4);
//
//
//
//
require_once("functions.php");

?>
