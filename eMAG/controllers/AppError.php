<?php


class AppError extends Controller
{

    /**
     * Error constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    function index() {
        $this->view->msg = 'This page doesn\'t exist!';
        $this->view->render('error/index');
    }


}
