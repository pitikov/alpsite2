<?php
  array_push($this->breadcrumbs, "Новости");
?>
<div class = "twoColumns">
  <div id="federationContent" class = "span-9">
    <h1>Новости федерации</h1>
     <p>Здесь должны быть новости федерации</p>
<?php
    if (!Yii::app()->user->isGuest) echo CHtml::link("Добавить новость", array('/article/publicate', 'context'=>'federation'));
?>
  </div>
  <div id="clubContent" class = "span-9 last">
    <h1>Новости клуба</h1>
     <p>Здесь должны быть новости клуба</p>
<?php
    if (!Yii::app()->user->isGuest) echo CHtml::link("Добавить новость", array('/article/publicate', 'context'=>'club'));
?>
  </div>
</div>