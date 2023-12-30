<?php
        define("DS",DIRECTORY_SEPARATOR);
       define("ROOT",dirname(__DIR__));
       define("APP",ROOT.DS.'app');
    define("CONFIG",APP.DS.'config');
    define("MODELS",APP.DS.'models');
    define("VIEWS",APP.DS.'views'.DS);
    define("CONTROLLERS",APP.DS.'controlles');
define("CORE",APP.DS.'core');
define("domain_name",'http://bluelight.com');
define('path',domain_name.'/');


    require_once("../vendor/autoload.php");

$app = new MVC\core\app();

?>