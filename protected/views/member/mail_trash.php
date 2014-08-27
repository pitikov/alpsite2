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
	    'folder',
	    array(
		'name'=>'sender',
		'value'=>'"{$data->Sender->name} <{$data->Sender->email}>"'
	    ),
	    array(
		'name'=>'receiver',
		'value'=>'"{$data->Receiver->name} <{$data->Receiver->email}>"',
	    ),
	    'sended',
	    array(            // display a column with "view", "update" and "delete" buttons
		'class'=>'CButtonColumn',
	    ),
	    
	),
    )
);

?>