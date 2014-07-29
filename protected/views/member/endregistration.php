<?php
/* @var $this PwdRequestController */
/* @var $model PwdRequest */
/* @var $form CActiveForm */

array_push($this->breadcrumbs, $pagename); 
?>
<h1><?php echo $pagename; ?></h1>
<?php
if (Yii::app()->user->hasFlash('registration-success')) {
?>
<div class="flash-success">
<?php echo Yii::app()->user->getFlash('registration-success'); ?>
</div>
<?php } else { ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pwd-request-endregistration-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
));?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password_confirm'); ?>
		<?php echo $form->passwordField($model,'password_confirm'); ?>
		<?php echo $form->error($model,'password_confirm'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранть пароль'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php } ?>