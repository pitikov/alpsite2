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
	    array('label'=>'Публикации', 'url'=>array("/{$this->id}/articles")),
	    array('label'=>'Пользователи', 'url'=>array("/{$this->id}/users")),
	    array('label'=>'О федерации', 'url'=>array("/{$this->id}/about")),
	    array('label'=>'Должности федерации', 'url'=>array("/{$this->id}/roles")),
	    array('label'=>'Члены федерации', 'url'=>array("/{$this->id}/federationmembers")),
	    array('label'=>'Классификатор', 'url'=>array("/{$this->id}/guide")),
    	    array('label'=>'Книга выходов', 'url'=>array("/{$this->id}/mountaring")),
	    array('label'=>'Документы', 'url'=>array("/{$this->id}/documents")),
	    array('label'=>'Рекламные банеры', 'url'=>array("/{$this->id}/baners")),
	    array('label'=>'Ссылки', 'url'=>array("/{$this->id}/links")),
	    array('label'=>'База данных', 'url'=>array("/{$this->id}/database"))
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
	    if($model->validate() && $model->save()) {
		$model=new Baners('add');
		$model->position = count(Baners::model()->findAll()) + 1;
		$model->on_show = true;
		Yii::app()->user->setFlash('flash-baner-add-success', 'Банер успешно добавлен');
	    } else {
		Yii::app()->user->setFlash('flash-baner-add-error', 'Ошибка добавления банера');
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
	$model=new Links('add');
	$linksProvider = new CActiveDataProvider('Links');
	$model->position = count($linksProvider->data)+1;
	
	if(isset($_POST['ajax']) && $_POST['ajax']==='links-links-form')
	{
	    echo CActiveForm::validate($model);
	    Yii::app()->end();
	}
	
	if(isset($_POST['Links']))
	{
	    $model->attributes=$_POST['Links'];
	    if($model->validate() && $model->save()) {
		Yii::app()->user->setFlash('flash-link-add-success', 'Графическая ссылка успешно добавленна.');
		$model = new Links('add');
		$model->position = count($linksProvider->data)+1;
	    } else {
		Yii::app()->user->setFlash('flash-link-add-error', 'Ошибка добавления графической ссылки.');
	    }	    
	}
	$this->render('links',array('model'=>$model, 'dataProvider'=>$linksProvider));
    } 
    
    public function actionAbout()
    {
	$model = Article::model()->find('art_location = :About', array(':About'=>'about'));
	if ($model === null) {
	    $model=new Article;
	    $model->author = Yii::app()->user->getId();
	    $model->title = 'About federation';
	    $model->art_location = 'about';
	}
	
	if(isset($_POST['ajax']) && $_POST['ajax']==='article-about-form')
	{
	    echo CActiveForm::validate($model);
	    Yii::app()->end();
	}
	
	if(isset($_POST['Article']))
	{
	    $model->attributes=$_POST['Article'];
	    if($model->validate())
	    {
		if ($model->save()) Yii::app()->user->setFlash('flash-about-save', 'Данные успешно сохраненны.');
	    }
	}
	$this->render('about',array('model'=>$model));
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