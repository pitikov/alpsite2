<?php

class FederationController extends Controller
{
  
  public function init()
  {
      $this->layout='//layouts/column2';
      $this->menuName="ФАПО";
      $this->menu = array(
	array('label'=>'Новости', 'url'=>array($this->id.'/index')),
	array('label'=>'Календарь альпмероприятий', 'url'=>array($this->id.'/calendar')),
	array('label'=>'Члены федерации', 'url'=>array($this->id.'/members')),
	array('label'=>'О федерации', 'url'=>array($this->id.'/about')),
	array('label'=>'Докуметы', 'url'=>array($this->id.'/documents')),
	array('label'=>'Классификатор', 'url'=>array($this->id.'/guidebook')),
	array('label'=>'Книга выходов', 'url'=>array($this->id.'/mountaring')),
      );
      $this->defaultAction = "index";
      $this->breadcrumbs = array("Федерация Альпинизма Пензенской Области"=>array("/federation/index"));
      parent::init();
  }
  
  public function actionIndex()
  {
      $this->render('index');
  }
  
  public function actionAbout()
  {
      $aboutArticle = Article::model()->find('art_location=:Theme', array(':Theme'=>'about'));
      $body=$aboutArticle===null?"<div id='about-blank'>Контент данной странице не задан. Обратитесь к администратору сайта для устраненния этой проблеммы.</div>":$aboutArticle->body;
      $this->render('about', array('body'=>$body));
  }
  
  public function actionGuidebook()
  {
      $this->render('guidebook');
  }
  
  public function actionAddregion()
  {
      $this->render('guidebook');
  }
  
  public function actionDeleteregion()
  {
      $this->render('guidebook');
  }
  
  public function actionAddmount()
  {
      $this->render('guidebook');
  }
  
  public function actionDeletemount()
  {
      $this->render('guidebook');
  }
  
  public function actionAddroute()
  {
      $this->render('guidebook');
  }
  
  public function actionDeleteroute()
  {
      $this->render('guidebook');
  }
  
  public function actionEditroute()
  {
      $this->render('editroute');
  }
  
  public function actionMountaring()
  {
      $this->render('mountaring');
  }
  
  
  public function actionError()
  {
    if($error=Yii::app()->errorHandler->error)
    {
      if(Yii::app()->request->isAjaxRequest)
	echo $error['message'];
	else
	$this->render('error', $error);
    }
  }
  
  public function actionAction()
  {
      $this->render('action');
  }

  public function actionAddaction()
  {
    $model=new FederationCalendar('create');

    // uncomment the following code to enable ajax-based validation
    
    if(isset($_POST['ajax']) && $_POST['ajax']==='federation-calendar-addaction-form')
    {
	echo CActiveForm::validate($model);
	Yii::app()->end();
    }
    

    if(isset($_POST['FederationCalendar']))
    {
	$model->attributes=$_POST['FederationCalendar'];
	if($model->validate())
	{
	    // form inputs are valid, do something here
	    return;
	}
    }
    $this->render('addaction',array('model'=>$model));	
  }
  
  public function actionAddmember()
  {
      $this->render('addmember');
  }
  
  public function actionCalendar()
  {
      $this->render('calendar');
  }

  public function actionDeleteaction()
  {
      $this->render('deleteaction');
  }
  
  public function actionDeletemember()
  {
      $this->render('deletemember');
  }
  
  public function actionEditaction()
  {
      $this->render('editaction');
  }
  
  public function actionEditmember()
  {
      $this->render('editmember');
  }
  
  public function actionMember()
  {
      $this->render('member');
  }
  
  public function actionMembers()
  {
      $this->render('members');
  }
  
  public function actionDocuments()
  {
      $dataProvider = new CActiveDataProvider('Document', array(
	  'criteria'=>array(
	      'condition'=>'private=false'
	  ),
	  'pagination'=>array(
	      'pageSize'=>25
	  ),
      ));
      $this->render('documents', array('dataProvider'=>$dataProvider));
  }

  public function actionLoaddocument()
  {
      $this->render('documents');
  }
  
  public function actionDeletedocument()
  {
      $this->render('documents');
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
		  'deletemember',
		  'deleteaction',
		  'addmember', 
		  'editmember', 
		  'loaddocument', 
		  'deletedocument',
		  'deleteregion',
		  'deletemount',
		  'deleteroute',
		  'addaction', 
		  'editaction',
	      ),
	      'roles'=>array('admin'),
	  ),
	  array(
	      'allow',
	      'actions'=>array(
		  'addaction', 
		  'editaction',
		  'addregion',
		  'addmount',
		  'addroute',
		  'editroute',
	      ),
	      'roles'=>array('fapo'),
	  ),
	  array(
	      'deny',
	      'actions'=>array(
		  'deletemember',
		  'deleteaction',
		  'addmember', 
		  'editmember', 
		  'loaddocument', 
		  'deletedocument',
		  'deleteregion',
		  'deletemount',
		  'deleteroute',
		  'addaction', 
		  'editaction',
		  'addregion',
		  'addmount',
		  'addroute',
		  'editroute',
	      ),
	      'roles'=>array('guest'),
	  )
      );
  }
}