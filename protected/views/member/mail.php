<?php
    // $this = MemberController
    $pagename = "Сообщения";
    array_push($this->breadcrumbs, $pagename);
?>

<h1><?php echo $pagename; ?></h1>
<?php
$this->widget('CTabView', array(
    'tabs'=>array(
        'tab_inbox'=>array(
            'title'=>'Входящие',
            'view'=>'mail_inbox',
            //'data'=>array('model'=>$model),
        ),
        'tab_outbox'=>array(
            'title'=>'Отправленные',
            'view'=>'mail_sended',
             //'data'=>array('model'=>$model),
        ),
        'tab_trash'=>array(
            'title'=>'Корзина',
            'view'=>'mail_trash',
             //'data'=>array('model'=>$model),
        ),
    ),
))?>