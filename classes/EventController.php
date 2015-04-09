<?php

class EventController extends Controller
{

    public function __construct($get, $post)
    {
        $this->model = new Event;
        $this->view = new Viewer;
        parent::__construct($get, $post);
    }

    public function showEventDetails()
    {
        if (isset($this->dataGet["id"]))
        {
            $id = (int) $this->dataGet["id"];
            $params['id'] = $id;
            $temp = $this->model->eventList($params);
            $dateStart = new DateTime($temp[0]['date_start']);
            $dateEnd = new DateTime($temp[0]['date_end']);
            $res['dateEvent'] = $dateStart->format("Y-m-d H:i:s");
            $res['date_start'] = $dateStart->format('H:i');
            $res['date_end'] = $dateEnd->format('H:i');
            $res['user'] = $temp[0]['name'] . ' ' . $temp[0]['surname'];
            $res['description'] = $temp[0]['description'];
            $res['eventId'] = $temp[0]['id'];
            $res['recurrentId'] = $temp[0]['recurrent_id'];
            $res['dateCreateEvent'] = $temp[0]['date_create_event'];
            echo json_encode($res);
        }
    }

    /**
     * Метод удаляет событие. Если есть отметка об удалении всех связаных событий,
     *  то удаляет их все.
     * @return json object
     */
    public function deleteEvent()
    {
        if (isset($this->dataPost['deleteAllEvent']))
        {
            if ($this->dataPost['deleteAllEvent'] != "false")
            {
                $data['recurrent_id'] = $this->dataPost['recurrentId'];
            } else
            {

                $data['id'] = $this->dataPost['id'];
            }
        }
        $res = $this->model->deleteEvent($data);
        $respone = array();
        $respone['success'] = TRUE;
        $respone['message'] = 'Event has been deleted';
        echo json_encode($respone);
        exit;
    }

    public function updateEvent()
    {

        $date = explode(" ", $this->dataPost['eventDate']);

        $eventDateStart = new DateTime($date[0] . $this->dataPost['dateStart']);
        $eventDateEnd = new DateTime($date[0] . $this->dataPost['dateEnd']);

        $data[0]['dateStart'] = $eventDateStart->format('Y-m-d H:i:s');
        $data[0]['dateEnd'] = $eventDateEnd->format('Y-m-d H:i:s');
        $data[0]['roomId'] = $_SESSION['room']['id'];
        $data[0]['id'] = $this->dataPost['id'];
        $data[0]['description'] = $this->dataPost['description'];

        $dataCheck = $data;
        foreach ($dataCheck as $key => $value)
        {
            unset($dataCheck[$key]['description']);
        }

        $canCreateEvent = TRUE;
        //Проверяю свободное время
        foreach ($dataCheck as $value)
        {

            $eventInBD = $this->model->checkEvent($value);
            if (!empty($eventInBD))
            {
                $canCreateEvent = FALSE;
            }
        }
        if ($canCreateEvent)
        {
            foreach ($data as $value)
            {
                $this->model->updateEvent($value);
            }
            $respone = array();
            $respone['success'] = TRUE;
            $respone['message'] = 'Event has been updated';
            echo json_encode($respone);
            exit;
        }
    }

    public function showCalendar()
    {
        //var_dump($_SESSION['userData']);

        if (isset($this->dataGet["room"]))
        {
            $room = $this->dataGet["room"];
            $_SESSION['room'] = $room;
        } else
        {
            $rooms = $this->model->getRooms();
            $room = $rooms[0];
            $_SESSION['room'] = $room;
            $_SESSION['rooms'] = $rooms;
        }

        if (isset($this->dataGet["month"]))
        {
            $month = (int) $this->dataGet["month"];
        } else
        {
            $month = date("m");
        }
        if (isset($this->dataGet["year"]))
        {
            $year = $this->dataGet["year"];
            //var_dump($year);exit;
        } else
        {
            $year = date("Y");
        }
        $currentDate = date(mktime(0, 0, 0, $month, 1, $year));
        $prevMonth = date("m", mktime(0, 0, 0, $month - 1, 1, $year));
        $nextMonth = date("m", mktime(0, 0, 0, $month + 1, 1, $year));
        $prevYear = date("Y", mktime(0, 0, 0, $month - 1, 1, $year));
        $nextYear = date("Y", mktime(0, 0, 0, $month + 1, 1, $year));
        $year = date("Y", $currentDate);
        $month = date("m", $currentDate);
        //количество дней в месяце
        $countDayMonth = date("t", mktime(0, 0, 0, $month, 1, $year));
        $firstDayMonth = date("w", mktime(0, 0, 0, $month, 1, $year));
        $firstDayWeek = 1;
        $caledarData = array("countDayMonth" => $countDayMonth,
            "firstDayWeek" => $firstDayWeek, "firstDayMonth" => $firstDayMonth,);
        //подготоваливаю данные для вывода событий в календарь.
        $params['date_start'] = new DateTime(date("Y-m-d H:i:s", $currentDate));
        $params['date_end'] = new DateTime(date("Y-m-d H:i:s", $currentDate));
        $params['date_end']->add(new DateInterval('P' . $countDayMonth . 'D'));
        $params['date_start'] = $params['date_start']->format('Y-m-d H:i:s');
        $params['date_end'] = $params['date_end']->format('Y-m-d H:i:s');

        $res = $this->model->eventList($params);

        $dataArray = array();

        foreach ($res as $value)
        {
            $temp[] = array();
            $tmpStart = new DateTime($value['date_start']);
            $tmpEnd = new DateTime($value['date_end']);
            // $value['date_start'];
            $temp['id'] = $value['id'];
            $temp['date_start'] = $tmpStart->format('H:i');
            $temp['date_end'] = $tmpEnd->format('H:i');
            $dataArray[(int) $tmpStart->format('d')][] = $temp;
        }
        $eventDetails = $this->showEventDetails();

        $this->view->setVar('boardrooms', $_SESSION['rooms']);
        $this->view->setVar('currentMonth', date("F", $currentDate));
        $this->view->setVar('prevMonth', $prevMonth);
        $this->view->setVar('prevYear', $prevYear);
        $this->view->setVar('year', $year);
        $this->view->setVar('nextMonth', $nextMonth);
        $this->view->setVar('nextYear', $nextYear);
        $this->view->setVar('calendarData', $caledarData);
        $this->view->setVar('res', $dataArray);
        $this->view->setVar('eventDetails', $eventDetails);
        $this->view->addTemplate('calendar')->render();
    }

    public function validate()
    {
        $res = TRUE;

        if (!isset($this->dataPost['username']))
        {
            $res = FALSE;
        }
        if (!isset($this->dataPost['month']))
        {
            $res = FALSE;
        }
        if (!isset($this->dataPost['hourStat']))
        {
            $res = FALSE;
        }
        if (!isset($this->dataPost['minutStat']))
        {
            $res = FALSE;
        }
        if (!isset($this->dataPost['timePrefStart']))
        {
            $res = FALSE;
        }
        if (!isset($this->dataPost['hourEnd']))
        {
            $res = FALSE;
        }
        if (!isset($this->dataPost['minutEnd']))
        {
            $res = FALSE;
        }
        if (!isset($this->dataPost['timePrefEnd']))
        {
            $res = FALSE;
        }
        if (!isset($this->dataPost['meetingSpecText']))
        {
            $res = FALSE;
        }
        if (!isset($this->dataPost['recurringEvent']))
        {
            $res = FALSE;
        }
        if (!isset($this->dataPost['recurringSpecify']))
        {
            $res = FALSE;
        }
        if (!isset($this->dataPost['durationEvents']))
        {
            $res = FALSE;
        }
        return $res;
    }

    public function addEvent()
    {
        if ($this->validate())
        {

            $monthEvent = $this->dataPost['month'];
            $dayEvent = $this->dataPost['days'];
            $yearEvent = $this->dataPost['year'];
            $hourStat = $this->dataPost['hourStat'];
            $minutStat = $this->dataPost['minutStat'];
            $timePrefStart = $this->dataPost['timePrefStart'];
            $hourEnd = $this->dataPost['hourEnd'];
            $minutEnd = $this->dataPost['minutEnd'];
            $timePrefEnd = $this->dataPost['timePrefEnd'];

            $eventDateStart = new DateTime(date("Y-m-d H:i:s", mktime($hourStat, $minutStat, 0, $monthEvent, $dayEvent, $yearEvent)));
            $eventDateEnd = new DateTime(date("Y-m-d H:i:s", mktime($hourEnd, $minutEnd, 0, $monthEvent, $dayEvent, $yearEvent)));
            $recurringEvent = $this->dataPost['recurringEvent'];
            $recurringSpecify = $this->dataPost['recurringSpecify'];
            $durationEvents = $this->dataPost['durationEvents'];

            $data = $this->getRecurringArray($eventDateStart, $eventDateEnd, $recurringSpecify, $recurringEvent, $durationEvents);
            $dataCheck = $data;
            foreach ($dataCheck as $key => $value)
            {
                unset($dataCheck[$key]['userId']);
                unset($dataCheck[$key]['description']);
            }

            $canCreateEvent = TRUE;
            foreach ($dataCheck as $value)
            {
                $eventInBD = $this->model->checkEvent($value);
                if (!empty($eventInBD))
                {
                    $canCreateEvent = FALSE;
                }
            }
            if ($canCreateEvent)
            {
                $insertId = NULL;
                foreach ($data as $value)
                {
                    $value['insertId'] = $insertId;
                    if ($insertId == NULL)
                    {
                        $insertId = $this->model->createEvent($value);

                        $temp['id'] = $insertId;
                        //var_dump($temp,$value);
                        $this->model->updateRecurrentEvent($temp);
                    } else
                    {
                        $this->model->createEvent($value);
                    };
                }
                $host = $_SERVER['HTTP_HOST'];
                header("Location: http://$host");
                exit;
            } else
            {
                foreach ($eventInBD as $value)
                {
                    $error = "Room is booked from " . $value['date_start'] . " to " . $value['date_end'];
                    User::setFlash($error, 'errors');

                    $this->view->setMainTemplate('blank');
                    $user = new User;
                    $res = $user->userList(NULL);
                    $this->view->setVar('users', $res);

                    $this->view->addTemplate('newevent')->render();
                }
            }
        } else
        {
            $this->view->setMainTemplate('blank');
            $user = new User;
            $res = $user->userList(NULL);
            $this->view->setVar('users', $res);
            $this->view->addTemplate('newevent')->render();
        }
    }

    private function getRecurringArray($dateStart, $dateEnd, $recurringSpecify, $recurringEvent, $repeatCount)
    {

        $data[0]['dateStart'] = $dateStart->format('Y-m-d H:i:s');
        $data[0]['dateEnd'] = $dateEnd->format('Y-m-d H:i:s');
        $data[0]['userId'] = $this->dataPost['username'];
        $data[0]['roomId'] = $_SESSION['room']['id'];
        $data[0]['description'] = $this->dataPost['meetingSpecText'];
        if ($recurringEvent == "yes")
        {
            if ($recurringSpecify == 'weekly')
            {
                $countRecurringSpecify = 7;
            } elseif ($recurringSpecify == 'biWeekly')
            {
                $countRecurringSpecify = 14;
            } elseif ($recurringSpecify == 'month')
            {
                //Делаю,потому что не всегда будет попадать в этот - же месяц.
                $countRecurringSpecify = 24;
            }
            for ($i = 1; $i < $repeatCount; $i++)
            {
                $dateStart->add(new DateInterval('P' . $countRecurringSpecify . 'D'));
                $dateEnd->add(new DateInterval('P' . $countRecurringSpecify . 'D'));
                $data[$i]['userId'] = $this->dataPost['username'];
                $data[$i]['roomId'] = $_SESSION['room']['id'];
                $data[$i]['description'] = $this->dataPost['meetingSpecText'];
                $data[$i]['dateStart'] = $dateStart->format('Y-m-d H:i:s');
                $data[$i]['dateEnd'] = $dateEnd->format('Y-m-d H:i:s');
            }
        }
        return $data;
    }

}
