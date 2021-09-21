<?php
require 'functions.php';
require_once 'App/classes/PageClass.php';
$obj = new PageClass();

$page = basename($_SERVER['PHP_SELF'], ".php");

$data = $obj->{$page}();
// pr($data);
if (!empty($data)) {
    extract($data);
}
