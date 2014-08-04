<?php

class AdminController extends Controller
{
    
    public function init()
    {
	if (!$this->isUser()) $this->redirect('/');
	$this->breadcrumbs = array('Администрирование сайта'=>array('/admin'));
	$this->defaultAction = "articles";
	$this->layout="//layouts/column2";
	$this->menuName="Администрирование";
	$this->menu=array(
	    array('label'=>'Публикации', 'url'=>array('/admin/articles')),
	    array('label'=>'Пользователи', 'url'=>array('/admin/users')),
	    array('label'=>'О федерации', 'url'=>array('/admin/about')),
	    array('label'=>'Должности федерации', 'url'=>array('/admin/roles')),
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
	$model=new Baners('add');
	
	$banersProvider = new CActiveDataProvider('Baners');
	$model->position = count(Baners::model()->findAll()) + 1;
	$model->on_show = true;
	
	if(isset($_POST['ajax']) && $_POST['ajax']==='baners-baners-form')
	{
	    echo CActiveForm::validate($model);
	    Yii::app()->end();
	}
	
	if(isset($_POST['Baners']))
	{
	    $model->attributes=$_POST['Baners'];
	    if($model->validate())
	    {
		if ($model->save()) {
		  $model=new Baners('add');
		  $model->position = count(Baners::model()->findAll()) + 1;
		  $model->on_show = true;
		  Yii::app()->user->setFlash('flash-baner-add-success', 'Банер успешно добавлен');
		} else {
		    Yii::app()->user->setFlash('flash-baner-add-error', 'Ошибка добавления банера');
		}
	    }
	}
	$this->render('baners',array('model'=>$model, 'dataProvider'=>$banersProvider));
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
    
    public function actionRoles()
    {
	$this->render('roles');
    }
    
    public function filters()
    {
        return array(
            'accessControl'
        );
    }
    
    public function accessRules()
    {
        return array(
	    array(
		'allow',
		'actions'=>array(
		    'articles',
		    'baners',
		    'database',
		    'links',
		    'about',
		    'users',
		    'roles',
		    'federationmembers',
		    'documents',
		    'mountaring',
		    'guide',
		 ),
		'roles'=>array('admin'),
	    ),
            array(
		'deny',
		'actions'=>array(
		    'articles',
		    'baners',
		    'database',
		    'links',
		    'about',
		    'users',
		    'roles',
		    'federationmembers',
		    'documents',
		    'mountaring',
		    'guide',
		 ),
		'users'=>array('*'),
	    ),
        );
    }
}