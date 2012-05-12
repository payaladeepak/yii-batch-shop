<div class="view" style="border:1px solid #BBBBBB;">
    <?php $this->widget('CStarRating',array(
                'model'=>$data,
                'attribute'=>'rating',
            //    'name'=>'rating',
                'value'=>$data->rating,
              //  'id'=>$data->id,
                'maxRating'=>5,
                'readOnly'=>true
                )); ?><br />
    <strong>From&nbsp;:&nbsp;</strong><?php echo CHtml::encode($data->nickname); ?>
    &nbsp;-&nbsp;<?php echo CHtml::encode($data->country); ?><br />
    <i><?php echo CHtml::encode($data->content); ?></i>
</div>