<?php

class Event extends sql
{

    public function __construct()
    {
        parent::__construct();
    }

    public function eventList($data)
    {
        $query = 'SELECT * FROM user LEFT JOIN userPreference ON user.id = userPreference.idUser';

        $res = $this->getAll($query, $data);
        return $res;
    }

    public function checkEvent($data)
    {
        var_dump($data);
        $query = 'SELECT `id`,`date_start`,`date_end`  FROM  `event`' .
                'WHERE  `room_id` = :roomId AND((`date_start` BETWEEN  :dateStart AND  :dateEnd)' .
                'OR  (`date_end` BETWEEN  :dateStart AND  :dateEnd)' .
                'OR (`date_start`< :dateStart AND `date_end`>:dateStart)' .
                'OR  (`date_start`< :dateEnd AND `date_end`>:dateEnd))';
        var_dump($query);
        $res = $this->getAll($query, $data);
        var_dump($res);
        return $res;
    }

    public function createEvent($data)
    {

        $query = 'INSERT INTO `event`(`user_id`, `description`, `room_id`,'
                . ' `date_end`, `date_start`) '
                . 'VALUES (:userId,:description,:roomId,:dateEnd,:dateStart)';
        var_dump($query);
        $res = $this->executeQuery($query, $data);
        return $res;
    }

}
