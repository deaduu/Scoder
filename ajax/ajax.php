<?php
require '../include/functions.php';
require_once '../App/classes/AjaxClass.php';
$obj = new AjaxClass();

$obj->data = isset($_POST) ? $_POST : NULL;

$method = $_POST['method'];

$data = $obj->{$method}();
echo $data;
