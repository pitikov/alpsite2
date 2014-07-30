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
	array('label'=>'Журнал восхождений', 'url'=>array($this->id.'/mountaring')),
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
      $body = null;
      $this->render('about', array('body'=>$body));
  }
  
  public function actionGuidebook()
  {
      $this->render('guidebook');
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
	    $this->render('documents');
	}
}