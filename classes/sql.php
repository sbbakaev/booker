<?php

/**
 * Клсс для работы c mySQL.
 * @author Сергей Бакаев <sbbakaev@mail.ru>
 */
class sql
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = DataBase::getInstanse()->connect();
    }

    /**
     * Выполняет заранее подготовленный запрос и возвращает последний вставленный id
     * @param string $query - mySQL запрос
     * @param array $parameters - любой аррайв зависимостиотзапроса
     * @return int возвращает последний вставленный id если все хорошо
     */
    public function executeQuery($query, $parameters)
    {
        try
        {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($parameters);
            $result = $this->pdo->lastInsertId();
        } catch (PDOException $e)
        {
            die('Method /"executeQuery/" wasn`t execute.' . $e->getMessage());
        }
        return $result;
    }

    /**
     * Выполняет заранее подготовленный запрос на удление.
     * @param string $query - mySQL запрос
     * @param array $parameters - любой аррайв зависимостиотзапроса
     * @return boolean возвращает true если все хорошо.
     */
    public function executeDeleteQuery($query, $parameters)
    {
        try
        {
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute($parameters);
        } catch (PDOException $e)
        {
            die('Method /"executeDeleteQuery/" wasn`t execute.' . $e->getMessage());
        }
        return $result;
    }

    /**
     * Выполняет заранее подготовленный запрос на select.
     * @param string $query - mySQL запрос
     * @param array $parameters - любой аррайв зависимостиотзапроса
     * @return boolean возвращает true если все хорошо.
     */
    public function getAll($query, $params)
    {
        try
        {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
        } catch (PDOException $e)
        {
            die('Method /"getAll/" wasn`t execute.' . $e->getMessage());
        }
        $res = array();
        foreach ($stmt as $value)
        {
            $res[] = $value;
        }
        return $res;
    }

}
