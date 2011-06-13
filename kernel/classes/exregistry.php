<?php

/**
 * Project:		eXFramework: Lightweight PHP framework
 * File: 		exregistry.php
 *
 * Global vars container for communication
 * between objects
 * 
 * @author Ivan Lyutov
 * @email ivanlyutov@gmail.com
 * @date 09.11.2011
 * @version 0.1
 */

final class eXRegistry implements ArrayAccess
{
	private $vars = array();
	public static $_instance;

	public function set($key, $var)
	{
		if (isset($this->vars[$key]) == true)
		{
		        throw new Exception('Unable to set var `' . $key . '`. Already set.');
		}

		$this->vars[$key] = $var;

		return true;
	}

	public function get($key)
	{
		if (isset($this->vars[$key]) == false)
		{
		        return null;
		}

		return $this->vars[$key];
	}

	public function remove($var)
	{
		unset($this->vars[$key]);
	}

	public function offsetExists($offset)
	{
	        return isset($this->vars[$offset]);
	}

	public function offsetGet($offset)
	{
		return $this->get($offset);
	}

	public function offsetSet($offset, $value)
	{
		$this->set($offset, $value);
	}

	public function offsetUnset($offset)
	{
		unset($this->vars[$offset]);
	}

	/**
	 * Wrapper for instantiating the object.
	 * Only one instance is available at one time.
	 */
	public static function instance()
	{
		if (!is_object(self::$_instance))
		{
			self::$_instance = new eXRegistry();
			return self::$_instance;
		}
		else
			return self::$_instance;
	}
}

?>
