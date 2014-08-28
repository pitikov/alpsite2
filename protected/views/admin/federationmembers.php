<?php
/* @var $this AdminController */
$pagename = 'Члены федерации';

array_push($this->breadcrumbs, $pagename);

echo CHtml::tag('h1', array(), $pagename);

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'FederationMembers',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
	array(
	    'name'=>'photo',
	    'value'=>'CHtml::image("$data->photo","$data->name",array("width"=>"60px"))',
	    'type'=>'raw'
	),
	'name', 
	array(
	    'name'=>'role',
	    'value'=>'isset($data->roles)?$data->roles->title:""',
	), 
	'memberfrom', 
	'memberto',
	array(
	    'class'=>'GridButtonGroup',
	    'buttons'=>array(
// 		'edit'=>array(
// 		    'label'=>'Редактировать',
// 		    'img'=>'/images/edit.png',
// 		    'url'=>'#',
// 		    'confirm'=>null,
// 		    'action'=>null,
// 		    'id'=>null,
// 		 ),
		 'delete'=>array(
		    'label'=>'Удалить',
		    'img'=>'/images/delete.png',
		    'confirm'=>'Удалить запись?',
		    'action'=>'/federation/deletemember',
		    'id'=>'id',
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
	      ),
	      'width'=>'800px'
	  ),  
));
echo CHtml::tag('table', array(), 
    CHtml::tag('caption', array(),null).
    CHtml::tag('tbody', array(),null)
,false);
  echo CHtml::tag('tr', array(),
    CHtml::tag('th', array(), 'Фамилия, Имя, Отчество').
    CHtml::tag('td', array(), CHtml::textField('memberName'))
  );
  echo CHtml::tag('tr', array(),
    CHtml::tag('th', array(), 'Родился(ась)').
    CHtml::tag('td', array(), CHtml::dateField('memberDob',''))
  );
  echo CHtml::tag('tr', array(),
    CHtml::tag('th', array(), 'фото').
    CHtml::tag('td', array(), CHtml::image('/images/noavatar.png', 'фото', array('title'=>'Щелкните для изменения фотографии')))
  );
  echo CHtml::tag('tr', array(),
    CHtml::tag('th', array(), 'информация о участнике').
    CHtml::tag('td', array(), null, false)
  , false);
  $this->widget('ImperaviRedactorWidget', array(
      // You can either use it for model attribute
//       'model' => $model,
//       'attribute' => 'body',
      // or just for input field
      'name' => 'memberAbout',
      // Some options, see http://imperavi.com/redactor/docs/
      'options' => array(
	  'lang' => 'ru',
	  'toolbar' => true,
	  'iframe' => false,
	  'css' => 'wym.css',
      ),
  ));
  echo CHtml::closeTag('td');
  echo CHtml::closeTag('tr');
  
  echo CHtml::tag('tr', array(),
    CHtml::tag('th', array(), 'член с').
    CHtml::tag('td', array(), CHtml::dateField('memberFrom',''))
  );
  echo CHtml::tag('tr', array(),
    CHtml::tag('th', array(), 'член по').
    CHtml::tag('td', array(), CHtml::dateField('memberTo',''))
  );
  echo CHtml::tag('tr', array(),
    CHtml::tag('th', array(), 'Занимаемая должность').
    CHtml::tag('td', array(), CHtml::dropDownList('memberRole',null,array()))
  );
  echo CHtml::tag('tr', array(),
    CHtml::tag('th', array(), 'Пользователь сайта').
    CHtml::tag('td', array(), CHtml::dropDownList('memberUid',null,array()))
  );

echo CHtml::closeTag('tbody');
echo CHtml::closeTag('table');

$this->endWidget('zii.widgets.jui.CJuiDialog');

?>

<script>
function newFederationMember() {
    jQuery.ajax({
	url:'/index.php/federation/roles',
	dataType:'json',
	success:function(data){
	  var roles = $('#memberRole');
	  roles.html('');
	  $.each(data, function(i, item){
	      roles.append("<option value="+i+">"+item+"</option>");
	  });
 	  $('#memberRole').val(null);
	},
	error:function(xhtml, status, errorThrow) {
	    alert('Что - пошло не так. Запрос должностей федераци вернул '+status);
	}
    });
    jQuery.ajax({
	url:'/index.php/federation/users',
	dataType:'json',
	success:function(data){
	  var users = $('#memberUid');
	  users.html('');
	  $.each(data, function(i, item){
	      users.append("<option value="+i+">"+item+"</option>");
	  });
 	  $('#memberUid').val(null);
	},
	error:function(xhtml, status, errorThrow) {
	    alert('Что - пошло не так. Запрос списка пользователей сайта вернул '+status+" "+errorThrow);
	}
    });
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
	  $('#FederationMemberDialog').append('Что-то не так:\n\tСтатус:'+textStatus);
	},
	beforeSend:function(xhtml){
	}
    }).responseText;;
};

function cancelFederationMember()
{
    $("#FederationMemberDialog").dialog('close');
};
</script>