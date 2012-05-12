<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
            ));
    ?>
    <div class="row">
        <?php echo $form->label($model, 'nickname'); ?>
        <?php echo $form->textField($model, 'nickname', array('size' => 48, 'maxlength' => 48)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'country'); ?>
        <?php echo $form->textArea($model, 'country', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'content'); ?>
        <?php echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'rating'); ?>
        <?php echo $form->textField($model, 'rating'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'status'); ?>
        <?php echo $form->textField($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->