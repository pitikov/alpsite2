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
		
		// Здесь осуществить вывод банеров рекламной сети, но не более трех. В случае отсутствия вывести приглашение к размещении рекламы
		echo CHtml::image('/images/banerfree.png', 'Здесь могла бы быть ваша реклама');
		echo 'Здесь будут графические ссылки на дружественные сайты, но не более десяти';
	?>
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>