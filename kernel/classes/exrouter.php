<?php

/**
 * Project:		eXFramework: Lightweight PHP framework
 * File: 		exrouter.php
 *
 * Class for routing the paths
 * 
 * @author Ivan Lyutov
 * @date 09.11.2011
 * @email ivanlyutov@gmail.com
 * @version 0.1
 */

class eXRouter
{
	private $path;
	public $args = array();

	/**
	 * Setting the path to controller
	 */
	public function setPath($path)
	{
		$path .= DIRSEP;

		if (is_dir($path) == false)
		{
			throw new Exception ('Invalid controller path: `' . $path . '`');
		}

		$this->path = $path;
	}

	/**
	 * Delegating the functionality the processing to requested controller
	 */
	public function delegate()
	{
		$this->getController($file, $controller, $action, $this->args);

		if (is_readable($file) == false)
		{
		        die ('404 Not Found');
		}

		require_once $file;

		$controller[0] = strtoupper($controller[0]);
		$class = 'eXController' . $controller;

		$controller = new $class($this->args);

		if (is_callable(array($controller, $action)) == false)
		{
		        die ('404 Not Found');
		}

		$controller->$action();
	}

	/**
	 * Detecting the controller
	 */
	private function getController(&$file, &$controller, &$action, &$args)
	{
		$route = (empty($_SERVER['REDIRECT_URL'])) ? '' : $_SERVER['REDIRECT_URL'];

		if (empty($route)) { $route = 'index'; }

		$route = trim($route, '/\\');
		$parts = explode('/', $route);
		$cmdPath = $this->path;

		foreach ($parts as $key => $part)
		{
			$fullPath = $cmdPath . $part;

		      if (is_dir($fullPath))
			{
		                $cmdPath .= $part . DIRSEP;
		                array_shift($parts);

		                continue;
		      }

		      if (is_file($fullPath . '.php'))
			{
		                $controller = $part;
		                array_shift($parts);

		                break;
		      }
		}

		if (empty($controller)) { $controller = 'index'; };

		$action = array_shift($parts);

		if (empty($action)) { $action = 'index'; }

		$file = $cmdPath . $controller . '.php';
		
		$args = $parts;
	}

	/**
	 * Wrapper for instantiating the object.
	 * Only one instance is available at one time.
	 */
	public static function instance()
	{
		if (!is_object(eXRegistry::$_instance['router']))
		{
			eXRegistry::$_instance->set('router', new eXRouter());
			return eXRegistry::$_instance['router'];
		}
		else
		{
			return eXRegistry::$_instance['router'];
		}
	}
}

?>
