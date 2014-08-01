<?php
    // $this = MemberController
    $pagename = "Сообщения";
    array_push($this->breadcrumbs, $pagename);
?>

<h1><?php echo $pagename; ?></h1>
<?php
$this->widget('CTabView', array(
    'tabs'=>array(
        'tab_inbox'=>array(
            'title'=>'Входящие',
            'view'=>'mail_inbox',
            'data'=>array('model'=>$inbox),
        ),
        'tab_outbox'=>array(
            'title'=>'Отправленные',
            'view'=>'mail_sended',
             'data'=>array('model'=>$outbox),
        ),
        'tab_trash'=>array(
            'title'=>'Корзина',
            'view'=>'mail_trash',
             'data'=>array('model'=>$trash),
        ),
    ),
))?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'SendMailDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Новое сообщение',
        'autoOpen'=>false,
    ),
));
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'mail-sendmail-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>true,
)); ?>

    <?php echo $form->errorSummary($model); ?>
<table>
  <tr>
    <td>
        <?php echo $form->label($model,'receiversearch'); ?>
    </td><td>
        <?php //echo $form->textField($model,'receiversearch'); 
	  $this->widget('zii.widgets.jui.CJuiAutoComplete', 
	      array(
		  'model'=>$model,
		  'attribute'=>'receiversearch',
		  'name'=>'mailReceiverSearch',
		  'source'=>$userlist,
	      // additional javascript options for the autocomplete plugin
	      'options'=>array(
		  'minLength'=>'2',
	      ),
	      'htmlOptions'=>array(
		  'style'=>'height:20px;'
	      ),
	  ));
        ?>
        <?php echo $form->error($model,'receiversearch'); ?>
    </td>
  </tr><tr>
    <td>
        <?php echo $form->label($model,'subject'); ?>
    </td><td>
        <?php echo $form->textField($model,'subject'); ?>
        <?php echo $form->error($model,'subject'); ?>
    </td>
  </tr>
</table>

    <div class="row">
        <?php 
	    $this->widget('ImperaviRedactorWidget', array(
	    // You can either use it for model attribute
		'model' => $model,
		'attribute' => 'body',
		// or just for input field
		'name' => 'mail_message',
		
		// Some options, see http://imperavi.com/redactor/docs/
		'options' => array(
		    'lang' => 'ru',
		    'toolbar' => true,
		    'iframe' => false,
		    'css' => 'wym.css',
		  ),
		));
	    echo $form->error($model,'body'); 
	?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить'); ?>
    </div>

<?php $this->endWidget('CActiveForm');?>

</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');

// the link that may open the dialog
echo CHtml::link('Написать сообщение', '#', array(
   'onclick'=>'$("#SendMailDialog").dialog("open"); return false;',
));
if (Yii::app()->user->hasFlash('flash-send-mail')) {
?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('flash-send-mail'); ?>
</div>

<?php
}
?>