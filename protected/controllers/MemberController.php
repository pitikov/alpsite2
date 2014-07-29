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
    
    
	public function actionEndregistration($uid, $ctrlhash)
	{
	    $model=new PwdRequest;
	    $user = User::model()->findByPk($uid);
	    $pwdrestore = Pwdrestore::model()->findByPk($uid);
	    
	    if (((count($user) === 0) or (count($pwdrestore)===0) or (strcmp($pwdrestore->ctrlhash,$ctrlhash) != 0))and(!Yii::app()->user->hasFlash('registration-success'))) {
		throw new CHttpException(404,'Указанная запись не найдена');
	    }
	    
	    if(isset($_POST['ajax']) && $_POST['ajax']==='pwd-request-endregistration-form')
	    {
		echo CActiveForm::validate($model);
		Yii::app()->end();
	    }
	    
	    if(isset($_POST['PwdRequest']))
	    {
		$model->attributes=$_POST['PwdRequest'];
		if($model->validate())
		{
		    $command = Yii::app()->db->createCommand("update `".User::tableName()."` set `pwdhash`='".crypt($model->password)."' where `uid`={$user->uid};");
		    if ($command->execute() == 1) {
			$pwdrestore->delete();
			Yii::app()->user->setFlash('registration-success', 'Регистрация пользователя успешно завершенна');
		    } else {
			Yii::app()->user->setFlash('registration-success', 'Регистрация пользователя проваленна');
		    }
		    $this->refresh();
		}
	    }
	    $this->render('endregistration',array('model'=>$model, 'pagename'=>"Окончание регистрации {$user->name}"));
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
		    if ($model->save()) {
			$ctrlhash = crypt($model->dob);
			$mail_body = "<html><body><p>При регистрации на сайте ".Yii::app()->name." был указан ваш e-mail.</p>".
				     "<p>Если это были Вы, то для продолжения регистрации перейдите по <a href=\"".
				      Yii::app()->request->hostInfo.$this->createUrl("/{$this->id}/endregistration", array(
					'uid'=>$model->uid, 
					'ctrlhash'=>$ctrlhash
				     )).
				     "\">ссылке</a>.</p><p>Если же это были не Вы, просто проигнорируйте данное сообщение.</p></body></html>";
			$subject='=?UTF-8?B?'.base64_encode("Регистрация пользователя").'?=';
			$headers="From: admin '".Yii::app()->request->hostInfo."' <{$model->email}>\r\n".
			"Reply-To: ".Yii::app()->params['adminEmail'].
			"\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8";
			mail($model->email,$subject,$mail_body,$headers);
			
			// На указанный E-Mail отправить сообщение с инструкциями по активаци аккаунта
			$command = Yii::app()->db->createCommand("insert into `".Pwdrestore::tableName()."` values ( {$model->uid}, '{$ctrlhash}');");
			
			$command->execute();
			///@todo Перейти от флэш к статичным страницам
			Yii::app()->user->setFlash('registration-success','На указанный E-mail отправленно письмо с инструкциями по продолжению регистрации.');
		    } else {
			Yii::app()->user->setFlash('registration-deny','Ошибка регистрации пользователя.');
		    }
		    $this->refresh();
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