<?php

class Controller
{
    protected $model;
    protected $view;
    protected $getData;
    protected $postData;

    public function __construct($get,$post)
    {
        $this->getData = $get;
        $this->postData = $post;
    }
}
