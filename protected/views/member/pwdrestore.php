<?php
/* @var $this PwdRestoreFormController */
/* @var $model PwdRestoreForm */
/* @var $form CActiveForm */

$pagename = 'Восстановление пароля';
array_push($this->breadcrumbs, $pagename);
?>
<h1><?php echo $pagename;?></h1>
<?php if (Yii::app()->user->hasFlash('registration-success')) { ?>
<div class="flash-success">
<?php echo Yii::app()->user->getFlash('registration-success'); ?>
</div>
<?php
    } else {
?>
<div class="form">
<div>
<p>Введите Login или E-Mail зарегистрированного пользователя для восстановления пороля.</p>
<p>На указанный при регистрации E-Mail будет высланно письмо с инструкцией по восстановленю пароля.</p>
</div>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pwd-restore-form-pwdrestore-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'user'); ?>
		<?php echo $form->textField($model,'user'); ?>
	</div>
	<?php echo $form->errorSummary($model); ?>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php } ?>