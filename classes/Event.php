<?php

/**
 * Модель для работы с событиями.
 * @author Сергей Бакаев <sbbakaev@mail.ru>
 */
class Event extends sql
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Получает все события удовлетворяющие условию.
     * @param array $params содержит id или дату создания и дату конца события.
     * @return array событий с детальными данными о них.
     */
    public function eventList($params)
    {

        if (isset($params['id']))
        {
            $query = 'SELECT ev.*, u.surname as surname, u.name as name FROM event ev '
                    . 'LEFT JOIN user u ON ev.user_id = u.id'
                    . ' WHERE ev.id=:id';
        } else
        {
            $query = 'SELECT * FROM event WHERE date_start>=:date_start AND date_end<:date_end';
        }

        $res = $this->getAll($query, $params);

        return $res;
    }

    /**
     * Получает все события удовлетворяющие условию.
     * @param array $params содержит id или дату создания и дату конца события и
     *  id комнаты.
     * @return array событий с датой начала и датой конца.
     */
    public function checkEvent($params)
    {
        if (isset($params['id']))
        {

            $query = 'SELECT `id`,`date_start`,`date_end`  FROM  `event`' .
                    'WHERE  `room_id` = :roomId AND `id`!=:id AND ((`date_start` BETWEEN  :dateStart AND  :dateEnd)' .
                    'OR  (`date_end` BETWEEN  :dateStart AND  :dateEnd)' .
                    'OR (`date_start`< :dateStart AND `date_end`>:dateStart)' .
                    'OR  (`date_start`< :dateEnd AND `date_end`>:dateEnd))';
        } else
        {
            $query = 'SELECT `id`,`date_start`,`date_end`  FROM  `event`' .
                    'WHERE  `room_id` = :roomId AND((`date_start` BETWEEN  :dateStart AND  :dateEnd)' .
                    'OR  (`date_end` BETWEEN  :dateStart AND  :dateEnd)' .
                    'OR (`date_start`< :dateStart AND `date_end`>:dateStart)' .
                    'OR  (`date_start`< :dateEnd AND `date_end`>:dateEnd))';
        }
        $res = $this->getAll($query, $params);
        return $res;
    }

    /**
     * Обновляет одно событие новыми данными.
     * @param array $params содержит id или дату создания и дату конца события,
     * описание события и id комнаты.
     * @return int последнего добавленного события.
     */
    public function updateEvent($params)
    {
        //var_dump($data);exit;
        $query = 'UPDATE  `event` SET `room_id`=:roomId, `date_start`=:dateStart, `date_end`=:dateEnd,'
                . '`description`=:description WHERE `id`=:id';

        $res = $this->executeQuery($query, $params);
        return $res;
    }

    /**
     * Обновляет одно событие для заполнения связующего поля recurrent_id.
     * @param array $params содержит id.
     * @return int последнего добавленного события.
     */
    public function updateRecurrentEvent($params)
    {
        $query = 'UPDATE  `event` SET `recurrent_id`=:id WHERE `id`=:id';

        $res = $this->executeQuery($query, $params);
        return $res;
    }

    /**
     * Делает запись одного события с детальными данными.
     * @param array $params содержит поля id, user_id, description, room_id, 
     * date_end, date_start, recurrent_id.
     * @return int последнего добавленного события.
     */
    public function createEvent($params)
    {

        $query = 'INSERT INTO `event`(`user_id`, `description`, `room_id`,'
                . ' `date_end`, `date_start`,`recurrent_id`) '
                . 'VALUES (:userId,:description,:roomId,:dateEnd,:dateStart,:insertId)';

        $res = $this->executeQuery($query, $params);
        return $res;
    }

    /**
     * Удаляет одну запись по id или все записи по полю recurrent_id.
     * @param array $params может содержать поле id или recurrent_id. 
     * date_end, date_start, recurrent_id.
     * @return int последнего добавленного события.
     */
    public function deleteEvent($params)
    {
        if (isset($params['recurrent_id']))
        {
            $query = 'DELETE FROM `event` WHERE `recurrent_id` =:recurrent_id';
        } else
        {
            $query = 'DELETE FROM `event` WHERE `id` = :id';
        }
        $res = $this->executeDeleteQuery($query, $params);

        return $res;
    }

    public function getRooms()
    {
        $data = array();
        $query = 'SELECT *  FROM `rooms`';

        $res = $this->getAll($query, $data);

        return $res;
    }

}
