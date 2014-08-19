<?php
    $pagename = "Должности в федерации";
    array_push($this->breadcrumbs, $pagename);
?>
<h1><?php echo $pagename; ?></h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$roleProvider,
));
echo CHtml::link('Создать', "#",array('onclick'=>'$("#RoleAddDialog").dialog("open"); return false;'));
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'RoleAddDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Должность',
        'autoOpen'=>false,
        'modal'=>true,

    ),
));
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'federation-role-role-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>true,
)); ?>

    <?php echo $form->errorSummary($new_role); ?>

    <div class="row">
        <?php echo $form->label($new_role,'title'); ?>
        <?php echo $form->textField($new_role,'title'); ?>
        <?php echo $form->error($new_role,'title'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Добавить'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form --> 
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php if (Yii::app()->user->hasFlash('flash-role-save-success')) { ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('flash-role-save-success'); ?>
</div>
<?php } ?>
<?php if (Yii::app()->user->hasFlash('flash-role-save-error')) { ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('flash-role-save-error'); ?>
</div>
<?php } ?>