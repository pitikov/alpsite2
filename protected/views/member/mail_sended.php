<?php
$this->widget('zii.widgets.grid.CGridView', 
    array(
	'dataProvider'=>$model,
	'columns'=>array(
	    array(
		'name'=>'check',
		'header'=>'',
	    ),
	    'subject',
	    'receiver',
	    'sended',
	    array(            // display a column with "view", "update" and "delete" buttons
		'class'=>'CButtonColumn',
	    ),
	    
	),
    )
);
?>