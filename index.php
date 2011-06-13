<?php

if (version_compare(phpversion(), '5.1.0', '<') == true)
{
	die ('PHP 5.1 or higher is required');
}

define ('DIRSEP', DIRECTORY_SEPARATOR);
define ('ROOT_DIR', dirname(__FILE__));

function __autoload($className)
{
	$fileName = strtolower($className) . '.php';

	$classesDir = ROOT_DIR . DIRSEP . 'kernel'. DIRSEP . 'classes' . DIRSEP;
	$libsDirs = scanDirs(ROOT_DIR . DIRSEP . 'kernel' . DIRSEP . 'libs' . DIRSEP);
	$modelsDir = ROOT_DIR . DIRSEP . 'apps'. DIRSEP . 'models' . DIRSEP;

	$dirs = array_merge((array)$classesDir, $libsDirs, (array)$modelsDir);

	foreach ($dirs as $dir)
	{
		$path = $dir . $fileName;

		if (file_exists($path))
		{
			require_once $path;
		}
	}

	return false;
}

function scanDirs($path)
{
	$sortedData = array();

	foreach(scandir($path) as $dir)
	{
		$dirPath = $path . $dir . DIRSEP;
		if ( $dir != '.' && $dir != '..'  && is_dir($dirPath))
		{	
			if (scanDirs($dirPath))
			{
				array_push($sortedData,scanDirs($dirPath));
			}

			array_push($sortedData, $dirPath);
		}
	}

	return $sortedData;
}

$registry = eXRegistry::instance();

$ini = eXINI::instance('DatabaseSettings','site.ini');
$settings = $ini->getINI();

if ($settings['db_type'])
{
	$db = eXDBLayer::instance();
}

$template = eXTemplate::instance();
$template->setPath(ROOT_DIR);

$router = eXRouter::instance();
$router->setPath(ROOT_DIR . '/apps/controllers');
$router->delegate();

?>
