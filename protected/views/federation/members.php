<?php
/* @var $this FederationController */
$pagename = 'Члены федерации';
array_push($this->breadcrumbs, $pagename);
Yii::app()->getClientScript()->registerScriptFile('/js/FederationMember.js');

echo CHtml::tag('h1', array(), $pagename);

/// @todo Использовать CListView
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
	array(
	    'name'=>'photo',
	    'value'=>'CHtml::image("$data->photo","$data->name",array("width"=>"60px"))',
	    'type'=>'raw',
            'class'=>'CDblClickColumn',
            'onDblClick'=>'showFederationProfile',
            'key'=>'id'
	),
        array(
            'name'=>'name',            
            'class'=>'CDblClickColumn',
            'onDblClick'=>'showFederationProfile',
            'key'=>'id'
        ),
	array(
	    'name'=>'role',
	    'value'=>'isset($data->roles)?$data->roles->title:""',
            'class'=>'CDblClickColumn',
            'onDblClick'=>'showFederationProfile',
            'key'=>'id'
	), 
	array(
            'name'=>'memberfrom',
            'class'=>'CDblClickColumn',
            'onDblClick'=>'showFederationProfile',
            'key'=>'id'
        ),
        array(
            'name'=> 'memberto',
            'class'=>'CDblClickColumn',
            'onDblClick'=>'showFederationProfile',
            'key'=>'id'
        )
    )
    
));

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'MemberProfile',
        'options'=>array(
            'modal'=>true,
            'autoOpen'=>false,
            'title'=>'Член федерации "'.CHtml::tag('span', array('class'=>'memberName')).'"',
            'buttons'=>array(
		  array('text'=>'Закрыть', 'click'=>'js:function(){$("#MemberProfile").dialog("close");}'),
            ),
        'width'=>'800px'
        )
    ));
    echo CHtml::tag('div', array('id'=>'federationMemberProfile'),
            CHtml::image('/images/noavatar.png', '', array('id'=>'memberPhoto','align'=>'left')), false);
    echo CHtml::tag('h1', array('class'=>'memberName'),null);
    echo CHtml::tag('div', array(),
        CHtml::tag('div',array('class'=>'row'),
            CHtml::tag('span', array('class'=>'header'), 'родился(ась) : ').
            CHtml::tag('span', array('class'=>'data', 'id'=>'memberDob'), null)
        ).
        CHtml::tag('div',array('class'=>'row'),
            CHtml::tag('span', array('class'=>'header'), 'член федерации с : ').
            CHtml::tag('span', array('class'=>'data', 'id'=>'memberFrom'), null)
        ).
        CHtml::tag('div',array('class'=>'row'),
            CHtml::tag('span', array('class'=>'header'), 'член федерации по : ').
            CHtml::tag('span', array('class'=>'data', 'id'=>'memberTo'), null)
        ).
        CHtml::tag('div',array('class'=>'row'),
            CHtml::tag('span', array('class'=>'header'), 'занимаемая должность : ').
            CHtml::tag('span', array('class'=>'data', 'id'=>'memberRole'), null)
        ).
        CHtml::tag('div',array('class'=>'row', 'id'=>'memberDescription'),null)
    );
    // Отобразить список восхождений
    $this->widget('MemberMountaringTable', array(
        'id'=>'memberMountarings',
    ));
    
    echo CHtml::closeTag('div');
$this->endWidget();