<?php
/**
 * Класс для объявления и инициализации одинаковых свойств.
 */
class Controller
{
    protected $model;
    protected $view;
    protected $dataGet;
    protected $dataPost;

    public function __construct($get,$post)
    {
        $this->dataGet = $get;
        $this->dataPost = $post;
    }
}
