<?php

class MemberController extends Controller
{
    
    public function init()
    {
	$this->layout = '//layouts/column2';
	if (Yii::app()->user->isGuest) {
	    $this->defaultAction="login";
	} else {
	    $this->defaultAction = 'profile';
	    $this->menuName = 'Кабинет пользователя';
	    
	    $this->menu = array(
		array('label'=>'Профиль', 'url'=>array('/member/profile')),
		array('label'=>'Членство в федерации', 'url'=>array('/member/federationprofile'), 'visible'=>$this->isFapo()),
		array('label'=>'Восхождения', 'url'=>array('/member/peaklist')),
		array('label'=>'Сообщения', 'url'=>array('/member/mail')),
		array('label'=>'Публикации', 'url'=>array('/member/articles')),
		array('label'=>'Администрирование', 'url'=>array('/admin'), 'visible'=>$this->isAdmin()),
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
	    $pagename = "Окончание регистрации";
	    
	    if (isset($_POST['pwdrestore'])) $pagename = "Восстановление пароля";
	    
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
			Yii::app()->user->setFlash('registration-success', "{$pagename} успешно завершенно");
		    } else {
			Yii::app()->user->setFlash('registration-success', "{$pagename} проваленно");
		    }
		}
	    }
	    $this->render('endregistration',array('model'=>$model, 'pagename'=>"{$pagename} {$user->name}"));
	}

	public function actionLogin()
	{
	    // Для OpenId аутенфикации использовать методы описанные http://habrahabr.ru/post/129804/
	    
		$model=new LoginForm;

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
	
	public function actionPwdrestore()
	{
	    $model=new PwdRestoreForm;
	    
	    if(isset($_POST['PwdRestoreForm']))
	    {
		$model->attributes=$_POST['PwdRestoreForm'];
		if($model->validate())
		{
		    $user = User::model()->find('`login`=:User or `email`=:User', array(':User'=>$model->user));
		    $ctrlhash = crypt($user->dob);
		    $mail_body = "<html><body><p>Кто-то, возможно это были Вы, на сайте ".Yii::app()->name." активировал процедуру восстановления пароля.</p>".
				 "<p>Если это были Вы, то для продолжения перейдите по <a href=\"".
				 Yii::app()->request->hostInfo.$this->createUrl("/{$this->id}/endregistration", array(
				    'uid'=>$user->uid, 
				    'ctrlhash'=>$ctrlhash,
				    'pwdrestore'
				 )).
				 "\">ссылке</a>.</p><p>Если же это были не Вы, просто проигнорируйте данное сообщение.</p></body></html>";
		    $subject='=?UTF-8?B?'.base64_encode("Регистрация пользователя").'?=';
		    $headers="From: admin '".Yii::app()->request->hostInfo."' <".Yii::app()->params['adminEmail'].">\r\n".
			     "Reply-To: ".Yii::app()->params['adminEmail'].
			     "\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8";
		    mail($user->email,$subject,$mail_body,$headers);
		    
		    $command = Yii::app()->db->createCommand("delete from `".Pwdrestore::tableName()."` where `uid`= {$user->uid};");
		    $command->execute();
		    $command = Yii::app()->db->createCommand("insert into `".Pwdrestore::tableName()."` values ( {$user->uid}, '{$ctrlhash}');");
		    $command->execute();
		    Yii::app()->user->setFlash('registration-success', 'На указанный E-Mail высланно письмо с инструкций по восстановленю пароля');
		}
	    }
	    $this->render('pwdrestore',array('model'=>$model));	
	}

	public function actionArticles()
	{
	    $this->render('articles');
	}
	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->user->returnUrl);
	}

	public function actionProfile()
	{
	    $model=Yii::app()->user->model();
	    
	    if(isset($_POST['ajax']) && $_POST['ajax']==='user-profile-form')
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
			Yii::app()->user->setFlash('flash-profile-success','Данные профиля сохраненны.');
		    } else {
		    	Yii::app()->user->setFlash('flash-profile-error','Ошибка сохранения профиля.');
		    }
		}
	    
	    }
	    
	    $avatar=new Document;
	    if(isset($_POST['Document'])){
		$avatar->attributes=$_POST['Document'];
		$avatar->document=CUploadedFile::getInstance($avatar,'document');
		    /// @todo Сохранять в заданную папку под "своим" именем, после чего фиксим и сохраняем модель
		    $avatar->document->saveAs('/upload/avatar.png');
	    }
	    $this->render('profile',array('model'=>$model, 'avatar'=>$avatar));
	}
	
	public function actionPeaklist()
	{
	    /// @todo Делать выборку по восхождениям исходя из участия в них текущего пользователя
	    $mountaring = new CActiveDataProvider('Mountaring',
		array('criteria'=>array(
		    /*'condition'=>array(
		    ),*/
		))
	    );
	    $mountaringModel=new Mountaring;
	    
	    if(isset($_POST['ajax']) && $_POST['ajax']==='mountaring-mountaring-form')
	    {
		echo CActiveForm::validate($mountaringModel);
		Yii::app()->end();
	    }
	    
	    if(isset($_POST['Mountaring']))
	    {
		$mountaringModel->attributes=$_POST['Mountaring'];
		if($mountaringModel->validate())
		{
		    // form inputs are valid, do something here
		    return;
		}
	    }
	    
	    $this->render('peaklist', array('model'=>$mountaringModel,'peaklist'=>$mountaring));
	}
	
	public function actionMail()
	{
	    $model=new Mail('sendmail');
	    $model->user=Yii::app()->user->getId();
	    $model->sender = $model->user;
	    $model->folder = 'outbox';
	    
	    $users = User::model()->findAll();
	    $userlist = array();
	    
	    foreach($users as $user) {
	        array_push($userlist, "{$user->login} ({$user->name}) <{$user->email}>");
	    }
	    
	    
	    $inbox = new CActiveDataProvider('Mail',
		array(
		    'criteria'=>array(
		        'condition'=>"user = {$model->user} and folder = 'inbox' and trash=false",
		        'order'=>'sended DESC',
		    )
		)
	    );
	    $outbox = new CActiveDataProvider('Mail',
		array(
		    'criteria'=>array(
		        'condition'=>"user = {$model->user} and folder = 'outbox' and trash=false",
		        'order'=>'sended DESC',
		    )
		)
	    );
	    $trash = new CActiveDataProvider('Mail',
		array(
		    'criteria'=>array(
		        'condition'=>"user = {$model->user} and trash=true",
		        'order'=>'sended DESC',
		    )
		)
	    );	  
	    
	    if(isset($_POST['ajax']) && $_POST['ajax']==='mail-sendmail-form')
	    {
		echo CActiveForm::validate($model);
		Yii::app()->end();
	    }
	    
	    if(isset($_POST['Mail']))
	    {
		$model->attributes=$_POST['Mail'];
		    if($model->validate() && $model->save()) {
			$msg = new Mail();
			$msg->user = $model->receiver;
			$msg->sender = $model->sender;
			$msg->receiver = $model->receiver;
			$msg->sended = $model->sended;
			$msg->subject = $model->subject;
			$msg->body = $model->body;
			$msg->folder = 'inbox';
			$msg->save();
			
			$mail_body = "<html><body><h1>{$model->subject}</h1>{$model->body}<hr/>Писмо отправленно с сайта '".Yii::app()->getBaseUrl(true)."'</body></html>";
			$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
			
			$headers="From: ".Yii::app()->user->model()->login." <".Yii::app()->user->email().">\r\n".
			"Reply-To: ".Yii::app()->user->email().
			"\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8";
			$receiver = User::model()->findByPk($model->receiver);
			mail($receiver->email, $subject, $mail_body, $headers);
			
			Yii::app()->user->setFlash('flash-send-mail','Сообщение отправленно.');
			$model = new Mail('sendmail');
			$model->user=Yii::app()->user->getId();
			$model->sender = $model->user;
			$model->folder = 'outbox';
		      
		    } else {
			Yii::app()->user->setFlash('flash-send-mail-error','Ошибка отправки сообщения.');
		    }
	    }
	    $this->render('mail',array('model'=>$model, 'inbox'=>$inbox, 'outbox'=>$outbox, 'trash'=>$trash, 'userlist'=>$userlist));
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
			$headers="From: admin '".Yii::app()->request->hostInfo."' <".Yii::app()->params['adminEmail'].">\r\n".
			"Reply-To: ".Yii::app()->params['adminEmail'].
			"\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8";
			mail($model->email,$subject,$mail_body,$headers);
			
			$command = Yii::app()->db->createCommand("insert into `".Pwdrestore::tableName()."` values ( {$model->uid}, '{$ctrlhash}');");
			
			$command->execute();
			Yii::app()->user->setFlash('registration-success','На указанный E-mail отправленно письмо с инструкциями по продолжению регистрации.');
		    } else {
			Yii::app()->user->setFlash('registration-deny','Ошибка регистрации пользователя.');
		    }
		}
	    }
	    $this->render('registration',array('model'=>$model));
	} 
	
	public function actionFederationprofile()
	{
	    $model = FederationMember::model()->find('user=:User', array(':User'=>Yii::app()->user->getId()));
	    $roles = FederationRole::model()->findAll();
	    $roleList = array(null=>'-- выберите занимаюмую должность --');
	    foreach($roles as $role) {
		$roleList[$role->id]=$role->title;
	    }
	    
	    
	    if(isset($_POST['ajax']) && $_POST['ajax']==='federation-member-federationprofile-form')
	    {
		echo CActiveForm::validate($model);
		Yii::app()->end();
	    }
	    
	    
	    if(isset($_POST['FederationMember']))
	    {
		$model->attributes=$_POST['FederationMember'];
		if($model->validate())
		{
		    if ($model->save()) {
			Yii::app()->user->setFlash('flash-federation-profile-success','Данные профиля сохраненны.');
		    } else {
		    	Yii::app()->user->setFlash('flash-federation-profile-error','Ошибка сохранения профиля.');
		    }
		}
	    }
	    $this->render('federationprofile',array('model'=>$model, 'roles'=>$roleList));
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
		    'actions'=>array('federationprofile',),
		    'roles'=>array('fapo'),
		),
		array(
		    'deny',
		    'actions'=>array('login','registration','endregistration','pwdrestore',),
		    'roles'=>array('user'),
		),
		array(
		    'allow',
		    'actions'=>array('articles','mail','logout','profile','peaklist'),
		    'roles'=>array('user'),
		),
		array(
		    'deny',
		    'actions'=>array('articles','mail','logout','profile','peaklist','federationprofile'),
		    'roles'=>array('guest'),
		),
		array(
		    'allow',
		    'actions'=>array('login','registration','endregistration','pwdrestore'),
		    'roles'=>array('guest'),
		),
	    );
	}	
}