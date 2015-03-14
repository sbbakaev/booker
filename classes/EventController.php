<?php

class EventController {

    private $model;
    private $view;

    public function __construct() {
        $this->model = new Event;
        $this->view = new Viewer;
    }
    public function getCalendar($vars=  array()){
      // $currertDate = date("m.d.y");
       $firstDayweek = date("w");
       $countDayMonth = date("t");
       $firstDayMonth = date("Y-m-01, w");
       var_dump($firstDayMonth);
       echo date("w");
       $res = array("firstDayweek"=>$firstDayweek,
           "countDayMonth"=>$countDayMonth,"firstDayMonth"=>$firstDayMonth);
       
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

