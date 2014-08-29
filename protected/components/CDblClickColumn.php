<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CDblClickColumn extends CDataColumn {
    public $onDblClick;
    public $key;


    protected function renderDataCellContent($row, $data) {
        echo CHtml::tag('div', array(
            'class'=>'DataCell', 
            'ondblclick'=>  "{$this->onDblClick}({$data->attributes[$this->key]})",
            ),null, false);
        parent::renderDataCellContent($row, $data);
        echo CHtml::closeTag('div');                
    }
}
