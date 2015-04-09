<?php

/**
 * Модель для работы с сотрудниками.
 * @author Сергей Бакаев <sbbakaev@mail.ru>
 */
class User extends sql
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Обновляет данные по сотруднику и настройкам сотрудника.
     * @param array $params содержит name, password, surname, username, mail,
     *  id, firstDayWeek, isAdmin, timeFormat24, idUser.
     * @return int последнего добавленного события.
     */
    public function updateUser($params)
    {
        if (isset($params['password']))
        {
            $query = 'UPDATE  boardroom.user  SET `name`=:name, `password`=:password, `surname`=:surname,'
                    . '`username`=:username ,`mail`=:mail WHERE `id`=:id;'
                    . 'UPDATE  boardroom.userPreference  '
                    . 'SET `firstDayWeek`=:firstDayWeek, `isAdmin`=:isAdmin, '
                    . '`timeFormat24`=:timeFormat24 WHERE `idUser`=:idUser';
        } else
        {
            $query = 'UPDATE  boardroom.user  SET `name`=:name, `surname`=:surname,'
                    . '`username`=:username ,`mail`=:mail WHERE `id`=:id;'
                    . 'UPDATE  boardroom.userPreference  '
                    . 'SET `firstDayWeek`=:firstDayWeek, `isAdmin`=:isAdmin, '
                    . '`timeFormat24`=:timeFormat24 WHERE `idUser`=:idUser';
        }

        $res = $this->executeQuery($query, $params);
        return $res;
    }

    /**
     * Добавляет данные по сотруднику.
     * @param array $params содержит name, password, surname, username, mail.
     * @return int последнего добавленного события.
     */
    public function createUser($data)
    {
        $query = 'INSERT INTO  `boardroom`.`user` ('
                . '`name` , `surname` , `password` , `username` , `mail`)'
                . 'VALUES (:name,  :surname, :password, :username, :mail)';
        $res = $this->executeQuery($query, $data);
        return $res;
    }

    /**
     * Добавляет данные по настройкам сотрудника.
     * @param array $params содержит timeFormat24, firstDayWeek, isAdmin, idUser.
     * @return int последнего добавленного события.
     */
    public function addPreference($data)
    {
        $query = 'INSERT INTO `boardroom`.`userPreference`'
                . '(`timeFormat24`, `firstDayWeek`, `isAdmin`, `idUser`) VALUES'
                . '(:timeFormat24,:firstDayWeek,:isAdmin,:idUser)';

        $res = $this->executeQuery($query, $data);
        return $res;
    }

     /**
     * Получает всех пользователей удовлетворяющих.
     * @param array $params содержит id или дату создания и дату конца события.
     * @return array событий с детальными данными о них.
     */
    public function userList($data)
    {
        $query = 'SELECT user.id, `surname`,`name`,`username`,`mail`FROM `user` LEFT JOIN userPreference ON user.id = userPreference.idUser';

        $res = $this->getAll($query, $data);
        return $res;
    }

     /**
     * Удаляет сотрудника и его настройкивсех пользователей удовлетворяющих.
     * @param array $params содержит id или дату создания и дату конца события.
     * @return array событий с детальными данными о них.
     */
     public function deleteUser($data)
    {
        $query = 'DELETE FROM `user`  WHERE `user`.`id` = :userid;' .
                'DELETE FROM `userPreference`  WHERE `userPreference`.`idUser` = :userid';

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

    public static function setFlash($data, $type)
    {
        $_SESSION['flash'][$type][] = $data;
    }

    public static function getFlash($type = 'error')
    {

        if (isset($_SESSION['flash'][$type]))
        {
            $errors = $_SESSION['flash'][$type];
            $_SESSION['flash'][$type] = array();
        } else
        {
            $errors = array();
        }
        return $errors;
    }

    public function getUserDetails($data)
    {
        $query = 'SELECT u.*, up.firstDayWeek as firstDayWeek ,'
                . ' up.idUser as idUser, up.isAdmin as isAdmin,'
                . ' up.timeFormat24 as timeFormat24 FROM boardroom.user u  '
                . 'LEFT JOIN boardroom.userPreference up ON u.id = up.idUser '
                . 'WHERE u.id =:userId';

        $res = $this->getAll($query, $data);
        return $res;
    }

}
