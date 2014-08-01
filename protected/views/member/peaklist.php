<?php
/* @var $this MemberController */
$pagename = 'Список восхождений';
array_push($this->breadcrumbs, $pagename);
?>
<h1><?php echo $pagename;?></h1>

<?php 
$this->widget('zii.widgets.grid.CGridView', 
    array(
	'dataProvider'=>$peaklist,
    )
);

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'AddMountaringDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Добавить восхождение',
        'autoOpen'=>false,
    ),
));
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'mountaring-mountaring-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>true,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'date'); ?>
        <?php echo $form->textField($model,'date'); ?>
        <?php echo $form->error($model,'date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'route'); ?>
        <?php echo $form->textField($model,'route'); ?>
        <?php echo $form->error($model,'route'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textField($model,'description'); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Создать'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php 
$this->endWidget('zii.widgets.jui.CJuiDialog');

echo CHtml::link('Добавить восхождение', '#', array(
   'onclick'=>'$("#AddMountaringDialog").dialog("open"); return false;',
));
?>