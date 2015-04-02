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
        if (isset($this->data["month"]))
        {
            $month = (int) $this->data["month"];
        } else
        {
            $month = date("m");
        }
        if (isset($this->data["year"]))
        {
            $year = $this->data["year"];
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
            $this->dataPost['username'];
            $res = FALSE;
        }
        if (!isset($this->dataPost['month']))
        {
            $this->dataPost['month'];
            $res = FALSE;
        }
        if (!isset($this->dataPost['hourStat']))
        {
            $this->dataPost['hourStat'];
            $res = FALSE;
        }
        if (!isset($this->dataPost['minutStat']))
        {
            $this->dataPost['minutStat'];
            $res = FALSE;
        }
        if (!isset($this->dataPost['timePrefStart']))
        {
            $this->dataPost['timePrefStart'];
            $res = FALSE;
        }
        if (!isset($this->dataPost['hourEnd']))
        {
            $this->dataPost['hourEnd'];
            $res = FALSE;
        }
        if (!isset($this->dataPost['minutEnd']))
        {
            $this->dataPost['minutEnd'];
            $res = FALSE;
        }
        if (!isset($this->dataPost['timePrefEnd']))
        {
            $this->dataPost['timePrefEnd'];
            $res = FALSE;
        }
        if (!isset($this->dataPost['meetingSpecText']))
        {
            $this->dataPost['meetingSpecText'];
            $res = FALSE;
        }
        if (!isset($this->dataPost['recurringEvent']))
        {
            $this->dataPost['recurringEvent'];
            $res = FALSE;
        }
        if (!isset($this->dataPost['recurringSpecify']))
        {
            $this->dataPost['recurringSpecify'];
            $res = FALSE;
        }
        if (!isset($this->dataPost['durationEvents']))
        {
            $this->dataPost['durationEvents'];
            $res = FALSE;
        }
        return $res;
    }

    public function addEvent()
    {
        if ($this->showCalendar())
        {
            $this->model = new Event;
            $this->view = new Viewer;

            $res = $this->model->addEvent($this->data);
        }
    }

}
