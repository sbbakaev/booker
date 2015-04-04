<?php

class EventController extends Controller
{

    public function __construct($get, $post)
    {
        $this->model = new Event;
        $this->view = new Viewer;
        parent::__construct($get, $post);
    }

    public function showCalendar()
    {
        //var_dump($_SESSION['userData']);
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
        $countDayMonth = date("t", mktime(0, 0, 0, $month, 1, $year));
        $firstDayMonth = date("w", mktime(0, 0, 0, $month, 1, $year));
        $firstDayWeek = 1;
        $caledarData = array("countDayMonth" => $countDayMonth,
            "firstDayWeek" => $firstDayWeek, "firstDayMonth" => $firstDayMonth,);
        $res = $this->model->eventList($this->data);
        $this->view->setVar('boardrooms', array("Room1", "Room2", "Room3"));
        $this->view->setVar('currentMonth', date("F", $currentDate));
        $this->view->setVar('prevMonth', $prevMonth);
        $this->view->setVar('prevYear', $prevYear);
        $this->view->setVar('year', $year);
        $this->view->setVar('nextMonth', $nextMonth);
        $this->view->setVar('nextYear', $nextYear);
        $this->view->setVar('calendarData', $caledarData);
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

            $eventDateStart = mktime($hourStat, $minutStat, 0, $monthEvent, $dayEvent, $yearEvent);
           // var_dump($eventDateStart);exit;
            $eventDateEnd = mktime($hourEnd, $minutEnd, 0, $monthEvent, $dayEvent, $yearEvent);
            $recurringEvent = $this->dataPost['recurringEvent'];
            $recurringSpecify = $this->dataPost['recurringSpecify'];
            $durationEvents = $this->dataPost['durationEvents'];


            $data = $this->getRecurringArray($eventDateStart, $eventDateEnd, $recurringSpecify, $recurringEvent,$durationEvents);
            $dataCheck['dateStart'] = $eventDateStart;
            $dataCheck['dateEnd'] = $eventDateEnd;
            $dataCheck['roomId'] = '1';
 
            
            $eventInBD = $this->model->checkEvent($dataCheck);
            if (empty($eventInBD))
            {
                foreach ($data as $value)
                {
                    $this->model->createEvent($value);
                }
                //  $this->model->createEvent($data);
            } else
            {
                foreach ($eventInBD as $value)
                {
                    $error = "Room is booked from " . $value['date_start'] . " to " . $value['date_end'];
                    User::setFlash($error, 'errors');
                    echo $error;
                }
                $errors = User::getFlash('errors');
            }
        } else
        {
            $this->view->setMainTemplate('blank');
            $tr = new User;
            $res = $tr->userList(NULL);

            $this->view->setVar('users', $res);
            $this->view->addTemplate('newevent')->render();
        }
    }

    private function getRecurringArray($dateStart, $dateEnd, $recurringSpecify,$recurringEvent, $repeatCount)
    {

        $data[0]['dateStart'] = $dateStart;
        $data[0]['dateEnd'] = $dateEnd;
                $data[0]['userId'] = $this->dataPost['username'];
                $data[0]['roomId'] = "1";
                $data[0]['description'] = $this->dataPost['meetingSpecText'];
        if ($recurringEvent=="yes")
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
                $data[$i]['userId'] = $this->dataPost['username'];
                $data[$i]['roomId'] = "1";
                $data[$i]['description'] = $this->dataPost['meetingSpecText'];
                $data[$i]['dateStart'] = $dateStart;
                $data[$i]['dateEnd'] = $dateEnd;

                $dateStart = strtotime("+$countRecurringSpecify day");
                $dateEnd = strtotime("+$countRecurringSpecify day");
            }
        }
        return $data;
    }

}
