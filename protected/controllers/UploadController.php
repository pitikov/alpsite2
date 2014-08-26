<?php 
class UploadController extends Controller {
/*
	public function init()
	{
	    $this->defaultAction = 'upload';
	    if(!Yii::app()->request->isAjaxRequest) throw new CHttpException(500, "Only AJAX upload.");
	}
	*/
	public function actionUpload($document, $type/*, $description=null*/)
	{
	  $model = new Document;
	  $dir;
	    switch($type) {
	      case 'avatar':
		$dir = Yii::app()->basePath.'/upload/avatars/profile';
		break;
	      case 'fapo_photo' : 
		$dir = Yii::app()->basePath.'/upload/avatars/fapo'; 
		break;
	      case 'pdf' :
		break;
	      case 'image' :
		break;
	      default: throw new CHttpException(500, "Uncorrect resssource type");
	    }
	    $file = CUploadedFile::getInstanceByName($document);
	    if ($file == null) {
	      echo json_encode('error'=>$file->getError());
	    } else {
	      //echo json_encode('url'=>'correct url');
	    }
	}
	
	public function actionMyuploadslist()
	{
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
		    'actions'=>array('upload',),
		    'roles'=>array('fapo'),
		),
		array(
		    'deny',
		    'actions'=>array('upload','myuploadslist'),
		    'roles'=>array('guest'),
		),
	    );
	}	
}
?>