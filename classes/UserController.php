<?php

class UserController {

    private $model;
    private $view;

    public function __construct() {
        $this->model = new User;
        $this->view = new Viewer;
    }

    public function userList() {
        $data = array();
        $res = $this->model->userList($data);
         $this->view->addTemplate('asd')->render();

        //include 'templates/main.template.php';
    }

}
