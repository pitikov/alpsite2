<?php
/* @var $this ClubController */

array_push($this->breadcrumbs, 'Календарь мероприятий');
?>
<h1>Мероприятия клуба</h1>
<?php
//   echo CHtml::link('Добавить', array('/club/addaction'));
//   
  $this->widget('Calendar');
  
//   echo CHtml::link('Добавить', array('/club/addaction'));
?>