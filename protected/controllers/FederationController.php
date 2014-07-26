<?php

class FederationController extends Controller
{
  
  public function init()
  {
      $this->layout='//layouts/column2';
      
      $this->menu = array(
	array('label'=>'Новости', 'url'=>array($this->id.'/index')),
	array('label'=>'Календарь альпмероприятий', 'url'=>array($this->id.'/calendar')),
	array('label'=>'Члены федерации', 'url'=>array($this->id.'/members')),
	array('label'=>'Докуметы', 'url'=>array($this->id.'/documents')),
      );
      $this->defaultAction = "index";
      $this->breadcrumbs = array("Федерация Альпинизма Пензенской Области"=>array("/federation/index"));
      parent::init();
  }
  
  public  function actionIndex()
  {
      $this->render('index');
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
		$this->render('addaction');
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
	    $this->render('documents');
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