<?php

include_once('iview.php');

class View implements IView
{
	public $modes = array(
		'html' => 'html',
		'text' => 'html',
		'tpl' => 'tpl',
		'js' => 'js',
		'json' => 'json',
		'result' => 'result',
		'debug' => 'debug'
	);

	public function html($result)
	{
		Header("content-type: text/html; charset=utf-8");
		echo $result;
	}

	public function tpl($result)
	{
		require('../smarty/smarty.class.php');
		$smarty = new Smarty();

		$smarty->setTemplateDir('../smarty/templates');
		$smarty->setCompileDir('../smarty/templates_c');
		$smarty->setCacheDir('../smarty/cache');
		$smarty->setConfigDir('../smarty/configs');

		$smarty->assign('data', $result['data']);
		Header("content-type: text/html; charset=utf-8");
		echo $smarty->fetch($result['tpl']);
	}

	public function debug($result)
	{
		Header("content-type: text/html; charset=utf-8");
		print_r($result);
	}

	public function json($result)
	{
		Header("content-type: application/json; charset=utf-8");
		return json_encode($result);
	}

	public function js($result)
	{
		Header("content-type: application/javascript; charset=utf-8");
		echo $result;
	}

	public function result($result)
	{
		$json = $result === true ? array('result' => true) : array('result' => false);
		return $this->json($json);
	}

	public function output($result, $mode, $callback = null)
	{
		if (isset($callback) && ($mode != 'json' || $mode != 'result')) {
			$mode = 'json';
		}
		$raw = '';
		if (array_key_exists($mode, $this->modes)) {
			$methodName = $this->modes[$mode];
			$raw = $this->$methodName($result, null);
		}
		if (isset($callback)){
			echo $callback . '(' . $raw . ')';
		}else if (isset($raw)){
			echo $raw;
		}
	}
}
