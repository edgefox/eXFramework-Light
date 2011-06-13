<?php

/**
 * Example model
 */

class eXModelIndex extends eXModel
{
	public static function definition()
	{
		$model['fields'] = array( 'name' => '',
						  'surname' => '' );

		$model['primary_key'] = 'id';
		$model['table_name'] = 'personlist';

		return $model;
	}
}

?>
