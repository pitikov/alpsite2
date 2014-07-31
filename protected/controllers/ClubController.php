<?php

class ClubController extends Controller
{
    
    public function init()
    {
	$this->layout = '//layouts/column2';
	$this->defaultAction = "calendar";
	$this->breadcrumbs = array("Альпклуб \"Пенза\""=>array("/club"));
        parent::init();
    }
    
    public function actionAction()
    {
	$this->render('action');
    }
    
    public function actionAddaction()
    {
	$this->render('addaction');
    }

    public function actionCalendar()
    {
	$this->render('calendar');
    }
    
    public function actionDeleteaction()
    {
	$this->render('deleteaction');
    }
    
    public function actionEditaction()
    {
	$this->render('editaction');
    }
    
    
    public function filters()
    {
	{
	    return array(
		'accessControl'
	    );
	}	
    }
    
    
    public function accessRules()
    {
        return array(
	    array(
		'allow',
		'actions'=>array('deleteaction'),
		'roles'=>array('admin'),
	    ),
	    array(
		'allow',
		'actions'=>array('addaction', 'editaction'),
		'roles'=>array('user'),
	    ),
	    array(
		'allow',
		'actions'=>array('action', 'calendar'),
		'roles'=>array('guest'),
	    ),
	    array(
		'deny',
		'actions'=>array('addaction', 'editaction', 'deleteaction'),
		'roles'=>array('guest'),
	    ),
        );
    }
}