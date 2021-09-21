<?php
spl_autoload_register('myAutoloader');

function myAutoloader($className)
{
    $path = 'scoder/classes/';

    include $path . $className . '.php';
}
