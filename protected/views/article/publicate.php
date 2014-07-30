<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */
$pagename = 'Публикация';

array_push($this->breadcrumbs, $pagename);
?>

<div class="form">
<h1><?php echo $pagename;?></h1>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-publicate-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body'); ?>

		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->