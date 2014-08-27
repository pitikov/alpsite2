<?php
    // $this = MemberController
    $pagename = "Сообщения";
    array_push($this->breadcrumbs, $pagename);

    echo CHtml::tag('h1', array(), $pagename);

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
    ));
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'SendMailDialog',
	// additional javascript options for the dialog plugin
	'options'=>array(
	    'title'=>'Новое сообщение',
	    'autoOpen'=>false,
	),
    ));
    echo CHtml::tag('div', array('class'=>"form"),null,false);

    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mail-sendmail-form',
	'enableAjaxValidation'=>true,
    )); 
    echo $form->errorSummary($model); ?>
    
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

    <?php 
    echo CHtml::tag('div',array('class'=>'row buttons'), CHtml::submitButton('Отправить'));
    
    $this->endWidget('CActiveForm');
    
    echo CHtml::closeTag('div');

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    
    // the link that may open the dialog
    echo CHtml::link('Написать сообщение', '#', array(
	'onclick'=>'$("#SendMailDialog").dialog("open"); return false;',
    ));
    if (Yii::app()->user->hasFlash('flash-send-mail')) { 
	echo CHtml::tag('div', array('class'=>"flash-success"), Yii::app()->user->getFlash('flash-send-mail'));
    }
    if (Yii::app()->user->hasFlash('flash-send-mail-error')) { 
	echo CHtml::tag('div', array('class'=>"flash-error"), Yii::app()->user->getFlash('flash-send-mail-error'));
    } 
?>