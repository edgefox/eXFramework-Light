<?php

/**
 * Project: eXFramework. Lightweight PHP framework
 * File: extemplate.php
 *
 * Class for working with Templates and Layouts.
 * Basicly, wrapper for Smarty.
 *
 * @author Ivan Lyutov
 * @date 09.11.2011
 * @email ivanlyutov@gmail.com
 * @version 0.1
 */

class eXTemplate extends Smarty
{
	private $name;
	private $path;

	/**
	 * Setting the path to templates directory
	 */
	function setPath($path)
	{
		$this->path = $path;
	}

	/**
	 * Displaying the template
	 */
	function show($template)
	{	
		$cmdPath = $this->path;
		$file = $cmdPath . DIRSEP .'apps' . DIRSEP . 'templates' . DIRSEP . $template->getName();
		
		$this->display($file);
	}

	/**
	 * Setting the template to show
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * Getting the template name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Configurating the template engine
	 */
	private static function configTplSystem($tpl)
	{
		$ini = eXINI::instance('TemplateEngine','template.ini');
		$settings = $ini->getINI();

		$tpl->setTemplateDir($settings['templates_dir']);
		$tpl->setCompileDir($settings['compile_dir']);
		$tpl->setCacheDir($settings['cache_dir']);

		return $tpl;
	}

	/**
	 * Wrapper for instantiating the object.
	 * Only one instance is available at one time.
	 */
	public static function instance($name = false)
	{
		if (!is_object(eXRegistry::$_instance['template']))
		{
			eXRegistry::$_instance->set('template', new eXTemplate());
			$tpl = eXTemplate::configTplSystem(eXRegistry::$_instance['template']);

			if ($name)
				$tpl->setName($name);

			return $tpl;
		}
		else
		{
			if ($name)
				eXRegistry::$_instance['template']->setName($name);

			return eXRegistry::$_instance['template'];
		}
	}
}

?>
