<?php
/* @var $this AdminController */

$this->breadcrumbs=array(
	'Admin'=>array('/admin'),
	'Database',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
<?php
$this->widget('ext.easymap.EasyMap', array(
    'key' => '', /*Insert your developer API key for google map*/
    'id' => 'newmap', /*This is the id of the map wrapper div*/
    'latitude' => '44.572646000000000000', /*Place Latitude*/
    'longitude' => '44.5763894999999950000', /*Place Longitude*/
    'maptype' => 'HYBRID', /*ROADMAP, SATELITE, HYBRID, TERRAIN*/
    'zoom' => '10', /*Zoom level. Default is 7*/
    'width' => '700', /*Map height*/
    'height' => '600', /*Map width*/
    'markertitle' => '', /*Title of the place marker*/
));?>