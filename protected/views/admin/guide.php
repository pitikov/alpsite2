<?php
    $pagename = 'Классификатор';
    array_push($this->breadcrumbs, $pagename);
    
    echo CHtml::tag('h1', array(), $pagename);

    
    $this->widget('Guide', array(
        'editable'=>true,
        ));
