<?php
    $pagename = 'Документы';
    array_push($this->breadcrumbs, $pagename);
    
    echo CHtml::tag('h1', array(), $pagename);

    echo CHtml::tag('p', array('class'=>'note'), 'Данная страница предоставлят доступ к документам, касающихся работы федерации.');
    
    if (isset($dataProvider))
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'public_documents_list',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
	    array(
		'value'=>'$row+1',
		'header'=>'№'
	    ),
	    'file_name',
	    'type',
	    'description',
	),
	'emptyText'=>CHtml::tag('div',array('id'=>'empty_document_list'), 'В настоящее время на сайте нет загруженных документов.'),
));

?>