<?php
  array_push($this->breadcrumbs, "Новости");
    
  echo CHtml::tag('div',array('class'=>'twoColumns'), null, false);
      echo CHtml::tag('div', array('class'=>'span-9', 'id'=>'federationContent'),
	  CHtml::tag('h1', array(), 'Новости федерации')
	  , false);
	      /// @todo Implict me
	      echo CHtml::tag('div', array('class'=>'flash-success'), 'Здесь следует вывести события федерации (из календаря), происходящие сейчас или ожидаемые в ближайший месяц');

	      /// @todo Implict me
	      echo CHtml::tag('div', array('class'=>'flash-error'), 'Здесь должны быть новости федерации в обратном хронологическом порядке по дате публикации');

	      if ($this->isFapo() | $this->isAdmin()) echo CHtml::link("Добавить новость", array('/article/publicate', 'context'=>'federation'));
      echo CHtml::closeTag('div');  // federationContent
      
      echo CHtml::tag('div', array('class'=>'span-9 last', 'id'=>'clubContent'),
	  CHtml::tag('h1', array(), 'Новости клуба')
	  , false);
     	      /// @todo Implict me
	      echo CHtml::tag('div', array('class'=>'flash-success'), 'Здесь следует вывести события альпклуба (из календаря), происходящие сегодня или ожидаемые в ближайшую неделю');

	      /// @todo Implict me
	      echo CHtml::tag('div', array('class'=>'flash-error'), 'Здесь должны быть новости альпклуба в обратном хронологическом порядке по дате публикации');	      
	      if ($this->isAdmin()) echo CHtml::link("Добавить новость", array('/article/publicate', 'context'=>'club'));
	      
      echo CHtml::closeTag('div');  // clubContent
      
  echo CHtml::closeTag('div'); // twoColumns
