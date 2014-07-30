<?php
/* @var $this MemberController */
$pagename = 'Профиль пользователя '.Yii::app()->user->getName();
array_push($this->breadcrumbs, $pagename)
?>
<h1><?php echo $pagename;?></h1>

<p>
    Здесь должен быть виджет вкладок профиля пользователя
</p><p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
<?php
    print_r(Yii::app()->user->model());
    echo "<br/>Role = ".Yii::app()->user->getRole();
    if($this->isAdmin()) echo "<h1>hello, I'm administrator</h1>";
    if($this->isUser()) echo "<h1>hello, I'm user</h1>";
    if($this->isFapo()) echo "<h1>hello, I'm federation member</h1>";
?>