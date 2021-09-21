<?php
require '../include/functions.php';
require '../App/classes/CreateProjectClass.php';

if (!empty($_POST['name'])) {
    mkdir('../projects/' . $_POST['name']);
    mkdir('../projects/' . $_POST['name'] . '/scoder');
    mkdir('../projects/' . $_POST['name'] . '/scoder/classes');

    $rootpath = "../App/classes/";

    $destination = "../projects/" . $_POST['name'] . '/scoder/classes/';

    $copies = ['Dbclass.php', 'MainClass.php'];

    foreach ($copies as $copy) {
        copy($rootpath . $copy, $destination . $copy);
    }
    copy("../App/autoload.php", "../projects/" . $_POST['name'] . "/autoload.php");

    $project = new CreateProjectClass(slugify($_POST['name'], '_'), $_POST['name']);
    $project->writeConfig($destination . "config.ini", slugify($_POST['name'], '_'));
}
