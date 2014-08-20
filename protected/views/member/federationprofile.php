<?php
/* @var $this FederationMemberController */
/* @var $model FederationMember */
/* @var $form CActiveForm */
$pagename = "Членство в ФАПО";
array_push($this->breadcrumbs, $pagename);
$fromprofile = 'Взять из профиля';
?>
<h1><?php echo $pagename; ?></h1>
<div class="form">
<script>
function profileFoto() {
  $('#FederationMember_photo').val('<?php echo Yii::app()->user->model()->avatar;?>');
};
function profileName() {
  $('#FederationMember_name').val('<?php echo Yii::app()->user->model()->name;?>');
};
function profileDob() {
  $('#DateOfBethday').val('<?php echo Yii::app()->user->model()->dob;?>');
};
</script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'federation-member-federationprofile-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
)); ?>
<table>
  <caption class='note'><p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p></caption>
  <thead><?php echo $form->errorSummary($model); ?></thead>
  <tbody>
    <tr>
      <td width='35%'>
	<?php echo $form->labelEx($model,'photo'); ?>
      </td>
      <td>
	<?php echo $form->textField($model,'photo').
	CHtml::link(CHtml::image('/images/getfromprofile.png',$fromprofile, array('title'=>$fromprofile)), '#', array('onclick'=>'profileFoto();')); ?>
	<?php echo $form->error($model,'photo'); ?>
      </td>
    </tr>

    <tr>
      <td>
	<?php echo $form->labelEx($model,'name'); ?>
      </td>
      <td>
	<?php echo $form->textField($model,'name').
	CHtml::link(CHtml::image('/images/getfromprofile.png',$fromprofile, array('title'=>$fromprofile)), '#', array('onclick'=>'profileName();')); ?>
	<?php echo $form->error($model,'name'); ?>
      </td>
    </tr>
    <tr>
      <td>
	<?php echo $form->labelEx($model,'role'); ?>
      </td>
      <td>
	<?php echo $form->dropDownList($model,'role', $roles); ?>
	<?php echo $form->error($model,'role'); ?>
      </td>
    </tr>
    <tr>
      <td>
	<?php echo $form->labelEx($model,'dob'); ?>
      </td>
      <td>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
				  array(
				      'model'=>$model,
				      'attribute'=>'dob',
				      'name'=>'DateOfBethday',
				      // additional javascript options for the date picker plugin
				      'options'=>array(
					  'showAnim'=>'fold',
				      ),
				      'htmlOptions'=>array(
					  'style'=>'height:20px;'
				      ),
				      'language'=>'ru',
	));
	echo CHtml::link(CHtml::image('/images/getfromprofile.png',$fromprofile, array('title'=>$fromprofile)), '#', array('onclick'=>'profileDob();')); ?>
	<?php echo $form->error($model,'dob'); ?>
      </td>
    </tr>
    <tr>
      <td>
	<?php echo $form->labelEx($model,'memberfrom'); ?>
      </td>
      <td>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
				  array(
				      'model'=>$model,
				      'attribute'=>'memberfrom',
				      'name'=>'MemberFromDate',
				      // additional javascript options for the date picker plugin
				      'options'=>array(
					  'showAnim'=>'fold',
				      ),
				      'htmlOptions'=>array(
					  'style'=>'height:20px;'
				      ),
				      'language'=>'ru',
	)); ?>
	<?php echo $form->error($model,'memberfrom'); ?>
      </td>
    </tr>
    <tr>
      <td>
	<?php echo $form->labelEx($model,'memberto'); ?>
	<div class='hint'>Для действующих членов федерации поле оставить пустым.</div>
      </td>
      <td>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
				  array(
				      'model'=>$model,
				      'attribute'=>'memberto',
				      'name'=>'MemberToDate',
				      // additional javascript options for the date picker plugin
				      'options'=>array(
					  'showAnim'=>'fold',
				      ),
				      'htmlOptions'=>array(
					  'style'=>'height:20px;'
				      ),
				      'language'=>'ru',
	)); ?>
	<?php echo $form->error($model,'memberto'); ?>
      </td>
    </tr>
    <tr>
      <td>
	<?php echo $form->labelEx($model,'description'); ?>
      </td>
      <td>
        <?php $this->widget('ImperaviRedactorWidget', array(
	    // You can either use it for model attribute
		'model' => $model,
		'attribute' => 'description',
		// or just for input field
		'name' => 'member_description',
		
		// Some options, see http://imperavi.com/redactor/docs/
		'options' => array(
		    'lang' => 'ru',
		    'toolbar' => true,
		    'iframe' => false,
		    'css' => 'wym.css',
		  ),
		));
		?>
	<?php echo $form->error($model,'description'); ?>
      </td>
    </tr>
  </tbody>
</table>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>
<?php if (Yii::app()->user->hasFlash('flash-federation-profile-success')) { ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('flash-federation-profile-success'); ?>
</div>
<?php } ?>
<?php if (Yii::app()->user->hasFlash('flash-federation-profile-error')) { ?>
<div class="flash-error">
    <?php echo Yii::app()->user->getFlash('flash-federation-profile-error'); ?>
</div>
<?php } ?>
<?php $this->endWidget(); ?>

</div><!-- form -->