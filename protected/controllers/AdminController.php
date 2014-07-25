<?php

class AdminController extends Controller
{
    
    public function init()
    {
	$this->breadcrumbs = array('Администрирование сайта'=>array('/admin'));
	$this->defaultAction = "news";
        parent::init();
    }
    
	public function actionArticles()
	{
		$this->render('articles');
	}

	public function actionBaners()
	{
		$this->render('baners');
	}

	public function actionDatabase()
	{
		$this->render('database');
	}

	public function actionLinks()
	{
		$this->render('links');
	}

	public function actionNews()
	{
		$this->render('news');
	}

	public function actionUsers()
	{
		$this->render('users');
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