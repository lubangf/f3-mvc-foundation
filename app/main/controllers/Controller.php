<?php

namespace main\controllers;
use \BaseController;
use \Template;

class Controller extends BaseController {
	function index($app){
        $app->set('page_title','Home');
        $app->set('inc','index.html');
    }

	function page1($app){}

	function page2($app){}
}