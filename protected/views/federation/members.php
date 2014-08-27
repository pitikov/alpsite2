<?php
/* @var $this FederationController */
$pagename = 'Члены федерации';
array_push($this->breadcrumbs, $pagename);

echo CHtml::tag('h1', array(), $pagename);

/// @todo Использовать CListView
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
	'photo', 'name',
	array(
	    'name'=>'role',
	    'value'=>'$data->roles->title',
	), 
	'memberfrom', 'memberto'
    )
    
));
?>
