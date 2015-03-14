<?php

class Viewer {

    private $vars = array();
    private $templates = array();
    private $mainTemplate = 'main.template';

    public function __construct($template = 'main.template') {
        $file = './templates/' . $template . '.php';
        if (file_exists($file)) {
            $this->mainTemplate = $file;
        } else {
            exit('server fail');
        }
    }

    public function addTemplate($template) {
        $file = './templates/' . $template . '.template.php';
        if (file_exists($file)) {
            $this->templates[] = $file;
        } else {
            exit('template fail');
        }
        return $this;
    }

    public function setVar($key, $val) {
        $this->vars[$key] = $val;
    }

    public function render() {
        $templates = $this->templates;
        $vars = $this->vars;
        include $this->mainTemplate;
    }

}
