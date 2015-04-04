<?php

class sql
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = DataBase::getInstanse()->connect();
    }

    public function executeQuery($query, $parameters)
    {var_dump($query);
        echo '</br>';
               var_dump($parameters);
        echo '</br>';
 
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

    public function getAll($query, $parameters = null)
    {
        try
        {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($parameters);
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
