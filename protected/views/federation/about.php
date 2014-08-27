<?php
$pagename = 'О федерации';

array_push($this->breadcrumbs, $pagename);

echo CHtml::tag('h1',array(), $pagename);
echo CHtml::tag('div', array('class'=>'article', 'id'=>'about'), $body);

?>