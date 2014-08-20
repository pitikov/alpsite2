<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
$pagename = "Профиль пользователя \"{$model->login}\"";

array_push($this->breadcrumbs, $pagename);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-profile-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>
	<table>
	  <thead><h1><?php echo $pagename; ?></h1></thead>
	  <caption><p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p></caption>
	  <tbody>
	  <tr>
	    <td width='35%'>
		<?php echo $form->labelEx($model,'login'); ?>
	    </td><td>
		<?php //echo $form->textLabel($model,'login'); ?>
		<?php echo $model->login; ?>
		<?php echo $form->error($model,'login'); ?>
	    </td>
	  </tr>
	  <tr>
	    <td>
		<?php echo $form->labelEx($model,'regdate'); ?>
		<?php //echo $form->textLabel($model,'regdata'); ?>
	    </td><td>
		<?php echo $model->regdate; ?>
		<?php echo $form->error($model,'regdate'); ?>
	    </td>
	  </tr>
	  <tr>
	    <td>
		<?php echo $form->labelEx($model,'role'); ?>
	    </td><td>
		<?php if ($this->isAdmin()) { ?><div class='memberrole' id='admin'>Администратор</div><?php } ?>
		<?php if ($this->isFapo()) { ?><div class='memberrole' id='fapo'>Член ФАПО</div><?php } ?>
		<?php echo $form->error($model,'role'); ?>
	    </td>
	  </tr>
	  <tr>
	    <td>
		<?php echo $form->labelEx($model,'avatar'); ?>
	    </td><td>
		<?php echo CHtml::link(CHtml::image($model->avatar, 'Фото', array('title'=>'Щелкните мышью для изменения')), '#', array('onclick'=>'$("#avatarDialog").dialog("open"); return false;')); ?>
		<?php echo $form->hiddenField($model, 'avatar'); ?>
		<?php echo $form->error($model,'avatar'); ?>
	    </td>
	  </tr>
	  <tr>
	    <td>
		<?php echo $form->labelEx($model,'name'); ?>
	    </td><td>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	    </td>
	  </tr>
	  <tr>
	    <td>
		<?php echo $form->labelEx($model,'email'); ?>
	    </td><td>
		<?php echo $form->emailField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	    </td>
	  </tr>
	  <tr>
	    <td>
		<?php echo $form->labelEx($model,'dob'); ?>
	    </td><td>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
				  array(
				      'model'=>$model,
				      'attribute'=>'dob',
				      'name'=>'DateOfBethday',
				      // additional javascript options for the date picker plugin
				      'options'=>array(
					  'showAnim'=>'fold',
				      ),
				      'htmlOptions'=>array(
					  'style'=>'height:20px;'
				      ),
				      'language'=>'ru',
		    ));
		
		?>
		<?php echo $form->error($model,'dob'); ?>
	    </td>
	  </tr>
	  <tr>
	    <td>
		<?php echo $form->labelEx($model,'sign'); ?>
		<div class='hint'>Краткое сообщение - девиз, отображаемое после каждой вашей записи в комментариях</div>
	    </td><td>
		<?php echo $form->textArea($model,'sign'); ?>
		<?php echo $form->error($model,'sign'); ?>
	    </td>
	  </tr>
	  </tbody>
	</table>
	<?php echo CHtml::submitButton('Сохранить'); ?>
<?php if (Yii::app()->user->hasFlash('flash-profile-success')) { ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('flash-profile-success'); ?>
</div>
<?php } ?>
<?php if (Yii::app()->user->hasFlash('flash-profile-error')) { ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('flash-profile-error'); ?>
</div>
<?php } ?>
<?php $this->endWidget(); ?>
</div><!-- form -->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'avatarDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Загрузка аватарки',
        'autoOpen'=>false,
        'modal'=>true,
        'buttons'=>array(
	    'Загрузить'=>'js:function(){$("#avatarDialog").dialog("close"); $("#formAvatarUpload").submit();}',
        ),
    ),
));
?>
<?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data', 'id'=>'formAvatarUpload')); ?>
<?php echo CHtml::activeFileField($avatar, 'document'); ?>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget('avatarDialog');?>

<script>
function setAvatar(){
    $('#avatarDialog').dialog("close");
}
</script>

