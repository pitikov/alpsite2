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
    CHtml::tag('caption', array('id'=>'MemberFormCaption'),
            CHtml::tag('h2', array('id'=>'MemberFormCaptionHeader'),null).
            CHtml::tag('div',array('id'=>'action_status'), null)
            ).
    CHtml::tag('tbody', array(),null)
,false);
  echo CHtml::tag('tr', array(),
    CHtml::tag('th', array(), 'Фамилия, Имя, Отчество').
    CHtml::tag('td', array(), CHtml::textField('memberName'))
  );
  echo CHtml::tag('tr', array(),
    CHtml::tag('th', array(), 'Родился(ась)').
    CHtml::tag('td', array(), null, false)
  ,false);
  $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'memberDob',
    // additional javascript options for the date picker plugin
    'options'=>array(
        'showAnim'=>'fold',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
    'language'=>'ru',
  ));
  echo CHtml::closeTag('td');
  echo CHtml::closeTag('tr');
    
  echo CHtml::tag('tr', array(),
    CHtml::tag('th', array(), 'фото').
    CHtml::tag('td', array(), CHtml::image('/images/noavatar.png', 'фото', array(
        'title'=>'Щелкните для изменения фотографии',
        'id'=>'memberPhoto',
        'onclick'=>'uploadPhoto();')))
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
    CHtml::tag('td', array(), null, false)
  ,false);
  $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'memberFrom',
    // additional javascript options for the date picker plugin
    'options'=>array(
        'showAnim'=>'fold',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
    'language'=>'ru',
  ));
  echo CHtml::closeTag('td');
  echo CHtml::closeTag('tr');

  echo CHtml::tag('tr', array(),
    CHtml::tag('th', array(), 'член по').
    CHtml::tag('td', array(), null, false)
  ,false);
  $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'memberTo',
    // additional javascript options for the date picker plugin
    'options'=>array(
        'showAnim'=>'fold',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
    'language'=>'ru',
  ));
  echo CHtml::closeTag('td');
  echo CHtml::closeTag('tr');

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
    $('#MemberFormCaptionHeader').html('Новая учетная запись');
    memberFormPrepare();
    $('#memberId').val('');
    $('#memberName').val('');
    $('#memberDob').val('');
    $('#memberPhoto').prop('src', '/images/noavatar.png');
    $('#memberDescription').val('');
    $('#memberFrom').val('');
    $('#memberTo').val('');
    
    $('#FederationMemberDialog').dialog('open');
};

function memberFormPrepare()
{
    var status = $('#action_status');
    status.removeClass('flash-error');
    status.removeClass('flash-success');
    status.html('');
    
    $.ajax({
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
    $.ajax({
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
};

function saveFederationMember()
{
    $.ajax({
	url:'/index.php/federation/addmember'+
                '?id='+$('#memberId').val()+
                '&name='+$('#memberName').val()+
                '&dob='+$('#memberDob').val()+
                '&photo='+$('#memberPhoto').attr('src')+
                '&description='+$('#memberDescription').val()+
                '&from='+$('#memberFrom').val()+
                '&to='+$('#memberTo').val()+
                '&role='+$('#memberRole').val()+
                '&uid='+$('#memberUid').val(),
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            var status = $('#action_status');
            status.addClass('flash-success');
            status.html('Данные сохраненны');
            cancelFederationMember();
            $('#FederationMembers').yiiGridView('update');
                    },
        error: function (jqXHR, textStatus, errorThrown) {
            var status = $('#action_status');
            status.addClass('flash-error');
            status.html(errorThrown);
                    }
    });
};

function cancelFederationMember()
{
    $("#FederationMemberDialog").dialog('close');
};

function uploadPhoto()
{
    alert('This function not implicted');
}
</script>