<?php

class EventController extends Controller
{
    public function __construct($get,$post)
    {
        $this->model = new Event;
        $this->view = new Viewer;
        parent::__construct($get, $post);
    }

    public function showCalendar()
    {
        var_dump($_SESSION['userData']);
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
    

}
