<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Guide
 *
 * @author evgeniy
 */
class Guide extends CWidget {
    
    public $editable = false;
    public function init() {
        $assets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.Guide.assets'));
        
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($assets.'/Guide.js');
        $cs->registerCssFile($assets.'/Guide.css');
        
        echo CHtml::tag('div', array('id'=>$this->id, 'class'=>'mountaring-guide'), null, false);
        echo CHtml::hiddenField("assets", $assets);
        echo CHtml::tag('h3',array(),'Классификатор маршрутов на горные вершины');

        echo CHtml::image('/images/new.png', 'Добавить маршрут', array(
            'onclick'=>'addRoute();',
            'title'=>'Добавить описание маршрута'
        ));

        
        echo CHtml::tag('div', array('id'=>'region-list'),null);
        
        echo CHtml::closeTag('div');
        echo CHtml::script('getRegions();');
        parent::init();
        
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'RouteEditDialog',
            'options'=>array(
		    'title'=>'Классификатор',
		    'autoOpen'=>false,
                    'buttons'=>array(
                        array('text'=>'Сохранить', 'click'=>'js:function(){saveRoute()}'),
                        array('text'=>'Отмена', 'click'=>'js:function(){$("#RouteEditDialog").dialog("close");}'),
                    ),
                    'width'=>'800px'
		),
        ));
        echo CHtml::hiddenField('mountainId');
        echo CHtml::tag('div', array('id'=>'routeLocation'), 
                CHtml::tag('div', array('class'=>"row"), 
                        CHtml::label('Регион', 'mountaringRegions').
                        CHtml::dropDownList('mountaringRegions', null, array(), array('onchange'=>'regionChanged();')).
                        CHtml::image('/images/new.png', 'Добавить регион', array('onclick'=>'addNewRegion()'))
                        ).
                CHtml::tag('div', array('class'=>"row"), 
                        CHtml::label('Район', 'mountaringSubRegions').
                        CHtml::dropDownList('mountaringSubRegions', null, array()).
                        CHtml::image('/images/new.png', 'Добавить район', array('onclick'=>'addNewSubRegion()'))
                        ).
                CHtml::tag('div', array('class'=>"row"), 
                        CHtml::label('Вершина', 'mountaringMountain').
                        CHtml::dropDownList('mountaringMountain', null, array()).
                        CHtml::image('/images/new.png', 'Добавить вершину', array('onclick'=>'addNewMountain()'))
                        ).
                CHtml::tag('hr')
                );
        echo CHtml::tag('div', array('id'=>'route-detail'),
                CHtml::tag('div', array('class'=>'row'), 
                        CHtml::label('маршрут', 'RouteTitle').
                        CHtml::textField('RouteTitle')
                        ).
                CHtml::tag('div', array('class'=>'row'), 
                        CHtml::label('КС', 'RouteDifficulty').
                        CHtml::dropDownList('RouteDifficulty', null, array(
                            '1Б','2А','2Б','3А','3Б','4А','4Б','5А','5Б','6А','6Б'
                        )).
                        CHtml::label('зимний', 'RouteWinter').
                        CHtml::checkBox('RouteWinter', false)
                        ).
                CHtml::tag('div', array('class'=>'row'), 
                        CHtml::label('автор', 'RouteAuthor').
                        CHtml::textField('RouteAuthor').
                        CHtml::label('год', 'RouteYear').
                        CHtml::numberField('RouteYear').
                        CHtml::label('тип', 'RouteType').
                        CHtml::dropDownList('RouteType',3,array(1=>'Ск', 2=>'ЛС', 3=>'К'))
                        )
                ,false);
        echo CHtml::label('описание', 'RouteDescription');
        $this->widget('ImperaviRedactorWidget', array(
		'name' => 'RouteDescription',
		
		// Some options, see http://imperavi.com/redactor/docs/
		'options' => array(
		    'lang' => 'ru',
		    'toolbar' => true,
		    'iframe' => false,
		    'css' => 'wym.css',
		  ),
		));
        echo CHtml::closeTag('div');
        
        $this->endWidget();
    }
}
?>

<script type="text/javascript">
    
    function getRegions() {
        $.ajax({
            url:'/index.php/guide/getregions',
            success: function (data, textStatus, jqXHR) {
                data.forEach(function (region, count, array) {
                    insetRegion(region);
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                        alert('Что-то пошло не так.\nЗапрос списка регионов вернул: '+errorThrown);
                    },
            dataType: 'json',
            type: 'POST'
        });
    }
    
    function insetRegion(region) {
        regionList = $('#region-list');
        var existed = $('#region_'+region.id);
        var select = $('#mountaringRegionSelect_'+region.id);

        if (existed.length) {
            //alert ('Update record '+region.title);
            select.removeAttr('selected');
            select.html(region.title);

            ///@todo update existed record
        } else {
            if (region.description === null) region.description = '';
            regionList.append('<div id = "region_'+region.id+'"/>');
            $('#region_'+region.id).append('<h4 class="region-title" onclick="getSubregions('+region.id+')">'+region.title+"</h4>");
            $('#region_'+region.id).append('<div class="region-contetnt" id="region-content_'+region.id+'"/>');
            if (select.length) {
            } else {
                $('#mountaringRegions').append('<option id="mountaringRegionSelect_'+region.id+'" value='+region.id+' selected="selected">'+region.title+'</option>');
                $('#mountaringRegions').select(region.id);
            }
        }
    }
    
    function getSubregions(region) {
        if ($('#region-content_'+region).html()!=='') {
            $('#region-content_'+region).html('');
        } else {
            $.ajax({
               url:'/index.php/guide/getsubregions',
               data: {'regionId':region},
               type: 'POST',
               dataType: 'json',
               success: function (data, textStatus, jqXHR) {
                   if(data.length) {
                       $('#region-content_'+region).html('');
                       data.forEach(function (subregion, count, array) {
                           insertSubregion(subregion);
                       });
                   } else {
                       $('#region-content_'+region).html('<div class="empty-content">Не информации о районах</div>');
                   }
               },
               error: function (jqXHR, textStatus, errorThrown) {
                   $('#region-content_'+region).html('<div class="flash-error">Ошибка получения данных</div>');
                   alert('Что-то пошло не так. Запросс районов вернул: '+errorThrown);
               },
               beforeSend: function (xhr) {
                   var assets = $('#assets').val();
                   $('#region-content_'+region).html('<img src = "'+assets+'/progress.gif">');
               }
            });
        }
    }
    
    function insertSubregion(subregion) {
        var subregionList = $('#region-content_'+subregion.region);
        if ($('#subregion_'+subregion.id).length) {
            /// @todo Обновить запись
        } else {
            subregionList.append('<div class="subregion" id="subregion_'+subregion.id+'"/>');
            $('#subregion_'+subregion.id).append('<h5 class="subregion-title" onclick="getMountains('+subregion.id+')">'+subregion.title+'</h5>');
            //$('#subregion_'+subregion.id).append('<p class="subregion-about note" onclick="getMountains('+subregion.id+')">'+subregion.description+'</p>');

            $('#subregion_'+subregion.id).append('<div class="subregion-contetnt" id="subregion-content_'+subregion.id+'"/>');

        }
    }
    
    function getMountains(subregion) {
        var subregionContent = $('#subregion-content_'+subregion);
        if (subregionContent.html()!=='') {
            subregionContent.html('');
        } else {
            $.ajax({
                url:'/index.php/guide/getmountains',
                data:{'subregionId':subregion},
                dataType: 'json',
                type: 'POST',
                beforeSend: function (xhr) {
                    var assets = $('#assets').val();
                    subregionContent.html('<img src = "'+assets+'/progress.gif">');
                },
                success: function (data, textStatus, jqXHR) {
                        if (data.length) {
                            subregionContent.html('');
                            data.forEach(function (mountain, count, array) {
                                insertMountain(mountain);
                       });
                        } else {
                            subregionContent.html('<div class="empty-content">Не информации о вершинах района</div>');
                        }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    subregionContent.html('<div class="flash-error">Ошибка получения данных</div>');
                    alert('Что-то пошло не так. Запросс вершин района вернул: '+errorThrown);

                }
            });
        }
    }
    
    function insertMountain(mountain)
    {
        var mountainItem = $('#mountain_'+mountain.id);
        var subregionContent = $('#subregion-content_'+mountain.subregion);
        if (mountainItem.length) {
            /// @todo Update moumountainItem record
        } else {
            subregionContent.append('<div class="mountain" id="mountain_'+mountain.id+'"/>');
            mountainItem = $('#mountain_'+mountain.id);
            mountainItem.append('<h6 class="mountain-title" onclick="getRoutes('+mountain.id+')">'+mountain.title+'</h6>');
            // mountainItem.append('<div class="mountain-lonlat"><span class="lon">'+mountain.lon+'</span>, <span class="lat">'+mountain.lat+'</span></div>');
            mountainItem.append('<div class="mountain-routes" id="mountain-routes_'+mountain.id+'"/>');

        }
    }
    
    function getRoutes(mountain) {
        var mountainRoutes = $('#mountain-routes_'+mountain);
        if (mountainRoutes.html()==='') {
            $.ajax({
                url:'/index.php/guide/getroutes',
                data:{'mountainId':mountain},
                dataType: 'html',
                type: 'POST',
                success: function (data, textStatus, jqXHR) {
                    mountainRoutes.html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                        
                },
                beforeSend: function (xhr) {
                    var assets = $('#assets').val();
                    mountainRoutes.html('<img src = "'+assets+'/progress.gif">');                        
                }
            });
        } else {
            mountainRoutes.html('');
        }
    }
    
    function addRoute(mountain) {
        dialogPrepare();
        $('#RouteEditDialog').dialog('open');
    }
    
    function saveRoute() {
        alert('Implict me, please.');
    }
    
    function addNewRegion() {
        var region = prompt('Введите название региона');
        if (region.length) {
            $.ajax({
                url:'/index.php/guide/addregion',
                data:{'region':region},
                success: function (data, textStatus, jqXHR) {
                    getRegions();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Ошибка добавления региона');
                }
            });
        }
    }
         
    function addNewSubRegion() {
        var subregion = prompt('Введите название района');
        if (subregion.length) {
            $.ajax({
                url:'/index.php/guide/addsubregion',
                dataType: 'json',
                type: 'GET',
                data:{
                    'region':$('#mountaringRegions').val(),
                    'subregion':subregion
                },
                success: function (data, textStatus, jqXHR) {
                    getSubregions($('#mountaringRegions').val());
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Ошибка добавления района');
                }
            });
        }    
    }
    
    function addNewMountain() {
        alert('Implict me, please.');
    }
    
    function dialogPrepare() {
        $('#mountainId').val(0);
       
    }
    
    function regionChanged() {
        getSubregions($('#mountaringRegions').val());
        if ($('#region-content_'+$('#mountaringRegions').val()).html()==='') getSubregions($('#mountaringRegions').val());
    }
</script>
