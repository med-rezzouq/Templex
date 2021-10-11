<?php

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
defined('_JEXEC') or die('Restricted access');

use Templex\Templex;
// get templex

require(__DIR__ . '/templex.php');
$templex = new Templex();



echo $templex['template']->render('theme');
