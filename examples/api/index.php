<?php

include_once('api.php');
include_once('../view.php');

$route = @$_REQUEST['r'];

unset ($_REQUEST['r']);

$view = new View();
$api = new Api($view);
$api->call($route, $_REQUEST, 'json');