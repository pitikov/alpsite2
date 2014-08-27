<?php
$pagename = 'Книга выходов';

array_push($this->breadcrumbs, $pagename);

echo CHtml::tag('h1', array(), $pagename);

echo 'На данной странице будет отображаться журнал восхождений';
?>