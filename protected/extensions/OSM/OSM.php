<?php
/** @author Pitikov E.A. <pitikov@yandex.ru>
* @brief OSM extension to Yii framefwork
    */
class OSM extends CWidget {
    
    /** @property $options Списое специальных свойств OpenLayers в форамте массива 'optionName'=>'optionValue' */
    public $options = array();
    
    /** @property $id Имя идентификатора контейнера */
    public $id = 'OpenStreetMapCanvas';
    
    public $layers=array(
	'osm'=>array(
	    'title'=>'OpenStreetMap',
	),
	'google'=>array(
	    'title'=>'GoogleMaps гибрид'
	), 
	'markers'=>array(
	    'title'=>'Точки пользователя',
	    'points'=>array(),
	),
	'route'=>array(
	    'title'=>'Маршруты',
	    'points'=>array(),
	)
    );
    public $width=700;
    public $height=500;
    public $position=array('lon'=>5008810.59272, 'lat'=>7021711.41236);
    public $zoom=11;
    public $findEngine=false;

    public function init()
    {   
    if ($this->findEngine) {
?>
<b>Поиск:</b><input type='text' value='Введите название и нажмите "ввод"'/>
<div id='find_return'>
<!-- Здесь разместить вывод результатов поиска -->
</div>
<?php } // end findEngine ?>
<script src="http://openlayers.org/api/OpenLayers.js"></script>
<?php if (isset($this->layers['google'])) { ?>
  <script src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
<?php } ?>
<div id='<?php echo $this->id; ?>' style='width:<?php echo $this->width;?>px; height:<?php echo $this->height;?>px;'></div>
<script>

  var map = new OpenLayers.Map('<?php echo $this->id; ?>', { controls: [] });

  <?php if (isset($this->layers['osm'])) { ?>
  var osm = new OpenLayers.Layer.OSM("<?php if (isset($this->layers['osm']['title'])) echo $this->layers['osm']['title']; else echo "OSM карта"; ?>");
  map.addLayer(osm);
  <?php } ?>


  <?php if (isset($this->layers['google'])) { ?>
 
  var gmap = new OpenLayers.Layer.Google("<?php if (isset($this->layers['google']['title'])) echo $this->layers['google']['title']; else echo "GoogleMaps гибрид"; ?>",
                {type: google.maps.MapTypeId.HYBRID, numZoomLevels: 20}
            );
  map.addLayer(gmap);
  <?php } ?>
  <?php if (isset($this->layers['markers'])) { ?>

  var markers = new OpenLayers.Layer.Markers("Точки пользователя");
  map.addLayer(markers);
  
  <?php } ?>
  
  <?php if (isset($this->layers['route'])) { ?>

  var routes = new OpenLayers.Layer.PointTrack("Маршруты");
  map.addLayer(routes);
  
  <?php } ?>
    
  // В дальнейшем сделать проверку на количество слоев на карте и всавлять, если список слоев содержит более одного слоя
  <?php if (count($this->layers)>1) { ?>
  map.addControl(new OpenLayers.Control.LayerSwitcher());
  <?php } ?>
  map.addControl(new OpenLayers.Control.ScaleLine());
  map.addControl(new OpenLayers.Control.Navigation());
  map.addControl(new OpenLayers.Control.PanZoomBar());
  map.addControl(new OpenLayers.Control.MousePosition({
    prefix: 'Координаты: '
    }
));
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
  map.setCenter([<?php echo $this->position['lon']; ?>, <?php echo $this->position['lat']; ?>],<?php echo $this->zoom; ?>);
  
  
</script>
<?php }
// end of init()    
    /// @todo Здесь разместить вкладки точек пользователя и маршрута
}

?>