<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<?php
echo CHtml::tag('html', array(
    'xmlns'=>"http://www.w3.org/1999/xhtml",
    'xml:lang'=>"ru",
    'lang'=>"ru"
    ),null, false);
echo CHtml::tag('head',array(),
    CHtml::tag('meta', array('http-equiv'=>'Content-Type', 'content'=>'text/html; charset=utf-8')).
    CHtml::tag('meta', array('name'=>'language', 'content'=>'ru')).
    CHtml::tag('title', array(), CHtml::encode($this->pageTitle))
);

$clientScript = Yii::app()->clientScript;
$clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/screen.css', "screen, projection");
$clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/print.css', 'print');
/// @todo Подключение is.css только для ie младше 8
//$clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/ie.css', "screen, projection");
$clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/main.css');
$clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/form.css');
$clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/alpsite.css');

echo CHtml::tag('body',array(),
    CHtml::tag('div', array('class'=>'container', 'id'=>'page'),
	CHtml::tag('div', array('id'=>'header'), 
	    CHtml::tag('div', array('id'=>'logo'), CHtml::encode(Yii::app()->name))
	),false),false);
	
	echo CHtml::tag('div', array('id'=>'mainmenu'), null, false);
	    $this->widget('zii.widgets.CMenu',array(
		'items'=>array(
		    array('label'=>'Федерация Альпинизма Пензенской Области', 'url'=>array('/federation/index')),
		    array('label'=>'Альпклуб "Пенза"', 'url'=>array('/club/calendar')),
		    array('label'=>'Войти', 'url'=>array('/member/login'), 'visible'=>Yii::app()->user->isGuest),
		    array('label'=>'Регистрация', 'url'=>array('/member/registration'), 'visible'=>Yii::app()->user->isGuest),
		    array('label'=>Yii::app()->user->name, 'url'=>array('/member/profile'), 'visible'=>!Yii::app()->user->isGuest),
		    array('label'=>'Выйти', 'url'=>array('/member/logout'), 'visible'=>$this->isUser())
		),
	    ));
	echo CHtml::closeTag('div'); // div#mainmenu
		
	
	if(isset($this->breadcrumbs)):
		$this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		));
	endif;

	// Выводим контент
	echo $content;
	
	// Подчищаем
	echo CHtml::tag('div', array('class'=>"clear"));
	
	// Выводим подвал
	echo CHtml::tag('div', array('id'=>'footer'), 
	    'Copyright &copy; 2014, by E.A.Pitikov'. CHtml::tag('br').
	    'All Rights Reserved'.CHtml::tag('br').Yii::powered()
	);
    echo CHtml::closeTag('div'); // div#page
echo CHtml::closeTag('body');
	
echo CHtml::closeTag('html');
