<?php

/**
 * Project: eXFramework. Lightweight PHP framework
 * File: excontroller.php
 *
 * Basic controller class
 *
 * @author Ivan Lyutov
 * @date 09.11.2011
 * @email ivanlyutov@gmail.com
 * @version 0.1
 */

abstract class eXController
{
	/**
	 * Container for arguments passed to controller
	 */
	protected $args;

	function __construct($args)
	{
		$this->args = $args;
	}

	public function getModel($name)
	{
		$name[0] = strtoupper($name[0]);
		$class = 'eXModel' . $name;
		return new $class;
	}

	/**
	 * Displaying the template
	 */
	protected function display($tplObject)
	{
		$tplObject->show($tplObject);
	}

	abstract function index();
}

?>
