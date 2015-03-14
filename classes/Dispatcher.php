<?php

class Dispatcher
{
    private static $instanse;
    
    private function __construct() {
        
    }   
    
    public static function getInstanse()
    {
        if(!isset(self::$instanse))
        {
            self::$instanse = new self;
        }
            return self::$instanse;
    }
    public function dispatch($url)
    {
        $url = strtolower($url);
        $dispatch = explode("/", $url);
        $class = ucfirst($dispatch[1]).'Controller';//TODO Добавить проверку доступа к предопределенным классам.
        $method = $dispatch[2];
        $object = new $class();
        $object->$method();
    }
}
