<?php

class User extends sql {

    public function __construct() {
        parent::__construct();
    }

    public function userList($data) {
        $query = 'SELECT * FROM user LEFT JOIN userPreference ON user.id = userPreference.idUser';

        $res = $this->getAll($query, $data);
        return $res;
    }

}
