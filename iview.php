<?php

interface IView
{
	public function output($result, $outputFormat, $callback = null);
}
