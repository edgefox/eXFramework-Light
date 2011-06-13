<?php

/**
 * Project:		eXFramework: Lightweight PHP framework
 * File: 		excontroller.php
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

	/**
	 * Displaying the template
	 */	
	function display($tplObject)
	{
		$tplObject->show($tplObject);
	}

	abstract function index();
}

?>
