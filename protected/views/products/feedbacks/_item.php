<div class="view" style="border:1px solid #BBBBBB;">
    <?php
    $this->widget('CStarRating',array(
        'attribute'=>'rating',
        'name'=>'rating_'.$data->id,
        'value'=>$data->rating,
        'id'=>'rating_'.$data->id,
        'maxRating'=>5,
        'readOnly'=>true,
    ));
    ?><br />
    <strong>From&nbsp;:&nbsp;</strong><?php echo CHtml::encode($data->nickname); ?>
    &nbsp;-&nbsp;<?php echo CHtml::encode($data->country); ?><br />
    <i><?php echo nl2br(CHtml::encode($data->content)); ?></i>
    <?php if (!Yii::app()->user->isGuest): ?>
        <?php echo CHtml::ajaxButton(
                ($data->approved?'Disapprove':'Approve'),
                array('feedbacks/ApproveDisapprove'),
                array(
                    'data'=>"feedback_id={$data->id}&product_id={$product_id}&approved=".($data->approved==0?1:0),
                    'replace'=>'#button_'.$data->id,),
                array('id'=>'button_'.$data->id,'style'=>'position: relative; left: 70%;'));
        ?>
    <?php endif; ?>
</div>