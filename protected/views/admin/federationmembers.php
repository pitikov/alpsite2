<?php
/* @var $this AdminController */
$pagename = 'Члены федерации';

array_push($this->breadcrumbs, $pagename);

echo CHtml::tag('h1', array(), $pagename);

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'FederationMembers',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
	'photo',
	'name', 
	'role', 
	'memberfrom', 
	'memberto',
	array(
	    'class'=>'GridButtonGroup',
	    'buttons'=>array(
		'edit'=>array(
		    'label'=>'Редактировать',
		    'img'=>'/images/edit.png',
		    'url'=>'#',
		    'confirm'=>null,
		    'action'=>null,
		    'id'=>null,
		 ),
		 'delete'=>array(
		    'label'=>'Удалить',
		    'img'=>'/images/delete.png',
		    'url'=>'#',
		    'confirm'=>'Удалить запись?',
		    'action'=>null,
		    'id'=>null,
		)
	    ),
	)
    )
));

echo CHtml::link('Зарегистрировать', '#', array('id'=>'linkNewFederationMember', 'onclick'=>'newFederationMember();'));

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	  'id'=>'FederationMemberDialog',
	  'options'=>array(
	      'title'=>'Учетная запись члена ФАПО',
	      'autoOpen'=>false,
	      'modal'=>true,
	      'buttons'=>array(
		  array('text'=>'Сохранить', 'click'=>'js:function(){saveFederationMember();}'),
		  array('text'=>'Отменить', 'click'=>'js:function(){cancelFederationMember();}'),
	      )
	  ),  
));
echo CHtml::tag('div', array('class'=>'row'), 
    CHtml::tag('b',array(), 'Фамилия, Имя, Отчество').
    CHtml::textField('memberName','')
);
echo CHtml::tag('div', array('class'=>'row'),
    CHtml::tag('b',array(), 'Занимаемая должность').
    CHtml::dropDownList('memberName',null,array(null=>'Хто это???',1=>'Насяльника', 2=>'Равшана', 3=>'Джамшута'))
);
echo CHtml::tag('div', array('class'=>'row'),
    CHtml::tag('b',array(), 'Пользователь сайта').
    CHtml::dropDownList('siteUser',null,array(null=>'Хто это???',1=>'Насяльника', 2=>'Равшана', 3=>'Джамшута'))
);
echo CHtml::tag('div', array('class'=>'row'),
    CHtml::tag('b',array(), 'Родился(ась)').
    CHtml::dateField('dob','')
);
echo CHtml::tag('div', array('class'=>'row'),
    CHtml::tag('b',array(), 'член с').
    CHtml::dateField('memberfrom','')
);
echo CHtml::tag('div', array('class'=>'row'),
    CHtml::tag('b',array(), 'член по').
    CHtml::dateField('memberto','')
);



$this->endWidget('zii.widgets.jui.CJuiDialog');

?>

<script>
function newFederationMember() {
    $('#FederationMemberDialog').dialog('open');
};

function saveFederationMember()
{
    var request = jQuery.ajax({
	url:'/index.php/federation/addmember',
	type:'POST',
	dataType:'josn',
	data:({name:'Noname'}),	/// @todo Здесь разместить передеваемые параметры
	success:function(msg, textStatus){
	    alert(msg);
	},
	error:function(xhtml, textStatus, errorThrow){
	  $('#FederationMemberDialog').html('Что-то не так:\n\tСтатус:'+textStatus);
	},
	complite:function(xhtml, textStatus){
	    alert(textStatus);
	},
	beforeSend:function(xhtml){
	  $('#FederationMemberDialog').html('Поехали');
	}
    }).responseText;;
};

function cancelFederationMember()
{
    $("#FederationMemberDialog").dialog('close');
};
</script>