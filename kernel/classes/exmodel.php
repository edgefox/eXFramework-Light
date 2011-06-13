<?php

/**
 * Project: eXFramework. Lightweight PHP framework
 * File: exmodel.php
 *
 * Custom data structures should be defined
 * via extending eXModel class in
 * static definition() method
 *
 * @author Ivan Lyutov
 * @date 13.11.2011
 * @email ivanlyutov@gmail.com
 * @version 0.1
 */

abstract class eXModel
{
	private $model = array();

	function __construct()
	{
		$class = get_called_class();
		$this->model = $class::definition();
	}

	public function setAttribute($key, $value)
	{
		if ( isset($this->model['fields'][$key]) )
		{
			$this->model['fields'][$key] = $value;

			return true;
		}
		else
			return false;
	}

	public function fetchObject($id)
	{
		$db = eXDBLayer::instance();

		$fieldsString = implode(', ', array_keys($this->model['fields']));

		$query = "SELECT " . $fieldsString . " FROM " . $this->model['table_name'] . " WHERE " . $this->model['primary_key'] . "=" . $id;
		$result = $db->query($query);
		$row = $result->fetch_object();

		return $row;
	}

	public function store($filter=false)
	{
		if ( $this->model )
		{
			$db = eXDBLayer::instance();

			foreach ($this->model['fields'] as $key => $item)
			{
				if ( is_string($item) )
					$this->model['fields'][$key] = "'".$item."'";
			}

			if ( !is_array($filter) )
			{
				$keys = implode(", ", array_keys($this->model['fields']));

				$values = implode(", ", $this->model['fields']);
				$query = "INSERT INTO " . $this->model['table_name'] . "(" . $keys . ") VALUES(" . $values . ")";
				$db->query($query);

				return true;
			}
			else
			{
				$update = "";

				foreach ($this->model['fields'] as $key => $item)
				{
					$update[] .= $key . "=" . $item;
				}

				$updateString = implode(", ", $update);
				$condition = implode(" AND ", $filter);
				
				$query = "UPDATE " . $this->model['table_name'] . " SET " . $updateString . " WHERE " . $condition;
				$db->query($query);

				return true;
			}
		}
		else
			return false;
	}

	public static function definition()
	{
		return array();
	}
}

?>
