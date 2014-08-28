<?php
/* @var $this FederationController */
$pagename = 'Члены федерации';
array_push($this->breadcrumbs, $pagename);

echo CHtml::tag('h1', array(), $pagename);

/// @todo Использовать CListView
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
	array(
	    'name'=>'photo',
	    'value'=>'CHtml::image("$data->photo","$data->name",array("width"=>"60px"))',
	    'type'=>'raw'
	),
	'name',
	array(
	    'name'=>'role',
	    'value'=>'isset($data->roles)?$data->roles->title:""',
	), 
	'memberfrom', 'memberto'
    )
    
));
?>
