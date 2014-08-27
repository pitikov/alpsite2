<?php /* @var $this Controller */ 

$this->beginContent('//layouts/main'); 
echo CHtml::tag('div',array('id'=>'content'), $content);
$this->endContent();
?>