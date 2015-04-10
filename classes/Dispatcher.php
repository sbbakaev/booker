<?php

/**
 * Класс для распарсивания url и вызова метода конкретного класса.
 */
class Dispatcher
{

    private $class = 'EventController';
    private $method = 'showCalendar';
    private static $instanse;

    private function __construct()
    {
        
    }

    /**
     * реализация сингл тон
     * @return type
     */
    public static function getInstanse()
    {
        if (!isset(self::$instanse))
        {
            self::$instanse = new self;
        }
        return self::$instanse;
    }

    /**
     * Распарсивание url и вызов метода конкретного класса
     * @param string $url.
     */
    public function dispatch($url)
    {
        $url = strtolower($url);
        $argument = explode("?", $url);
        $dispatch = explode("/", $argument[0]);
        if (isset($dispatch[1]) && strlen($dispatch[1]) > 0)
        {
            $this->class = ucfirst($dispatch[1]) . 'Controller';
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
