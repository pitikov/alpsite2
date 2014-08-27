<?php
/* @var $this PwdRequestController */
/* @var $model PwdRequest */
/* @var $form CActiveForm */

array_push($this->breadcrumbs, $pagename); 
echo CHtml::tag('h1',array(),$pagename);

if (Yii::app()->user->hasFlash('registration-success')) {
    echo CHtml::tag('div', array('class'=>'flash-success'), Yii::app()->user->getFlash('registration-success'));
} else { 
    echo CHtml::tag('div', array('class'=>'form'), '', false);

    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pwd-request-endregistration-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
    ));

    echo CHtml::tag('p', array('class'=>'note'), 'Поля, отмеченные '. CHtml::tag('span', array('class'=>'required'), '*').', обязательны для заполнения.');
    echo $form->errorSummary($model);

    echo CHtml::tag('div', array('id'=>'row'), 
	$form->labelEx($model,'password'). 
	$form->passwordField($model,'password').
	$form->error($model,'password')
    );
    echo CHtml::tag('div', array('id'=>'row'), 
	$form->labelEx($model,'password_confirm'). 
	$form->passwordField($model,'password_confirm').
	$form->error($model,'password_confirm')
    );
    echo CHtml::tag('div', array('class'=>"row buttons"), CHtml::submitButton('Сохранть пароль'));
    $this->endWidget(); 
	
    echo CHtml::closeTag('div'); //form
} 
?>