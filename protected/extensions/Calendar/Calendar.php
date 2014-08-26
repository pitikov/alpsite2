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
    $this->html_tag('div', array('id'=>$this->id, 'class'=>'CalendarWidget'));
    $this->html_tag('table', array('id'=>$this->id, 'class'=>'Calendar'));
    $this->html_tag('caption', array('class'=>'Calendar'));
    $this->html_tag('h3');
    echo $this->caption;
    $this->html_end_tag();
    $this->html_tag('span', array('class'=>'Calendar', 'id'=>'Paginator')); echo "{Туда} {{$date->format('m.Y')}}  {Сейчас {$now->format('m.Y')}} {Сюда}"; $this->html_end_tag();

    $this->html_end_tag();	// caption
    $this->html_tag('thead');
    $this->html_tag('th'); echo "Понедельник"; $this->html_end_tag();
    $this->html_tag('th'); echo "Вторник"; $this->html_end_tag();
    $this->html_tag('th'); echo "Среда"; $this->html_end_tag();
    $this->html_tag('th'); echo "Четверг"; $this->html_end_tag();
    $this->html_tag('th'); echo "Пятница"; $this->html_end_tag();
    $this->html_tag('th'); echo "Суббота"; $this->html_end_tag();
    $this->html_tag('th'); echo "Воскресенье"; $this->html_end_tag();
    $this->html_end_tag();	// thead
    $this->html_tag('tbody');
    $env = false;
    for ($week = 1; $week <=5; $week++) {
      $this->html_tag('tr', array('class'=>$env?'env':'nenv'));
      for ($day=0; $day<7; $day++) {
	$this->html_tag('td', array('class'=>'day_of_cal'));
	$this->html_end_tag();
      }
      $this->html_end_tag();
      $env = !$env;
    }
    $this->html_end_tag();	// tbody

    $this->html_end_tag();	// table
    
    $this->html_tag('div', array('id'=>'day_briefing', 'class'=>'Calendar'));
    $this->html_tag('hr');
    echo "@TODO Здесь разместить брифинг на день (по выбору дня)<br/>По умолчанию выбирать текущую дату";
    $this->html_end_tag();
    // Подчистить теги, если что забыл
    foreach ($this->_tags as $tag) {
      $this->html_end_tag();
    }
  }
  
  public function render() {
  
  }
  
  private function html_tag($tag, $options = array(), $value=null)
  {
    echo "<{$tag}";
    foreach ($options as $key=>$value) {
      echo " {$key}='{$value}'";
    }
    echo ">";
    array_push($this->_tags, $tag);
  }
  
  private function html_end_tag() 
  {
    echo "</".array_pop($this->_tags).">";
  }
}
?>