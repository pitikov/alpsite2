<?php
/* @var $this ClubController */
array_push($this->breadcrumbs,'Мероприятие альпклуба');
?>
<h1>Мероприятие альпклуба</h1>

<?php
  echo CHtml::link('Редактировать', array('/club/editaction')) . " | " . CHtml::link('Удалить', array('/club/deleteaction'));
?>
<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
<?php
  echo CHtml::link('Редактировать', array('/club/editaction')) . " | " . CHtml::link('Удалить', array('/club/deleteaction'));
?>