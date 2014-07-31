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
	    'sender',
	    'sended',
	    array(            // display a column with "view", "update" and "delete" buttons
		'class'=>'CButtonColumn',
	    ),
	    
	),
    )
);

?>