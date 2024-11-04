<?php

require_once 'Controller.php';

class AboutController extends Controller
{
    public function index()
    {
        $this->render('about');
    }
}
