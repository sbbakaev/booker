<?php
  
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

function __autoload($classname)
{
    $filename = "./classes/" . $classname . ".php";
    if (file_exists($filename))
    {
        include_once($filename);
    } else
    {
        echo 'File not found ' . $filename;
    }
}

$url = $_SERVER['REQUEST_URI'];
Dispatcher::getInstanse()->dispatch($url);

