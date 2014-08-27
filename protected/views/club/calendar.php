<?php
/* @var $this ClubController */

array_push($this->breadcrumbs, 'Календарь мероприятий');

echo CHtml::tag('h1', array(), 'Меропиятия альпклуба');
// echo CHtml::link('Добавить', array('/club/addaction'));

$this->widget('Calendar',array(
  'id'=>'ClubCal',
  'caption'=>'Календарь мерорприятий Альпклуба "Пенза"'
));
  
?>