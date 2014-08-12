<?php
/* @var $this AdminController */

$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Database',
);
?>

<?php 
    $this->widget('ext.OSM.OSM', array('findEngine'=>true, 'layers'=>array('osm'=>array(),'google'=>array(), 'outdor'=>array('label'=>'Outdor карта'))));
?>