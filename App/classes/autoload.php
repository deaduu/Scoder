<?php
spl_autoload_register('myAutoloader');

function myAutoloader($className)
{
    $path = dirname(__FILE__) . 'scoder/classes/';

    include $path . $className . '.php';
}
