<?php
/* @var $this FederationCalendarController */
/* @var $model FederationCalendar */
/* @var $form CActiveForm */
$pagename = 'Регистрация альпмероприятия';
array_push($this->breadcrumbs, $pagename);
?>

<div class="form">
<h1><?php echo $pagename; ?></h1>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'federation-calendar-addaction-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'begin'); ?>
		<?php echo $form->textField($model,'begin'); ?>
		<?php echo $form->error($model,'begin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'finish'); ?>
		<?php echo $form->textField($model,'finish'); ?>
		<?php echo $form->error($model,'finish'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location_lat'); ?>
		<?php echo $form->textField($model,'location_lat'); ?>
		<?php echo $form->error($model,'location_lat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location_lng'); ?>
		<?php echo $form->textField($model,'location_lng'); ?>
		<?php echo $form->error($model,'location_lng'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Зарегистрировать альпмероприятие'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->