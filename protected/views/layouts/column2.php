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
			'title'=>'ФАПО',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
		
		echo "<hr/>";
		echo 'Здесь будут банеры рекламной банерной сети, но не более трех';
		echo "<hr/>";
		echo 'Здесь будут графические ссылки на дружественные сайты, но не более десяти';
	?>
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>