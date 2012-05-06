<?php $this->breadcrumbs=array(
	'Feedbacks',
);
?>

<h1>Feedbacks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
<hr/>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>