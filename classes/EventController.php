<?php

class EventController {

    private $model;
    private $view;

    public function __construct() {
        $this->model = new Event;
        $this->view = new Viewer;
    }
    public function getCalendar($vars=  array()){
        $countDayMonth = date("t");
        $firstDayMonth = date("w", mktime(0,0,0,date("m"),1,date("Y"))); 
        $firstDayWeek = 1;
       //var_dump($firstDayMonth);
     //  echo date("w");
       $res = array("countDayMonth"=>$countDayMonth,
           "firstDayWeek"=>$firstDayWeek, "firstDayMonth"=>$firstDayMonth);
       
       return $res;
    }

    public function eventList() {
        $data = array();
        $res = $this->model->eventList($data);
        $this->view->setVar('boardrooms',  array("Room1","Room2","Room3"));
        $this->view->setVar('monthCurrent',  "july");
        $this->view->setVar('calendarData', $this->getCalendar());
        $this->view->addTemplate('calendar')->render();
    }

}

