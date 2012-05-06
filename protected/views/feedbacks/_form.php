<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>'feedbacks/create',
        'id'=>'feedbacks-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>48,'maxlength'=>48)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>48,'maxlength'=>48)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

        <div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
                <?php echo $form->labelEx($model,'rating'); ?>
		<?php $this->widget('CStarRating',array(
                'model'=>$model,
                'attribute'=>'rating',
                'maxRating'=>5,
                'allowEmpty'=>false,
                )); ?>
	</div>
        <br/>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->