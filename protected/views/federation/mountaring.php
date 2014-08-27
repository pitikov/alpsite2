<?php
$pagename = 'Книга выходов';

array_push($this->breadcrumbs, $pagename);

echo CHtml::tag('h1', array(), $pagename);

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'MountaringList',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
	array(
	    'value'=>'$row+1'
	),
	'date',
	array(
	    'header'=>'на вершину',
	    'value'=>'$data->mountaringRoute->RouteMountain->title'
	),
	array(
	    'header'=>'по маршруту',
	    'value'=>'$data->mountaringRoute->title'
	),
	'Composition'
    ),
    'emptyText'=>CHtml::tag('div', array('id'=>'mountaring_list_empty'), 'Зарегистрированных восхождений не найденно')
));
?>