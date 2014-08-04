<?php
/* @var $this LinksController */
/* @var $model Links */
/* @var $form CActiveForm */
$pagename = 'Ссылки';

array_push($this->breadcrumbs, $pagename)
?>

<h1><?php echo $pagename; ?></h1>
<?php $this->widget('zii.widgets.grid.CGridView', array('dataProvider'=>$dataProvider,)); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'LinkAddDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Новая ссылка',
        'autoOpen'=>false,
    ),
));
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'links-links-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
)); ?>
<h1></h1>
<p class='note'>Заполните поля формы и нажмите кнопку &quot;Добавить&quot;</p>
<p class='note'>Изображение может быть как выбранно с сетевых рессурсов, так и загруженно на сервер. В случае заполнения обоих полей будет использованно изображение загруженное пользователем.</p>

<table>
    <caption>
	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>
    </caption>
    <thead>
	<td colspan="2">
	    <?php echo $form->errorSummary($model); ?>
	</td>
    </thead>
    <tbody>
	<tr>
	    <td>
		<?php echo $form->labelEx($model,'title'); ?>
	    </td>
	    <td>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	    </td>
	</tr>
	<tr>
	    <td>
		<?php echo $form->labelEx($model,'url'); ?>
	    </td>
	    <td>
		<?php echo $form->textField($model,'url'); ?>
		<?php echo $form->error($model,'url'); ?>
	    </td>
	</tr>
	<tr>
	    <td>
		<?php echo $form->labelEx($model,'image'); ?>
	    </td>
	    <td>
		<?php echo $form->textField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	    </td>
	</tr>
    </tbody>
</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Добавить'); ?>
	</div>

<?php $this->endWidget('CActiveForm'); ?>

</div><!-- form -->

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
// the link that may open the dialog
echo CHtml::link('Добавить ссылку', '#', array(
   'onclick'=>'$("#LinkAddDialog").dialog("open"); return false;',
));
if (Yii::app()->user->hasFlash('flash-link-add-success')) { ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('flash-link-add-success'); ?>
</div>
<?php } else if (Yii::app()->user->hasFlash('flash-link-add-error')) { ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('flash-link-add-error'); ?>
</div>
<?php } ?>