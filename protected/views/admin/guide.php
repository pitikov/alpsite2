<?php
    $pagename = 'Классификатор';
    array_push($this->breadcrumbs, $pagename);
?>
<h1><?php echo $pagename; ?></h1>
<?php 
  $this->widget('system.web.widgets.CTreeView', array(
      'data'=>array(
          'node1'=>array(
	      'text'=>'Кавказ',
	      'expanded'=>true,
	      'children'=>array(
		  array(
		      'text'=>'Безенги',
		      'expanded'=>false,
		      'children'=>array(
			  array(
			      'text'=>'Архимед',
			      'expanded'=>false,
			      'children'=>array(
				  array('text'=>'2А по С стене'),
				  array('text'=>'3А по Ю-З склону'),
				  array('text'=>'3Б Арбуз'),
			      ),
			  ),
		      ),
		  ),
		  array(
		      'text'=>'Цей',
		  ),
		  array(
		      'text'=>'Уллутау',
		  ),
		  
	      )
	  ),
      )
  ));
?>