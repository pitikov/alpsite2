<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>$this->menuName,
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
		
		if (count($this->banerList)==0) {
		    echo CHtml::image('/images/banerfree.png', 'Здесь могла бы быть ваша реклама');
		} else {
		    foreach($this->banerList as $baner) {
		        echo $baner->body;
		    }
		} 
		if (count($this->linkList)>0) {
		    foreach($this->linkList as $link) {
			echo CHtml::link(CHtml::image($link->image, $link->title), $link->url, array('title'=>$link->title));
		    }
		}
	?>
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>