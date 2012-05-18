<?php
$this->breadcrumbs=array(
	'Foobars'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Foobar', 'url'=>array('index')),
	array('label'=>'Create Foobar', 'url'=>array('create')),
	array('label'=>'Update Foobar', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Foobar', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Foobar', 'url'=>array('admin')),
);
?>

<h1>View Foobar #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
	),
)); ?>
