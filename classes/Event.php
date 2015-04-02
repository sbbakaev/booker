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

    public function addEvent($data)
    {

      /*  $query = 'INSERT INTO event (`room_id`, `description`,`user_id`) '
                . 'VALUES (:room_id, :description,:user_id)';
        $params = array("room_id" => $data['room'], "description" => $data['description'], "user_id" => $data['user_id']);
        $res = $this->executeQuery($query, $params);

        $recurringCount = $data['recurringCount'];
        $recurringFrequency = $data['recurringFrequency'];
        $dateStart = $data['dateStart'];
        $dateEnd = $data['dateEnd'];
        $dateStart = $data['dateStart'];
        $params = [];
        $temp = array();
        if ($recurringCount > 0)
        {
            if ($recurringFrequency == "weekly")
            {
                $dateInterval = 'P7D';
            } elseif ($recurringFrequency == "be-weekly")
            {
                $dateInterval = 'P7W';
            } elseif ($recurringFrequency == "monthly")
            {
                $dateInterval = 'P1M';
            }
            for ($i = 0; $i <= $recurringCount; $i++)
            {
                if ($i == 0)
                {
                    $temp['dateStart'] = $dateStart;
                    $temp['dateEnd'] = $dateEnd;
                    $temp['recurrentId'] = $res;
                } else
                {
                    $temp['dateStart'] = $dateStart->add(new DateInterval($dateInterval));
                    $temp['dateEnd'] = $dateEnd->add(new DateInterval($dateInterval));
                    $temp['recurrentId'] = $res;
                }
                $params[] = $temp;
            }
        }

        $query = "INSERT INTO date_event (`recurrent_id`, `date_start`,`date_end`,"
                . " `isAdmin`, `idUser`) VALUES (:recurrent_id, :date_start, :date_end)";
        $params = array("recurrent_id" => "$recurrent_id",
            "date_start" => "$date_start", "date_end" => "$date_end");

        $res = $this->executeQuery($query, $data);
        return $res;
        */
    }

}
