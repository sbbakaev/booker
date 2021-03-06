<?php

/**
 * Контролер для работы с событиями.
 * @author Сергей Бакаев <sbbakaev@mail.ru>
 */
class EventController extends Controller
{

    public function __construct($get, $post)
    {
        $this->model = new Event;
        $this->view = new Viewer;
        parent::__construct($get, $post);
    }

    /**
     * Формирует json объект с детальными данными о событии.
     * @return object json.
     */
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
     * то удаляет их все.
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
        if ($res != null)
        {
            $respone = array();
            $respone['success'] = TRUE;
            $respone['message'] = 'Event has been deleted';
            echo json_encode($respone);
            exit;
        } else
        {

            $respone = array();
            $respone['success'] = FALSE;
            $respone['message'] = 'Event dosn`t deleted';
            echo json_encode($respone);
            exit;
        }
    }

    /**
     * Обновляет событие и формирует json object с ответом. 
     * @return json object событий с детальными данными о них.
     */
    public function updateEvent()
    {
        if ($this->dataPost['deleteAllEvent'] == "true")
        {

            $res = $this->model->eventList(array('recurrent_id' => $this->dataPost['recurrentId']));


            list($hourStart, $minutStart) = explode(":", $this->dataPost['dateStart']);
            list($hourEnd, $minutEnd) = explode(":", $this->dataPost['dateEnd']);

            $ind = 0;
            foreach ($res as $value)
            {
                $date = explode(" ", $value['date_start']);
                $eventDateStart = new DateTime($date[0] . $hourStart . $minutStart);
                $eventDateEnd = new DateTime($date[0] . $hourEnd . $minutEnd);
                $data[$ind]['dateStart'] = $eventDateStart->format('Y-m-d H:i:s');
                $data[$ind]['dateEnd'] = $eventDateEnd->format('Y-m-d H:i:s');
                $data[$ind]['roomId'] = $_SESSION['room']['id'];
                $data[$ind]['roomId'] = $_SESSION['room']['id'];
                $data[$ind]['id'] = $value['id'];
                $data[$ind]['description'] = $value['description'];
                $ind++;
            }

            $canUpdateEvent = TRUE;
            //Проверяю свободное время
            foreach ($data as $value)
            {
                $tmp = $this->model->checkEvent($value);
                if (!empty($tmp))
                {
                    $eventInBD[] = $tmp;
                    $canUpdateEvent = FALSE;
                }
            }
            if ($canUpdateEvent)
            {
                foreach ($data as $value)
                {

                    $this->model->updateEvent($value, $this->dataPost['deleteAllEvent']);
                }
                $tmpStart = new DateTime($data[0]['dateStart']);
                $tmpEnd = new DateTime($data[0]['dateEnd']);

                $respone = array();
                $respone['success'] = TRUE;
                $respone['time'] = $this->getStringTime($tmpStart) . "-" . $this->getStringTime($tmpEnd);
                $respone['message'] = 'Event has been updated';
                echo json_encode($respone);
                exit;
            } else
            {
                $respone = array();
                $respone['success'] = FALSE;
                $message = " Room is booked: ";
                foreach ($eventInBD as $tmpArr)
                {
                    
                    
                    foreach ($tmpArr as $value)
                    {
                        $message = $message." from ".$value['date_start'] . " to " . $value['date_end'];
                    }
                }
                $respone['message'] = $message;
                echo json_encode($respone);
            }
        } else
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

            $canUpdateEvent = TRUE;
            //Проверяю свободное время
            foreach ($dataCheck as $value)
            {
                $tmp = $this->model->checkEvent($value);

                if (!empty($tmp))
                {
                    $eventInBD[] = $tmp;
                    $canUpdateEvent = FALSE;
                }
            }
            if ($canUpdateEvent)
            {
                foreach ($data as $value)
                {
                    $this->model->updateEvent($value, $this->dataPost['deleteAllEvent']);
                }

                $tmpStart = new DateTime($data[0]['dateStart']);
                $tmpEnd = new DateTime($data[0]['dateEnd']);

                $respone = array();
                $respone['success'] = TRUE;
                $respone['time'] = $this->getStringTime($tmpStart) . "-" . $this->getStringTime($tmpEnd);
                $respone['message'] = 'Event has been updated';
                echo json_encode($respone);
                exit;
            } else
            {
                $respone = array();
                $respone['success'] = FALSE;
                //$respone['time'] = $this->getStringTime($tmpStart) . "-" . $this->getStringTime($tmpEnd);
                foreach ($eventInBD as $tmpArr)
                {   foreach ($tmpArr as $value)
                    {
                        $respone['message'] = "Room is booked from " . $value['date_start'] . " to " . $value['date_end'];
                    }
                }
                echo json_encode($respone);
            }
        }
    }

    public function getStringTime($date)
    {
        if ($_SESSION['userData'][0]['timeFormat24'])
        {
            $date = $date->format('H:i');
        } else
        {
            $date = $date->format('g:i a');
        }
        return $date;
    }

    /**
     * Формирует список событий и выполняет запуск отображение календаря. 
     */
    public function showCalendar()
    {
        if (isset($this->dataGet["room"]))
        {
            $room = $this->dataGet["room"];
            $_SESSION['room'] = $room['id'];
        } elseif (!isset($_SESSION['room']))
        {
            $rooms = $this->model->getRooms();
            $room = $rooms[0];
            $_SESSION['room'] = $room['id'];
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
        $firstDayWeek = $_SESSION['userData'][0]['firstDayWeek'];
        $caledarData = array("countDayMonth" => $countDayMonth,
            "firstDayWeek" => $firstDayWeek, "firstDayMonth" => $firstDayMonth,);
        //подготоваливаю данные для вывода событий в календарь.
        $params['date_start'] = new DateTime(date("Y-m-d H:i:s", $currentDate));
        $params['date_end'] = new DateTime(date("Y-m-d H:i:s", $currentDate));
        $params['date_end']->add(new DateInterval('P' . $countDayMonth . 'D'));
        $params['date_start'] = $params['date_start']->format('Y-m-d H:i:s');
        $params['date_end'] = $params['date_end']->format('Y-m-d H:i:s');
        $params['room_id'] = $_SESSION['room']['id'];

        $res = $this->model->eventList($params);
        $dataArray = array();
        foreach ($res as $value)
        {
            $temp[] = array();
            $tmpStart = new DateTime($value['date_start']);
            $tmpEnd = new DateTime($value['date_end']);
            $temp['id'] = $value['id'];
            if ($_SESSION['userData'][0]['timeFormat24'])
            {
                $temp['recurrent_id'] = $value['recurrent_id'];
                $temp['date_start'] = $tmpStart->format('H:i');
                $temp['date_end'] = $tmpEnd->format('H:i');
            } else
            {
                $temp['recurrent_id'] = $value['recurrent_id'];
                $temp['date_start'] = $tmpStart->format('g:i a');
                $temp['date_end'] = $tmpEnd->format('g:i a');
            }
            $dataArray[(int) $tmpStart->format('d')][] = $temp;
        }

        $this->view->setVar('currentRoom', $_SESSION['room']);
        $this->view->setVar('boardrooms', $_SESSION['rooms']);
        $this->view->setVar('currentMonth', date("F", $currentDate));
        $this->view->setVar('prevMonth', $prevMonth);
        $this->view->setVar('prevYear', $prevYear);
        $this->view->setVar('year', $year);
        $this->view->setVar('nextMonth', $nextMonth);
        $this->view->setVar('nextYear', $nextYear);
        $this->view->setVar('calendarData', $caledarData);
        $this->view->setVar('res', $dataArray);
        //$this->view->setVar('eventDetails', $eventDetails);
        $this->view->addTemplate('calendar')->render();
    }

    /**
     * Проверяет, что все необходимые данные есть.
     * @return boolean true если все необходиммые данные есть.
     */
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

    private function validateEvent($dateStart, $dateEnd)
    {
        $currentDay = new DateTime();
        $message = "";
        if ($currentDay > $dateStart || $currentDay > $dateEnd)
        {
            $message = "Current day mast be lower date start and date end event.";
        }
        if ((int) $this->dataPost['durationEvents'] < 1 && (int) $this->dataPost['durationEvents'] > 4)
        {
            $message = $message . "</br> Duration value of events must be from 1 to 4t.";
        }
        if ($this->dataPost['username'] === "")
        {
            $message = $message . "</br> You need entry username.";
        }
        if ($message === "")
        {
            
        } else
        {
            $error = $message;
            User::setFlash($error, 'errors');
            $this->view->setMainTemplate('blank');
            $user = new User;
            $res = $user->userList(NULL);
            $this->view->setVar('users', $res);

            $this->view->addTemplate('newevent')->render();
            exit;
        }
    }

    /**
     * Создает новое событие, а так же выполняет все необходимые проверки. 
     * Например: Свободна комната или нет.
     * */
    public function addEvent()
    {
        if ($this->validate())
        {
            $canCreateEvent = TRUE;
            $monthEvent = $this->dataPost['month'];
            $dayEvent = $this->dataPost['days'];
            $yearEvent = $this->dataPost['year'];
            $hourStat = $this->dataPost['hourStat'];
            $minutStat = $this->dataPost['minutStat'];
            $timePrefStart = $this->dataPost['timePrefStart'];
            $hourEnd = $this->dataPost['hourEnd'];
            $minutEnd = $this->dataPost['minutEnd'];
            $timePrefEnd = $this->dataPost['timePrefEnd'];
            if ($timePrefStart == 'AM')
            {
                $eventDateStart = new DateTime(date("Y-m-d H:i:s", mktime($hourStat, $minutStat, 0, $monthEvent, $dayEvent, $yearEvent)));
            } else
            {
                $eventDateStart = new DateTime(date("Y-m-d H:i:s", mktime($hourStat + 12, $minutStat, 0, $monthEvent, $dayEvent, $yearEvent)));
            }
            if ($timePrefEnd == 'AM')
            {
                $eventDateEnd = new DateTime(date("Y-m-d H:i:s", mktime($hourEnd, $minutEnd, 0, $monthEvent, $dayEvent, $yearEvent)));
            } else
            {
                $eventDateEnd = new DateTime(date("Y-m-d H:i:s", mktime($hourEnd + 12, $minutEnd, 0, $monthEvent, $dayEvent, $yearEvent)));
            }
            $this->validateEvent($eventDateStart, $eventDateEnd);
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

            // $eventInBD;
            foreach ($dataCheck as $value)
            {
                $tmp = $this->model->checkEvent($value);

                if (!empty($tmp))
                {
                    $eventInBD[] = $tmp;
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
                        $this->model->updateRecurrentEvent($temp);
                    } else
                    {
                        $this->model->createEvent($value);
                    }
                }
                $error = 'Event is added';
                User::setFlash($error, 'errors');
                $host = $_SERVER['HTTP_HOST'];
                header("Location: http://$host");
                exit;
            } else
            {

                foreach ($eventInBD as $tempArr)
                {
                    foreach ($tempArr as $value)
                    {
                        $error = "Room is booked from " . $value['date_start'] . " to " . $value['date_end'];
                        User::setFlash($error, 'errors');
                        $this->view->setMainTemplate('blank');
                        $user = new User;
                        $res = $user->userList(NULL);
                        $this->view->setVar('users', $res);
                    }
                }

                $this->view->addTemplate('newevent')->render();
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

    /**
     * Формирует array повторений событий для дальнейшего создания или проверки 
     * занятости комнаты.
     * $params date $dateStart дата-время начала события, 
     * $params date $dateEnd дата-время конца события
     * $params int $recurringSpecify переодичность повторений 7,14,28 дней 
     * $params int $recurringEvent будет повторятся совещание или нет 
     * $params int $repeatCount  количество повторений события.
     * @return array событий.
     */
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
