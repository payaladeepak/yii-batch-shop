<div class="form">
    <?php
    $form=$this->beginWidget('CActiveForm',array(
        'id'=>'products-form',
        'action'=>array('products/batchadd'),
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($this->model);?>
<?php echo CHtml::hiddenField('activeTab','batch-add');?>
    <div class="row">
        <?php
        $this->widget('ext.EAjaxUpload.EAjaxUpload',array(
            'id'=>'title',
            'config'=>array(
                'action'=>Yii::app()->createUrl('products/UploadResponse'),
                'allowedExtensions'=>array_merge(Yii::app()->params['allowedTypes'],array('zip')),
                'sizeLimit'=>Yii::app()->params['maxUploadSize'],
            )
        ));
        ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($this->model,'price');?>
        <?php echo $form->textField($this->model,'price');?>
        <?php echo $form->error($this->model,'price');?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($this->model,'options',array('label'=>'Options (One option per line)'));?>
        <?php echo $form->textArea($this->model,'options',array('rows'=>6,'cols'=>50,'class'=>'clear2'));?>
        <?php echo CHtml::button('Clear',array('id'=>'clear2'));?>
        <?php echo $form->error($this->model,'options');?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($this->model,'menu_id');?>
        <?php echo CHtml::activeDropDownList($this->model,'menu_id',$listData);?>
        <?php echo $form->error($this->model,'menu_id');?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton('Save');?>
    </div>

<?php $this->endWidget();?>
</div><!-- form -->
<?php
Yii::app()->getClientScript()->registerScript('clear2','$("#clear2").click(function() {$(".clear2").val(\'\').empty();});');
?>