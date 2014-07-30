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

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}