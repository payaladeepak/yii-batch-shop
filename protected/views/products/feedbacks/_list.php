<?php if (Yii::app()->user->hasFlash('feedback')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('feedback');?>
    </div>
<?php endif;?>
<?php
$this->widget('zii.widgets.CListView',array(
    'id'=>'#foo',
    'dataProvider'=>$dataProvider,
    'itemView'=>'feedbacks/_item',
    'viewData'=>array(
        'product_id'=>$product_id,
    ),
    'pager'=>array(
        'class'=>'SeoLinkPager',
        'cssFile'=>Yii::app()->baseUrl.'/css/'.'pager.css',
    )
));
?>