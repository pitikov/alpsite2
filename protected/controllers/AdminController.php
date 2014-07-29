<?php

class AdminController extends Controller
{
    
    public function init()
    {
	$this->breadcrumbs = array('Администрирование сайта'=>array('/admin'));
	$this->defaultAction = "articles";
	$this->layout="//layouts/column2";
	$this->menuName="Администрирование";
	$this->menu=array(
	    array('label'=>'Публикации', 'url'=>array('/admin/articles')),
	    array('label'=>'Пользователи', 'url'=>array('/admin/users')),
	    array('label'=>'О федерации', 'url'=>array('/admin/about')),
	    array('label'=>'Члены федерации', 'url'=>array('/admin/federationmembers')),
	    array('label'=>'Классификатор', 'url'=>array('/admin/guide')),
    	    array('label'=>'Книга выходов', 'url'=>array('/admin/mountaring')),
	    array('label'=>'Документы', 'url'=>array('/admin/documents')),
	    array('label'=>'Рекламные банеры', 'url'=>array('/admin/baners')),
	    array('label'=>'Ссылки', 'url'=>array('/admin/links')),
	);
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
    
    public function actionAbout()
    {
	$this->render('about');
    }
    
    public function actionUsers()
    {
	$this->render('users');
    }
    
    public function actionFederationmembers()
    {
	$this->render('federationmembers');
    }
    
    public function actionDocuments()
    {
	$this->render('documents');
    }
    
    public function actionMountaring()
    {
	$this->render('mountaring');
    }

    public function actionGuide()
    {
	$this->render('guide');
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