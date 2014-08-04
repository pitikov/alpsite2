<?php
/** @var $this BanersController
*   @var $model Baners
*   @var $form CActiveForm */

$pagename = 'Рекламные банеры';

array_push($this->breadcrumbs, $pagename);
?>
<h1><?php echo $pagename; ?></h1>

<?php 
    $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'Список банеров')); 
    $this->widget('zii.widgets.grid.CGridView', array('dataProvider'=>$dataProvider,));
    $this->endWidget(); 
?>

<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'Добавление банера')); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'baners-baners-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
)); ?>
<table>
  <caption>
	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>
  </caption>
  <thead>
    <tr>
      <td colspan="2">
	<?php echo $form->errorSummary($model); ?>
      </td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
	<?php echo $form->labelEx($model,'body'); ?>
      </td>
      <td>
	<?php echo $form->textArea($model,'body'); ?>
	<?php echo $form->error($model,'body'); ?>
      </td>
    </tr>
  </tbody>
</table>

<div class="row buttons">
    <?php echo CHtml::submitButton('Добавить'); ?>
</div>
<?php if (Yii::app()->user->hasFlash('flash-baner-add-success')) { ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('flash-baner-add-success'); ?>
</div>
<?php } else if (Yii::app()->user->hasFlash('flash-baner-add-error')) { ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('flash-baner-add-error'); ?>
</div>
<?php } ?>
<?php $this->endWidget('baners-baners-form'); ?>
</div><!-- form -->
<?php $this->endWidget(); ?>

<?php
$tabParameters = array();
foreach($this->clips as $key=>$clip)
    $tabParameters['tab'.(count($tabParameters)+1)] = array('title'=>$key, 'content'=>$clip);
?>
<?php $this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters)); ?>