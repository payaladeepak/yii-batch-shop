<div class="form">
    <?php
    $form=$this->beginWidget('CActiveForm',array(
        'id'=>'products-form',
        'action'=>array('products/add'),
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($this->model);?>
    <?php echo CHtml::hiddenField('activeTab','add');?>
    <div class="row">
    <?php echo $form->labelEx($this->model,'title');?>
    <?php if ($this->model->getScenario()!='update'):?>
        <?php echo $form->fileField($this->model,'title',array('size'=>50));?>
    <?php else:?>
        <?php echo $form->textField($this->model,'title');?>
    <?php endif;?>
    <?php echo $form->error($this->model,'title');?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($this->model,'price');?>
        <?php echo $form->textField($this->model,'price');?>
        <?php echo $form->error($this->model,'price');?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($this->model,'options',array('label'=>'Options (One option per line)'));?>
        <?php echo $form->textArea($this->model,'options',array('rows'=>6,'cols'=>50,'class'=>'clear'));?>
        <?php echo CHtml::button('Clear',array('id'=>'clear'));?>
        <?php echo $form->error($this->model,'options');?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($this->model,'menu_id');?>
        <?php echo CHtml::activeDropDownList($this->model,'menu_id',$listData);?>
        <?php echo $form->error($this->model,'menu_id');?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton($this->model->isNewRecord ? 'Create' : 'Save');?>
    </div>

<?php $this->endWidget();?>
</div><!-- form -->
<?php
Yii::app()->getClientScript()->registerScript('clear','$("#clear").click(function() {$(".clear").val(\'\').empty();});');
?>