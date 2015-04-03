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
        //   var_dump($res);
        return $res;
    }

    public function addEvent()
    {
        if ($this->validate())
        {

            //  var_dump($this->dataPost);
            $data['userId'] = $this->dataPost['username'];
            $monthEvent = $this->dataPost['month'];
            $dayEvent = $this->dataPost['days'];
            $yearEvent = $this->dataPost['year'];
            $hourStat = $this->dataPost['hourStat'];
            $minutStat = $this->dataPost['minutStat'];

            $timePrefStart = $this->dataPost['timePrefStart'];
            $hourEnd = $this->dataPost['hourEnd'];
            $minutEnd = $this->dataPost['minutEnd'];
            $timePrefEnd = $this->dataPost['timePrefEnd'];

            $eventDateStart = date(mktime($hourStat, $minutStat, 0, $monthEvent, $dayEvent, $yearEvent));
            $eventDateEnd = date(mktime($hourEnd, $minutEnd, 0, $monthEvent, $dayEvent, $yearEvent));
            $data['roomId'] = "1";
            $data['description'] = $this->dataPost['meetingSpecText'];
            //$recurringEvent = $this->dataPost['recurringEvent'];
            $recurringSpecify = $this->dataPost['recurringSpecify'];
            $durationEvents = $this->dataPost['durationEvents'];
            $data['dateStart'] = $eventDateStart;
            $data['dateEnd'] = $eventDateEnd;
            if ($this->model->checkEvent($data) == "0")
            {

                $this->model->createEvent($data);
                exit('add');
                return TRUE;
                
            } else
            {
                exit('not');
                return FALSE;
            }
        } else
        {
            $this->view->setMainTemplate('blank');
            $tr = new User;
            $res = $tr->userList(NULL);
//        var_dump($res);
            $this->view->setVar('users', $res);
            $this->view->addTemplate('newevent')->render();
        }
    }

}
