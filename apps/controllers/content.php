<?php

class eXControllerContent extends eXController
{
      function index()
	{
		$tpl = eXTemplate::instance('test.tpl');
		$tpl->assign('test',array('one','two','three'));

		parent::display($tpl);
	}
}

?>
