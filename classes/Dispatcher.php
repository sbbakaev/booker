<?php

class Dispatcher
{

    private $class = 'EventController';
    private $method = 'showCalendar';
    private static $instanse;

    private function __construct()
    {
        
    }

    public static function getInstanse()
    {
        if (!isset(self::$instanse))
        {
            self::$instanse = new self;
        }
        return self::$instanse;
    }

    public function dispatch($url)
    {
       
        //  $logined = UserController::checkAuth();
        $url = strtolower($url);
        $argument = explode("?", $url);
        $dispatch = explode("/", $argument[0]);
        if (isset($dispatch[1]) && strlen($dispatch[1]) > 0)
        {
            $this->class = ucfirst($dispatch[1]) . 'Controller'; //TODO Добавить проверку доступа к предопределенным классам.
        }

        if (isset($dispatch[2]) && strlen($dispatch[2]) > 0)
        {
            $this->method = $dispatch[2];
        }
        $logined = UserController::checkAuth($this->class, $this->method);

        $object = new $this->class($_GET, $_POST);
        $object->{$this->method}();
    }

}
