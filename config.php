<?php

//Autoinkludera klasser
spl_autoload_register(function ($class_name) {
    include "classes/" . $class_name . '.class.php';
});


session_start();
$devmode = false;

if ($devmode) {
    // Aktivera felrapportering
    // Dessa ska tas bort om webbsidan ska läggas upp "på riktigt", men jag låter dessa vara kvar nu under inlämning.
    error_reporting(-1);
    ini_set("display_errors", 1);

    //Databasinställningar
    define("DBHOST", "localhost");
    define("DBUSER", "projektwebb");
    define("DBPASS", "sora");
    define("DBDATABASE", "projektwebb");
} else {
    //Publicerad webbplats
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "liba2103");
    define("DBPASS", "jHATC9uM5r");
    define("DBDATABASE", "liba2103");
}

