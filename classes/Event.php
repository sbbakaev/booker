<?php

class Event extends sql
{

    public function __construct()
    {
        parent::__construct();
    }

    public function eventList($params)
    {
        $query = 'SELECT * FROM event WHERE date_start>:date_start AND date_end>:date_end';

        $res = $this->getAll($query,$params);
        return $res;
    }

    public function checkEvent($params)
    {

        $query = 'SELECT `id`,`date_start`,`date_end`  FROM  `event`' .
                'WHERE  `room_id` = :roomId AND((`date_start` BETWEEN  :dateStart AND  :dateEnd)' .
                'OR  (`date_end` BETWEEN  :dateStart AND  :dateEnd)' .
                'OR (`date_start`< :dateStart AND `date_end`>:dateStart)' .
                'OR  (`date_start`< :dateEnd AND `date_end`>:dateEnd))';
 
        $res = $this->getAll($query, $params);

        return $res;
    }

    public function createEvent($data)
    {

        $query = 'INSERT INTO `event`(`user_id`, `description`, `room_id`,'
                . ' `date_end`, `date_start`) '
                . 'VALUES (:userId,:description,:roomId,:dateEnd,:dateStart)';

        $res = $this->executeQuery($query, $data);
        return $res;
    }

}
