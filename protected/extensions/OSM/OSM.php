<?php
/** @author Pitikov E.A. <pitikov@yandex.ru>
* @brief OSM extension to Yii framefwork
    */
class OSM extends CWidget {
    
    /** @property $options Списое специальных свойств OpenLayers в форамте массива 'optionName'=>'optionValue' */
    public $options = array();
    
    /** @property $id Имя идентификатора контейнера */
    public $id = 'OpenStreetMapCanvas';
    
    protected $layers=array('osm'=>array(), 'google'=>array(), 'markers'=>array(), 'wms'=>array(), 'route'=>array());
    protected $width=700;
    protected $height=500;

    public function init()
    {    
?>
<script src="http://openlayers.org/api/OpenLayers.js"></script>
<?php if (isset($this->layers['google'])) { ?>
<script src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
<?php } ?>
<div id='<?php echo $this->id; ?>' style='width:<?php echo $this->width;?>px; height:<?php echo $this->height;?>px;'></div>
<script>

  var map = new OpenLayers.Map('<?php echo $this->id; ?>', { controls: [] });

  <?php if (isset($this->layers['osm'])) { ?>
  var osm = new OpenLayers.Layer.OSM("OSM карта");
  map.addLayer(osm);
  <?php } ?>


  <?php if (isset($this->layers['google'])) { ?>
 
  var gmap = new OpenLayers.Layer.Google("Google Hybrid",
                {type: google.maps.MapTypeId.HYBRID, numZoomLevels: 20}
            );
  map.addLayer(gmap);
  <?php } ?>
  <?php if (isset($this->layers['markers'])) { ?>

  var markers = new OpenLayers.Layer.Markers("Точки пользователя");
  map.addLayer(markers);
  
  <?php } ?>
    
  // В дальнейшем сделать проверку на количество слоев на карте и всавлять, если список слоев содержит более одного слоя
  <?php if (count($this->layers)>1) { ?>
  map.addControl(new OpenLayers.Control.LayerSwitcher());
  <?php } ?>
  map.addControl(new OpenLayers.Control.ScaleLine());
  map.addControl(new OpenLayers.Control.Navigation());
  map.addControl(new OpenLayers.Control.PanZoomBar());
  map.addControl(new OpenLayers.Control.MousePosition());
  map.addControl(new OpenLayers.Control.Attribution());
  map.addControl(new OpenLayers.Control.ArgParser());   

  /** Marker example
  @code 
  var size = new OpenLayers.Size(21,25);
  var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
  var icon = new OpenLayers.Icon('http://www.openlayers.org/dev/img/marker.png', size, offset);
  markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(0,0),icon));
  markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(0,0),icon.clone()));
  @endcode
*/
  map.zoomToMaxExtent();
</script>
	     
	 <?php

    }
    
    
    public function __construct($owner = null, $params = null )
    {
	if (is_array($params)) {
	    if (isset($params['id']) and is_string($params['id'])) $this->id = $params['id'];
	}
        parent::__construct($owner);
    }
    
    
}

?>