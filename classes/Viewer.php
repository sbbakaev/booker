<?php

/**
 * Класс для работы с отображением.
 */
class Viewer
{

    private $vars = array();
    private $templates = array();
    private $mainTemplate = 'main.template';
    private $flash = array();

    public function __construct($template = 'main.template')
    {
        $file = './templates/' . $template . '.php';
        if (file_exists($file))
        {
            $this->mainTemplate = $file;
        } else
        {
            exit('server fail');
        }
    }

    /**
     * Добавляет и проверяет наличие файла темплейта.
     * @param string $template имя файла темплейта.
     * @return \Viewer
     */
    public function addTemplate($template)
    {
        $file = './templates/' . $template . '.template.php';
        // var_dump($file);exit;
        if (file_exists($file))
        {
            $this->templates[] = $file;
        } else
        {
            exit('template fail');
        }
        return $this;
    }

    /**
     * Устанавливает главный темплейт, который будет отображаться в любом случае.
     * @param string $template имя файла темплейта.
     */
    public function setMainTemplate($template)
    {
        $file = './templates/' . $template . '.template.php';
        if (file_exists($file))
        {
            $this->mainTemplate = $file;
        } else
        {
            exit('server fail');
        }
    }

    /**
     * Передает данные в отображение.
     * @param string $key
     * @param type $val
     */
    public function setVar($key, $val)
    {
        $this->vars[$key] = $val;
    }

    /**
     * Переопределяет  данные и инклюдитфайл с главным темплейтом.
     */
    public function render()
    {
        $templates = $this->templates;
        $vars = $this->vars;
        $flash = User::getFlash('errors');
        include $this->mainTemplate;
    }

}
