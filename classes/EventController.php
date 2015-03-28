<?php

class EventController {

    private $model;
    private $view;
    private $data;

    public function __construct($data) {
        $this->model = new Event;
        $this->view = new Viewer;
        $this->data = $data;
    }
   
    public function showCalendar() {
        if(isset($this->data["month"]))
        {
            $month = (int)$this->data["month"];
        }
        else {
            $month = date("m");    
        }   
        if(isset($this->data["year"]))
        {
            $year = $this->data["year"];
        }
        else {
            $year = date("Y");    
        }           
 
        $prevMonth = $month-1;
        $prevYear = $year-1;
        $nextMonth = $month+1;
        $nextYear = $year+1;
        var_dump($year);
        
        $countDayMonth = date("t",mktime(0,0,0,$month,1,$year));
        $firstDayMonth = date("w", mktime(0,0,0,$month,1,$year)); 
        $firstDayWeek = 1;
        $caledarData = array("countDayMonth"=>$countDayMonth,
           "firstDayWeek"=>$firstDayWeek, "firstDayMonth"=>$firstDayMonth,
            );
        //    var_dump($nextYear);
        $res = $this->model->eventList($this->data);
        $this->view->setVar('boardrooms',  array("Room1","Room2","Room3"));
        $this->view->setVar('currentMonth', $month);
        $this->view->setVar('prevMonth', $prevMonth);
        $this->view->setVar('prevYear', $prevYear);
        $this->view->setVar('nextMonth', $nextMonth);
        $this->view->setVar('nextYear', $nextYear);
        $this->view->setVar('calendarData', $caledarData);
        $this->view->addTemplate('calendar')->render();
    }

}

