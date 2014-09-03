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
        echo CHtml::tag('h3',array(),'Классификатор маршрутов на горные вершины');
        
        echo CHtml::tag('div', array('id'=>'region-list'),null);
        
        echo CHtml::closeTag('div');
        echo CHtml::script('getRegions();');
        parent::init();
    }
}
?>

<script type="text/javascript">
    
    function getRegions() {
        $.ajax({
            url:'/index.php/federation/getregions',
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
        if (existed.length) {
            alert ('Update record '+region.title);
        } else {
            if (region.description === null) region.description = '';
            regionList.append('<div id = "region_'+region.id+'"/>');
            $('#region_'+region.id).append('<h4 class="region-title" onclick="getSubregions('+region.id+')">'+region.title+"</h4>");
            //$('#region_'+region.id).append('<div class="region-about" id="region-about_'+region.id+'">'+region.description+'</div>');
            $('#region_'+region.id).append('<div class="region-contetnt" id="region-content_'+region.id+'"/>');
        }
    }
    
    function getSubregions(region) {
        if ($('#region-content_'+region).html()!=='') {
            $('#region-content_'+region).html('');
        } else {
            $.ajax({
               url:'/index.php/federation/getsubregions',
               data: {'regionId':region},
               type: 'POST',
               dataType: 'json',
               success: function (data, textStatus, jqXHR) {
                   $('#region-content_'+region).html('Все хорошо');

                    },
               error: function (jqXHR, textStatus, errorThrown) {
                   alert('Что-то пошло не так. Запросс районов вернул: '+errorThrown);
                   $('#region-content_'+region).html('<div class="flash-error">Ошибка получения данных</div>');
                    },
               beforeSend: function (xhr) {
                   $('#region-content_'+region).html('Ждите ответа');
                    }
            });
        }
    }
    
</script>
