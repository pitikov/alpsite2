<?php
class GridButtonGroup extends CGridColumn {
  public $GridId;
  public $buttons = array(
      'edit'=>array(
	  'label'=>'Редактировать',
	  'img'=>'/images/edit.png',
	  'url'=>'#',
	  'confirm'=>null,
	  'action'=>null,
	  'id'=>null,
      ),
      'delete'=>array(
	  'label'=>'Удалить',
	  'img'=>'/images/delete.png',
	  'url'=>'#',
	  'confirm'=>'Удалить запись?',
	  'action'=>null,
	  'id'=>null,
      ),
      'up'=>array(
	  'label'=>'Поднять',
	  'img'=>'/images/up.png',
	  'url'=>'#',
	  'confirm'=>null,
  	  'action'=>null,
	  'id'=>null,
      ),
      'down'=>array(
	  'label'=>'Опустить',
	  'img'=>'/images/down.png',
	  'url'=>'#',
	  'confirm'=>null,
	  'action'=>null,
	  'id'=>null,
      ),
  );

  
  protected function renderDataCellContent($row, $data)
  {
      foreach($this->buttons as $key=>$button) {      
	  if (!isset($button['url'])) $button['url'] = Yii::app()->createUrl($button['action'], array('id'=>$data[$button['id']]));
	  $ajaxProps = array(
		  'type'=>'POST',
		  'dataType'=>'json',
		  'complete' => 'function() {$.fn.yiiGridView.update("'.$this->GridId.'")}',
		  /// @bug При данном методе обновления не обновляются скрипты, навешенные Yii (наверное CGridView-ом) на ajaxLink -и
	  );
	  if (isset($button['confirm']) and ($button['confirm']!=null)) $ajaxProps['beforeSend'] = "function() {return confirm('{$button['confirm']}')}";
          echo CHtml::ajaxLink(
	      CHtml::image($button['img'],$button['label'],array('title'=>$button['label'])),
	      $button['url'],
	      $ajaxProps,
	      array(
		  'id'=>"btn_{$data->id}_{$key}", 
	  ));	  
      }      
      parent::renderDataCellContent($row, $data);
  }
}
?>