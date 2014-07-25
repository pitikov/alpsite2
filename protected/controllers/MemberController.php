<?php

class MemberController extends Controller
{
    
    public function init()
    {
      if (Yii::app()->user->isGuest) $this->defaultAction="login";
      else $this->defaultAction = 'profile';
        parent::init();
    }
    
    
	public function actionEndregistration()
	{
		$this->render('endregistration');
	}

	public function actionLogin()
	{
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
		$this->render('registration');
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