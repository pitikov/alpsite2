<?php
/* @var $this FederationController */
array_push($this->breadcrumbs, 'Календарь альпмероприятий');
?>
<h1>Календарь альпмероприятий ФАПО</h1>
<?php
  if ($this->isFapo()) echo CHtml::link('Добавить', array('/federation/addaction'));
?>
<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
<?php
  if ($this->isFapo()) echo CHtml::link('Добавить', array('/federation/addaction'));
?>