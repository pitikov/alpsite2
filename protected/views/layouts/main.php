<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="ru" xml:lang="ru">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta http-equiv="content-language" content="ru" />
<?php
// @note используем доктайп HTML5 и статичную информацию выводим без использования PHP
/*
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
*/

echo CHtml::tag('title', array(), CHtml::encode($this->pageTitle));

$clientScript = Yii::app()->clientScript;

// @note Для осликов младше 9-ки добавляем элементы HTML5 для совместимости
echo '
<!-- [if lt IE 9]>
<script>
var e = ("abbr,article,aside,audio,canvas,datalist,details," +
"figure,footer,header,hgroup,mark,menu,meter,nav,output," +
"progress,section,time,video").split(',');
for (var i = 0; i < e.length; i++) {
document.createElement(e[i]);
} </script>
<![endif]-->'.PHP_EOL;

// @todo Сделать CSS main - общие элементы стиля, desctop, mobile и print - верстка и т.п. специфичные для устройств
echo '
<link rel="stylesheet" type="text/css" href="/css/main.css" />
<link rel="stylesheet" type="text/css" href="/css/desktop.css" media="only screen and (min-device-width: 1000px)" />
<link rel="stylesheet" type="text/css" href="/css/mobile.css" media="only handheld, screen and (max-device-width: 480px)" />
<link rel="stylesheet" type="text/css" href="/css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="/css/form.css" />
';

// @note Подключение is.css только для ie младше 8 с использованием метаязыка браузера
echo '
<!-- [if lt IE 8]>'.PHP_EOL;
//$clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/ie.css', "screen");
echo '<![endif]-->'.PHP_EOL;

?>
</head>
<body>
<?php

echo CHtml::tag('div', array('class'=>'container', 'id'=>'page'),
	CHtml::tag('div', array('id'=>'header'), 
	    CHtml::tag('div', array('id'=>'logo'), CHtml::encode(Yii::app()->name))
	),false);
	
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

//echo CHtml::closeTag('body');
//echo CHtml::closeTag('html');
?>
</body>
</html>
