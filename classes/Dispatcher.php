<?php

class Dispatcher
{
    private $class = 'EventController';
    private $method = 'showCalendar';
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
       // var_dump($_SERVER);exit;
        $argument = explode("?", $url);
        $dispatch = explode("/", $argument[0]);
        var_dump($argument);
        if(isset($dispatch[1])&& strlen($dispatch[1])>0)
        {
            $this->class = ucfirst($dispatch[1]).'Controller';//TODO Добавить проверку доступа к предопределенным классам.
        }
        
        if(isset($dispatch[2]) && strlen($dispatch[2])>0)
        {
            $this->method = $dispatch[2];
        }
            $object = new $this->class($_GET);
            $object->{$this->method}();
    }
}
