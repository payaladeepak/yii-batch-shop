<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>'feedbacks/create',
        'id'=>'feedbacks-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($feedbacks); ?>

	<div class="row">
		<?php echo $form->labelEx($feedbacks,'email'); ?>
		<?php echo $form->textField($feedbacks,'email',array('size'=>48,'maxlength'=>48)); ?>
		<?php echo $form->error($feedbacks,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($feedbacks,'country'); ?>
		<?php echo $form->textField($feedbacks,'country',array('size'=>48,'maxlength'=>48)); ?>
		<?php echo $form->error($feedbacks,'country'); ?>
	</div>

        <div class="row">
		<?php echo $form->labelEx($feedbacks,'content'); ?>
		<?php echo $form->textArea($feedbacks,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($feedbacks,'content'); ?>
	</div>

	<div class="row">
                <?php echo CHtml::label('Rating',false); ?>
		<?php $this->widget('CStarRating',array(
                'model'=>$feedbacks,
                'attribute'=>'rating',
                'maxRating'=>5,
                'allowEmpty'=>false,
                )); ?>
	</div><br/>

        <?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php echo $form->labelEx($feedbacks,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($feedbacks,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
		<?php echo $form->error($feedbacks,'verifyCode'); ?>
	</div>
	<?php endif; ?>

        <br/>
	<div class="row buttons">
		<?php echo CHtml::submitButton($feedbacks->isNewRecord ? 'Create' : 'Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->