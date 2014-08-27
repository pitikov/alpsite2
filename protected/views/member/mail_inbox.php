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
	    array(
		'name'=>'sender',
		'value'=>'"{$data->Sender->name} <{$data->Sender->email}>"'
	    ),
	    'sended',
	    array(            // display a column with "view", "update" and "delete" buttons
		'class'=>'CButtonColumn',
	    ),
	    
	),
    )
);

?>