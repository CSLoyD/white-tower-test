<?php

require __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// DB Variables
DEFINE('DBHOST', $_ENV['DBHOST']);
DEFINE('DBUSER', $_ENV['DBUSER']);
DEFINE('DBPASS', $_ENV['DBPASS']);
DEFINE('DBNAME', $_ENV['DBNAME']);
DEFINE('ASSETVERSION', $_ENV['ASSETVERSION']);

// SMTP GMAIL
DEFINE('EMAILUSERNAME',$_ENV['EMAILUSERNAME']);
DEFINE('EMAILPASSWORD',$_ENV['EMAILPASSWORD']);