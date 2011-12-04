<?php

include_once('../app.php');
include_once('../view.php');
include_once('../api/api.php');

class Main extends App
{
	public $api;

	public $export = array(
		'item/get' => 'getItem',
		'stream' => 'stream'
	);

	public function __construct($view = null)
	{
		parent::__construct($view);
		$this->api = new Api();
	}

	public function getItem()
	{
		return array(
			'tpl' => 'add_item.tpl',
			'data' => $this->api->call('item/get', $this->args)
		);
	}

	public function stream()
	{
		return array(
			'tpl' => 'layout.tpl',
			'data' => $this->api->call('user', $this->args)
		);
	}
}

$route = @$_REQUEST['r'];
if (!isset($route)) {
	$route = 'stream';
}

unset ($_REQUEST['r']);

$view = new View();
$app = new Main($view);
$app->call($route, $_REQUEST, 'tpl');