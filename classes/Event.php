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
        $query = 'SELECT count(id) FROM  `event`' .
                'WHERE  (`date_start` BETWEEN  :dateStart AND  :dateEnd)' .
                'OR  (`date_end` BETWEEN  :dateStart AND  :dateEnd)' .
                'OR (`date_start`< :dateStart AND `date_end`>:dateStart)' .
                'OR  (`date_start`< :dateEnd AND `date_end`>:dateEnd)';

        $res = $this->getAll($query, $data);
        echo '</br>//////';
        var_dump($res);
        echo '</br>//////';
        return $res;
    }

    public function createEvent($data)
    {
        $query = 'INSERT INTO `event`(`user_id`, `description`, `room_id`, `date_end`, `date_start`) VALUES (:userId,:description,:roomId,:dateEnd,:dateStart)';

        $res = $this->executeQuery($query, $data);
        return $res;
    }

}
