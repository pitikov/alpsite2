<?php

class MemberController extends Controller
{
    
    public function init()
    {
	if (Yii::app()->user->isGuest) {
	    $this->defaultAction="login";
	    $this->layout = '//layouts/column1';
	} else {
	    $this->defaultAction = 'profile';
	    $this->layout = '//layouts/column2';
	    $this->menuName = 'Кабинет пользователя';
	    
	    $this->menu = array(
		array('label'=>'Профиль', 'url'=>array('/member/profile', 'uid'=>Yii::app()->user->id)),
		array('label'=>'Восхождения', 'url'=>array('/member/peaklist', 'uid'=>Yii::app()->user->id)),
		array('label'=>'Сообщения', 'url'=>array('/member/mail', 'uid'=>Yii::app()->user->id, 'folder'=>'inbox')),
		array('label'=>'Публикации', 'url'=>array('/member/articles', 'uid'=>Yii::app()->user->id)),
		array('label'=>'Администрирование', 'url'=>array('/admin'), 'visible'=>Yii::app()->user->isAdmin()),
	    );
	}
	
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
	    
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));

	}

	public function actionArticles()
	{
	    $this->render('articles');
	}
	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect("./");
	}

	public function actionProfile()
	{
		$this->render('profile');
	}
	
	public function actionPeaklist()
	{
	    $this->render('peaklist');
	}
	
	public function actionMail($uid, $folder)
	{
	    $this->render('mail');
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