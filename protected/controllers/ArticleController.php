<?php

class ArticleController extends Controller
{
    
    public function init()
    {
	$this->breadcrumbs = array("Статьи и отчеты"=>array('/'.$this->id));
	$this->defaultAction='publicate';
        parent::init();
    }
    
	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionEdit()
	{
		$this->render('edit');
	}

	public function actionFind()
	{
		$this->render('find');
	}

	public function actionPublicate()
	{
	  $model=new Article('publicate');
	  $model->author = Yii::app()->user->getId();
	  $model->dop = time();

	  // uncomment the following code to enable ajax-based validation
	  if(isset($_POST['ajax']) && $_POST['ajax']==='article-publicate-form')
	  {
	      echo CActiveForm::validate($model);
	      Yii::app()->end();
	  }
	  
	  if(isset($_POST['Article']))
	  {
	      $model->attributes=$_POST['Article'];
	      if($model->validate())
	      {
		  // form inputs are valid, do something here
		  return;
	      }
	  }
	  
	  $this->render('publicate',array('model'=>$model));	
	}

	public function actionView()
	{
		$this->render('view');
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