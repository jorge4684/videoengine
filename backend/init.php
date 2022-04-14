<?php

ob_start();

require "backend/config.php"; 

require "classes/PHPMailer.php";
require "classes/SMTP.php";
require "classes/Exception.php";

//autoload
spl_autoload_register(function($class){
    require_once "classes/{$class}.php";
});



//$db=new $data;
session_start();

require "functions.php";

$loadFromUser=new User;
$verify=new Verify;
$account=new Account;










?>