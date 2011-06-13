<?php

/**
 * Project: eXFramework. Lightweight PHP framework
 * File: exini.php
 *
 * Class for working with INI files
 *
 * @author Ivan Lyutov
 * @date 09.11.2010
 * @email ivanlyutov@gmail.com
 * @version 0.1
 */

class eXINI
{
	/**
	 * Configuration container
	 */
	private $config;

	/**
	 * Fetching settings from specified INI file
	 */
	private function __construct($section,$filePath)
	{
		$config = parse_ini_file($filePath, true);

		if ($section)
		{
			if (isset($config[$section]))
				$this->setINI($config[$section]);
			else
				$this->setINI(false);
		}
		else
			$this->setINI($config);
	}

	/**
	 * Changing the settings
	 */
	public function setINI($value)
	{
		$this->config = $value;
	}

	/**
	 * Getting the settings
	 */
	public function getINI()
	{
		return $this->config;
	}

	/**
	 * Wrapper for instantiating the object.
	 * Only one instance is available at one time.
	 */
	public static function instance($section = false, $file)
	{
		$filePath = 'settings' . DIRECTORY_SEPARATOR . $file;
		return new eXINI($section, $filePath);
	}
}

?>
