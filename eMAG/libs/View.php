<?php


class View
{

    /**
     * View constructor.
     */
    public function __construct()
    {
    }

    public function render($name,$onlyContent=false) {
        if (!$onlyContent) {
            require 'views/head.php';
        }
        require 'views/' . $name . '.php';
        if (!$onlyContent) {
            require 'views/footer.php';
        }
        $this->$name = '';
    }
}
