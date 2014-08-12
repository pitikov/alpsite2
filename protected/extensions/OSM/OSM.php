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
	'cycleMap'=>array(
	    'title'=>'ВелоКарта',
	),
	'outdor'=>array(
	    'title'=>'Outdor карта',
	),
	'high'=>array(
	    'title'=>'OutDoors карта',
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
	),
	'transport'=>array(
	    'title'=>'Общественный транспорт',
	    'points'=>array(),
	)
    );
    public $width=700;
    public $height=500;
    public $position=array('lon'=>5008810.59272, 'lat'=>7021711.41236);
    public $zoom=11;
    public $findEngine=true;
    public $search;

    public function init()
    {   

    	if ($this->findEngine) {
	    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'osmSearchDialog',
		// additional javascript options for the dialog plugin
		'options'=>array(
		    'title'=>'Поиск по карте',
		    'autoOpen'=>false,
		),
	    ));
	    echo "Поиск:".CHtml::textField('GeoSearchNode').CHtml::button('Найти',array('id'=>'GeoSearchButton')).CHtml::button('Очистить',array('id'=>'GeoSearchCleanButton'));
	    echo '<div id="GeoSearchResult"></div>';
	    $this->endWidget('zii.widgets.jui.CJuiDialog');
	    echo CHtml::link('Поиск по карте', '#', array('onclick'=>'$("#osmSearchDialog").dialog("open"); return false;',));
	} // end findEngine

	$clientScripts = Yii::app()->clientScript;
	$clientScripts->registerScriptFile('http://openlayers.org/api/OpenLayers.js');
	Yii::app()->getClientScript()->registerCoreScript('jquery'); 
	
	if (isset($this->layers['google'])) { 
	    $clientScripts->registerScriptFile("http://maps.google.com/maps/api/js?v=3&amp;sensor=false");
	} ?>
	<a name='map'>
	    <div id='<?php echo $this->id; ?>' style='width:<?php echo $this->width;?>px; height:<?php echo $this->height;?>px;'></div>
	</a>
<script>

  var map = new OpenLayers.Map('<?php echo $this->id; ?>', { controls: [], 
	projection: new OpenLayers.Projection('EPSG:900913'),
        displayProjection: new OpenLayers.Projection("EPSG:4326")
  });
  /// @todo Сделать возможным добавление слоев не по массивам а поп перечислению

  <?php if (isset($this->layers['osm'])) { ?>
  var osm = new OpenLayers.Layer.OSM("<?php if (isset($this->layers['osm']['title'])) echo $this->layers['osm']['title']; else echo "OSM карта"; ?>");
  map.addLayer(osm);
  <?php } 
  if (isset($this->layers['cycleMap'])) { ?>
  var openCycle = new OpenLayers.Layer.OSM("<?php if (isset($this->layers['cycleMap']['title'])) echo $this->layers['cycleMap']['title']; else echo "ВелоКарта"; ?>", ["http://a.tile.opencyclemap.org/cycle/${z}/${x}/${y}.png",
   "http://b.tile.opencyclemap.org/cycle/${z}/${x}/${y}.png",
   "http://c.tile.opencyclemap.org/cycle/${z}/${x}/${y}.png"]);
  map.addLayer(openCycle);
  <?php } 
  if (isset($this->layers['outdor'])) { ?>
  var outdor = new OpenLayers.Layer.OSM("<?php if (isset($this->layers['outdor']['title'])) echo $this->layers['outdor']['title']; else echo "OutDoors карта"; ?>",
      ['http://a.tile.thunderforest.com/outdoors/${z}/${x}/${y}.png',
      'http://b.tile.thunderforest.com/outdoors/${z}/${x}/${y}.png',
      'http://c.tile.thunderforest.com/outdoors/${z}/${x}/${y}.png']);
  map.addLayer(outdor);
  <?php } 
  if (isset($this->layers['transport'])) { ?>
  var transport = new OpenLayers.Layer.OSM("<?php if (isset($this->layers['transport']['title'])) echo $this->layers['transport']['title']; else echo "Общественный транспорт"; ?>",
      ['http://a.tile.thunderforest.com/transport/${z}/${x}/${y}.png',
      'http://b.tile.thunderforest.com/transport/${z}/${x}/${y}.png',
      'http://c.tile.thunderforest.com/transport/${z}/${x}/${y}.png']);
  map.addLayer(transport);
  <?php } 
  
  if ($this->findEngine) {
  ?>
  var searchLayer = new OpenLayers.Layer.Markers("Результаты поиска",{name:'searchLayer'});
  map.addLayer(searchLayer);
  searchLayer.setVisibility(false);
  <?php
  }
  ?>
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
    
  <?php if (count($this->layers)>1) { ?>
  map.addControl(new OpenLayers.Control.LayerSwitcher());
  <?php } ?>
  map.addControl(new OpenLayers.Control.ScaleLine());
  map.addControl(new OpenLayers.Control.Navigation());
  map.addControl(new OpenLayers.Control.PanZoomBar());
  <?php /** @todo Создать панель и кнопку для поиска ?>
  var toolBar = new OpenLayers.Control.Panel();
  map.addControl(toolBar);
  <?php if ($this->findEngine) { ?>
    var button = new OpenLayers.Control.Button({
	displayClass: "searchButton", trigger: searchDialog, active:true, title:'search node'
    });
    toolBar.addControls([button]);
  <?php } ?>
  <?php */ ?>
  map.addControl(new OpenLayers.Control.MousePosition({
    prefix: 'Координаты: '
  }));
  //map.addControl(new OpenLayers.Control.Attribution());
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

  var $geoNone = $("input#GeoSearchNode");
  var $searchButton = $("input#GeoSearchButton");
  var $searchresults = $("#GeoSearchResult");
  
  $searchButton.click(function(event) {
      if ($geoNone.val() == '') {
	  alert("Введите название искомого объекта");
      } else {
	  var $node = $geoNone.val();
	  searchLayer.clearMarkers();
	  $searchresults.html('');
	  /// @todo Выводить индикатор поиска
	  jQuery.getJSON('http://nominatim.openstreetmap.org/search',{q:$node, format:'json', limit:100},
	      function(data, textStatus){
		  /// @todo Убрать индикатор поиска
		  if (textStatus == 'success') {
		      $searchresults.html('<h3>Результаты поиска "'+$node+'"</h3>');
		      jQuery.each(data, function(count, item){
			  $searchresults.append('<div id="OSM'+item.osm_id+'" class="OsmSearchNode"/>');
			  var osm_node = $("#OSM"+item.osm_id);
			  if (item.icon) osm_node.append('<img src="'+item.icon+'"/>');
			  else osm_node.append('<img src="http://www.openlayers.org/dev/img/marker.png"/>');
			  var osm_id = 'OSM_POINT_'+item.osm_id;
			  osm_node.append(item.display_name);
			  osm_node.append('<br/>');
			  osm_node.append('Координаты: <a id="'+ osm_id+'" href="#map" onclick="mapToPoint(this);"><span id="'+ osm_id + '_LON">'+item.lon +'</span>; <span id="' + osm_id +'_LAT">'+item.lat+'</span></a>');
			  
			  var size = new OpenLayers.Size(21,25);
			  var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
			  if (item.icon) icon = new OpenLayers.Icon(item.icon, size, offset);
			  else var icon = new OpenLayers.Icon('http://www.openlayers.org/dev/img/marker.png', size, offset);
			  
			  var point = new OpenLayers.Geometry.Point(item.lon, item.lat);
			  //Помним что карта отображается в одной проекции, а с данными работает в другой проекции. 
			  point.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));

			  searchLayer.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(point.x,point.y),icon));
    
		      });
		      searchLayer.setVisibility(true);

		  } else {
		      alert('Ошибка обработки запросса на стороне сервера');
		      $searchresults.html('');
		  }
	      }
	  );
      }
  });
  
  $('input#GeoSearchCleanButton').click(function(){
      $searchresults.html('');
      searchLayer.setVisibility(false);
      searchLayer.clearMarkers();
  });
  
  function mapToPoint(obj) {
    var lon = $("#"+obj.id + "_LON").text();
    var lat = $("#"+obj.id + "_LAT").text();
    var point = new OpenLayers.Geometry.Point(lon, lat);
    //Помним что карта отображается в одной проекции, а с данными работает в другой проекции. 
    point.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));
    map.setCenter([point.x, point.y], map.zoom);
  }
  
  function searchDialog() {
      $("#osmSearchDialog").dialog("open");
  }
</script>
<?php 

    }
// end of init()    
    /// @todo Здесь разместить вкладки точек пользователя и маршрута
}

?>