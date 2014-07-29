<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

    array_push($this->breadcrumbs, 'Регистрация пользователя');
    if (Yii::app()->user->hasFlash('registration-success')) {
?>
<div class="flash-success">
<?php echo Yii::app()->user->getFlash('registration-success'); ?>
</div>
<?php
    } else {
	if (Yii::app()->user->hasFlash('registration-deny')) {
?>
<div class="flash-deny">
<?php echo Yii::app()->user->getFlash('registration-deny'); ?>
</div>
<?php
	} else {
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
		<?php echo $form->emailField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить данные'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php }} ?>