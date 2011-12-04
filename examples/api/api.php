<?php

include_once('../../app.php');

class Api extends App
{
	public $export = array(
		'user' => 'getUser',
		'item/get' => 'getItem'
	);

	public function getUser()
	{
		return array(
			id => 100,
			name => "UserName"
		);
	}

	public function getItem()
	{
		return array(
			'name' => $this->arg('name', ''),
			'url' => $this->arg('url', '')
		);
	}
}