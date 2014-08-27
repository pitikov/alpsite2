<?php
    // $this = MemberController
    $pagename = "Публикации";
    array_push($this->breadcrumbs, $pagename);
    
    echo CHtml::tag('h1',array(), $pagename);
    echo 'Здесь должен быть размещен список публикаций пользователя с детализацией комментариев и т.п.';
?>
