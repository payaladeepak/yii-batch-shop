<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
	<?php echo CHtml::encode($data->country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nickname')); ?>:</b>
	<?php echo CHtml::encode($data->nickname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rating')); ?>:</b>
	<?php $this->widget('CStarRating',array(
                'model'=>$data,
                'attribute'=>'rating',
            //    'name'=>'rating',
                'value'=>$data->rating,
              //  'id'=>$data->id,
                'maxRating'=>5,
                'readOnly'=>true
                )); ?>
</div>