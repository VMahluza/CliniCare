<?php

spl_autoload_register('classAutoloader');

function classAutoloader($classname){

    $path = "Classes";
    $extension = ".class.php";

    $fullclasspath = $path . DIRECTORY_SEPARATOR . $classname . $extension;

    if(!file_exists($fullclasspath)){

        return false;

    }

    require_once ($fullclasspath);

}

