<?php

class MemberController extends Controller
{
    
    public function init()
    {
	if (Yii::app()->user->isGuest) $this->defaultAction="login";
	else $this->defaultAction = 'profile';
	
	$this->breadcrumbs=array('Управление пользователями'=>array('/member'));

        parent::init();
    }
    
    
	public function actionEndregistration()
	{
		$this->render('endregistration');
	}

	public function actionLogin()
	{
	    // Для OpenId аутенфикации использовать методы описанные http://habrahabr.ru/post/129804/
	    $this->render('login');
	}

	public function actionLogout()
	{
		$this->render('logout');
	}

	public function actionProfile()
	{
		$this->render('profile');
	}
	
	public function actionRegistration()
	{
	    $model=new User('register');
	    
	    $model->regdata = date('Y-m-d', time());
	    // uncomment the following code to enable ajax-based validation
	    
	    if(isset($_POST['ajax']) && $_POST['ajax']==='user-registration-form')
	    {
		echo CActiveForm::validate($model);
		Yii::app()->end();
	    }   
	    
	    if(isset($_POST['User']))
	    {
		$model->attributes=$_POST['User'];
		if($model->validate())
		{ 
		    // form inputs are valid, do something here
		    // В случае успеха на указанный E-Mail отправить сообщение с инструкциями по активаци аккаунта и вывести собщенеие о отправке сообщения
		    $this->redirect('/');
		}
	    }
	    $this->render('registration',array('model'=>$model));
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