<?php if(Yii::app()->user->hasFlash('feedback')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('feedback'); ?>
</div>
<?php endif;?>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'feedbacks/_item',
)); ?>