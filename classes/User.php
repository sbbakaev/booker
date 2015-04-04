<?php

class User extends sql
{

    public function __construct()
    {
        parent::__construct();
    }

    public function userList($data)
    {
        $query = 'SELECT user.id, `surname`,`name`,`username`,`mail`FROM `user` LEFT JOIN userPreference ON user.id = userPreference.idUser';

        $res = $this->getAll($query, $data);
        return $res;
    }

    public function deleteUser($data)
    {
        $query = 'DELETE FROM `user`  WHERE `user`.`id` = :id;' .
                'DELETE FROM `userPreference`  WHERE `userPreference`.`idUser` = :id';

        $res = $this->executeQuery($query, $data);
        return $res;
    }

    public function getPermision($username, $password)
    {
        $query = 'SELECT * FROM user LEFT JOIN userPreference' .
                ' ON user.id = userPreference.idUser' .
                ' WHERE username = :username and password = :password';

        $queryData['username'] = $username;
        $queryData['password'] = sha1($password);

        $res = $this->getAll($query, $queryData);
        return $res;
    }

    public static function setFlash($data,$type)
    {
        $_SESSION['flash'][$type] = $data;
    }

    public static function getFlash($type='error')
    {

        $errors = $_SESSION['flash'][$type];
        $_SESSION['flash'][$type] = array();
        return $errors;
    }

}
