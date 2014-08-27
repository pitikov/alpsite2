<?php /* @var $this Controller */ 

$this->beginContent('//layouts/main'); 
echo CHtml::tag('div', 
  array('class'=>'span-19'),
  CHtml::tag('div',array('id'=>'content'), $content)
);

echo CHtml::tag('div', array('class'=>'span-5 last'), CHtml::tag('div', array('id'=>'sidebar'), '',false),false);

$this->beginWidget('zii.widgets.CPortlet', array(
    'title'=>$this->menuName,
));

$this->widget('zii.widgets.CMenu', array(
    'items'=>$this->menu,
    'htmlOptions'=>array('class'=>'operations'),
));

$this->endWidget();

// Вывод рекламных банеров
if (count($this->banerList)==0) {
    echo CHtml::image('/images/banerfree.png', 'Здесь могла бы быть ваша реклама');
} else {
    foreach($this->banerList as $baner) {
	echo $baner->body;
    }
} 
// Вывод графических ссылок
if (count($this->linkList)>0) {
    foreach($this->linkList as $link) {
	echo CHtml::link(CHtml::image($link->image, $link->title), $link->url, array('title'=>$link->title));
    }
}

echo CHtml::closeTag('div');	// div#sidebar
echo CHtml::closeTag('div');	// div.span-5 last

$this->endContent(); 
?>