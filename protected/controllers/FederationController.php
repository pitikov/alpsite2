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
      $dataProvider = new CActiveDataProvider('Mountaring');
      $this->render('mountaring', array('dataProvider'=>$dataProvider));
  }
  
  public function actionError()
  {
    if($error=Yii::app()->errorHandler->error)
    {
      if(Yii::app()->request->isAjaxRequest) {
	echo $error['message'];
      } else {
	$this->render('error', $error);
      }
    }
  }
  
  public function actionAction()
  {
      $this->render('action');
  }

  public function actionAddaction()
  {
    $model=new FederationCalendar('create');

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
      if (Yii::app()->request->isAjaxRequest) {
          $member = null;
          if (isset($_POST)) { 
              if (($_POST['id'] === 'undefined')or($_POST['id']==0)) {
                  $member = new FederationMember();
              } else {
                  $member = FederationMember::model()->findByPk($_POST['id']);
              }
              $member->name = $_POST['name'];
              $member->dob = $_POST['dob'];
              if ( $_POST['description'] === 'undefined' ) {
                  $member->description = null; 
              } else { 
                  $member->description = $_POST['description'];
              }
              $member->memberfrom = $_POST['from'];
              $member->memberto = $_POST['to'];
              if ( $_POST['role'] === 'undefined' ) {
                  $member->role = null; 
              } else { 
                  $member->role = $_POST['role'];
              }
              if ( $_POST['uid'] === 'undefined' ) {
                  $member->user = null;
              } else {
                  $member->user = $_POST['uid'];
              }
              
              if ($member->validate()) {
                  if ($member->save()) {
                      echo json_encode(array('action'=>'success'));                  
                  } else {
                      echo json_decode(array('action'=>'Ошибка при работе С БД. Попробуйте повторить попытку позднее.'));
                  }
              } else {
                  echo json_encode(array());
              }
          } else {
              echo json_encode(array('status'=>'error'));
          }
          
      } else {
	  throw new CHttpException(500, "Разрешен только AJAX запрос.");
      }
  }
  
  public function actionCalendar()
  {
      $this->render('calendar');
  }

  public function actionDeleteaction()
  {
      $this->render('deleteaction');
  }
  
  public function actionDeletemember($id)
  {
      if (Yii::app()->request->isAjaxRequest) {
	  if (FederationMember::model()->deleteByPk($id)) {
              echo json_encode(array('status'=>'successed'));
          } else {
              throw new CHttpException(404, "Запись не найденна.");
          }
      } else {
	  throw new CHttpException(500, "Разрешен только AJAX запрос.");
      }
  }
  
  public function actionEditaction()
  {
      $this->render('editaction');
  }
  
  public function actionEditmember($id)
  {
      if (Yii::app()->request->isAjaxRequest) {
          $member = FederationMember::model()->findByPk($id);
	  if ($member !== null) {
              echo json_encode(array(
                  'id'=>$member->id,
                  'name'=>$member->name,
                  'photo'=>$member->photo,
                  'dob'=>$member->dob,
                  'from'=>$member->memberfrom,
                  'to'=>$member->memberto,
                  'description'=>$member->description,
                  'role'=>$member->role,
                  'uid'=>$member->user
                      ));
          } else {
              throw new CHttpException(404, "Запись не найденна.");
          }
      } else {
	  throw new CHttpException(500, "Разрешен только AJAX запрос.");
      }
  }
  
  public function actionMember()
  {
      $this->render('member');
  }
  
  public function actionMembers()
  {
      $dataProvider=new CActiveDataProvider('FederationMember');
      $this->render('members', array('dataProvider'=>$dataProvider));
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
  
  public function actionRoles()
  {
      if (Yii::app()->request->isAjaxRequest) {
	  $rolesBase=FederationRole::model()->findAll();
	  $roles=array(null=>'член федерации');
	  foreach ($rolesBase as $role) {
	      $roles[$role->id]=$role->title;
	  }
	  echo json_encode($roles);
      } else {
 	  throw new CHttpException(500, "Разрешен только AJAX запрос.");
      }
  }
  
  public function actionGetrole($id) {
      if (Yii::app()->request->isAjaxRequest) {
          $role = FederationRole::model()->findByPk($id);
          if ($role === null) {
             throw new CHttpException(404, "Запись не найденна."); 
          } else {
              echo json_encode(array(
                  'id'=>$role->id,
                  'title'=>$role->title
              ));
          }
      } else {
          throw new CHttpException(500, "Разрешен только AJAX запрос.");
      }
  }

  public function actionUsers()
  {
      if (Yii::app()->request->isAjaxRequest) {
	  $usersBase=User::model()->findAll();
	  $users=array(null=>'-- не привязывать к аккаунту --');
	  foreach ($usersBase as $user) {
	      $users[$user->uid]=$user->name.': '.$user->login.'['.$user->email.']';
	  }
	  echo json_encode($users);
      } else {
 	  throw new CHttpException(500, "Разрешен только AJAX запрос.");
      }
  } 
  
  /** @fn actionGetmembermountarings
   *  @brief Получить список восхождений участника по заданному id
   */
  public function actionGetmembermountarings($id)
  {
      if (Yii::app()->request->isAjaxRequest) {
          $mounatringList = MountaringMembers::model()->findAll('member=:MemberId', array(':MemberId'=>$id));
          
       
          if (count($mounatringList)>0) {

              echo CHtml::tag('table', array('id'=>'mountaringListTable'), 
                      CHtml::tag('caption',array('style'=>'text-align:center'),
                              CHtml::tag('b', array(),'список восходжений')).
                              CHtml::tag('thead', array(), 
                                      CHtml::tag('th',array(),'дата').
                                      CHtml::tag('th',array(),'на вершину').
                                      CHtml::tag('th',array(),'по маршруту').
                                      CHtml::tag('th',array(),'КС').
                                      CHtml::tag('th',array(),'в составе')
                                      ).
                              CHtml::tag('tbody',array(),null,false)
                      ,false);
              $rowClass = 'even';
              foreach ($mounatringList as $item) {
                  $mountaring = $item->Mountaring;
                  echo CHtml::tag('tr', array('class'=>$rowClass),
                          CHtml::tag('td', array(), $mountaring->date).
                          CHtml::tag('td', array(), $mountaring->mountaringRoute->RouteMountain->title).
                          CHtml::tag('td', array(), $mountaring->mountaringRoute->title).
                          CHtml::tag('td', array(), $mountaring->mountaringRoute->difficulty).
                          CHtml::tag('td', array(), $mountaring->Composition)
                          );
                  $rowClass = $rowClass==='even'?'odd':'even';  
              }
              echo CHtml::closeTag('tbody');
              echo CHtml::closeTag('table');       
          }


      } else {
          throw new CHttpException(500, "Разрешен только AJAX запрос.");
      }
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