<?php

class sql
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = DataBase::getInstanse()->connect();
    }

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

    public function getAll($query, $params)
    {
        try
        {
               //         var_dump($query,$params);
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
