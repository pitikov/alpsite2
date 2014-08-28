<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */

$pagename = 'О Федерации';
array_push($this->breadcrumbs, $pagename);
?>
<h1><?php echo $pagename; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-about-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	    <?php $this->widget('ImperaviRedactorWidget', array(
	    // You can either use it for model attribute
		'model' => $model,
		'attribute' => 'body',
		// or just for input field
		'name' => 'about_federation',
		
		// Some options, see http://imperavi.com/redactor/docs/
		'options' => array(
		    'lang' => 'ru',
		    'toolbar' => true,
		    'iframe' => false,
		    'css' => 'wym.css',
		  ),
		));
	    echo $form->error($model,'body'); 

	    ?>
	    <?php echo $form->error($model,'body'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<?php if (Yii::app()->user->hasFlash('flash-about-save')) { ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('flash-about-save'); ?>
</div>
<?php } ?>