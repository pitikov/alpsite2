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
	'outdoor'=>array(
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
    /// @todo Для унификации принимать данные в utm проекции
    public $position=array('lon'=>5008810.59272, 'lat'=>7021711.41236);
    public $zoom=11;
    public $findEngine=true;
    public $search;
    
    public function init()
    {   
	$clientScripts = Yii::app()->clientScript;
	$clientScripts->registerScriptFile('http://openlayers.org/api/OpenLayers.js');
	Yii::app()->getClientScript()->registerCoreScript('jquery'); 
	if (isset($this->layers['google'])) { 
	    $clientScripts->registerScriptFile("http://maps.google.com/maps/api/js?v=3&amp;sensor=false");
	}

    	if ($this->findEngine) {
	    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'osmSearchDialog',
		// additional javascript options for the dialog plugin
		'options'=>array(
		    'title'=>'Поиск по карте',
		    'autoOpen'=>false,
		),
	    ));	   
	    echo "Поиск:".CHtml::textField('GeoSearchNode', $this->search).CHtml::button('Найти',array('id'=>'GeoSearchButton')).CHtml::button('Очистить',array('id'=>'GeoSearchCleanButton'));
	    echo '<div id="GeoSearchResult"></div>';
	    $this->endWidget('zii.widgets.jui.CJuiDialog');
	    echo CHtml::link('Поиск по карте', '#', array('onclick'=>'$("#osmSearchDialog").dialog("open"); return false;',));
	} // end findEngine
	
	 ?>
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
  if (isset($this->layers['outdoor'])) { ?>
  var outdoor = new OpenLayers.Layer.OSM("<?php if (isset($this->layers['outdoor']['title'])) echo $this->layers['outdoor']['title']; else echo "OutDoors карта"; ?>",
      ['http://a.tile.thunderforest.com/outdoors/${z}/${x}/${y}.png',
      'http://b.tile.thunderforest.com/outdoors/${z}/${x}/${y}.png',
      'http://c.tile.thunderforest.com/outdoors/${z}/${x}/${y}.png']);
  map.addLayer(outdoor);
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

  map.setCenter([<?php echo $this->position['lon']; ?>, <?php echo $this->position['lat']; ?>],<?php echo $this->zoom; ?>);
 
  var popup;
  map.events.register('click', map, function(e){
      if (popup) map.removePopup(popup);
      var whatThis = map.getLonLatFromViewPortPx(e.xy);
      var whatThis2 = whatThis.clone().transform(map.projection, map.displayProjection);
      jQuery.getJSON('http://nominatim.openstreetmap.org/reverse',
	  {format:'json', addressdetails:1, lat:whatThis2.lat, lon:whatThis2.lon,zoom:map.getZoom(), osm_type:'N'},
	  function(data, textStatus){
 	      popup = new OpenLayers.Popup(data.osm_id, whatThis, new OpenLayers.Size(200,100), data.display_name, true);
 	      //popup.autoSize = true;
 	      popup.minSize = new OpenLayers.Size(150,30);
 	      popup.minSize = new OpenLayers.Size(200,300);
 	      popup.closeOnMove = false;
 	      map.addPopup(popup);
	  });
  });

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
	  var $viewport = map.getExtent().transform(map.projection, map.displayProjection);
	  /** @todo Выводить индикатор поиска
	  @todo Добавить возможность тонкой настройки поиска (ограничение по классу/типу искомого объекта, а так-же поиск по видимой терретории) */
	  jQuery.getJSON('http://nominatim.openstreetmap.org/search',{q:$node, format:'json', limit:100},
	      function(data, textStatus){
		  /// @todo Убрать индикатор поиска
		  if (textStatus == 'success') {
		      $searchresults.html('<h3>Результаты поиска "'+$node+'"</h3>');
		      jQuery.each(data, function(count, item){
			  $searchresults.append('<div id="OSM'+item.osm_id+'" class="OsmSearchNode" item_class="'+ item.class+'"item_type="'+item.type+'" osm_type="'+item.osm_type+'" osm_id = "'+item.osm_id+'" place_id="'+item.place_id+'" importance="'+item.importance+'" />');
			  var osm_node = $("#OSM"+item.osm_id);
			  /// @todo По типу/виду найденного объекта при необходимости формировать префикс
			  /// @todo при отсутствии иконки от поисковика по типу виду найденного объекта подставить иконку из имеющихся
			  if (!item.icon) item.icon = "http://www.openlayers.org/dev/img/marker.png";
			  osm_node.append('<img src="'+item.icon+'"/>');
			  var osm_id = 'OSM_POINT_'+item.osm_id;
			  if (item.type == 'river') osm_node.append('Река ');
			  osm_node.append(item.display_name);
			  osm_node.append('<br/>');
			  osm_node.append('Координаты: <a id="'+ osm_id+'" href="#map" onclick="mapToPoint(this);"><span id="'+ osm_id + '_LON">'+item.lon +'</span>; <span id="' + osm_id +'_LAT">'+item.lat+'</span></a>');
			  
			  var size = new OpenLayers.Size(21,25);
			  var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
			  icon = new OpenLayers.Icon(item.icon, size, offset);
			  
			  var point = new OpenLayers.Geometry.Point(item.lon, item.lat);
			  //Помним что карта отображается в одной проекции, а с данными работает в другой проекции. 
			  point.transform(map.displayProjection, map.projection);

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
    point.transform(map.displayProjection, map.projection);
    map.setCenter([point.x, point.y], map.zoom);
  }
    
</script>
<?php 

    }
// end of init()    
    
}

?>