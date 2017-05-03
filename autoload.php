<?php

set_include_path( __DIR__ . '/lib' . PATH_SEPARATOR .
    get_include_path());

function __autoload($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require_once($path . '.php');
}