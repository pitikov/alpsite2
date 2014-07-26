<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

    array_push($this->breadcrumbs, 'Регистрация пользователя');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-registration-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
)); ?>
	<h1>Регистрация пользователя</h1>
	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login'); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dob'); ?>
		<?php // echo $form->textField($model,'dob'); 
		$this->widget('zii.widgets.jui.CJuiDatePicker',array(
		    'attribute'=>'dob',
		    'model'=>$model,
		    'language'=>'ru',
		    // additional javascript options for the date picker plugin
		    'options'=>array(
			'showAnim'=>'fold',
		    ),
		    'htmlOptions'=>array(
			'style'=>'height:20px;'
		    ),
		));
		?>
		<?php echo $form->error($model,'dob'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sign'); ?>
		<?php echo $form->textArea($model,'sign'); ?>
		<?php echo $form->error($model,'sign'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить данные'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->