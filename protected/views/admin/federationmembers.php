<?php
/* @var $this AdminController */
$pagename = 'Члены федерации';
Yii::app()->getClientScript()->registerScriptFile('/js/FederationMember.js');

array_push($this->breadcrumbs, $pagename);

echo CHtml::tag('h1', array(), $pagename);

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'FederationMembers',
    'dataProvider'=>$dataProvider,
    'emptyText'=>  CHtml::tag('div', array(
        'class'=>'emptyMemberList'
        ), 'В настоящее время нет данных о зарегистрированных членах федерации.'),
    'columns'=>array(
	array(
	    'name'=>'photo',
	    'value'=>'CHtml::image("$data->photo","$data->name",array("width"=>"60px"))',
	    'type'=>'raw',
            'class'=>'CDblClickColumn',
            'onDblClick'=>'editFederationMember',
            'key'=>'id',
	),
	array(
            'name'=>'name',
            'class'=>'CDblClickColumn',
            'onDblClick'=>'editFederationMember',
            'key'=>'id',
        ),
	array(
	    'name'=>'role',
	    'value'=>'isset($data->roles)?$data->roles->title:""',
            'class'=>'CDblClickColumn',
            'onDblClick'=>'editFederationMember',
            'key'=>'id',
	), 
        array(
            'name'=>'memberfrom',
            'class'=>'CDblClickColumn',
            'onDblClick'=>'editFederationMember',
            'key'=>'id',
        ),
        array(
            'name'=>'memberto',
            'class'=>'CDblClickColumn',
            'onDblClick'=>'editFederationMember',
            'key'=>'id',
            'value'=>'isset($data->memberto)?$data->memberto:"по настоящее время"'
        ),
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
    ),
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
            CHtml::tag('div',array('id'=>'action_status'), null).
            CHtml::hiddenField('memberId')
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
      'id'=>'memberAbout',
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