<?php

namespace Controller;


use Framework\BaseController;

class ErrorController extends BaseController
{
    private $exception;

    public function __construct(\Exception $e)
    {
        $this->exception = $e;
    }

    public function errorAction()
    {
        return $this->render('error.html.twig',[
            'message' => $this->exception->getMessage()
        ]);

    }

    public function error404Action()
    {
        return $this->render('error404.html.twig',[
            'message' => $this->exception->getMessage()
        ]);
    }

}