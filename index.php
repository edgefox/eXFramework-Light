<?php

if (version_compare(phpversion(), '5.1.0', '<') == true) { die ('PHP5.1 Only'); }

define ('DIRSEP', DIRECTORY_SEPARATOR);

$site_path = dirname(__FILE__);
define ('site_path', $site_path);

function __autoload($class_name)
{
	$fileName = strtolower($class_name) . '.php';
	$classesDir = site_path . DIRSEP . 'kernel'. DIRSEP . 'classes' . DIRSEP;
	$libsDirs = scanDirs(site_path . DIRSEP . 'kernel' . DIRSEP . 'libs' . DIRSEP);
	$dirs = array_merge((array)$classesDir, $libsDirs);

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
$template->setPath(site_path);

$router = eXRouter::instance();
$router->setPath(site_path . '/apps/controllers');
$router->delegate();

?>
