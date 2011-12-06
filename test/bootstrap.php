<?php
require_once __DIR__ . '/../ext/Autoloader/Simple.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

$path_list = array_merge(array(__DIR__ . '/../ext', __DIR__ . '/../src'), array_filter(explode(PATH_SEPARATOR, get_include_path()), function($value)
{
    return $value !== '.';
}));
set_include_path(implode(PATH_SEPARATOR, $path_list));
spl_autoload_register(array('Autoloader_Simple', 'load'));
