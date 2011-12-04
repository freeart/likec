<?php

abstract class App
{
	public $view;
	public $args;
	public $export = array();

	public function __construct($view = null)
	{
		if (isset($view)) {
			$this->view = $view;
			if (!($this->view instanceof IView)) {
				throw new Exception('View must implement IView interface');
			}
		}
	}

	public function arg($name, $default)
	{
		return (isset($this->args[$name]) && !empty($this->args[$name]) ? urldecode($this->args[$name]) : $default);
	}

	public function call($route, $args, $format = null)
	{
		if (!isset($route)) throw new Exception('Route is not exists');

		$this->args = $args;
		$callback = $this->arg('jsoncallback', null);

		if (array_key_exists($route, $this->export)) {
			$methodName = $this->export[$route];
			$result = $this->$methodName();
			if (!isset($this->view)) {
				return $result;
			} else {
				if (!isset($format)) throw new Exception('Format is not exists');

				$this->view->output($result, $format, $callback);
			}
		}
	}
}
