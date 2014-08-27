<?php
/** 
*/
class Calendar extends CWidget {

  public $title;
  public $caption;
  public $date;
  
  private $_tags = array();

  public function init()
  {
    $assets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.Calendar.assets'));
    $cs = Yii::app()->clientScript;
    $cs->registerCoreScript('jquery');
    $cs->registerScriptFile($assets.'/Calendar.js');
    $cs->registerCssFile($assets.'/Calendar.css');
    $now = date_create('now');
    
    if ($this->date===null) $this->date=$now;
    $date = $this->date;
    
    if ($this->caption === null) {
      $this->caption = 'Календарь';
      if ($this->title !== null) {
	$this->caption = "{$this->caption} \"{$this->title}\"";
      }
    }
    echo CHtml::tag('div', array('id'=>$this->id, 'class'=>'CalendarWidget'), false);
    echo CHtml::tag('table', array('id'=>$this->id, 'class'=>'Calendar'), false);
    echo CHtml::tag('caption', 
	array('class'=>'Calendar'),
	CHtml::tag('h3', array(), $this->caption). 
	CHtml::tag('span', 
	    array('class'=>'Calendar', 'id'=>'Paginator'), 
	    "{Туда} {{$date->format('m.Y')}}  {Сейчас {$now->format('m.Y')}} {Сюда}"
	)
    );

    echo CHtml::tag('thead', array(), 
	CHtml::tag('th', array(), "Понедельник"). 
	CHtml::tag('th', array(), "Вторник"). 
	CHtml::tag('th', array(), "Среда"). 
	CHtml::tag('th', array(), "Четверг"). 
	CHtml::tag('th', array(), "Пятница"). 
	CHtml::tag('th', array(), "Суббота"). 
	CHtml::tag('th', array(), "Воскресенье")
    );
    CHtml::tag('tbody',array(),'',false);
    $env = false;
    for ($week = 1; $week <=5; $week++) {
      echo CHtml::tag('tr', array('class'=>$env?'env':'nenv'));
      for ($day=0; $day<7; $day++) {
	echo CHtml::tag('td', array('class'=>'day_of_cal'));
	echo CHtml::closeTag('td');      
      }
      echo CHtml::closeTag('tr');;
      $env = !$env;
    }
    echo CHtml::closeTag('tbody');	// tbody

    echo CHtml::closeTag('table');	// table
    
    echo CHtml::tag('div', array('id'=>'day_briefing', 'class'=>'Calendar'), "@TODO Здесь разместить брифинг на день (по выбору дня)<br/>По умолчанию выбирать текущую дату"
    );
    echo CHtml::closeTag('div');
  }
  
}
?>