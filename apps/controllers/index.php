<?php


class eXControllerIndex extends eXController
{
	function index()
	{
		$tpl = eXTemplate::instance('index.tpl');
		$string = 'Welcome to eXFramework';
		$tpl->assign('index', $string);
		parent::display($tpl);
	}
}


?>
