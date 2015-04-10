<?php

/**
 * Класс для работы с базой данных
 */
class DataBase
{

    private static $instanse;
    private $dbLink;

    private function __construct()
    {
        
    }

    /**
     * реализация сингл тон.
     * @return объект.
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
     * Создание PDO объекта для работы с базойданных.
     * @return PDO объект если все хорошо.
     */
    public function connect()
    {
        if (!isset($this->dbLink))
        {
            $opt = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );
            $dsn = "mysql:host=" . DATABASE_HOST . ";dbname=" . DATABASE_NAME;
            try
            {
                $this->dbLink = new PDO($dsn, DATABASE_USER, DATABASE_PASSWORD, $opt);
            } catch (PDOException $e)
            {
                die('Connection error: ' . $e->getMessage());
            }
        }
        return $this->dbLink;
    }

}
