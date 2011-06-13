<?php

/**
 * Project: eXFramework. Lightweight PHP framework
 * File: exdblayer.php
 *
 * Database abstraction layer class.
 * All communication with database
 * should be performed via this class.
 *
 * @author Ivan Lyutov
 * @date 09.11.2011
 * @email ivanlyutov@gmail.com
 * @version 0.1
 */

class eXDBLayer
{
	/**
	 * Connection data that
	 * comes from config or set
	 * manually
	 */
	private $dbConfig = array( 'db_host' => '',
					   'db_user' => '',
					   'db_pass' => '',
					   'db_name' => '' );
	
	/**
	 * Active connection field
	 */
	private $db;

	/**
	 * Creating the connection
	 */
	private function __construct( $settings )
	{
		if (!$settings)
		{
			$ini = eXINI::instance('DatabaseSettings', 'site.ini');
			$settings = $ini->getINI();
		}

		$connection = eXDBLayer::connect($settings);

		if (!is_array($connection))
		{
			$this->dbConfig['db_host'] = $settings['db_host'];
			$this->dbConfig['db_user'] = $settings['db_user'];
			$this->dbConfig['db_pass'] = $settings['db_pass'];
			$this->dbConfig['db_name'] = $settings['db_name'];

			$this->db = $connection;
		}
		else
		{
			/**
			 * If failed connecting the database then
			 * handling the error with system handler
			 */
			die($connection['object']->connect_error);
		}
	}

	/**
	 * Closing the connection
	 */
	function __destruct()
	{
		if ($this->db)
		{
			$this->db->close();
		}
	}

	/**
	 * Query wrapper method
	 */
	public function query($query)
	{
		$result = $this->db->query($query);

		if ($this->db->errno)
		{
			$result = $this->db->error;
		}
		
		return $result;
	}

	public function getDBConfig()
	{
		return $this->dbConfig;
	}

	/**
	 * Checking the connection settings
	 * Returns active connection if succeeded
	 */	
	static private function connect( $settingsArray )
	{
		if ( isset($settingsArray) && is_array($settingsArray))
		{
			
			foreach ($settingsArray as $setting)
			{
				if (!$setting)
					return false;
			}

			$connection = new mysqli( $settingsArray['db_host'],
							  $settingsArray['db_user'],
						  	  $settingsArray['db_pass'],
						  	  $settingsArray['db_name']);
			
			if ( !$connection->connect_errno )
			{
				return $connection;
			}
			else
			{
				$error = array( 'class' => get_called_class(),
						'object' => $connection );

				return $error;
			}
		}
		else
			return false;
	}

	/**
	 * Wrapper for instantiating the object.
	 * Only one instance is available at one time.
	 */
	public static function instance($settings = false)
	{
		if (!is_object(eXRegistry::$_instance['db']))
		{
			eXRegistry::$_instance->set('db', new eXDBLayer($settings));
			return eXRegistry::$_instance['db'];
		}
		else
			return eXRegistry::$_instance['db'];
	}
}

?>