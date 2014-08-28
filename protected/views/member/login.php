<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
array_push($this->breadcrumbs, 'Авторизация');

echo CHtml::tag('h1', array(), 'Авторизация пользователя');
echo CHtml::tag('p', array(), 'Введите свои учетные данные для входа на сайт:');

echo CHtml::tag('div', array('class'=>'form'), null, false);

    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
	    'validateOnSubmit'=>true,
	),
    ));
    
    echo CHtml::tag('p', array('class'=>'note'), 
	'Поля, отмеченные'.CHtml::tag('span', array('class'=>'required'), '*').', обязательны для заполнения.'
    );
    
    echo CHtml::tag('div', array('class'=>'row'),
	$form->labelEx($model, 'username').$form->textField($model,'username').$form->error($model,'username')
    );

    echo CHtml::tag('div', array('class'=>'row'),
	$form->labelEx($model, 'password').$form->passwordField($model,'password').$form->error($model,'password')
    );

    echo CHtml::tag('div', array('class'=>'row rememberMe'),
	$form->checkBox($model, 'rememberMe')." ".$form->label($model,'rememberMe').$form->error($model,'rememberMe')
    );
    
    echo CHtml::link('Восстановить пароль', array($this->id.'/pwdrestore'));
    
    echo CHtml::tag('div', array('class'=>'row buttons'), CHtml::submitButton('Войти'));

    $this->endWidget();
    
echo CHtml::closeTag('div'); //form

?>