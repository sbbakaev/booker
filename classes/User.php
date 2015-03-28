<?php

class User extends sql
{

    public function __construct()
    {
        parent::__construct();
    }

    public function userList($data)
    {
        $query = 'SELECT * FROM user LEFT JOIN userPreference ON user.id = userPreference.idUser';

        $res = $this->getAll($query, $data);
        return $res;
    }

    public function getPermision($username,$password)
    {
        $query = 'SELECT * FROM user LEFT JOIN userPreference'.
                ' ON user.id = userPreference.idUser'.
                ' WHERE username = :username and password = :password';

        $queryData['username'] = $username;
        $queryData['password'] = sha1($password);
 
        $res = $this->getAll($query, $queryData);
        return $res;

    }

}
