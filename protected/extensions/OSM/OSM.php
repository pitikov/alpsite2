<?php
/** @author Pitikov E.A. <pitikov@yandex.ru>
* @brief OSM extension to Yii framefwork
    */
class OSM extends CWidget {
    
    public $options = array();
    public $id = 'OpenStreetMapCanvas';
    protected $_assets_path = null;
    
    /** @return Каталог assets для данного расширения */
    protected function getAssetsPath()
    {
	if ($this->_assets_path===null) $this->_assets_path = dirname(__FILE__) . '/assets';
	return $this->_assets_path;
    }
    
    public function init()
    {
	echo "<scripts src='{$this->getAssetsPath()}/OpenLayers.js' type='text/javascript'/>";
	echo "<div id='demoMap'></div>";
	echo "<script>map = new OpenLayers.Map('demoMap');".
	     "map.addLayer(new OpenLayers.Layer.OSM());".
	     "map.zoomToMaxExtent();".
	     "</script>";

    }
    
}

?>