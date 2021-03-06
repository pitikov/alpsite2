<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/** @var string the context menu title string */
	public $menuName="";
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public $banerList = array();
	public $linkList = array();
	
	public function isAdmin()
	{
	    return Yii::app()->user->checkAccess('admin');
	}
	
	public function isFapo()
	{
	    return Yii::app()->user->checkAccess('fapo');
	}
	
	public function isUser()
	{
	    return !Yii::app()->user->isGuest;
	}	
	
	protected function beforeAction($action)
	{
	    $this->banerList = Baners::model()->findAll(array('condition'=>'on_show=true','order'=>'position ASC', 'limit'=>3));
	    $this->linkList = Links::model()->findAll(array('condition'=>'on_show=true', 'order'=>'position ASC', 'limit'=>10));
	    $ret = parent::beforeAction($action);
	    return $ret;
	}
	
}